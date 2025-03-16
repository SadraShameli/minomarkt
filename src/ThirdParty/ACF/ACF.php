<?php

namespace App\ThirdParty\ACF;

use App\ThirdParty\ACF\ACFGutenberg\Base\BaseBlock;
use App\ThirdParty\ACF\ACFGutenberg\Base\BasePostType;
use App\ThirdParty\ACF\ACFGutenberg\Base\BaseTaxonomy;

class ACF
{
    public function __construct()
    {
        if (!class_exists('ACF')) {
            return;
        }

        $this->registerFields();
        $this->registerOptionPages();
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

    public function registerFields(): void
    {
        $baseDir = __DIR__ . '/ACFGutenberg';
        $directories = ['Blocks', 'PostTypes', 'Taxonomies'];

        foreach ($directories as $dir) {
            $fullPath = $baseDir . '/' . $dir;
            if (!is_dir($fullPath)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($fullPath),
            );

            foreach ($iterator as $file) {
                if ($file->isDir() || 'php' !== $file->getExtension()) {
                    continue;
                }

                $relativePath = str_replace([$baseDir, '.php'], '', $file);
                $namespacePart = str_replace('/', '\\', trim($relativePath, '/'));
                $className = 'App\ThirdParty\ACF\ACFGutenberg\\' . $namespacePart;

                new $className();
            }
        }

        BasePostType::register();
        BaseTaxonomy::register();
        BaseBlock::register();
    }
}
