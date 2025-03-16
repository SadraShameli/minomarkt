<?php

namespace App\ThirdParty\ACF;

use App\ThirdParty\ACF\Base\BaseBlock;
use App\ThirdParty\ACF\Base\BaseMenu;
use App\ThirdParty\ACF\Base\BaseOptions;
use App\ThirdParty\ACF\Base\BasePostType;
use App\ThirdParty\ACF\Base\BaseTaxonomy;

class ACF
{
    public function __construct()
    {
        if (!class_exists('ACF')) {
            return;
        }

        $this->registerFields();
    }

    public function registerFields(): void
    {
        $baseDir = __DIR__;
        $directories = ['Blocks', 'Menu', 'Options', 'PostTypes', 'Taxonomies'];

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
                $className = 'App\ThirdParty\ACF\\' . $namespacePart;

                new $className();
            }
        }

        BaseBlock::register();
        BaseMenu::register();
        BaseOptions::register();
        BasePostType::register();
        BaseTaxonomy::register();
    }
}
