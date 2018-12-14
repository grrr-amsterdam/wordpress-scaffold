<?php

use \Timber as Timber;

$templates = [
    'index.twig',
];

$context = Timber\Timber::get_context();
$context['templates'] = $templates;

if (is_home()) {
	array_unshift($templates, 'front-page.twig', 'home.twig');
}

Timber\Timber::render('base.twig', $context);
