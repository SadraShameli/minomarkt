<?php

use Timber\Timber;

$context = Timber::context();
$templates = ['404.twig'];

Timber::render($templates, $context);
