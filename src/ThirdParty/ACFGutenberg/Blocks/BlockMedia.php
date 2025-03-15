<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockMedia extends BaseBlock
{
    public static string $blockName = 'media';

    public static string $blockTitle = 'Media';

    public static string $blockIcon = 'format-video';

    public static array $blockKeywords = ['image', 'video'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['video']) && empty($fields['image_id'])) {
            return;
        }

        $context['mediaWidth'] = match ($fields['media_width'] ?? null) {
            'large' => 'col-12 col-md-10',
            'medium' => 'col-10 col-md-8',
            'small' => 'col-8 col-md-6',
            default => 'col-12',
        };

        Timber::render('blocks/block-media.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addFields(ReusableFields::image(args: [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => '0',
                        ],
                    ],
                ],
            ]))
            ->addOembed('video', [
                'label' => 'Video',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->addText('caption', [
                'label' => 'Caption',
            ])
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addTrueFalse('media_type', [
                'label' => 'Media type',
                'message' => '',
                'ui' => true,
                'default_value' => true,
                'ui_on_text' => 'Video',
                'ui_off_text' => 'Image',
            ])
            ->addSelect('media_width', [
                'label' => 'Media width',
                'choices' => [
                    'full' => 'Full width',
                    'large' => 'Large width',
                    'medium' => 'Medium width',
                    'small' => 'Small width',
                ],
                'default_value' => 'full',
                'return_format' => 'value',
                'allow_null' => false,
            ])
            ->addSelect('media_ratio', [
                'label' => 'Media ratio',
                'choices' => [
                    '1x1' => '1:1',
                    '4x3' => '4:3',
                    '16x9' => '16:9',
                    '21x9' => '21:9',
                ],
                'default_value' => '16x9',
                'return_format' => 'value',
                'allow_null' => false,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '!=',
                            'value' => '1',
                        ],
                    ],
                ],
            ])
        ;
    }
}
