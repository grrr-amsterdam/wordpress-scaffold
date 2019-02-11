<?php

$templates = [
    '404.twig',
];

$context = Timber::get_context();
$context['templates'] = $templates;

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
