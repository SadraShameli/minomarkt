<?php

namespace App\Core;

class Enqueues
{
    private Vite $vite;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->vite = new Vite();
        $this->vite->initialize();

        add_action('wp_enqueue_scripts', [&$this, 'enqueueStylesAndScripts']);
        add_action('admin_enqueue_scripts', [&$this, 'enqueueAdminStylesAndScripts']);
        add_action('admin_init', [&$this, 'addEditorStyles']);
    }

    /**
     * Add editor styles.
     *
     * @throws \Exception
     */
    public function addEditorStyles(): void
    {
        add_theme_support('editor-styles');

        $build_path = get_stylesheet_directory() . '/build/assets/';
        $files = glob($build_path . 'appStyles*.css');

        if (!empty($files)) {
            $css_file = str_replace(get_stylesheet_directory() . '/', '', $files[0]);
            add_editor_style($css_file);
        }
    }

    /**
     * Enqueue the styles and scripts.
     *
     * @throws \Exception
     */
    public function enqueueStylesAndScripts(): void
    {
        $filename = $this->vite->asset('assets/styles/app.scss');
        wp_enqueue_style('mino-styles', $filename, [], null);

        $filename = $this->vite->asset('assets/scripts/app.ts');
        wp_enqueue_script_module('mino-scripts', $filename, [], null);
    }

    /**
     * @throws \Exception
     */
    public function enqueueAdminStylesAndScripts(): void
    {
        $filename = $this->vite->asset('assets/admin/admin-style.scss');
        wp_enqueue_style('mino-admin-styles', $filename, [], null);

        $filename = $this->vite->asset('assets/admin/admin-script.ts');
        wp_enqueue_script_module('mino-admin-scripts', $filename, [['id' => 'jquery']], null);
    }
}
