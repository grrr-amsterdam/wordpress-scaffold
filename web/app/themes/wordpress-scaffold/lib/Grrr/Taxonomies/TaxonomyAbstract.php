<?php

namespace Grrr\Taxonomies;

abstract class TaxonomyAbstract {

    protected $_taxonomy;
    protected $_slug;
    protected $_name;
    protected $_singular_name;

    protected $_args = [];

    public function init() {
        add_action('init', [$this, 'register'], 0);
    }

    public function register() {
        $defaults = [
            'public' => true,
            'hierarchical' => false,
            'show_admin_column' => true,
            'rewrite' => [
                'slug' => $this->_slug,
                'with_front' => true,
            ],
            'labels' => [
                'name' => $this->_name,
                'singular_name' => $this->_singular_name,
            ],
        ];

        register_taxonomy($this->_taxonomy, null, array_merge($defaults, $this->_args));
    }

}
