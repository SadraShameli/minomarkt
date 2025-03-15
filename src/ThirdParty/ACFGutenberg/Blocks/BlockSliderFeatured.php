<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockSliderFeatured extends BaseBlock
{
    public static string $blockName = 'slider-featured';

    public static string $blockTitle = 'Featured Slider';

    public static string $blockIcon = 'slides';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['items'])) {
            return;
        }

        Timber::render('blocks/slider-featured.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addTextarea('description', [
                'label' => 'Description',
            ])
            ->addRepeater('items', [
                'label' => 'Slider Items',
                'min' => 0,
                'layout' => 'block',
                'button_label' => 'Add Item',
            ])
            ->addFields(ReusableFields::image(args: [
                'required' => true,
            ]))
            ->addText('title', [
                'label' => 'Title',
                'required' => true,
            ])
            ->addLink('link', [
                'label' => 'Link',
                'required' => true,
            ])
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
