<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Blocks;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockShareItem extends BaseBlock
{
    public static string $blockName = 'share-item';

    public static string $blockTitle = 'Share Item';

    public static string $blockIcon = 'share';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/share-item.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('text', [
                'label' => 'Share Text',
                'default_value' => 'Share',
            ])
            ->addRepeater('items', [
                'label' => 'Share Items',
                'min' => 1,
                'layout' => 'table',
                'button_label' => 'Add Item',
            ])
            ->addSelect('icon', [
                'label' => 'Icon',
                'choices' => [
                    'icon-facebook' => 'Facebook',
                    'icon-twitter' => 'Twitter',
                    'icon-linkedin' => 'LinkedIn',
                    'icon-instagram' => 'Instagram',
                    'icon-youtube' => 'YouTube',
                ],
                'required' => true,
            ])
            ->addText('name', [
                'label' => 'Platform Name',
                'required' => true,
            ])
            ->addUrl('url', [
                'label' => 'Share URL',
                'required' => true,
            ])
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
    }
}
