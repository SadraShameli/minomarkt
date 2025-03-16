<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Taxonomies;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseTaxonomy;

class TaxonomyProductCategories extends BaseTaxonomy
{
    public static string $taxonomyName = 'product_categories';

    public static string $pluralName = 'Product Categories';

    public static string $singularName = 'Product Category';

    public static string $slug = 'product-categories';

    public static array|string $postType = 'product';

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
