<?php namespace Grrr\PostTypes;

class Example extends PostTypesAbstract {

    protected $_type               = 'example';
    protected $_slug               = 'examples';
    protected $_name               = 'Examples';
    protected $_singular_name      = 'Example';
    protected $_icon               = 'dashicons-portfolio';

    protected $_args = [
        'public' => true,
        'has_archive' => true,
        'taxonomies' => [
            'example_type',
        ],
    ];

}
