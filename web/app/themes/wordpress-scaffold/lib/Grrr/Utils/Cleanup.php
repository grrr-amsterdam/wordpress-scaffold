<?php namespace Grrr\Utils;

/**
 * Remove wp-embed.js (WP 4.4+)
 */
function wpembed_dequeue_script() {
	wp_deregister_script('wp-embed');
}
add_action('wp_print_scripts', __NAMESPACE__ . '\\wpembed_dequeue_script');

/**
 * Remove Gutenberg block-library/style.css (WP 5.0+)
 */
function wps_deregister_styles() {
    wp_dequeue_style('wp-block-library');
}
add_action('wp_print_styles', __NAMESPACE__ . '\\wps_deregister_styles');

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

/**
 * Disable W3TC footer comment for everyone but admins.
 */
function disable_w3tc_comment($can_print_comment) {
    if (!$can_print_comment) {
        return false;
    }
    return current_user_can('activate_plugins');
}
add_filter('w3tc_can_print_comment', __NAMESPACE__ . '\\disable_w3tc_comment');
