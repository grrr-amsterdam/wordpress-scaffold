<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */

$sage_includes = [
    'lib/assets.php',
    'lib/extras.php',
    'lib/setup.php',
    'lib/titles.php',
    'lib/wrapper.php',
    'lib/utils.php',
    'lib/cleanup.php',
    'lib/taxonomies.php',
    'lib/post-types.php',
    'lib/shortcodes.php',
    'lib/meta-boxes.php',
    'lib/debug.php',

    'lib/acf/options-page.php',
    'lib/acf/select-prefillers.php',
    'lib/acf/version.php',

    'lib/flexible-content/blocks.php',

    'lib/wp/import.php',
];

foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }
    require_once $filepath;
}
unset($file, $filepath);
