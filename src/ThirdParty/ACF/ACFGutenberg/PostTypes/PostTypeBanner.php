<?php

namespace App\ThirdParty\ACF\ACFGutenberg\PostTypes;

use App\ThirdParty\ACF\ACFGutenberg\Base\BasePostType;
use App\ThirdParty\ACF\ACFFields\ReusableFields;

class PostTypeBanner extends BasePostType
{
    public static string $postTypeName = 'banner';

    public static string $pluralName = 'Banners';

    public static string $singularName = 'Banner';

    public static string $slug = 'banner';

    public static string $menuIcon = 'dashicons-vault';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::wysiwyg())
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
