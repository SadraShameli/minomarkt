<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockCardGrid extends BaseBlock
{
    public static string $blockName = 'card-grid';

    public static string $blockTitle = 'Card Grid';

    public static string $blockIcon = 'grid-view';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/block-card-grid.twig', $context);
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
                'label' => 'Cards',
                'min' => 1,
                'layout' => 'block',
                'button_label' => 'Add Card',
            ])
            ->addFields(ReusableFields::icon(
                args: [
                    'required' => true,
                ],
            ))
            ->addText('title', [
                'label' => 'Title',
                'required' => true,
            ])
            ->addTextarea('description', [
                'label' => 'Description',
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
