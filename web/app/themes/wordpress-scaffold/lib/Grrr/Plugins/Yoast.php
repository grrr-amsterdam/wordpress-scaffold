<?php namespace Grrr\Plugins;

/**
 * Adjust settings for Yoast (WordPress SEO).
 *
 * @author Koen Schaft <koen@grrr.nl>
 */
final class Yoast {

    public function register() {
        add_filter('wpseo_metabox_prio', [$this, 'metabox_prio']);
        add_filter('wpseo_opengraph_image_size', [$this, 'opengraph_image_size']);
        add_action('template_redirect', [$this, 'remove_comments'], 9999);
    }

    /**
     * Move Yoast to bottom in admin.
     */
    function metabox_prio() {
        return 'low';
    }

    /**
     * Set the Open Graph image size (default is set to `large`, which is too small).
     *
     * Notes:
     * - The argument doesn't appear to work.
     * - We're using `full`, since setting it to `image--large` when the original is
     *   1920px (or smaller) will not show any Open Graph image. No fallback is provided.
     */
    public function opengraph_image_size($original) {
        return 'full';
    }

    /**
     * Remove Yoast comments.
     */
    function remove_comments() {
        if (!class_exists('WPSEO_Frontend')) {
            return;
        }
        $instance = \WPSEO_Frontend::get_instance();
        if (!method_exists($instance, 'debug_mark')) {
            return;
        }
        remove_action('wpseo_head', [$instance, 'debug_mark'], 2);
    }

}
