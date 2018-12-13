<?php

$templates = [
    'index.twig',
];

$context = Timber::get_context();

if (is_home()) {
	array_unshift($templates, 'front-page.twig', 'home.twig');
}

Timber::render($templates, $context);
