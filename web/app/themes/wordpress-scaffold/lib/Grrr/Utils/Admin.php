<?php

namespace Grrr\Utils\Admin;

use Grrr\Utils\Assets;

/**
 * Adjust WordPress editor.
 */
function adjust_editor(array $settings) {
    $settings['block_formats'] = 'Paragraph=p;'
        . 'Heading 2=h2;'
        . 'Heading 3=h3;'
        . 'Heading 4=h4;'
        . 'Preformatted=pre;';
    return $settings;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\\adjust_editor');

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
* Overrides the function user_can_richedit and only checks the
* user preferences instead of doing UA sniffing.
* See: https://benjaminhorn.io/code/wordpress-visual-editor-not-visible-because-of-user-agent-sniffing/
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
 * Move Yoast to bottom.
 */
function yoasttobottom() {
    return 'low';
}
add_filter('wpseo_metabox_prio', __NAMESPACE__ . '\\yoasttobottom');
