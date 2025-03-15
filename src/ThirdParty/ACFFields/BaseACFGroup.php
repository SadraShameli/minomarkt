<?php

namespace App\ThirdParty\ACFFields;

use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class BaseACFGroup
{
    public static function createGroup(FieldsBuilder $group): void
    {
        add_action('acf/init', static function () use ($group): void {
            acf_add_local_field_group($group->build());
        });
    }

    /**
     * @param array<mixed> $args
     */
    public static function setupGroup(
        string $title,
        int $menuOrder = 0,
        array $args = [],
    ): FieldsBuilder {
        return new FieldsBuilder(sanitize_title_with_dashes($title), array_merge([
            'title' => $title,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'menu_order' => $menuOrder,
        ], $args));
    }
}
