<?php

namespace App\ThirdParty\ACF\ACFFields;

class ReusableChoices
{
    /**
     * @return array<string, string>
     */
    public static function heading(): array
    {
        return [
            'h1' => 'Heading 1',
            'h2' => 'Heading 2',
            'h3' => 'Heading 3',
            'h4' => 'Heading 4',
            'h5' => 'Heading 5',
            'h6' => 'Heading 6',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function icon(): array
    {
        $icons = glob(get_template_directory() . '/assets/icons/*.svg');
        if (empty($icons)) {
            return [];
        }

        /** @var array<string, string> $choices */
        $choices = [];

        foreach ($icons as $icon) {
            $iconNameHyphenated = basename($icon, '.svg');
            $iconName = str_replace('-', ' ', $iconNameHyphenated);
            $choices[$iconNameHyphenated] = ucfirst($iconName);
        }

        return ['None' => ''] + $choices;
    }

    /**
     * @return array<string, string>
     */
    public static function textColor(): array
    {
        return [
            'default' => 'Default',
            'primary-500' => 'Primary',
            'secondary-500' => 'Secondary',
            'white' => 'White',
            'black' => 'Black',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function bgColor(): array
    {
        return [
            'default' => 'Default',
            'primary-500' => 'Primary',
            'secondary-500' => 'Secondary',
            'white' => 'White',
            'black' => 'Black',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function btnTypes(): array
    {
        return [
            'primary' => 'Primary',
            'primary-outline' => 'Primary outline',
            'secondary' => 'Secondary',
            'secondary-outline' => 'Secondary outline',
            'white' => 'White',
            'black' => 'Black',
            'link' => 'Link',
        ];
    }
}
