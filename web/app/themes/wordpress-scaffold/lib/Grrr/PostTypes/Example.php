<?php namespace Grrr\PostTypes;

class Example extends PostTypeAbstract {

    protected $type = 'example';
    protected $slug = 'examples';
    protected $icon = 'dashicons-portfolio';

    protected $labels = [
        'name' => 'Examples',
        'singular_name' => 'Example',
    ];

    protected $args = [
        'public' => true,
        'has_archive' => true,
        'post_type' => 'example',
        'show_in_rest' => true,
        'rest_base' => 'examples',
        'taxonomies' => [
            'example-type',
        ],
    ];

}
