<?php

namespace Grrr\Utils\AdminLogin;

use Grrr\Utils\Assets;

/**
 * Adjust admin logo URL.
 */
function my_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', __NAMESPACE__ . '\\my_login_logo_url');

/**
 * Adjust admin logo and login styling.
 */
function my_login_logo() {
    $logo = 'images/' . SITE_VARIATION . '/site-logo.svg';
    ?>
    <style type="text/css">
        .login #loginform {
            padding-bottom: 26px;
        }
        .login h1 a {
            margin-bottom: 20px !important;
            display: block !important;
            width: 150px !important;
            height: 90px !important;
            background-size: contain !important;
            background-position: center !important;
            background-image: url('<?= Assets\asset_path($logo) ?>') !important;
        }
        .login input[type="submit"] {
            background-color: #000000;
            box-shadow: 0 1px 0 #000000);
            color: #FFFFFF !important;
            border: none !important;
            text-shadow: none !important;
        }
        .login input[type="submit"]:hover,
        .login input[type="submit"]:focus {
            background-color: #000000;
            box-shadow: 0 1px 0 #000000);
            color: #FFFFFF !important;
            border: none !important;
            text-shadow: none !important;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', __NAMESPACE__ . '\\my_login_logo' );
