<?php

namespace App;

use Dotenv\Dotenv;
use Timber\Timber;

require_once __DIR__ . '/vendor/autoload.php';

function loadFilesRecursively(string $directory): void
{
    foreach (glob("$directory/*.php") as $file) {
        require_once $file;
    }

    foreach (glob("$directory/*") as $subdir) {
        loadFilesRecursively($subdir);
    }
}

loadFilesRecursively(__DIR__ . '/src');

Timber::init();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

new StarterSite();
new App();
