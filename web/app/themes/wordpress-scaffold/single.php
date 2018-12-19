<?php

$templates = [
    'singles/' . $post->ID . '-single.twig',
    'singles/' . $post->post_type . '-single.twig',
    'single.twig'
];

$context = Timber\Timber::get_context();
$post = Timber\Timber::query_post();
$context['post'] = $post;

if (post_password_required($post->ID)) {
    $context['templates'] = ['singles/password-single.twig'];
} else {
    $context['templates'] = $templates;
}

Timber\Timber::render('base.twig', $context);
