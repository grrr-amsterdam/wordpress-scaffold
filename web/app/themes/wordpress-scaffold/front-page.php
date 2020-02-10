<?php

use Grrr\PostTypes\Example;

$templates = [
    'front-page.twig',
];

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = $templates;
$context['examples'] = (new Example)->get_posts();

Timber::render('base.twig', $context);
