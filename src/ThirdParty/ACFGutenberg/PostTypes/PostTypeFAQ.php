<?php

namespace App\ThirdParty\ACFGutenberg\PostTypes;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BasePostType;

class PostTypeFAQ extends BasePostType
{
    public static string $postTypeName = 'faq';

    public static string $pluralName = 'FAQs';

    public static string $singularName = 'FAQ';

    public static string $slug = 'faqs';

    public static string $menuIcon = 'dashicons-editor-help';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::wysiwyg('answer', 'Answer', [
                'required' => true,
            ]))
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsRelations(): void
    {
        $this->fields
            ->addRelationship('related_products', [
                'label' => 'Related Products',
                'instructions' => 'Products this FAQ applies to',
                'post_type' => PostTypeProduct::$postTypeName,
                'filters' => ['search'],
                'elements' => ['featured_image'],
            ])
            ->addRelationship('related_faqs', [
                'label' => 'Related FAQs',
                'instructions' => 'Other related FAQs',
                'post_type' => PostTypeFAQ::$postTypeName,
                'filters' => ['search'],
            ])
        ;
    }

    protected function addFieldsSettings(): void
    {
    }
}
