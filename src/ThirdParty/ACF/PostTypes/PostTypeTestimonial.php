<?php

namespace App\ThirdParty\ACF\PostTypes;

use App\ThirdParty\ACF\Base\BasePostType;

class PostTypeTestimonial extends BasePostType
{
    public static string $postTypeName = 'testimonial';

    public static string $pluralName = 'Testimonials';

    public static string $singularName = 'Testimonial';

    public static string $slug = 'testimonials';

    public static string $menuIcon = 'dashicons-format-quote';

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addTextarea('quote', [
                'label' => 'Quote',
                'required' => 1,
                'rows' => 4,
            ])
            ->addText('author', [
                'label' => 'Author',
            ])
            ->addNumber('rating', [
                'label' => 'Rating',
                'min' => 1,
                'max' => 5,
                'step' => 1,
            ])
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'id',
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
