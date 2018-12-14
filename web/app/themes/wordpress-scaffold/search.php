<?php

use \Timber as Timber;

$templates = [
    'search.twig',
    'archive.twig',
    'index.twig',
];

$context = Timber\Timber::get_context();
$context['title'] = __('Search results for ', 'grrr') . get_search_query();
$context['posts'] = new Timber\PostQuery();
$context['templates'] = $templates;

Timber\Timber::render('base.twig', $context);
