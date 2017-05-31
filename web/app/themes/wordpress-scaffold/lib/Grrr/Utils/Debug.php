<?php

namespace Grrr\Utils;

/**
 * Enqueued scripts inspection, turn on when debugging
 */
function wp_inspect_scripts() {
	global $wp_scripts;
	echo '<h1>Script Handles</h1><pre><ul>';
	foreach ($wp_scripts->queue as $handle):
		echo '<li>' . $handle . '</li>';
	endforeach;
	echo '</ul></pre>';
    exit;
}
// add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\wp_inspect_scripts', 9999);

/**
 * Enqueued styles inspection, turn on when debugging
 */
function wp_inspect_styles() {
	global $wp_styles;
	echo '<h1>Style Handles</h1><pre><ul>';
	foreach ($wp_styles->queue as $handle):
		echo '<li>' . $handle . '</li>';
	endforeach;
	echo '</ul></pre>';
    exit;
}
// add_action('wp_print_styles', __NAMESPACE__ . '\\wp_inspect_styles');
