<?php

namespace Grrr\Acf\SelectPrefillers;

/**
 * Page colors.
 * Populate page_color select fields from page_colors field from options.
 */
// function acf_load_page_color_field_choices($field) {
// 	$field['choices'] = [];
// 	if (have_rows('page_colors', 'option')) {
// 		while (have_rows('page_colors', 'option')) {
// 			the_row();
//
//             $label = get_sub_field('label');
// 			$value = get_sub_field('value');
//
// 			$field['choices'][ $value ] = $label;
// 		}
// 	}
//     $field['choices']['custom'] = 'Custom (select one)';
// 	return $field;
// }
// add_filter('acf/load_field/name=page_color', __NAMESPACE__ . '\\acf_load_page_color_field_choices');
