<?php namespace Grrr\Theme;

use Timber;
use Grrr\Utils\Assets;
use Garp\Functional as f;

Timber::$dirname = ['templates'];
Timber::$autoescape = 'wp_kses_post';

// Cache the twig file and conversion to PHP.
// See `TWIG_CACHE_TTL` for static caching including data.
if (WP_ENV !== 'development') {
    Timber::$cache = true;
}

class Setup extends Timber\Site {

    const ENV_MAPPER = [
        'wp_env' => WP_ENV,
        'application_version' => APPLICATION_VERSION,
        'aws_s3_region' => AS3CF_REGION,
        'google_tag_manager_id' => GOOGLE_TAG_MANAGER_ID,
    ];

    const NAV_MENUS = [
        [
            'location' => 'primary_navigation',
            'description' => 'Primary Navigation',
        ],
        [
            'location' => 'footer_primary_navigation',
            'description' => 'Footer Primary Navigation',
        ],
        [
            'location' => 'footer_secondary_navigation',
            'description' => 'Footer Secondary Navigation',
        ],
    ];

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
    public function add_to_context($context) {
        $context['site'] = $this;
        $context['env'] = self::ENV_MAPPER;

        // Add menus to context, but check if menu for location exists.
        $context['menus'] = f\reduce(function ($menus, $nav_menu) {
            $menus[$nav_menu['location']] = has_nav_menu($nav_menu['location'])
                ? new Timber\Menu($nav_menu['location']) : null;
            return $menus;
        }, [], self::NAV_MENUS);

        return $context;
    }

    /**
     * WordPress theme setup.
     */
    public function theme_setup() {
        // Enable features from Soil when plugin is activated
        // https://roots.io/plugins/soil/
        add_theme_support('soil-clean-up');
        add_theme_support('soil-nav-walker');
        add_theme_support('soil-nice-search');
        add_theme_support('soil-js-to-footer');
        add_theme_support('soil-relative-urls');

        // Theme translations
        load_theme_textdomain('grrr', get_template_directory() . '/languages/grrr');

        // Enable plugins to manage the document title
        // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
        add_theme_support('title-tag');

        // Register wp_nav_menu() menus
        // http://codex.wordpress.org/Function_Reference/register_nav_menus
        $this->_register_nav_menus();

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
     * Theme assets.
     */
    function theme_assets() {
        wp_enqueue_style('grrr/css', Assets\asset_path('styles/base.css'), false, null);
        if (is_single() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }

    /**
     * Admin assets.
     */
    function admin_assets() {
        wp_enqueue_style('grrr/css', Assets\asset_path('styles/admin.css'), false, null);
    }

    /**
     * Nav menus.
     */
    protected function _register_nav_menus() {
        f\map(
            function ($nav_menu) {
                register_nav_menu($nav_menu['location'], $nav_menu['description']);
            },
            self::NAV_MENUS
        );
    }

}
