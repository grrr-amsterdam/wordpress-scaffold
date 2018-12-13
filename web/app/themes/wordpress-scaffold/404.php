<?php

$templates = [
    '404.twig',
];

$context = Timber::get_context();
Timber::render($templates, $context);
