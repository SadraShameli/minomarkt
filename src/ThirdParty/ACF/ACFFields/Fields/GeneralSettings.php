<?php

namespace App\ThirdParty\ACF\ACFFields\Fields;

use App\ThirdParty\ACF\ACFFields\BaseACFGroup;
use App\ThirdParty\ACF\ACFFields\ReusableFields;

class GeneralSettings extends BaseACFGroup
{
    public function __construct()
    {
        $this->createThemeSettingsGroup();
    }

    protected function createThemeSettingsGroup(): void
    {
        $fields = self::setupGroup('Theme Options');

        $fields
            ->addTab('logo', [
                'label' => 'Logo',
                'placement' => 'left',
            ])
            ->addFields(ReusableFields::image('site_logo', 'Site logo'))

            ->addTab('error_page', [
                'label' => '404 error page',
                'placement' => 'left',
            ])
            ->addText('error_title', [
                'label' => 'Error title',
                'required' => true,
            ])
            ->addTextarea('error_description', [
                'label' => 'Error description',
                'required' => true,
            ])
            ->addFields(ReusableFields::image('error_image', 'Error image'))

            ->addTab('address', [
                'label' => 'Address',
                'placement' => 'left',
            ])
            ->addGroup('address', [
                'label' => 'Address',
            ])
            ->addText('address', [
                'label' => 'Address',
            ])
            ->addText('postcode', [
                'label' => 'Postcode',
            ])
            ->addText('city', [
                'label' => 'City',
            ])
            ->addText('latitude', [
                'label' => 'Latitude',
            ])
            ->addText('longitude', [
                'label' => 'Longitude',
            ])
            ->endGroup()

            ->addTab('contact', [
                'label' => 'Contact',
                'placement' => 'left',
            ])
            ->addGroup('contact', [
                'label' => 'Contact',
            ])
            ->addText('phone', [
                'label' => 'Phone',
            ])
            ->addText('email', [
                'label' => 'Email',
            ])
            ->addText('kvk', [
                'label' => 'KvK',
            ])
            ->addText('vat', [
                'label' => 'VAT',
            ])
            ->endGroup()

            ->addTab('socials', [
                'label' => 'Socials',
                'placement' => 'left',
            ])
            ->addGroup('socials', [
                'label' => 'Socials',
            ])
            ->addRepeater('socials', [
                'label' => 'Socials',
                'layout' => 'table',
                'button_label' => 'Add Row',
            ])
            ->addLink('social', [
                'label' => 'Social URL',
            ])
            ->addFields(ReusableFields::icon('icon', 'Icon'))
            ->endRepeater()
            ->endGroup()

            ->addTab('opening_times', [
                'label' => 'Opening Times',
                'placement' => 'left',
            ])
            ->addGroup('opening_times', [
                'label' => 'Opening Times',
            ])
            ->addRepeater('days', [
                'label' => 'Days',
                'layout' => 'table',
                'button_label' => 'Add Day',
            ])
            ->addSelect('day', [
                'label' => 'Day',
                'choices' => [
                    'maandag' => 'Monday',
                    'dinsdag' => 'Tuesday',
                    'woensdag' => 'Wednesday',
                    'donderdag' => 'Thursday',
                    'vrijdag' => 'Friday',
                    'zaterdag' => 'Saturday',
                    'zondag' => 'Sunday',
                ],
                'required' => true,
            ])
            ->addTimePicker('open', [
                'label' => 'Opening Time',
                'required' => true,
                'display_format' => 'H:i',
                'return_format' => 'H:i',
            ])
            ->addTimePicker('close', [
                'label' => 'Closing Time',
                'required' => true,
                'display_format' => 'H:i',
                'return_format' => 'H:i',
            ])
            ->addTrueFalse('closed', [
                'label' => 'Closed',
                'ui' => true,
            ])
            ->endRepeater()
            ->endGroup()

            ->addTab('api', [
                'label' => 'API',
                'placement' => 'left',
            ])
            ->addGroup('api', [
                'label' => 'API',
            ])
            ->addText('google_maps_api_key', [
                'label' => 'Google Maps API Key',
            ])
            ->addText('google_maps_id', [
                'label' => 'Google Maps ID',
            ])
            ->addText('google_maps_place_id', [
                'label' => 'Google Maps Place ID',
            ])
            ->addText('google_maps_place_name', [
                'label' => 'Google Maps Place Name',
            ])
            ->endGroup()
            ->setLocation('options_page', '==', 'theme-general-settings')
        ;

        self::createGroup($fields);
    }
}
