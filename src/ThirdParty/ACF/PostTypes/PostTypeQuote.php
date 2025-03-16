<?php

namespace App\ThirdParty\ACF\PostTypes;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BasePostType;

class PostTypeQuote extends BasePostType
{
    public static string $postTypeName = 'quote';

    public static string $pluralName = 'Quotes';

    public static string $singularName = 'Quote';

    public static string $slug = 'quotes';

    public static string $menuIcon = 'dashicons-format-quote';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::image())
            ->addText('role', [
                'label' => 'Role',
            ])
            ->addTextarea('quote', [
                'label' => 'Text',
            ])
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsRelations(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
