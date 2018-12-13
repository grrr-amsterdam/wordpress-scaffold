<?php

namespace Grrr\Theme;

use Timber;
use Grrr\Utils\Assets;

Timber::$dirname = ['templates'];
Timber::$autoescape = true;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class Setup extends Timber\Site {

    /**
     * Add timber support.
     */
    public function __construct() {
        add_action('after_setup_theme', [$this, 'theme_setup']);
        add_action('wp_enqueue_scripts', [$this, 'theme_assets']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);

        add_filter('timber_context', [$this, 'add_to_context']);
        add_filter('get_twig', [$this, 'add_to_twig']);

        parent::__construct();
    }

    /**
     * Add Timber/Twig contexts.
     */
    public function add_to_context($context) {
        $context['menu'] = new Timber\Menu('primary_navigation');
        $context['site'] = $this;
        return $context;
    }

    public function theme_setup() {
        // Enable features from Soil when plugin is activated
        // https://roots.io/plugins/soil/
        add_theme_support('soil-clean-up');
        add_theme_support('soil-nav-walker');
        add_theme_support('soil-nice-search');
        add_theme_support('soil-js-to-footer');
        add_theme_support('soil-relative-urls');

        // Sage translations
        load_theme_textdomain('sage', get_template_directory() . '/languages/sage');

        // Theme translations
        load_theme_textdomain('grrr', get_template_directory() . '/languages/grrr');

        // Enable plugins to manage the document title
        // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
        add_theme_support('title-tag');

        // Register wp_nav_menu() menus
        // http://codex.wordpress.org/Function_Reference/register_nav_menus
        register_nav_menus([
            'primary_navigation' => __('Primary Navigation', 'sage'),
        ]);

        // Enable post thumbnails
        // http://codex.wordpress.org/Post_Thumbnails
        // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
        // http://codex.wordpress.org/Function_Reference/add_image_size
        add_theme_support('post-thumbnails');

        // Image scaling templates
        add_image_size('image--tiny', 640, 0, false);
        add_image_size('image--small', 960, 0, false);
        add_image_size('image--medium', 1280, 0, false);
        add_image_size('image--large', 1920, 0, false);
        add_image_size('image--huge', 2560, 0, false);

        add_image_size('image-cropped--tiny', 640, 360, true);
        add_image_size('image-cropped--small', 960, 540, true);
        add_image_size('image-cropped--medium', 1280, 720, true);
        add_image_size('image-cropped--large', 1920, 1280, true);
        add_image_size('image-cropped--huge', 2560, 1440, true);

        // Enable HTML5 markup support
        // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
        add_theme_support('html5', [
            'caption',
            'gallery',
            'search-form'
        ]);

        // Use main stylesheet for visual editor
        // This can be replaced by creating a custom `wysiwyg` stylesheet.
        add_editor_style(Assets\asset_path('styles/base.css'));
    }

    /**
     * Theme assets
     */
    function theme_assets() {
        wp_enqueue_style('grrr/css', Assets\asset_path('styles/base.css'), false, null);
        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Admin assets
     */
    function admin_assets() {
        wp_enqueue_style('grrr/css', Assets\asset_path('styles/admin.css'), false, null);
    }

    /** This Would return 'foo bar!'.
     *
     * @param string $text being 'foo', then returned 'foo bar!'.
     */
    public function myfoo($text) {
        $text .= ' bar!';
        return $text;
    }

    /**
     * This is where you can add your own functions to twig.
     *
     * @param string $twig get extension.
     */
    public function add_to_twig($twig) {
        $twig->addExtension(new \Twig_Extension_StringLoader());
        $twig->addFilter(new \Twig_SimpleFilter('myfoo', [$this, 'myfoo']));
        return $twig;
    }
}
