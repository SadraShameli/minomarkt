<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockSplitContent extends BaseBlock
{
    public static string $blockName = 'split-content';

    public static string $blockTitle = 'Split Content';

    public static string $blockIcon = 'columns';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['description']) || (empty($fields['image']) && empty($fields['video']))) {
            return;
        }

        Timber::render('blocks/block-split-content.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addFields(ReusableFields::wysiwyg('description'))
            ->addFields(ReusableFields::button())
            ->addFields(ReusableFields::image(args: [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => 'image',
                        ],
                    ],
                ],
            ]))
            ->addText('video', [
                'label' => 'Video',
                'required' => true,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => 'video',
                        ],
                    ],
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
            ->addTrueFalse('content_order', [
                'label' => 'Content Order',
                'ui' => true,
                'ui_on_text' => 'Left',
                'ui_off_text' => 'Right',
            ])
            ->addTrueFalse('media_inside', [
                'label' => 'Media Inside',
                'ui' => true,
            ])
            ->addSelect('media_type', [
                'label' => 'Media Type',
                'choices' => [
                    'image' => 'Image',
                    'video' => 'Video',
                ],
                'default_value' => 'image',
                'required' => true,
            ])
        ;
    }
}
