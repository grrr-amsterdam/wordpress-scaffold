<?php namespace Grrr\PostTypes;

use Timber;
use Garp\Functional as f;

abstract class PostTypeAbstract {

    protected $type;
    protected $slug;
    protected $icon;
    protected $labels = [];

    protected $args = [];

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
                'slug' => $this->slug,
                'with_front' => false,
            ],
            'taxonomies' => [],
            'labels' => $this->labels,
            'menu_icon' => $this->icon,
        ];
        $this->args = f\concat($defaults, $this->args);
    }

    public function register() {
        add_action('init', [$this, 'register_post_type'], 1);
        add_filter('timber/twig', [$this, 'twig_functions']);
    }

    public function register_post_type() {
        register_post_type($this->type, $this->args);
    }

    public function get_posts(int $amount = -1) {
        return Timber\Timber::get_posts([
            'post_type' => $this->type,
            'posts_per_page' => $amount,
        ]);
    }

    public function get_archive_link() {
        return get_post_type_archive_link($this->type);
    }

    public function twig_functions(\Twig_Environment $twig) {
        $type = str_replace('-', '_', $this->type);
        $twig->addFunction(
            new Timber\Twig_Function('get_' . $type . '_posts', [$this, 'get_posts'])
        );
        return $twig;
    }

}
