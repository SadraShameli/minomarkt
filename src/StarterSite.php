<?php

namespace App;

use Timber\Site;
use Timber\Timber;

class StarterSite extends Site
{
    public function __construct()
    {
        $this->registerMenus();

        add_action('after_setup_theme', [$this, 'themeSupports']);
        add_filter('timber/context', [$this, 'addToContext']);

        parent::__construct();
    }

    /**
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    public function addToContext(array $context): array
    {
        $context['menu'] = Timber::get_menu();
        $context['menus'] = [
            'primary' => Timber::get_menu('primary-menu'),
            'secondary' => Timber::get_menu('secondary-menu'),
            'footerOne' => Timber::get_menu('footer-menu-one'),
            'footerTwo' => Timber::get_menu('footer-menu-two'),
            'footerThree' => Timber::get_menu('footer-menu-three'),
            'pageMicro' => Timber::get_menu('page-micro-menu'),
        ];

        return $context;
    }

    public function themeSupports(): void
    {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            [
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ],
        );
        add_theme_support(
            'post-formats',
            [
                'aside',
                'image',
                'video',
                'quote',
                'link',
                'gallery',
                'audio',
            ],
        );
        add_theme_support('menus');
    }

    private function registerMenus(): void
    {
        register_nav_menu('primary-menu', 'Desktop menu');
        register_nav_menu('secondary-menu', 'Mobile menu');
        register_nav_menu('footer-menu-one', 'Footer Menu One');
        register_nav_menu('footer-menu-two', 'Footer Menu Two');
        register_nav_menu('footer-menu-three', 'Footer Menu Three');
        register_nav_menu('page-micro-menu', 'Page Micro Menu');

    }
}
