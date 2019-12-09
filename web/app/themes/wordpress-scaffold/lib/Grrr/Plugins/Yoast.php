<?php namespace Grrr\Plugins;

/**
 * Adjust settings for Yoast (WordPress SEO).
 *
 * @author Koen Schaft <koen@grrr.nl>
 */
final class Yoast {

    public function register() {
        add_filter('wpseo_metabox_prio', [$this, 'metabox_prio']);
        add_action('wpseo_opengraph_image_size', [$this, 'opengraph_image_size'], 10, 2);
        add_action('template_redirect', [$this, 'remove_comments'], 9999);
    }

    /**
     * Move Yoast to bottom in admin.
     */
    function metabox_prio() {
        return 'low';
    }

    /**
     * Set the Open Graph image size (default is 'large').
     * Note that it will not fallback to a default, so uploaded images should be at
     * least this size or should be upscaled.
     */
    public function opengraph_image_size() {
        return 'image--huge';
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
