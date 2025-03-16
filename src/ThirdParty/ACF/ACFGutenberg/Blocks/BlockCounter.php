<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Blocks;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockCounter extends BaseBlock
{
    public static string $blockName = 'counter';

    public static string $blockTitle = 'Counter';

    public static string $blockIcon = 'performance';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/counter.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addRepeater('items', [
                'label' => 'Counter Items',
                'min' => 1,
                'layout' => 'table',
                'button_label' => 'Add Counter',
            ])
            ->addText('prefix', [
                'label' => 'Prefix',
            ])
            ->addNumber('number', [
                'label' => 'Number',
                'required' => true,
            ])
            ->addText('suffix', [
                'label' => 'Suffix',
            ])
            ->addText('text', [
                'label' => 'Text',
            ])
            ->addSelect('separator', [
                'label' => 'Thousand Separator',
                'choices' => [
                    '.' => 'Dot (.)',
                    ',' => 'Comma (,)',
                    ' ' => 'Space',
                ],
                'default_value' => ',',
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
