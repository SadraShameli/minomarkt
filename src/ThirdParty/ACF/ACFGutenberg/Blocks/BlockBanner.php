<?php

namespace App\ThirdParty\ACF\ACFGutenberg\Blocks;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use App\ThirdParty\ACF\ACFGutenberg\PostTypes\PostTypeBanner;
use Timber\Timber;

class BlockBanner extends BaseBlock
{
    public static string $blockName = 'banner';

    public static string $blockTitle = 'Banner';

    public static string $blockIcon = 'slides';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        $banner = $fields['banner'] ?? null;
        if (empty($banner)) {
            return;
        }

        $fieldsBanner = get_fields($banner->ID);
        $context['bannerTitle'] = $banner->post_title;
        $context['bannerContent'] = $fieldsBanner['content'] ?? null;
        $context['bannerImage'] = $fieldsBanner['image'] ?? null;
        $context['bannerButton'] = $fieldsBanner['button'] ?? null;

        Timber::render('blocks/banner.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addPostObject('banner', [
                'label' => 'Banner',
                'post_type' => PostTypeBanner::$postTypeName,
                'required' => true,
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
        ;
    }
}
