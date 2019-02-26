<?php

$templates = [
    'archive.twig',
];

$context = Timber::get_context();

if (is_day()) {
    $context['title'] = 'Archive: ' . get_the_date('D M Y');
} else if (is_month()) {
    $context['title'] = 'Archive: ' . get_the_date('M Y');
} else if (is_year()) {
    $context['title'] = 'Archive: ' . get_the_date('Y');
} else if (is_tag()) {
    $context['title'] = single_tag_title('', false);
} else if (is_tax()) {
	$context['title'] = single_tag_title('', false);
	array_unshift($templates, 'archives/' . get_post_type() . '-archive.twig');
} else if (is_category()) {
    $context['title'] = single_cat_title('', false);
    array_unshift($templates, 'archives/' . get_query_var('cat') . '-archive.twig');
} else if (is_post_type_archive()) {
    $context['title'] = post_type_archive_title('', false);
    array_unshift($templates, 'archives/' . get_post_type() . '-archive.twig');
}

$context['posts'] = new Timber\PostQuery();
$context['templates'] = $templates;
$context['post_type'] = get_post_type();
$context['term'] = new Timber\Term();
$context['is_tax'] = is_tax();

Timber::render('base.twig', $context, TWIG_CACHE_TTL);
