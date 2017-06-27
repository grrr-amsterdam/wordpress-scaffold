<?php

namespace Grrr\PostTypes;

abstract class PostTypesAbstract {

    protected $_type;
    protected $_slug;
    protected $_name;
    protected $_singular_name;
    protected $_icon;

    protected $_args = [];

    public function init() {
        add_action('init', [$this, 'register'], 1);
    }

    public function get_posts(int $amount = -1): array {
        return get_posts([
            'post_type' => $this->_type,
            'posts_per_page' => $amount,
        ]);
    }

    public function register() {
        $defaults = [
            'capability_type'   => 'page',
            'supports'          => [ 'title', 'revisions', 'thumbnail' ],
            'public'            => true,
            'hierarchical'      => true,
            'query_var'         => true,
            'has_archive'       => false,
            'rewrite' => [
                'slug'          => $this->_slug,
                'with_front'    => true,
            ],
            'taxonomies'        => [],
            'labels'            => [
                'name'          => $this->_name,
                'singular_name' => $this->_singular_name,
            ],
            'menu_icon'         => $this->_icon,
        ];

        register_post_type($this->_type, array_merge($defaults, $this->_args));
    }

}
