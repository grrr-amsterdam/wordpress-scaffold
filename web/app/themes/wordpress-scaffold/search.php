<?php

$templates = [
    'search.twig',
    'archive.twig',
    'index.twig',
];

$context = Timber::get_context();
$context['title'] = __('Search results for ', 'grrr') . get_search_query();
$context['posts'] = new Timber\PostQuery();
$context['templates'] = $templates;

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
