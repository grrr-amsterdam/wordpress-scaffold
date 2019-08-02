<?php

$templates = [
    'pages/' . $post->post_name . '-page.twig',
    'page.twig',
];

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = $templates;

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
