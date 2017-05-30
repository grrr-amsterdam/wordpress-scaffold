<?php

namespace Grrr\Cleanup;

/**
 * Remove generator, rsd and wlw
 */
remove_action('wp_head', __NAMESPACE__ . '\\wp_generator' );

/**
 * Cleanup Emoji scripts/styling
 */
remove_action('wp_head', __NAMESPACE__ . '\\print_emoji_detection_script');
remove_action('admin_print_scripts', __NAMESPACE__ . '\\print_emoji_detection_script');
remove_action('wp_print_styles', __NAMESPACE__ . '\\print_emoji_styles');
remove_action('admin_print_styles', __NAMESPACE__ . '\\print_emoji_styles');

/**
 * Remove emoji DNS prefetch
 */
function remove_emoji_dns() {
    return false;
}
add_filter('emoji_svg_url', __NAMESPACE__ . '\\remove_emoji_dns');

/**
 * Remove wp-embed.js (WP 4.4+)
 */
function wpembed_dequeue_script() {
	wp_deregister_script('wp-embed');
}
add_action('wp_print_scripts', __NAMESPACE__ . '\\wpembed_dequeue_script');

/**
 * Remove dashicons for non-admins
 */
function wpdocs_dequeue_dashicon() {
	if (current_user_can('edit_posts')) {
	    return;
	}
	wp_deregister_style('dashicons');
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\wpdocs_dequeue_dashicon');
