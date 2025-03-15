<?php

namespace App\ThirdParty\ACFFields\Fields;

use App\ThirdParty\ACFFields\BaseACFGroup;
use App\ThirdParty\ACFFields\ReusableFields;


class FooterSettings extends BaseACFGroup
{
    public function __construct()
    {
        $this->createFooterSettingsGroup();
    }

    protected function createFooterSettingsGroup(): void
    {
        $fields = self::setupGroup('OPT: Footer');

        // @phpstan-ignore-next-line
        $fields
            ->addGroup('footer', [
                'label' => 'Footer',
            ])
            ->addFields(ReusableFields::tabContent())
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addFields(ReusableFields::wysiwyg('description'))
            ->addField('form', 'forms', [
                'label' => 'Form',
                'return_format' => 'post_object',
                'allow_null' => false,
                'multiple' => false,
            ])
            ->addTab('contact', [
                'label' => 'Contact',
            ])
            ->addGroup('contact', [
                'label' => 'Contact',
            ])
            ->addFields(ReusableFields::wysiwyg())
            ->addFields(ReusableFields::button())
            ->addRepeater('items', [
                'label' => 'Items',
                'layout' => 'block',
                'button_label' => 'Add Item',
            ])
            ->addFields(ReusableFields::icon())
            ->addText('text', [
                'label' => 'Text',
            ])
            ->endRepeater()
            ->endGroup()
            ->addTab('logos', [
                'label' => 'Logos',
            ])
            ->addRepeater('footer_logos', [
                'label' => 'Logos',
                'layout' => 'block',
                'button_label' => 'Add Logo',
                'rows_per_page' => 20,
            ])
            ->addFields(ReusableFields::image('logo', 'Logo'))
            ->endRepeater()
            ->addFields(ReusableFields::tabSettings())
            ->addGroup('settings', [
                'label' => 'Settings',
            ])
            ->addTrueFalse('show_logo', [
                'label' => 'Show Logo',
                'default_value' => 0,
                'ui' => true,
            ])
            ->addTrueFalse('show_logos', [
                'label' => 'Show Logos',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_socials', [
                'label' => 'Show Socials',
                'ui' => true,
                'default_value' => true,
            ])
            ->endGroup()
            ->endGroup()
            ->setLocation('options_page', '==', 'acf-options-footer')
        ;

        self::createGroup($fields);
    }
}
