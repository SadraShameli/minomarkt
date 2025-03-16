<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockButton extends BaseBlock
{
    public static string $blockName = 'button';

    public static string $blockTitle = 'Button';

    public static string $blockIcon = 'button';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/button.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addRepeater('buttons', [
                'min' => 1,
                'layout' => 'block',
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
    }
}
