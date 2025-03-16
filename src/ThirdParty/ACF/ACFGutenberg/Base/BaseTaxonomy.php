<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Base;

use App\ThirdParty\ACF\ACFFields\BaseACFGroup;
use App\ThirdParty\ACF\ACFFields\ReusableFields;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BaseTaxonomy
{
    public static string $taxonomyName;

    public static string $pluralName;

    public static string $singularName;

    public static string $slug;

    /** @var array<string>|string */
    public static array|string $postType;

    protected FieldsBuilder $fields;

    /** @var BaseTaxonomy[] */
    protected static array $instances = [];

    public function __construct()
    {
        static::$instances[] = $this;
    }

    public static function register(): void
    {
        usort(static::$instances, static fn ($a, $b): int => strcmp($a::$singularName, $b::$singularName));

        foreach (static::$instances as $instance) {
            $instance->registerTaxonomy();
            $instance->createFieldsGroup();
        }
    }

    protected function registerTaxonomy(): void
    {
        $labels = [
            'add_new_item' => 'Add New ' . static::$singularName,
            'all_items' => 'All ' . static::$pluralName,
            'edit_item' => 'Edit ' . static::$singularName,
            'menu_name' => ucfirst(static::$pluralName),
            'name' => ucfirst(static::$pluralName),
            'new_item_name' => 'New ' . static::$singularName,
            'parent_item_colon' => 'Parent ' . static::$singularName . ':',
            'parent_item' => 'Parent ' . static::$singularName,
            'search_items' => 'Search ' . static::$pluralName,
            'singular_name' => ucfirst(static::$singularName),
            'update_item' => 'Update ' . static::$singularName,
        ];

        register_taxonomy(static::$taxonomyName, static::$postType, [
            'hierarchical' => true,
            'labels' => $labels,
            'public' => true,
            'query_var' => true,
            'rewrite' => [
                'slug' => static::$slug,
                'with_front' => false,
            ],
            'show_admin_column' => true,
            'show_in_rest' => true,
            'show_ui' => true,
        ]);
    }

    protected function createFieldsGroup(): void
    {
        $this->fields = BaseACFGroup::setupGroup('Taxonomy: ' . static::$pluralName);

        $this->addFieldsContentDefault();
        $this->addFieldsContent();
        $this->addFields();
        $this->addFieldsSettingsDefault();
        $this->addFieldsSettings();

        $this->fields->setLocation('taxonomy', '==', static::$taxonomyName);

        BaseACFGroup::createGroup($this->fields);
    }

    abstract protected function addFields(): void;

    abstract protected function addFieldsContent(): void;

    abstract protected function addFieldsSettings(): void;

    private function addFieldsContentDefault(): void
    {
        $this->fields
            ->addFields(ReusableFields::tabContent())
        ;
    }

    private function addFieldsSettingsDefault(): void
    {
        $this->fields
            ->addFields(ReusableFields::tabSettings())
            ->addTrueFalse('is_featured', [
                'label' => 'Featured',
                'instructions' => 'Mark this ' . static::$singularName . ' as featured',
                'ui' => true,
            ])
        ;
    }
}
