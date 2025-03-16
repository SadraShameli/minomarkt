<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockFormQuote extends BaseBlock
{
    public static string $blockName = 'form-quote';

    public static string $blockTitle = 'Form Quote';

    public static string $blockIcon = 'feedback';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/form-quote.twig', $context);
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
            ->addGroup('person', [
                'label' => 'Contact Person',
            ])
            ->addTextarea('description', [
                'label' => 'Description',
            ])
            ->addText('name', [
                'label' => 'Name',
            ])
            ->addText('title', [
                'label' => 'Job Title',
            ])
            ->addEmail('email', [
                'label' => 'Email',
            ])
            ->addText('phone', [
                'label' => 'Phone',
            ])
            ->addFields(ReusableFields::image())
            ->endGroup()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
