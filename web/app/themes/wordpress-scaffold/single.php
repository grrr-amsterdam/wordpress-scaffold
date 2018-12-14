<?php

$templates = [
    'singles/single-' . $post->ID . '.twig',
    'singles/single-' . $post->post_type . '.twig',
    'singles/single.twig'
];

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

if (post_password_required($post->ID)) {
    $context['templates'] = ['singles/single-password.twig'];
} else {
    $context['templates'] = $templates;
}

Timber::render('base.twig', $context);
