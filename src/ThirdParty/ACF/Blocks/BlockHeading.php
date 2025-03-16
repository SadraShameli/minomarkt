<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockHeading extends BaseBlock
{
    public static string $blockName = 'heading';

    public static string $blockTitle = 'Heading';

    public static string $blockIcon = 'heading';

    public static array $blockKeywords = ['title'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['title'])) {
            return;
        }

        Timber::render('blocks/heading.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::title(includeType: true))
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addSelect('size', [
                'label' => 'Size',
                'choices' => [
                    'default' => 'Default',
                    'xsmall' => 'XS',
                    'small' => 'S',
                    'medium' => 'M',
                    'large' => 'L',
                    'xlarge' => 'XL',
                    'xxlarge' => 'XXL',
                ],
                'default_value' => 'default',
                'return_format' => 'value',
                'allow_null' => false,
            ])
        ;
    }
}
