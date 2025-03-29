<?php

namespace App\ThirdParty\ACF\Blocks;

use App\ThirdParty\ACF\Reusable\ReusableFields;
use App\ThirdParty\ACF\Base\BaseBlock;
use Timber\Timber;

class BlockTimeline extends BaseBlock
{
    public static string $blockName = 'timeline';

    public static string $blockTitle = 'Timeline';

    public static string $blockIcon = 'clock';

    public static array $blockKeywords = ['history', 'events', 'chronology'];

    protected function renderCallback(
        array $context,
        array $fields,
        array $block,
        string $content = '',
        bool $is_preview = true,
    ): void {
        if (empty($fields['events'])) {
            return;
        }

        Timber::render('blocks/timeline.twig', $context);
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
            ->addRepeater('events', [
                'label' => 'Timeline Events',
                'min' => 0,
                'layout' => 'block',
                'button_label' => 'Add Event',
            ])
            ->addText('date', [
                'label' => 'Date/Year',
                'required' => true,
            ])
            ->addText('event_title', [
                'label' => 'Event Title',
                'required' => true,
            ])
            ->addTextarea('event_description', [
                'label' => 'Event Description',
            ])
            ->addFields(ReusableFields::image(
                fieldName: 'event_image',
                fieldLabel: 'Event Image',
            ))
            ->addLink('event_link', [
                'label' => 'Event Link',
            ])
            ->addTrueFalse('featured', [
                'label' => 'Featured Event',
                'instructions' => 'Highlight this event on the timeline',
                'ui' => true,
                'default_value' => 0,
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
            ->addSelect('layout_style', [
                'label' => 'Layout',
                'choices' => [
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal',
                    'alternating' => 'Alternating',
                ],
                'default_value' => 'vertical',
            ])
            ->addColorPicker('line_color', [
                'label' => 'Timeline Line Color',
                'default_value' => '#dddddd',
            ])
            ->addColorPicker('dot_color', [
                'label' => 'Timeline Dot Color',
                'default_value' => '#0066cc',
            ])
            ->addTrueFalse('animate_on_scroll', [
                'label' => 'Animate On Scroll',
                'instructions' => 'Animate timeline items as they enter the viewport',
                'ui' => true,
                'default_value' => 1,
            ])
        ;
    }
}