<?php

namespace Roots\Sage\Extras;
use Roots\Sage\Assets;

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Set custom admin favicon
 */
function admin_favicon() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="'
        . Assets\asset_path('images/favicon--admin.png') . '">';
}
add_action('admin_head', __NAMESPACE__ . '\\admin_favicon');

/**
 * Admin logo and login styling
 */
function my_login_logo() { ?>
    <style type="text/css">
        .login h1 a {
            margin-bottom: 30px !important;
            display: block !important;
            width: 150px !important;
            height: 90px !important;
            background-size: contain !important;
            background-position: center !important;
            background-image: url('<?= Assets\asset_path('images/site-logo.svg') ?>') !important;
        }
        .login input[type="submit"] {
            background-color: rgb(255, 183, 84);
            box-shadow: 0 1px 0 rgb(255, 183, 84);
            color: #000000 !important;
            border: none !important;
            text-shadow: none !important;
        }
        .login input[type="submit"]:hover,
        .login input[type="submit"]:focus {
            background-color: rgb(255, 183, 84);
            box-shadow: 0 1px 0 rgb(255, 183, 84);
            color: #000000 !important;
            border: none !important;
            text-shadow: none !important;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\my_login_logo' );

/**
 * Admin logo URL
 */
function my_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', __NAMESPACE__ . '\\my_login_logo_url');

/**
 * Move Yoast to bottom
 */
function yoasttobottom() {
    return 'low';
}
add_filter('wpseo_metabox_prio', __NAMESPACE__ . '\\yoasttobottom');

/**
 * Allow svg uploads
 */
function mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', __NAMESPACE__ . '\\mime_types');

/**
 * Clear W3 Total Cache on saving ACF Options
 * Executes AFTER save_post hook (else use 1 as priority).
 */
function custom_cache_clearing($post_id) {
    // just execute if the $post_id has either of these Values. Skip on Autosave
    if (!defined('DOING_AUTOSAVE') && class_exists('W3_Plugin_TotalCacheAdmin')) {
        $plugin_totalcacheadmin = & w3_instance('W3_Plugin_TotalCacheAdmin');
        $plugin_totalcacheadmin->flush_all();
    }
    return $post_id;
}
add_action('acf/save_post', __NAMESPACE__ . '\\custom_cache_clearing', 20);

/**
* Overrides the function user_can_richedit and only checks the
* user preferences instead of doing UA sniffing.
* @see: https://benjaminhorn.io/code/wordpress-visual-editor-not-visible-because-of-user-agent-sniffing/
*/
function user_can_richedit_custom() {
    global $wp_rich_edit;
    if (get_user_option('rich_editing') == 'true' || !is_user_logged_in()) {
        $wp_rich_edit = true;
        return true;
    }
    $wp_rich_edit = false;
    return false;
}

add_filter('user_can_richedit', __NAMESPACE__ . '\\user_can_richedit_custom');

/**
 * Admin footer timing
 */
function my_admin_footer_function() {
    ?>
    <!--<?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.-->
    <?php
}
add_action('admin_footer-index.php', __NAMESPACE__ . '\\my_admin_footer_function');
