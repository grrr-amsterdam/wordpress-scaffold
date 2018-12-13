<?php

$templates = [
    'front-page.twig',
];

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

Timber::render($templates, $context);
