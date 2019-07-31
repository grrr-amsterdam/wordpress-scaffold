<?php namespace Grrr\Taxonomies;

class ExampleType extends TaxonomyAbstract {

    protected $_taxonomy           = 'example_type';
    protected $_slug               = 'type';
    protected $_name               = 'Example Types';
    protected $_singular_name      = 'Example Type';

    protected $_args = [
        'rewrite' => [
            'slug' => '<post_type_slug>/type',
        ],
    ];

}
