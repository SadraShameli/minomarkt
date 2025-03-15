<?php

namespace App\ThirdParty;

use App\ThirdParty\ACFGutenberg\ACFGutenbergLoader;

class ACF
{
    public function __construct()
    {
        if (!function_exists('acf_add_options_page')) {
            add_action('admin_notices', [&$this, 'displayACFInstallNotice']);

            return;
        }

        add_filter('block_categories_all', [$this, 'registerBlockCategories'], 999);

        ACFGutenbergLoader::initialize();

        $this->registerOptionPages();
    }

    public function displayACFInstallNotice(): void
    {
        $classes = 'notice notice-error';
        $message = 'Please install and activate Advanced Custom Fields PRO, it is required for this theme to work properly!';

        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($classes), esc_html($message));
    }

    public function registerOptionPages(): void
    {
        acf_add_options_page([
            'page_title' => 'Theme General Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'manage_options',
            'redirect' => false,
        ]);

        acf_add_options_sub_page([
            'page_title' => 'Theme Header Settings',
            'menu_title' => 'Header',
            'parent_slug' => 'theme-general-settings',
            'capability' => 'manage_options',
        ]);

        acf_add_options_sub_page([
            'page_title' => 'Theme Footer Settings',
            'menu_title' => 'Footer',
            'parent_slug' => 'theme-general-settings',
            'capability' => 'manage_options',
        ]);
    }

    /**
     * @param array<mixed> $categories
     *
     * @return array<mixed>
     */
    public function registerBlockCategories(array $categories): array
    {
        $customCategories = [
            [
                'slug' => 'minomarkt',
                'title' => 'Mino Markt',
            ],
        ];

        return array_merge($customCategories, $categories);
    }
}
