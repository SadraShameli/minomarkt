<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockHero extends BaseBlock
{
    public static string $blockName = 'hero';

    public static string $blockTitle = 'Hero';

    public static string $blockIcon = 'superhero-alt';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/block-hero.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addFields(ReusableFields::image())
            ->addRepeater('buttons')
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
