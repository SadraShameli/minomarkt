<?php

namespace App\ThirdParty\ACF\Base;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BasePostType
{
    public static string $postTypeName;

    public static string $pluralName;

    public static string $singularName;

    public static string $slug;

    public static string $menuIcon = 'dashicons-admin-post';

    /** @var array<string> */
    public static array $supports = [];

    protected FieldsBuilder $fields;

    /** @var BasePostType[] */
    protected static array $instances = [];

    public function __construct()
    {
        static::$instances[] = $this;
    }

    public static function register(): void
    {
        usort(static::$instances, static fn (BasePostType $a, BasePostType $b): int => strcmp($a::$singularName, $b::$singularName));

        foreach (static::$instances as $instance) {
            $instance->registerPostType();
            $instance->createFieldsGroup();
        }
    }

    abstract protected function addFields(): void;

    abstract protected function addFieldsContent(): void;

    abstract protected function addFieldsRelations(): void;

    abstract protected function addFieldsSettings(): void;

    private function registerPostType(): void
    {
        $labels = [
            'add_new_item' => 'Add New ' . static::$singularName,
            'add_new' => 'Add New',
            'all_items' => 'All ' . static::$pluralName,
            'attributes' => ucfirst(static::$singularName) . ' attributes',
            'edit_item' => 'Edit ' . static::$singularName,
            'featured_image' => 'Featured Image',
            'filter_items_list' => 'Filter ' . static::$pluralName . ' list',
            'insert_into_item' => 'Insert into ' . static::$singularName,
            'items_list_navigation' => static::$pluralName . ' list navigation',
            'items_list' => static::$pluralName . ' list',
            'menu_name' => static::$pluralName,
            'name_admin_bar' => static::$singularName,
            'name' => static::$pluralName,
            'new_item' => 'New ' . static::$singularName,
            'not_found_in_trash' => 'Not found in Trash',
            'not_found' => 'Not found',
            'parent_item_colon' => 'Parent ' . static::$singularName . ':',
            'remove_featured_image' => 'Remove featured image',
            'search_items' => 'Search ' . static::$pluralName,
            'set_featured_image' => 'Set featured image',
            'singular_name' => static::$singularName,
            'update_item' => 'Update ' . static::$singularName,
            'uploaded_to_this_item' => 'Uploaded to this ' . static::$singularName,
            'use_featured_image' => 'Use as featured image',
            'view_item' => 'View ' . static::$singularName,
            'view_items' => 'View ' . static::$pluralName,
        ];

        static::$supports = array_merge(static::$supports, ['title', 'thumbnail', 'custom-fields']);

        register_post_type(
            static::$postTypeName,
            [
                'exclude_from_search' => false,
                'has_archive' => false,
                'hierarchical' => true,
                'labels' => $labels,
                'menu_icon' => static::$menuIcon,
                'menu_position' => 5,
                'public' => false,
                'publicly_queryable' => false,
                'rewrite' => [
                    'slug' => static::$slug,
                    'with_front' => true,
                ],
                'show_in_admin_bar' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_rest' => true,
                'show_ui' => true,
                'supports' => static::$supports,
                'taxonomies' => [],
            ],
        );
    }

    private function createFieldsGroup(): void
    {
        $this->fields = ReusableFields::setupGroup('CPT: ' . static::$pluralName);

        $this->addFieldsContentDefault();
        $this->addFieldsContent();
        $this->addFields();
        $this->addFieldsRelationsDefault();
        $this->addFieldsRelations();
        $this->addFieldsSettingsDefault();
        $this->addFieldsSettings();

        $this->fields->setLocation('post_type', '==', static::$postTypeName);

        acf_add_local_field_group($this->fields->build());
    }

    private function addFieldsContentDefault(): void
    {
        $this->fields
            ->addFields(ReusableFields::tabContent())
        ;
    }

    private function addFieldsRelationsDefault(): void
    {
        $this->fields
            ->addFields(ReusableFields::tabRelations())
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

        $this->addFieldsSettings();
    }
}
