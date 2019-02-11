<?php namespace Grrr\Taxonomies;

abstract class TaxonomyAbstract {

    protected $_taxonomy;
    protected $_slug;
    protected $_name;
    protected $_singular_name;

    protected $_args = [];

    public function __construct() {
        $defaults = [
            'public' => false,
            'hierarchical' => true,
            'show_ui' => true,
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
        $this->_args = array_merge($defaults, $this->_args);
    }

    public function register() {
        add_action('init', [$this, 'register_taxonomy'], 0);
    }

    public function register_taxonomy() {
        register_taxonomy($this->_taxonomy, null, $this->_args);
    }

}
