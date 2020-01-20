<?php namespace Grrr\Taxonomies;

class ExampleType extends TaxonomyAbstract {

    protected $taxonomy = 'example-type';
    protected $slug = 'type';

    protected $labels = [
        'name' => 'Types',
        'singular_name' => 'Type',
    ];

    protected $args = [
        'rewrite' => [
            'slug' => '<post-type-slug>/type',
        ],
    ];

}
