<?php

namespace Grrr\PostTypes;

class Test extends PostTypesAbstract {

    protected $_type               = 'test';
    protected $_slug               = 'test';
    protected $_name               = 'Exampdsfles';
    protected $_singular_name      = 'Exampdsfle';
    protected $_icon               = 'dashicons-portfolio';

    protected $_args = [
        'public' => false,
        'hierarchical' => false,
        'supports' => [ 'title', 'revisions', 'thumbnail' ],
    ];

}
