<?php namespace Grrr\Theme;

use Timber;
use Grrr\Utils\Assets;
use Garp\Functional as f;

/**
 * Set Twig template directory.
 * https://timber.github.io/docs/guides/template-locations/
 */
Timber::$dirname = ['templates'];

/**
 * Set default escaper to KSES (KSES Kills Evil Scripts).
 * https://timber.github.io/docs/guides/escapers/
 */
Timber::$autoescape = 'wp_kses_post';

/**
 * Cache the Twig file (without the data).
 * https://timber.github.io/docs/guides/performance/
 */
if (WP_ENV !== 'development') {
    Timber::$cache = true;
}

class Setup extends Timber\Site {

    public function __construct() {
        parent::__construct();
    }

    public function register() {
		add_filter('timber_context', [$this, 'add_to_context']);
        add_action('after_setup_theme', [$this, 'theme_setup']);
        add_action('wp_enqueue_scripts', [$this, 'theme_assets']);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets']);
    }

    /**
     * Add Timber/Twig contexts.
     */
    public function add_to_context(array $context): array {
        $context['site']  = $this;
        $context['menus'] = $this->get_timber_menus(Config::NAV_MENUS);

        return $context;
    }

    /**
     * WordPress theme setup.
     */
    public function theme_setup(): void {
        // Enable features from Soil when plugin is activated
        // https://roots.io/plugins/soil/
        add_theme_support('soil-clean-up');
        add_theme_support('soil-nav-walker');
        add_theme_support('soil-nice-search');
        add_theme_support('soil-js-to-footer');
        add_theme_support('soil-relative-urls');
        add_theme_support('soil-disable-trackbacks');

        // Theme translations
        load_theme_textdomain('grrr', get_template_directory() . '/languages/grrr');

        // Enable plugins to manage the document title
        // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
        add_theme_support('title-tag');

        // Register wp_nav_menu() menus
        // http://codex.wordpress.org/Function_Reference/register_nav_menus
        $this->register_nav_menus(Config::NAV_MENUS);

        // Enable post thumbnails
        // http://codex.wordpress.org/Post_Thumbnails
        // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
        // http://codex.wordpress.org/Function_Reference/add_image_size
        add_theme_support('post-thumbnails');

        // Register custom image sizes.
        foreach (Config::IMAGE_SIZES as $entry) {
            add_image_size(...$entry);
        }

        // Enable HTML5 markup support
        // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
        add_theme_support('html5', [
            'caption',
            'gallery',
            'search-form'
        ]);

        // Stylesheet loaded in TinyMCE editor.
        add_editor_style(Assets\asset_path('styles/wysiwyg.css'));
    }

    /**
     * Theme assets.
     */
    public function theme_assets(): void {
        wp_enqueue_style('grrr/css', Assets\asset_path('styles/base.css'), false, null);
        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Admin assets.
     */
    public function admin_assets(): void {
        wp_enqueue_style('grrr/css', Assets\asset_path('styles/admin.css'), false, null);
    }

    /**
     * Nav menus.
     */
    protected function register_nav_menus(array $menus): void {
        f\map(
            function ($menu) {
                register_nav_menu($menu['location'], $menu['description']);
            },
            $menus
        );
    }

    /**
     * Get array of Timber\Menu menus, but check if menu for location exists.
     */
    protected function get_timber_menus(array $menus) {
        return f\reduce(function ($acc, $menu) {
            $acc[$menu['location']] = has_nav_menu($menu['location'])
                ? new Timber\Menu($menu['location'])
                : null;
            return $acc;
        }, [], $menus);
    }

}
