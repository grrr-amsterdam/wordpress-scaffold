<?php namespace Grrr\Taxonomies;

use Garp\Functional as f;

abstract class TaxonomyAbstract {

    protected $taxonomy;
    protected $slug;

    protected $labels = [];
    protected $args = [];

    public function __construct() {
        $defaults = [
            'public' => false,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'rewrite' => [
                'slug' => $this->slug,
                'with_front' => false,
            ],
            'labels' => $this->labels,
        ];
        $this->args = f\concat($defaults, $this->args);
    }

    public function register() {
        add_action('init', [$this, 'register_taxonomy'], 0);
    }

    public function register_taxonomy() {
        register_taxonomy($this->taxonomy, null, $this->args);
    }

}
