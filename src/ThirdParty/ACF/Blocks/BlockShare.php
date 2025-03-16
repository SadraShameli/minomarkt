<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockShare extends BaseBlock
{
    public static string $blockName = 'share';

    public static string $blockTitle = 'Share';

    public static string $blockIcon = 'share';

    public static array $blockKeywords = ['social'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        Timber::render('blocks/share.twig', $context);
    }

    protected function addFieldsContent(): void
    {
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addTrueFalse('list_order', [
                'label' => 'List order',
                'default_value' => false,
                'ui' => true,
                'ui_on_text' => 'Reverse',
                'ui_off_text' => 'Default',
            ])
            ->addTrueFalse('show_linkedin', [
                'label' => 'Show LinkedIn',
                'default_value' => true,
                'ui' => true,
                'ui_on_text' => 'Show',
                'ui_off_text' => 'Hide',
            ])
            ->addTrueFalse('show_facebook', [
                'label' => 'Show Facebook',
                'default_value' => true,
                'ui' => true,
                'ui_on_text' => 'Show',
                'ui_off_text' => 'Hide',
            ])
            ->addTrueFalse('show_x', [
                'label' => 'Show X',
                'default_value' => true,
                'ui' => true,
                'ui_on_text' => 'Show',
                'ui_off_text' => 'Hide',
            ])
            ->addTrueFalse('show_email', [
                'label' => 'Show Email',
                'default_value' => true,
                'ui' => true,
                'ui_off_text' => 'Hide',
                'ui_on_text' => 'Show',
            ])
        ;
    }
}
