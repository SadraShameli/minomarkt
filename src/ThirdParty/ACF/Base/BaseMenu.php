<?php

namespace App\ThirdParty\ACF\Base;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use Timber\Timber;
use Timber\Menu;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BaseMenu
{
    public static string $menuTitle;

    public static string $menuSlug;

    public static string $menuName;

    protected FieldsBuilder $fields;

    /** @var BaseMenu[] */
    protected static array $instances = [];

    public function __construct()
    {
        static::$instances[] = $this;
    }

    public static function register(): void
    {
        usort(static::$instances, static fn(BaseMenu $a, BaseMenu $b): int => strcmp($a::$menuSlug, $b::$menuSlug));

        foreach (static::$instances as $instance) {
            $instance->registerMenu();
            $instance->createFieldsGroup();
        }
    }

    /**
     * @return array<string, Menu|null>
     */
    public static function getMenus(): array
    {
        $menus = [];

        foreach (static::$instances as $instance) {
            $menus[$instance::$menuName] = Timber::get_menu($instance::$menuSlug);
        }

        return $menus;
    }

    abstract protected function addFields(): void;

    private function registerMenu(): void
    {
        register_nav_menu(static::$menuSlug, static::$menuTitle);
    }

    private function createFieldsGroup(): void
    {
        $this->fields = ReusableFields::setupGroup('Menu: ' . static::$menuTitle);

        $this->addFields();

        $this->fields->setLocation('nav_menu', '==', 'location/' . static::$menuSlug);

        acf_add_local_field_group($this->fields->build());
    }
}
