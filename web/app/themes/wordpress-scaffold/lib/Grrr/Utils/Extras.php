<?php namespace Grrr\Utils\Extras;

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Clear W3 Total Cache when publishing any 'post'.
 * Executes AFTER save_post hook (else use 1 as priority).
 */
function custom_cache_clearing($post_id) {
    if (!defined('DOING_AUTOSAVE') && function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
    return $post_id;
}
add_action('save_post', __NAMESPACE__ . '\\custom_cache_clearing', 20);
add_action('acf/save_post', __NAMESPACE__ . '\\custom_cache_clearing', 20);

/**
 * Add term query argument to get terms for a specific post type
 * Based on https://1fix.io/blog/2016/10/25/get-terms-cpt-taxonomy
 */
function my_terms_clauses( $clauses, $taxonomy, $args) {
    if (empty($args['post_type'])) {
        return $clauses;
    }
    global $wpdb;
    $post_types = is_array($args['post_type'])
        ? implode("','", $args['post_type'])
        : $args['post_type'];

    $clauses['join'] .= " INNER JOIN $wpdb->term_relationships AS r"
        . " ON r.term_taxonomy_id = tt.term_taxonomy_id"
        . " INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id";
    $clauses['where'] .= " AND p.post_type IN ('". esc_sql( $post_types ). "') GROUP BY t.term_id";
    return $clauses;
}
add_filter('terms_clauses', __NAMESPACE__ . '\\my_terms_clauses', 99999, 3);

/**
 * Set max srcset size
 */
function set_max_srcset(int $max, array $sizes) {
    return 2560;
}
add_filter('max_srcset_image_width', __NAMESPACE__ . '\\set_max_srcset', 10, 2);
