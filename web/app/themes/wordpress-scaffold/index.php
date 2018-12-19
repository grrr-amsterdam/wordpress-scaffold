<?php

$templates = [
    'index.twig',
];

if (is_home()) {
	array_unshift($templates, 'front-page.twig', 'home.twig');
}

$context = Timber\Timber::get_context();
$context['templates'] = $templates;

Timber\Timber::render('base.twig', $context);
