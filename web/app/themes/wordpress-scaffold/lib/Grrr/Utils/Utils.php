<?php

namespace Grrr\Utils;

use Roots\Sage\Assets;

/**
 * SVG helper
 * Usage: Utils\svg('arrow-down', ['class' => 'test', 'data-foo' => 'bar']);
 */
function svg($id, $args = []) {
    if (!func_num_args()) {
        return $this;
    }
    // keep spaces, due to Safari 10 bug
    $template = '<svg%s> <use xlink:href="%s#%s"/> </svg>';
    $attributes = '';
    foreach ($args as $key => $value) {
        $attributes .= " {$key}=\"{$value}\"";
    }
    $sprite = Assets\asset_path('images/icons.svg');
    return sprintf($template, $attributes, $sprite, $id);
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
