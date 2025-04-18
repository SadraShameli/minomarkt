<?php

namespace App\Core;

use App\ThirdParty\ACF\Base\BaseMenu;
use Timber\Timber;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\TwigTest;

class ExtendTwig
{
    public function __construct()
    {
        Timber::init();

        add_filter('timber/context', [$this, 'addToContext']);
        add_filter('timber/twig', [$this, 'addToTwig']);
    }

    /**
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public function addToContext(array $context): array
    {
        $context['menu'] = Timber::get_menu();
        $context['menus'] = BaseMenu::getMenus();
        $context['options'] = get_fields('options');

        return $context;
    }

    public function addToTwig(Environment $twig): Environment
    {
        $twig->addFunction(new TwigFunction('cs', [$this, 'classNames']));
        $twig->addFunction(new TwigFunction('get_fields', [$this, 'getFields']));
        $twig->addFunction(new TwigFunction('block_layout', [$this, 'getBlockLayout']));
        $twig->addFunction(new TwigFunction('fetch_svg', [$this, 'fetchSvg']));
        $twig->addFunction(new TwigFunction('get_image_focal', [$this, 'getImageFocal']));
        $twig->addFunction(new TwigFunction('get_link_directions', [$this, 'getLinkDirections']));

        $twig->addTest(new TwigTest('array', [&$this, 'isArray']));

        return $twig;
    }

    public function classNames(): string
    {
        $args = func_get_args();
        $attributes = [];
        $classes = [];

        foreach ($args as $arg) {
            if (is_array($arg)) {
                if (isset($arg['class'])) {
                    $classes[] = $arg['class'];
                    unset($arg['class']);
                }

                if (isset($arg['attributes']) && is_array($arg['attributes'])) {
                    $attributes = array_merge($attributes, $arg['attributes']);
                    unset($arg['attributes']);
                }

                $isConditionalClasses = true;
                foreach ($arg as $key => $value) {
                    if (!is_bool($value) && !is_int($value)) {
                        $isConditionalClasses = false;
                        break;
                    }
                }

                if ($isConditionalClasses) {
                    foreach ($arg as $className => $condition) {
                        if ($condition) {
                            $classes[] = $className;
                        }
                    }
                }
            } else {
                $classes[] = $arg;
            }
        }

        if (!empty($classes)) {
            $attributes['class'] = implode(' ', array_filter($classes));
        }

        $output = [];

        foreach ($attributes as $key => $value) {
            if (!empty($value)) {
                $output[] = $key . '="' . $value . '"';
            }
        }

        return implode(' ', $output);
    }

    /**
     * @return array<string, mixed>|false
     */
    public function getFields(int $id): array|false
    {
        return get_fields($id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getBlockLayout(mixed $layout): array
    {
        if (empty($layout)) {
            return [];
        }

        $classes = [];
        $data = [];

        if (!empty($layout['spacing_top'])) {
            $classes[] = 'block-spacing--top';
        }
        if (!empty($layout['spacing_bottom'])) {
            $classes[] = 'block-spacing--bottom';
        }

        if (!empty($layout['width'])) {
            $classes[] = 'block-width--' . $layout['width'];
        }

        if (!empty($classes)) {
            $data['class'] = implode(' ', $classes);
        }

        if (!empty($layout['anchor'])) {
            $data['attributes']['id'] = str_replace('#', '', trim($layout['anchor']));
        }

        return $data;
    }

    public static function fetchSvg(mixed $filename): string
    {
        if (empty($filename)) {
            return '';
        }

        if ('svg' !== pathinfo($filename, PATHINFO_EXTENSION)) {
            $filename .= '.svg';
        }

        $folders = [
            '/assets/icons/',
        ];

        $svg_path = '';
        foreach ($folders as $folder) {
            $path = get_theme_file_path($folder . $filename);

            if (file_exists($path)) {
                $svg_path = $path;

                break;
            }
        }

        if (empty($svg_path)) {
            return '';
        }

        $svg = file_get_contents($svg_path);

        if (empty($svg)) {
            return '';
        }

        return trim($svg);
    }

    public static function getImageFocal(mixed $focal, bool $inline = true): string
    {
        if (empty($focal['top']) || empty($focal['left'])) {
            return '';
        }

        $top = $focal['top'];
        $left = $focal['left'];

        $output = sprintf(
            'object-position: top %s%% left %s%%;',
            $top,
            $left,
        );

        if ($inline) {
            return 'style="' . $output . '"';
        }

        return $output;
    }

    public function getLinkDirections(): string
    {
        $options = get_fields('option');

        return 'https://google.com/maps/dir/?' . http_build_query([
            'api' => 1,
            'destination' => empty($options['api']['google_maps_place_name']) ? null : $options['api']['google_maps_place_name'],
            'destination_place_id' => empty($options['api']['google_maps_place_id']) ? null : $options['api']['google_maps_place_id'],
        ]);
    }

    public function isArray(mixed $value): bool
    {
        if (is_array($value) && count($value) > 0) {
            return true;
        }

        return false;
    }
}
