<?php

namespace App\ThirdParty\ACF\Base;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BaseOptions
{
    public static string $pageTitle;

    public static string $menuTitle;

    public static string $menuSlug;

    protected FieldsBuilder $fields;

    protected bool $isMain;

    /** @var BaseOptions[] */
    protected static array $instances = [];

    public function __construct()
    {
        static::$instances[] = $this;

        if ($this->isMain) {
            acf_add_options_page([
                'menu_slug' => static::$menuSlug,
                'menu_title' => static::$menuTitle,
                'page_title' => static::$pageTitle,
                'redirect' => false,
            ]);
        }
    }

    public static function register(): void
    {
        usort(static::$instances, static fn (BaseOptions $a, BaseOptions $b): int => strcmp($a::$menuSlug, $b::$menuSlug));

        foreach (static::$instances as $instance) {
            $instance->registerOptions();
            $instance->createFieldsGroup();
        }
    }

    abstract protected function getParentSlug(): string|null;

    abstract protected function addFields(): void;

    private function registerOptions(): void
    {
        if ($this->isMain) {
            return;
        }

        acf_add_options_sub_page([
            'menu_title' => static::$menuTitle,
            'page_title' => static::$pageTitle,
            'parent_slug' => $this->getParentSlug(),
        ]);
    }

    private function createFieldsGroup(): void
    {
        $this->fields = ReusableFields::setupGroup('Options: ' . static::$menuTitle);

        $this->addFields();

        if ($this->isMain) {
            $this->fields->setLocation('options_page', '==', static::$menuSlug);
        } else {
            $this->fields->setLocation('options_page', '==', 'acf-options-' . static::$menuSlug);
        }

        acf_add_local_field_group($this->fields->build());
    }
}
