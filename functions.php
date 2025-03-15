<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';

function loadFilesRecursively(string $directory): void
{
    $phpFiles = glob("$directory/*.php");
    if (is_array($phpFiles)) {
        foreach ($phpFiles as $file) {
            require_once $file;
        }
    }

    $subdirs = glob("$directory/*");
    if (is_array($subdirs)) {
        foreach ($subdirs as $subdir) {
            loadFilesRecursively($subdir);
        }
    }
}

loadFilesRecursively(__DIR__ . '/src');

new StarterSite();
new App();
