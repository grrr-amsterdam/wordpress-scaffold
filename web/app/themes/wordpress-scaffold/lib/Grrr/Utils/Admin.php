<?php namespace Grrr\Utils\Admin;

use Grrr\Utils\Assets;

/**
 * Set custom admin favicon.
 */
function admin_favicon() {
    echo '<link rel="icon" sizes="512x512" type="image/png" href="'
        . Assets\asset_path('images/favicons/favicon-admin.png') . '">';
}
add_action('admin_head', __NAMESPACE__ . '\\admin_favicon');

/**
 * Add footer timing comment to debug performance issues.
 */
function admin_footer_timing() {
    ?>
    <!--<?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.-->
    <?php
}
add_action('admin_footer-index.php', __NAMESPACE__ . '\\admin_footer_timing');

/**
 * Move Yoast to bottom.
 */
function yoasttobottom() {
    return 'low';
}
add_filter('wpseo_metabox_prio', __NAMESPACE__ . '\\yoasttobottom');
