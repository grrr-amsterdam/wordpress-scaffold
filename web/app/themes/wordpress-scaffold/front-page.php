<?php

$templates = [
    'front-page.twig',
];

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = $templates;

Timber::render('base.twig', $context);
