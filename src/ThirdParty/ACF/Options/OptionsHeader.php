<?php

namespace App\ThirdParty\ACF\Options;

use App\ThirdParty\ACF\Base\BaseOptions;
use App\ThirdParty\ACF\Reusable\ReusableFields;

class OptionsHeader extends BaseOptions
{
    public static string $pageTitle = 'Header Settings';

    public static string $menuTitle = 'Header';

    public static string $menuSlug = 'header';

    protected bool $isMain = false;

    protected function getParentSlug(): string|null
    {
        return OptionsGeneral::$menuSlug;
    }

    protected function addFields(): void
    {
        // @phpstan-ignore-next-line
        $this->fields
            ->addGroup('header', [
                'label' => 'Header',
            ])
            ->addFields(ReusableFields::tabContent())
            ->addRepeater('menu_buttons', [
                'label' => 'Menu buttons',
                'layout' => 'block',
            ])
            ->addFields(ReusableFields::button())
            ->endRepeater()
            ->addFields(ReusableFields::tabSettings())
            ->addGroup('settings', [
                'label' => 'Settings',
            ])
            ->addTrueFalse('show_logo', [
                'label' => 'Show logo',
                'ui' => true,
            ])
            ->addTrueFalse('show_site_name', [
                'label' => 'Show site name',
                'ui' => true,
                'default_value' => true,
            ])
            ->endGroup()
            ->endGroup()
        ;
    }
}
