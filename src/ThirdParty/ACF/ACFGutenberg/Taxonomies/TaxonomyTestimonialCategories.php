<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Taxonomies;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseTaxonomy;

class TaxonomyTestimonialCategories extends BaseTaxonomy
{
    public static string $taxonomyName = 'testimonial_categories';

    public static string $pluralName = 'Testimonial Categories';

    public static string $singularName = 'Testimonial Category';

    public static string $slug = 'testimonial-categories';

    public static array|string $postType = 'testimonial';

    protected function addFieldsContent(): void
    {
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
