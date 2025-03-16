<?php

namespace App\ThirdParty\ACF\PostTypes;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BasePostType;

class PostTypePeople extends BasePostType
{
    public static string $postTypeName = 'people';

    public static string $pluralName = 'People';

    public static string $singularName = 'Person';

    public static string $slug = 'people';

    public static string $menuIcon = 'dashicons-businessperson';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::wysiwyg())
            ->addEmail('people_mail', [
                'label' => 'Email',
            ])
            ->addText('people_first_name', [
                'label' => 'First name',
            ])
            ->addText('people_last_name', [
                'label' => 'Last name',
            ])
            ->addFields(ReusableFields::image('people_profile_image', 'Profile image'))
            ->addText('people_phone', [
                'label' => 'Phone number',
            ])
            ->addText('people_function', [
                'label' => 'Function',
            ])
            ->addText('people_expertise', [
                'label' => 'Expertise',
            ])
            ->addFields(ReusableFields::wysiwyg('people_bio', 'Bio'))
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
