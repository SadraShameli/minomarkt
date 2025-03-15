<?php

namespace App\ThirdParty\ACFGutenberg\Blocks;

use App\ThirdParty\ACFFields\ReusableFields;
use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use Timber\Timber;

class BlockGoogleMap extends BaseBlock
{
    public static string $blockName = 'google-map';

    public static string $blockTitle = 'Google Map';

    public static string $blockIcon = 'location-alt';

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        $context['currentDay'] = strtolower(date('l'));

        Timber::render('blocks/block-google-map.twig', $context);
    }

    protected function addFieldsContent(): void
    {
        $this->fields
            ->addText('title', [
                'label' => 'Title',
            ])
            ->addFields(ReusableFields::wysiwyg('description'))
            ->addRange('zoom', [
                'label' => 'Zoom Level',
                'min' => 1,
                'max' => 20,
                'default_value' => 19,
            ])
        ;
    }

    protected function addFields(): void
    {
    }

    protected function addFieldsSettings(): void
    {
        $this->fields
            ->addTrueFalse('show_content', [
                'label' => 'Show Content',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_contact', [
                'label' => 'Show Contact Section',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_opening_times', [
                'label' => 'Show Opening Times Section',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_map', [
                'label' => 'Show Map',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_address', [
                'label' => 'Show Address Section',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_phone', [
                'label' => 'Show Phone Section',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_email', [
                'label' => 'Show Email Section',
                'ui' => true,
                'default_value' => true,
            ])
            ->addTrueFalse('show_directions', [
                'label' => 'Show Get Directions Button',
                'ui' => true,
                'default_value' => true,
            ])
        ;
    }
}
