<?php

namespace App;

use App\Core\Enqueues;
use App\Core\ExtendTwig;
use App\Core\Gutenberg;
use App\Core\Vite;
use App\ThirdParty\ACF\ACF;

class App
{
    public function __construct()
    {
        $this->addThemeSupports();

        new ACF();
        new Enqueues();
        new ExtendTwig();
        new Gutenberg();
        new Vite();
    }

    private function addThemeSupports(): void
    {
        add_action('after_setup_theme', static function (): void {
            add_theme_support('menus');
            add_theme_support('title-tag');
            add_theme_support('post-thumbnails');
            add_theme_support('automatic-feed-links');
            add_theme_support(
                'html5',
                [
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                ],
            );
            add_theme_support(
                'post-formats',
                [
                    'aside',
                    'image',
                    'video',
                    'quote',
                    'link',
                    'gallery',
                    'audio',
                ],
            );
        });
    }

}
