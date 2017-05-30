<?php

namespace Grrr\Taxonomies;

use Grrr\Utils;

function register_taxonomies() {

    // register_taxonomy('expertise', null, array(
    //     'description'     => '',
    //     'public'          => true,
    //     'show_ui'         => true,
    //     'show_in_menu'    => true,
    //     'hierarchical'    => true,
    //     'query_var'       => true,
    //     'has_archive'     => false,
    //     'rewrite' => array(
    //         'slug'       => 'projecten/filter',
    //         'with_front' => true,
    //     ),
    //     'labels' => Utils\generate_label('Expertise', 'Expertises')
    // ));

}
add_action('init', __NAMESPACE__ . '\\register_taxonomies', 0);
