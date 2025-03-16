<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Taxonomies;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseTaxonomy;

class TaxonomyFAQCategories extends BaseTaxonomy
{
    public static string $taxonomyName = 'faq_categories';

    public static string $pluralName = 'FAQ Categories';

    public static string $singularName = 'FAQ Category';

    public static string $slug = 'faq-categories';

    public static array|string $postType = 'faq';

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
