<?php

$templates = [
    'index.twig',
];

$context = Timber::get_context();
$context['templates'] = $templates;

if (is_home()) {
	array_unshift($templates, 'front-page.twig', 'home.twig');
}

Timber::render('base.twig', $context);
