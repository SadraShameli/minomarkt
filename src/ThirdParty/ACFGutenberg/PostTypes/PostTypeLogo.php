<?php

namespace App\ThirdParty\ACFGutenberg\PostTypes;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BasePostType;

class PostTypeLogo extends BasePostType
{
    public static string $postTypeName = 'logo';

    public static string $pluralName = 'Logos';

    public static string $singularName = 'Logo';

    public static string $slug = 'logos';

    public static string $menuIcon = 'dashicons-images-alt2';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::image())
            ->addLink('link', [
                'label' => 'Link',
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
