<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockImageGrid extends BaseBlock
{
    public static string $blockName = 'image-grid';

    public static string $blockTitle = 'Image Grid';

    public static string $blockIcon = 'grid-view';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/block-image-grid.twig', $context);
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
                'label' => 'Grid Items',
                'min' => 3,
                'max' => 3,
                'layout' => 'block',
                'button_label' => 'Add Item',
            ])
            ->addFields(ReusableFields::image(args: [
                'required' => true,
            ]))
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
