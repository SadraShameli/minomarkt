<?php

/**
 * The template for displaying 404 pages (Not Found).
 */

use Timber\Timber;

$context = Timber::context();
$templates = ['404.twig'];

Timber::render($templates, $context);
