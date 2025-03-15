<?php

/**
 * The template for displaying Author Archive pages.
 */

use Timber\Timber;

$context = Timber::context();
$templates = ['author.twig', 'archive.twig'];

global $wp_query;
if (isset($wp_query->query_vars['author'])) {
    $author = Timber::get_user($wp_query->query_vars['author']);

    if (isset($author)) {
        $context['author'] = $author;
        $context['title'] = 'Author Archives: '.$author->name();
    }
}

Timber::render($templates, $context);
