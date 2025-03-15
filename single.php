<?php

/**
 * The Template for displaying all single posts.
 */

use Timber\Timber;

$context = Timber::context();
$templates = [
    'single-' . $context['post']->ID . '.twig',
    'single-' . $context['post']->post_type . '.twig',
    'single-' . $context['post']->slug . '.twig',
    'single.twig',
];

if (post_password_required($context['post']->ID)) {
    Timber::render('password.twig', $context);
} else {
    Timber::render($templates, $context);
}
