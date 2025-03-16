<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Blocks;

use App\ThirdParty\ACF\ACFFields\ReusableFields;
use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockSplitIcon extends BaseBlock
{
    public static string $blockName = 'split-icon';

    public static string $blockTitle = 'Split Icon';

    public static string $blockIcon = 'columns';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['icons'])) {
            return;
        }

        Timber::render('blocks/split-icon.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
                'required' => true,
            ])
            ->addRepeater('icons', [
                'label' => 'Icons',
                'min' => 1,
                'max' => 3,
            ])
            ->addFields(ReusableFields::icon(args: [
                'required' => true,
            ]))
            ->addText('title', [
                'label' => 'Title',
                'required' => true,
            ])
            ->addFields(ReusableFields::wysiwyg(args: [
                'required' => true,
            ]))
            ->addFields(ReusableFields::button())
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
