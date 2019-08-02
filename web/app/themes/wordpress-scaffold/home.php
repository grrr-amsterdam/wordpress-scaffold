<?php

$templates = [
    'home.twig',
];

$context = Timber::get_context();
$page_for_posts_id = get_option('page_for_posts');

$context['title'] = $page_for_posts_id ? get_the_title($page_for_posts_id) : null;
$context['posts'] = new Timber\PostQuery();
$context['templates'] = $templates;

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
