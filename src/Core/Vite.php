<?php

namespace App\Core;

class Vite
{
    /**
     * Flag to determine whether hot server is active.
     * Calculated when initialize() is called.
     */
    private bool $isHot = false;

    /**
     * The URI to the hot server. Calculated when
     * initialize() is called.
     */
    private string $server;

    /**
     * The path where compiled assets will go.
     */
    private string $buildPath = 'dist';

    /**
     * The root directory where assets are located.
     * Defaults to theme directory.
     */
    private string $rootDir;

    /**
     * Manifest file contents. Initialized
     * when initialize() is called.
     *
     * @var array<string, mixed>
     */
    private array $manifest = [];

    public function __construct(string $rootDir = '')
    {
        $this->server = get_site_url() . ':5173';
        $this->rootDir = $rootDir ?: get_stylesheet_directory();
    }

    /**
     * Will check for the presence of a hot file and read the manifest file.
     *
     * @param bool $output whether to output the Vite client
     *
     * @throws \Exception
     */
    public function initialize(?string $buildPath = null, bool $output = true): void
    {
        if ($buildPath) {
            $this->buildPath = $buildPath;
        }

        $hotFile = implode('/', [$this->buildPath(), 'hot']);
        $this->isHot = file_exists($hotFile);

        if ($this->isHot) {
            $client = $this->server . '/@vite/client';

            if ($output) {
                wp_enqueue_script_module('vite-client', $client, [], null);
            }

            return;
        }

        if (!file_exists($manifestPath = $this->buildPath() . '/.vite/manifest.json')) {
            throw new \Exception('No Vite Manifest exists');
        }

        $fileContent = file_get_contents($manifestPath);

        if (empty($fileContent)) {
            throw new \Exception('Vite Manifest is empty');
        }

        $this->manifest = json_decode($fileContent, true);
    }

    /**
     * Return URI path to an asset.
     *
     * @throws \Exception
     */
    public function asset(string $asset): string
    {
        if ($this->isHot) {
            return $this->server . '/' . ltrim($asset, '/');
        }

        if (!array_key_exists($asset, $this->manifest)) {
            throw new \Exception('Unknown Vite build asset: ' . $asset);
        }

        $rootUri = $this->rootDir === get_stylesheet_directory()
            ? get_stylesheet_directory_uri()
            : plugins_url('', $this->rootDir . '/plugin.php');

        return implode('/', [$rootUri, $this->buildPath, $this->manifest[$asset]['file']]);
    }

    /**
     * Internal method to determine buildPath.
     */
    private function buildPath(): string
    {
        return implode('/', [$this->rootDir, $this->buildPath]);
    }
}
