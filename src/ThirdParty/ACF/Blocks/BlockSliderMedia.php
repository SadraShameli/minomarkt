<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockSliderMedia extends BaseBlock
{
    public static string $blockName = 'slider-media';

    public static string $blockTitle = 'Media Slider';

    public static string $blockIcon = 'slides';

    public static array $blockKeywords = ['slider', 'gallery', 'image', 'video', 'media'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['items'])) {
            return;
        }

        Timber::render('blocks/slider-media.twig', $context);
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
            ->addRepeater('items', [
                'label' => 'Media Items',
                'min' => 0,
                'layout' => 'block',
                'button_label' => 'Add Media Item',
            ])
            ->addSelect('media_type', [
                'label' => 'Media Type',
                'choices' => [
                    'image' => 'Image',
                    'video_file' => 'Video File',
                    'video_embed' => 'Video Embed (YouTube/Vimeo)',
                ],
                'default_value' => 'image',
                'required' => true,
            ])
            ->addFields(ReusableFields::image('image', args: [
                'label' => 'Image',
                'required' => 1,
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
            ->addFile('video_file', [
                'label' => 'Video File',
                'required' => 1,
                'mime_types' => 'mp4,webm,ogv',
                'return_format' => 'url',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => 'video_file',
                        ],
                    ],
                ],
            ])
            ->addUrl('video_embed_url', [
                'label' => 'Video URL (YouTube/Vimeo)',
                'required' => 1,
                'instructions' => 'Enter the URL to a YouTube or Vimeo video',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => 'video_embed',
                        ],
                    ],
                ],
            ])
            ->addTrueFalse('video_loop', [
                'label' => 'Loop Video',
                'default_value' => 1,
                'ui' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'media_type',
                            'operator' => '==',
                            'value' => 'video_file',
                        ],
                    ],
                ],
            ])
            ->addText('title', [
                'label' => 'Caption Title',
            ])
            ->addTextarea('caption', [
                'label' => 'Caption Text',
                'rows' => 3,
            ])
            ->addFields(ReusableFields::button())
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addTrueFalse('show_captions', [
                'label' => 'Show Captions',
                'default_value' => true,
                'ui' => true,
            ])
        ;
    }
}
