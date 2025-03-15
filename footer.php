<?php

/**
 * The template for displaying the footer.
 */

use Timber\Timber;

$context = $GLOBALS['timberContext']; // @codingStandardsIgnoreFile
$templates = ['page-plugin.twig'];

if (!isset($context)) {
    throw new Exception('Timber context not set in footer.');
}

$context['content'] = ob_get_contents();
ob_end_clean();

Timber::render($templates, $context);
