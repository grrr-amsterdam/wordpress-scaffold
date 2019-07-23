<?php namespace Grrr\Utils;

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
 * Disable W3TC footer comment for everyone but Admins.
 */
function disable_w3tc_comment($can_print_comment) {
    if (!$can_print_comment) {
        return false;
    }
    return current_user_can('activate_plugins');
}
add_filter('w3tc_can_print_comment', __NAMESPACE__ . '\\disable_w3tc_comment');

/**
 * Disable Yoast's Hidden love letter about using the WordPress SEO plugin.
 */
function remove_yoast_comment() {
    if (!class_exists('WPSEO_Frontend')) {
        return;
    }
    $instance = \WPSEO_Frontend::get_instance();
    if (!method_exists($instance, 'debug_mark')) {
        return ;
    }
    remove_action('wpseo_head', [$instance, 'debug_mark'], 2);
};

add_action('template_redirect', __NAMESPACE__ . '\\remove_yoast_comment', 9999);
