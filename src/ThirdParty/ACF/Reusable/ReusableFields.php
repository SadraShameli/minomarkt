<?php

namespace App\ThirdParty\ACF\Reusable;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ReusableFields
{
    public static function setupGroup(
        string $title,
    ): FieldsBuilder {
        return new FieldsBuilder(sanitize_title_with_dashes($title), [
            'title' => $title,
        ]);
    }

    public static function tabContent(): FieldsBuilder
    {
        $fields = new FieldsBuilder('content');

        $fields
            ->addTab('content', [
                'label' => 'Content',
            ])
        ;

        return $fields;
    }

    public static function tabRelations(): FieldsBuilder
    {
        $fields = new FieldsBuilder('relations');

        $fields
            ->addTab('relations', [
                'label' => 'Relations',
            ])
        ;

        return $fields;
    }

    public static function tabSettings(): FieldsBuilder
    {
        $fields = new FieldsBuilder('settings');

        $fields
            ->addTab('settings', [
                'label' => 'Settings',
            ])
        ;

        return $fields;
    }

    public static function tabLayout(): FieldsBuilder
    {
        $fields = new FieldsBuilder('layout');

        $fields
            ->addTab('layout', [
                'label' => 'Layout',
            ])
        ;

        return $fields;
    }

    public static function spacing(): FieldsBuilder
    {
        $fields = new FieldsBuilder('spacing');

        $fields
            ->addTrueFalse('spacing_top', [
                'label' => 'Spacing Top',
                'ui' => true,
            ])
            ->addTrueFalse('spacing_bottom', [
                'label' => 'Spacing Bottom',
                'ui' => true,
            ])
        ;

        return $fields;
    }

    public static function width(): FieldsBuilder
    {
        $fields = new FieldsBuilder('width');

        $fields
            ->addSelect('width', [
                'label' => 'Width',
                'choices' => [
                    '' => 'Default',
                    'boxed' => 'Boxed',
                ],
                'default_value' => 'full',
                'return_format' => 'value',
                'allow_null' => false,
            ])
        ;

        return $fields;
    }

    public static function anchor(): FieldsBuilder
    {
        $fields = new FieldsBuilder('anchor');

        $fields
            ->addText('anchor', [
                'label' => 'Anchor',
            ])
        ;

        return $fields;
    }

    public static function textColor(): FieldsBuilder
    {
        $fields = new FieldsBuilder('color_text');

        $fields
            ->addSelect('color_text', [
                'label' => 'Text color',
                'choices' => ReusableChoices::textColor(),
                'default_value' => 'default',
                'return_format' => 'value',
                'allow_null' => false,
            ])
        ;

        return $fields;
    }

    public static function bgColor(): FieldsBuilder
    {
        $fields = new FieldsBuilder('color_bg');

        $fields
            ->addSelect('color_bg', [
                'label' => 'Background color',
                'choices' => ReusableChoices::bgColor(),
                'default_value' => 'default',
                'return_format' => 'value',
                'allow_null' => false,
            ])
        ;

        return $fields;
    }

    public static function title(
        string $fieldName = 'title',
        string $fieldLabel = 'Title',
        bool $includeType = false,
    ): FieldsBuilder {
        $fields = new FieldsBuilder($fieldName);

        $fields->addText($fieldName, [
            'label' => $fieldLabel,
            'wrapper' => [
                'width' => $includeType ? '70' : '100',
            ],
        ]);

        if ($includeType) {
            $fields->addSelect('type', [
                'label' => 'Heading',
                'choices' => ReusableChoices::heading(),
                'default_value' => 'h2',
                'return_format' => 'value',
                'allow_null' => false,
                'wrapper' => [
                    'width' => '30',
                ],
            ]);
        }

        return $fields;
    }

    /**
     * @param array<mixed> $args
     */
    public static function wysiwyg(
        string $fieldName = 'content',
        string $fieldLabel = 'Content',
        array $args = [],
    ): FieldsBuilder {
        $fields = new FieldsBuilder($fieldName);

        $fields->addWysiwyg($fieldName, [
            'label' => $fieldLabel,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
            'delay' => 1,
        ] + $args);

        return $fields;
    }

    /**
     * @param array<mixed> $args
     */
    public static function image(
        string $fieldName = 'image',
        string $fieldLabel = 'Image',
        array $args = [],
    ): FieldsBuilder {
        $fields = new FieldsBuilder($fieldName);

        $fields
            ->addImage($fieldName, [
                'label' => $fieldLabel,
                'preview_size' => 'medium',
                'return_format' => 'id',
            ] + $args)
        ;

        return $fields;
    }

    /**
     * @param array<mixed> $args
     */
    public static function imageFocusable(
        string $fieldName = 'image',
        string $fieldLabel = 'Image',
        array $args = [],
    ): FieldsBuilder {
        $fields = new FieldsBuilder($fieldName);

        $fields
            ->addField($fieldName, 'focuspoint', [
                'label' => $fieldLabel,
                'preview_size' => 'medium',
            ] + $args)
        ;

        return $fields;
    }

    /**
     * @param array<mixed> $args
     * @param mixed        $fieldName
     * @param mixed        $fieldLabel
     */
    public static function button(
        $fieldName = 'button',
        $fieldLabel = 'Button',
        array $args = [],
    ): FieldsBuilder {
        $fields = new FieldsBuilder($fieldName);

        $fields
            ->addGroup($fieldName, [
                'label' => $fieldLabel,
            ])
            ->addLink('link', [
                'label' => 'Link',
                'return_format' => 'array',
                'wrapper' => [
                    'width' => '50',
                ],
            ] + $args)
            ->addSelect('type', [
                'label' => 'Type',
                'choices' => ReusableChoices::btnTypes(),
                'default_value' => 'primary',
                'return_format' => 'value',
                'allow_null' => false,
                'wrapper' => [
                    'width' => '50',
                ],
            ] + $args)
            ->addFields(ReusableFields::icon(
                'icon_before',
                'Icon Before',
                [
                    'wrapper' => [
                        'width' => '50',
                    ],
                ] + $args,
            ))
            ->addFields(ReusableFields::icon(
                'icon_after',
                'Icon After',
                [
                    'wrapper' => [
                        'width' => '50',
                    ],
                ] + $args,
            ))
            ->endGroup()
        ;

        return $fields;
    }

    /**
     * @param array<mixed> $args
     */
    public static function icon(
        string $fieldName = 'icon',
        string $fieldLabel = 'Icon',
        array $args = [],
    ): FieldsBuilder {
        $fields = new FieldsBuilder($fieldName);

        $fields->addSelect($fieldName, [
            'label' => $fieldLabel,
            'choices' => ReusableChoices::icon(),
            'default_value' => 'none',
            'return_format' => 'value',
            'allow_null' => false,
        ] + $args);

        return $fields;
    }
}
