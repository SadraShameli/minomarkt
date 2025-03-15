<?php

use Timber\Timber;

$context = Timber::context();
$templates = ['search.twig', 'archive.twig', 'index.twig'];

$context['isSearchPage'] = true;

Timber::render($templates, $context);
