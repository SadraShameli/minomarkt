<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockTabs extends BaseBlock
{
    public static string $blockName = 'tabs';

    public static string $blockTitle = 'Tabs';

    public static string $blockIcon = 'table-row-after';

    public static array $blockKeywords = ['tabs', 'toggle', 'navigation'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['tabs'])) {
            return;
        }

        Timber::render('blocks/tabs.twig', $context);
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
            ->addRepeater('tabs', [
                'label' => 'Tabs',
                'min' => 0,
                'layout' => 'block',
                'button_label' => 'Add Tab',
            ])
            ->addText('tab_title', [
                'label' => 'Tab Title',
                'required' => true,
            ])
            ->addWysiwyg('tab_content', [
                'label' => 'Tab Content',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
            ])
            ->addFields(ReusableFields::image(
                fieldName: 'tab_image',
                fieldLabel: 'Tab Image',
            ))
            ->addLink('tab_button', [
                'label' => 'Tab Button',
            ])
            ->endRepeater()
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addSelect('tab_style', [
                'label' => 'Tab Style',
                'choices' => [
                    'default' => 'Default',
                    'boxed' => 'Boxed',
                    'pills' => 'Pills',
                    'underlined' => 'Underlined',
                ],
                'default_value' => 'default',
            ])
            ->addTrueFalse('vertical_tabs', [
                'label' => 'Vertical Tabs',
                'instructions' => 'Display tabs on the side instead of at the top',
                'ui' => true,
                'default_value' => 0,
            ])
            ->addSelect('animation', [
                'label' => 'Animation Style',
                'choices' => [
                    'none' => 'None',
                    'fade' => 'Fade',
                    'slide' => 'Slide',
                ],
                'default_value' => 'fade',
            ])
        ;
    }
}