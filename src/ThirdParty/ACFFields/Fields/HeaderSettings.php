<?php

namespace App\ThirdParty\ACFFields\Fields;

use App\ThirdParty\ACFFields\BaseACFGroup;
use App\ThirdParty\ACFFields\ReusableFields;

class HeaderSettings extends BaseACFGroup
{
    public function __construct()
    {
        $this->createHeaderSettingsGroup();
    }

    protected function createHeaderSettingsGroup(): void
    {
        $fields = self::setupGroup('OPT: Header');

        // @phpstan-ignore-next-line
        $fields
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
            ->setLocation('options_page', '==', 'acf-options-header')
        ;

        self::createGroup($fields);
    }
}
