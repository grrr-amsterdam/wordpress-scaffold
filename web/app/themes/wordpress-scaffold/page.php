<?php

$templates = [
    'page-' . $post->post_name . '.twig',
    'page.twig',
];

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['templates'] = $templates;

Timber::render('base.twig', $context);
