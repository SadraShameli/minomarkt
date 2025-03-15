<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use App\ThirdParty\ACFGutenberg\PostTypes\PostTypeLogo;
use Timber\Timber;

class BlockSliderLogo extends BaseBlock
{
    public static string $blockName = 'slider-logo';

    public static string $blockTitle = 'Logo Slider';

    public static string $blockIcon = 'slides';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['selected_logos'])) {
            $args = [
                'post_type' => PostTypeLogo::$postTypeName,
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ];

            $logos = get_posts($args);
        } else {
            $logos = array_map(static function ($logoId): ?\WP_Post {
                return get_post($logoId);
            }, $fields['selected_logos']);
        }

        if (empty($logos)) {
            return;
        }

        $context['items'] = array_map(static function ($logo): array {
            if (!$logo) {
                return [
                    'image' => null,
                    'link' => null,
                ];
            }

            return [
                'image' => get_field('image', $logo->ID),
                'link' => get_field('link', $logo->ID),
            ];
        }, $logos);

        Timber::render('blocks/block-slider-logo.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addRelationship('selected_logos', [
                'label' => 'Select Logos',
                'post_type' => PostTypeLogo::$postTypeName,
                'filters' => ['search'],
                'elements' => ['featured_image'],
                'return_format' => 'id',
            ])
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
