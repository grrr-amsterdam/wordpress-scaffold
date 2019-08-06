<?php
/**
 * Template Name: Example
 */

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = 'templates/example-template.twig';

Timber::render('base.twig', $context);
