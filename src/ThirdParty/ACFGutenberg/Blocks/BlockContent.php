<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockContent extends BaseBlock
{
    public static string $blockName = 'content';

    public static string $blockTitle = 'Content';

    public static string $blockIcon = 'text';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['content'])) {
            return;
        }

        Timber::render('blocks/block-content.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::wysiwyg())
            ->addRepeater('buttons', [
                'label' => 'Buttons',
                'layout' => 'table',
                'button_label' => 'Add Row',
            ])
            ->addFields(ReusableFields::button())
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addSelect('content_size', [
                'label' => 'Content size',
                'choices' => [
                    'small' => 'Small',
                    'default' => 'Default',
                    'large' => 'Large',
                    'huge' => 'Huge',
                    'giga' => 'Giga',
                ],
                'default_value' => 'default',
                'return_format' => 'value',
                'allow_null' => false,
            ])
        ;
    }
}
