<?php

namespace App\ThirdParty\ACFGutenberg;

use App\ThirdParty\ACFGutenberg\Base\BaseBlock;
use App\ThirdParty\ACFGutenberg\Base\BasePostType;
use App\ThirdParty\ACFGutenberg\Base\BaseTaxonomy;

class ACFGutenbergLoader
{
    public static function initialize(): void
    {
        $baseDir = dirname(__FILE__);
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
                $className = 'Mino\ThirdParty\ACFGutenberg\\' . $namespacePart;

                new $className();
            }
        }

        BaseBlock::register();
        BasePostType::register();
        BaseTaxonomy::register();
    }
}
