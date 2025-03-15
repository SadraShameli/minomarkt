<?php

use Timber\Timber;

$context = Timber::context();
$templates = ['index.twig'];

if (is_home()) {
    array_unshift($templates, 'front-page.twig');
}

Timber::render($templates, $context);
