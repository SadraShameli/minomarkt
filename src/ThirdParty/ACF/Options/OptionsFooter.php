<?php

namespace App\ThirdParty\ACF\Options;

use App\ThirdParty\ACF\Base\BaseOptions;
use App\ThirdParty\ACF\Reusable\ReusableFields;

class OptionsFooter extends BaseOptions
{
    public static string $pageTitle = 'Footer Settings';

    public static string $menuTitle = 'Footer';

    public static string $menuSlug = 'footer';

    protected bool $isMain = false;

    protected function getParentSlug(): string|null
    {
        return OptionsGeneral::$menuSlug;
    }

    protected function addFields(): void
    {
        // @phpstan-ignore-next-line
        $this->fields
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
        ;
    }
}
