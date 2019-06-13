<?php namespace Grrr\PostTypes;

use Timber;
use Garp\Functional as f;

abstract class PostTypesAbstract {

    protected $_type;
    protected $_slug;
    protected $_name;
    protected $_singular_name;
    protected $_icon;

    protected $_args = [];

    public function __construct() {
        $defaults = [
            'capability_type' => 'page',
            'supports' => [
                'title',
                'revisions',
                'thumbnail',
            ],
            'public' => true,
            'show_ui' => true,
            'has_archive' => true,
            'query_var' => true,
            'exclude_from_search' => false,
            'show_in_rest' => false,
            'hierarchical' => false,
            'rewrite' => [
                'slug' => $this->_slug,
                'with_front' => false,
            ],
            'taxonomies' => [],
            'labels' => [
                'name' => $this->_name,
                'singular_name' => $this->_singular_name,
            ],
            'menu_icon' => $this->_icon,
        ];
        $this->_args = f\concat($defaults, $this->_args);
    }

    public function register() {
        add_action('init', [$this, 'register_post_type'], 1);
        add_filter('timber/twig', [$this, 'twig_functions']);
    }

    public function register_post_type() {
        register_post_type($this->_type, $this->_args);
    }

    public function get_posts(int $amount = -1) {
        return Timber\Timber::get_posts([
            'post_type' => $this->_type,
            'posts_per_page' => $amount,
        ]);
    }

    public function get_index_link() {
        return get_post_type_archive_link($this->_type);
    }

    public function twig_functions(\Twig_Environment $twig) {
        $twig->addFunction(
            new Timber\Twig_Function('get_' . $this->_type . '_posts', [$this, 'get_posts'])
        );
        $twig->addFunction(
            new Timber\Twig_Function('get_' . $this->_type . '_archive_link', [$this, 'get_index_link'])
        );
        return $twig;
    }

}
