<?php

namespace Grrr\PostTypes;

class Example {

    private static $type               = 'example';
    private static $slug               = 'examples';
    private static $name               = 'Examples';
    private static $singular_name      = 'Example';
    private static $icon               = 'dashicons-portfolio';

    public function __construct() {
        add_action('init', [$this, 'setup'], 1);
    }

    public static function init() {
        $args = [
            'description'     => '',
            'public'          => true,
            'show_ui'         => true,
            'show_in_menu'    => true,
            'menu_icon'       => self::$icon,
            'capability_type' => 'post',
            'hierarchical'    => true,
            'query_var'       => true,
            'has_archive'     => false,
            'rewrite' => [
                'slug'       => self::$slug,
                'with_front' => true,
            ],
            'supports' => [
                'title',
                'revisions',
                'thumbnail',
            ],
            'labels' => [
                'name' => self::$name,
                'singular_name' => self::$singular_name,
            ],
            'taxonomies' => [
                'expertise',
            ]
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
