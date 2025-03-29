<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockComparisonTable extends BaseBlock
{
    public static string $blockName = 'comparison-table';

    public static string $blockTitle = 'Comparison Table';

    public static string $blockIcon = 'table-col-after';

    public static array $blockKeywords = ['pricing', 'compare', 'features', 'table'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['columns'])) {
            return;
        }

        Timber::render('blocks/comparison-table.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addTextarea('description', [
                'label' => 'Description',
            ])
            ->addRepeater('columns', [
                'label' => 'Table Columns',
                'min' => 0,
                'max' => 5,
                'layout' => 'block',
                'button_label' => 'Add Column',
            ])
            ->addText('column_title', [
                'label' => 'Column Title',
                'required' => true,
            ])
            ->addText('column_subtitle', [
                'label' => 'Column Subtitle',
            ])
            ->addText('price', [
                'label' => 'Price',
            ])
            ->addText('price_suffix', [
                'label' => 'Price Suffix',
                'instructions' => 'e.g., "/month", "/user", etc.',
            ])
            ->addTextarea('description', [
                'label' => 'Description',
            ])
            ->addFields(ReusableFields::image(
                fieldName: 'icon',
                fieldLabel: 'Icon',
            ))
            ->addLink('button', [
                'label' => 'Button',
            ])
            ->addTrueFalse('featured', [
                'label' => 'Featured Column',
                'instructions' => 'Highlight this column',
                'ui' => true,
                'default_value' => 0,
            ])
            ->addColorPicker('custom_color', [
                'label' => 'Custom Column Color',
            ])
            ->endRepeater()
            ->addRepeater('features', [
                'label' => 'Feature Rows',
                'min' => 1,
                'layout' => 'block',
                'button_label' => 'Add Feature Row',
            ])
            ->addText('feature_title', [
                'label' => 'Feature Title',
                'required' => true,
            ])
            ->addText('feature_description', [
                'label' => 'Feature Description',
            ])
            ->addTrueFalse('is_heading', [
                'label' => 'Is Section Heading',
                'instructions' => 'Make this row a section heading',
                'ui' => true,
                'default_value' => 0,
            ])
            ->addRepeater('feature_values', [
                'label' => 'Column Values',
                'min' => 2,
                'max' => 5,
                'layout' => 'table',
                'button_label' => 'Add Value',
            ])
            ->addSelect('value_type', [
                'label' => 'Value Type',
                'choices' => [
                    'text' => 'Text',
                    'yes_no' => 'Yes/No',
                    'icon' => 'Icon',
                ],
                'default_value' => 'yes_no',
            ])
            ->addText('text_value', [
                'label' => 'Text Value',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'value_type',
                            'operator' => '==',
                            'value' => 'text',
                        ],
                    ],
                ],
            ])
            ->addSelect('yes_no_value', [
                'label' => 'Yes/No Value',
                'choices' => [
                    'yes' => 'Yes',
                    'no' => 'No',
                    'partial' => 'Partial',
                ],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'value_type',
                            'operator' => '==',
                            'value' => 'yes_no',
                        ],
                    ],
                ],
            ])
            ->addSelect('icon_value', [
                'label' => 'Icon',
                'choices' => [
                    'check' => 'Check',
                    'cross' => 'Cross',
                    'arrow' => 'Arrow',
                    'star' => 'Star',
                    'info' => 'Info',
                ],
                'conditional_logic' => [
                    [
                        [
                            'field' => 'value_type',
                            'operator' => '==',
                            'value' => 'icon',
                        ],
                    ],
                ],
            ])
            ->endRepeater()
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addSelect('table_style', [
                'label' => 'Table Style',
                'choices' => [
                    'default' => 'Default',
                    'boxed' => 'Boxed',
                    'minimal' => 'Minimal',
                    'striped' => 'Striped',
                ],
                'default_value' => 'default',
            ])
            ->addTrueFalse('sticky_header', [
                'label' => 'Sticky Header',
                'instructions' => 'Keep table header visible when scrolling',
                'ui' => true,
                'default_value' => 0,
            ])
            ->addTrueFalse('highlight_differences', [
                'label' => 'Highlight Differences',
                'instructions' => 'Automatically highlight cells with different values',
                'ui' => true,
                'default_value' => 0,
            ])
            ->addTrueFalse('mobile_accordion', [
                'label' => 'Mobile Accordion View',
                'instructions' => 'Show as accordion on mobile devices',
                'ui' => true,
                'default_value' => 1,
            ])
        ;
    }
}