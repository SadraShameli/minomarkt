<?php

use Timber\Timber;

$context = Timber::context();
$templates = ['front-page.twig'];

if (post_password_required($context['post']->ID)) {
    Timber::render('password.twig', $context);
} else {
    Timber::render($templates, $context);
}
