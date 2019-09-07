<?php

$templates = [
    'page-404.twig',
];

$context = Timber::get_context();
$context['templates'] = $templates;

Timber::render('base.twig', $context);
