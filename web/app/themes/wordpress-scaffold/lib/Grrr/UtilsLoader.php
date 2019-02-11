<?php namespace Grrr;

/**
 * We include function-only files (non-PSR-4 autoloadable, they're not classes) this way,
 * since including them in the theme composer.json will fail due to being 'hoisted' to
 * the main composer.json.
 */

class UtilsLoader {

    const BASE_PATH = 'lib/Grrr';

    const DIRECTORIES = [
        'Utils',
    ];

    public function __construct() {
        foreach (static::DIRECTORIES as $directory) {
            $files = scandir(__DIR__ . '/' . $directory);
            foreach ($files as $file) {
                $filepath = locate_template(static::BASE_PATH . '/' . $directory . '/' . $file);
                if (is_dir($file) || !$filepath) {
                    continue;
                }
                require_once $filepath;
            }
        }
        unset($files, $file, $filepath);
    }

}
