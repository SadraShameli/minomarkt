<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockTeamMembers extends BaseBlock
{
    public static string $blockName = 'team-members';

    public static string $blockTitle = 'Team Members';

    public static string $blockIcon = 'groups';

    public static array $blockKeywords = ['staff', 'employees', 'people', 'team'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['selected_people'])) {
            return;
        }

        Timber::render('blocks/team-members.twig', $context);
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
            ->addRelationship('selected_people', [
                'label' => 'Team Members',
                'post_type' => 'people',
                'return_format' => 'id',
                'min' => 0,
                'max' => '',
                'filters' => [
                    'search',
                    'post_type',
                ],
                'elements' => [
                    'featured_image',
                ],
            ])
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addSelect('layout_style', [
                'label' => 'Layout Style',
                'choices' => [
                    'grid' => 'Grid',
                    'list' => 'List',
                    'carousel' => 'Carousel',
                ],
                'default_value' => 'grid',
            ])
            ->addSelect('columns', [
                'label' => 'Columns (Desktop)',
                'choices' => [
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                ],
                'default_value' => '3',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'layout_style',
                            'operator' => '==',
                            'value' => 'grid',
                        ],
                    ],
                ],
            ])
            ->addSelect('card_style', [
                'label' => 'Card Style',
                'choices' => [
                    'basic' => 'Basic',
                    'shadow' => 'Shadow',
                    'border' => 'Border',
                    'hover' => 'Hover Effect',
                ],
                'default_value' => 'basic',
            ])
            ->addSelect('image_style', [
                'label' => 'Image Style',
                'choices' => [
                    'square' => 'Square',
                    'circle' => 'Circle',
                    'rounded' => 'Rounded',
                ],
                'default_value' => 'rounded',
            ])
            ->addTrueFalse('show_bio_popup', [
                'label' => 'Show Biography in Popup',
                'instructions' => 'Show full bio in a popup when clicked',
                'ui' => true,
                'default_value' => 0,
            ])
        ;
    }
}