<?php

/**
 * The template for displaying the index.
 */

use Timber\Timber;

$context = Timber::context();
$templates = ['index.twig'];

if (is_home()) {
    array_unshift($templates, 'front-page.twig');
}

Timber::render($templates, $context);
