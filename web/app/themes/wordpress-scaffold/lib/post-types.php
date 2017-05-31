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

/**
 * Label generator (for use in custom post types/taxonomies)
 */
function generate_label($singular, $plural, $language = 'en_US') {
    if ($language === 'nl_NL'):
        return array(
            'name'               => $plural,
            'singular_name'      => $singular,
            'menu_name'          => $plural,
            'add_new'            => 'Nieuwe toevoegen',
            'add_new_item'       => 'Nieuwe ' . strtolower($singular) . ' toevoegen',
            'edit'               => 'Wijzigen',
            'edit_item'          => 'Wijzig ' . strtolower($singular),
            'new_item'           => 'Nieuwe ' . strtolower($singular),
            'view'               => 'Bekijk ' . strtolower($singular),
            'view_item'          => 'Bekijk ' . strtolower($singular),
            'search_items'       => 'Zoek ' . strtolower($plural),
            'not_found'          => 'Geen ' . strtolower($plural) . ' gevonden',
            'not_found_in_trash' => 'Geen ' . strtolower($plural) . ' gevonden in de prullenbak',
            'parent'             => 'Moeder ' . strtolower($singular),
        );
    endif;
    return array(
        'name'               => $plural,
        'singular_name'      => $singular,
        'menu_name'          => $plural,
        'add_new'            => 'Add new',
        'add_new_item'       => 'Add new ' . strtolower($singular),
        'edit'               => 'Edit',
        'edit_item'          => 'Edit ' . strtolower($singular),
        'new_item'           => 'New ' . strtolower($singular),
        'view'               => 'View ' . strtolower($singular),
        'view_item'          => 'View ' . strtolower($singular),
        'search_items'       => 'Search ' . strtolower($plural),
        'not_found'          => 'No ' . strtolower($plural) . ' found',
        'not_found_in_trash' => 'No ' . strtolower($plural) . ' found in trash',
        'parent'             => 'Parent ' . strtolower($singular),
    );
}
