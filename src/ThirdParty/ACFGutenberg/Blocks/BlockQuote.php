<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockQuote extends BaseBlock
{
    public static string $blockName = 'quote';

    public static string $blockTitle = 'Quote';

    public static string $blockIcon = 'format-quote';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['text'])) {
            return;
        }

        Timber::render('blocks/block-quote.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addTextarea('text', [
                'label' => 'Text',
                'required' => true,
            ])
            ->addText('subtitle', [
                'label' => 'Subtitle',
            ])
            ->addFields(ReusableFields::button())
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
