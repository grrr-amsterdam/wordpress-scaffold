<?php

use Grrr\Acf;
use Grrr\API;
use Grrr\Twig;
use Grrr\Theme;
use Grrr\Taxonomies;
use Grrr\PostTypes;

/**
 * We include function-only files (non-PSR-4 autoloadable, they're not classes) this way,
 * since including them in the theme composer.json will fail due to being 'hoisted' to
 * the main composer.json.
 */
$includes = [
    'lib/Grrr/Utils',
];
foreach ($includes as $directory) {
    $files = scandir(__DIR__ . '/' . $directory);
    foreach ($files as $file) {
        $filepath = locate_template($directory . '/' . $file);
        if (is_dir($file) || !$filepath) {
            continue;
        }
        require_once $filepath;
    }
}
unset($files, $file, $filepath);

/**
 * Theme setup (incl. Timber)
 */
new Theme\Setup();
new Twig\Functions();

/**
 * Advanced Custom Fields (when available)
 */
try {
    (new Acf\Setup)->init();
} catch(\Exception $e) {
    // Let if fail silently
}

/**
 * Post Types
 */
(new PostTypes\Post)->init();
(new PostTypes\Page)->init();
(new PostTypes\Example)->init();

/**
 * API
 */
(new API\Newsletter)->init();
