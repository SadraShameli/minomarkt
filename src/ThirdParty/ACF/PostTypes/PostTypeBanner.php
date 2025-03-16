<?php

namespace App\ThirdParty\ACF\PostTypes;

use App\ThirdParty\ACF\Base\BasePostType;
use App\ThirdParty\ACF\Reusable\ReusableFields;

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
