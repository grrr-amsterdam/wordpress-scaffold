<?php

namespace Grrr\Utils;

use Grrr\Utils\Assets;

/**
 * SVG helper
 * Usage: Utils\svg('arrow-down', ['class' => 'test', 'data-foo' => 'bar']);
 */
function svg($id, $args = []) {
    if (!func_num_args()) {
        return $this;
    }
    // keep spaces, due to Safari 10 bug
    $template = '<svg aria-hidden="true" role="presentation" focusable="false" %s> <use xlink:href="%s#%s"/> </svg>';
    $attributes = [];
    foreach ($args as $key => $value) {
        $attributes[]= "{$key}=\"{$value}\"";
    }
    $sprite = Assets\asset_path('images/icons.svg');
    return sprintf($template, implode(' ', $attributes), $sprite, $id);
}

/**
 * Render a template/partial
 */
function partial(string $file, array $args = []) {
    (new Renderer($file, $args))->render();
}

/**
 * Get title
 */
function get_title() {
    if (is_home()) {
        if (get_option('page_for_posts', true)) {
            return get_the_title(get_option('page_for_posts', true));
        } else {
            return __('Latest Posts', 'grrr');
        }
    } elseif (is_archive()) {
        return get_the_archive_title();
    } elseif (is_search()) {
        return sprintf(__('Search Results for %s', 'grrr'), get_search_query());
    } elseif (is_404()) {
        return __('Not Found', 'grrr');
    } else {
        return get_the_title();
    }
}

/**
 * Get body class
 */
function get_body_class() {
    $classes = [];
    if (is_admin_bar_showing()) {
        $classes[] = 'has-admin-bar';
    }
    if (is_front_page()) {
        $classes[] = 'is-front-page';
    }
    return implode($classes, ' ');
}

/**
 * Get image source
 */
function get_image_src($size, $post_id = null) {
    if (!$size) {
        return;
    }
    $image_id = get_post_thumbnail_id($post_id);
    return wp_get_attachment_image_src($image_id, $size)[0];
}

/**
 * Get image alt
 */
function get_image_alt($post_id = null) {
    $image_id = get_post_thumbnail_id($post_id);
    return get_post_meta($image_id, '_wp_attachment_image_alt', true);
}
