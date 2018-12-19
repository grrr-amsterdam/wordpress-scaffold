<?php

namespace Grrr\PostTypes;

class Example extends PostTypesAbstract {

    protected $_type               = 'example';
    protected $_slug               = 'examples';
    protected $_name               = 'Examples';
    protected $_singular_name      = 'Example';
    protected $_icon               = 'dashicons-portfolio';

    protected $_args = [
        'public' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => [ 'title', 'revisions', 'thumbnail' ],
        'taxonomies' => [
            'example_type',
        ],
    ];

}
