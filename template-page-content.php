<?php

/**
 * Template Name: Page content.
 */

use Timber\Timber;

$context = Timber::context();

if (post_password_required($context['post']->ID)) {
    Timber::render('single-password.twig', $context);
} else {
    $templates = [
        'page-content.twig',
    ];

    Timber::render($templates, $context);
}
