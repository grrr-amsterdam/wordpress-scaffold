<?php

$templates = [
    'page-' . $post->post_name . '.twig',
    'page.twig',
];

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = $templates;

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
