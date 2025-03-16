<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Blocks;

use App\ThirdParty\ACF\ACFFields\ReusableFields;
use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockCompanyDetails extends BaseBlock
{
    public static string $blockName = 'company-details';

    public static string $blockTitle = 'Company Details';

    public static string $blockIcon = 'screenoptions';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/company-details.twig', $context);
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
