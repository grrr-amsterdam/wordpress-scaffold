<?php

namespace Grrr\PostTypes;
use Grrr\Utils;

function register_post_types() {

    // register_post_type('project', array(
    //  'description'     => '',
    //  'public'          => true,
    //  'show_ui'         => true,
    //  'show_in_menu'    => true,
    //  'menu_icon'       => 'dashicons-portfolio',
    //  'capability_type' => 'post',
    //  'hierarchical'    => true,
    //  'query_var'       => true,
    //  'has_archive'     => false,
    //  'rewrite' => array(
    //      'slug'       => 'projects',
    //      'with_front' => true,
    //  ),
    //  'supports' => array(
    //      'title',
    //      'revisions',
    //      'thumbnail',
    //  ),
    //  'labels' => Utils\generate_label('Project', 'Projects'),
    //  'taxonomies' => array(
    //      'expertise'
    //  )
    // ));

}
add_action('init', __NAMESPACE__ . '\\register_post_types', 1);
