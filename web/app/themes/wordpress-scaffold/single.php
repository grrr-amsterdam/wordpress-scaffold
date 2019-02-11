<?php

$templates = [
    'singles/' . $post->post_type . '-single.twig',
    'single.twig'
];

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = post_password_required($post->ID)
    ? ['singles/password-single.twig']
    : $templates;

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
