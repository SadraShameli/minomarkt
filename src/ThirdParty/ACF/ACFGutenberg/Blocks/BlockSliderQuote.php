<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Blocks;

use App\ThirdParty\ACF\ACFFields\ReusableFields;
use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use App\ThirdParty\ACF\ACFGutenberg\PostTypes\PostTypeQuote;
use Timber\Timber;

class BlockSliderQuote extends BaseBlock
{
    public static string $blockName = 'slider-quote';

    public static string $blockTitle = 'Quote Slider';

    public static string $blockIcon = 'format-quote';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['selected_quotes'])) {
            $args = [
                'post_type' => PostTypeQuote::$postTypeName,
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ];

            $quotes = get_posts($args);
        } else {
            $quotes = array_map(static function ($quoteId): ?\WP_Post {
                return get_post($quoteId);
            }, $fields['selected_quotes']);
        }

        if (empty($quotes)) {
            return;
        }

        $context['items'] = array_map(static function ($quote): array {
            if (!$quote) {
                return [
                    'name' => null,
                    'image' => null,
                    'role' => null,
                    'quote' => null,
                ];
            }

            return [
                'name' => $quote->post_title,
                'image' => get_field('image', $quote->ID),
                'role' => get_field('role', $quote->ID),
                'quote' => get_field('quote', $quote->ID),
            ];
        }, $quotes);

        Timber::render('blocks/slider-quote.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addFields(ReusableFields::button())
            ->addRelationship('selected_quotes', [
                'label' => 'Select Quotes',
                'post_type' => PostTypeQuote::$postTypeName,
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
