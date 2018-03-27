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
