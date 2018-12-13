<?php

namespace Grrr\Utils\Admin;

use Grrr\Utils\Assets;

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
