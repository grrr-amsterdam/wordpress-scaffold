<?php

namespace Grrr\PostTypes;

class Example {

    private static $type               = 'example';
    private static $slug               = 'examples';
    private static $name               = 'Examples';
    private static $singular_name      = 'Example';
    private static $icon               = 'dashicons-portfolio';

    public function __construct() {
        add_action('init', [$this, 'init'], 1);
    }

    public function init() {
        $args = [
            'capability_type'   => 'post',
            'supports'          => [ 'title', 'revisions', 'thumbnail' ],
            'public'            => true,
            'hierarchical'      => true,
            'query_var'         => true,
            'has_archive'       => false,
            'rewrite' => [
                'slug'          => self::$slug,
                'with_front'    => true,
            ],
            'taxonomies'        => [],
            'labels'            => [
                'name'          => self::$name,
                'singular_name' => self::$singular_name,
            ],
            'menu_icon' => self::$icon,
        ];

        register_post_type(self::$type, $args);
    }

    public function get_posts($amount = -1) {
        return get_posts([
            'post_type' => $this->type,
            'posts_per_page' => $amount,
        ]);
    }

}
