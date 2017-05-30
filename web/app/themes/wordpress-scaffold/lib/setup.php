<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
    // Enable features from Soil when plugin is activated
    // https://roots.io/plugins/soil/
    add_theme_support('soil-clean-up');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-js-to-footer');
    add_theme_support('soil-relative-urls');

    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain('sage', get_template_directory() . '/languages/sage');

    // Custom theme translations
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

    // Enable post formats
    // http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', [
        'aside',
        'gallery',
        'link',
        'image',
        'quote',
        'video',
        'audio'
    ]);

    // Enable HTML5 markup support
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form'
    ]);

    // Use main stylesheet for visual editor
    // To add custom styles edit /assets/styles/layouts/_tinymce.scss
    add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
    // register_sidebar([
    //   'name'          => __('Primary', 'sage'),
    //   'id'            => 'sidebar-primary',
    //   'before_widget' => '<section class="widget %1$s %2$s">',
    //   'after_widget'  => '</section>',
    //   'before_title'  => '<h3>',
    //   'after_title'   => '</h3>'
    // ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
* Determine which pages should NOT display the sidebar
*/
function display_sidebar() {
    static $display;

    isset($display) || $display = !in_array(true, [
        // The sidebar will NOT be displayed if ANY of the following return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        is_404(),
        is_front_page(),
        is_page_template('template-custom.php'),
    ]);

    // return apply_filters('sage/display_sidebar', $display);
    return apply_filters('sage/display_sidebar', false);
}

/**
 * Theme assets
 */
function assets() {
    wp_enqueue_style('grrr/css', Assets\asset_path('styles/base.css'), false, null);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    /**
    * For now, this is loaded async in the head
    */
    // wp_enqueue_script('grrr/js', Assets\asset_path('scripts/main.js'), [], null, true);
    // wp_localize_script('grrr/js', 'picl_vars', array(
    //     'ajax_url' => admin_url('admin-ajax.php'),
    // ));
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
 * Admin assets
 */
function admin_assets() {
    // wp_enqueue_style('grrr/css', Assets\asset_path('styles/admin.css'), false, null);
}
add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\admin_assets');
