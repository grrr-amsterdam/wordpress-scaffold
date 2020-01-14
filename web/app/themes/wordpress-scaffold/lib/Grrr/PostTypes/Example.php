<?php namespace Grrr\PostTypes;

class Example extends PostTypeAbstract {

    protected $type   = 'example';
    protected $slug   = 'examples';
    protected $icon   = 'dashicons-portfolio';
    protected $labels = [
        'name' => 'Examples',
        'singular_name'  => 'Example',
    ];

    protected $args = [
        'public' => true,
        'has_archive' => true,
        'taxonomies' => [
            'example_type',
        ],
    ];

}
