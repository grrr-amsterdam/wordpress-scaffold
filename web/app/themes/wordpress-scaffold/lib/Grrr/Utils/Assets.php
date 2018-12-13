<?php

namespace Grrr\Utils\Assets;

/**
 * Get paths for assets
 */
class JsonManifest {
    private $manifest;

    public function __construct($manifest_path) {
        if (file_exists($manifest_path)) {
            $this->manifest = json_decode(file_get_contents($manifest_path), true);
        } else {
            $this->manifest = [];
        }
    }

    public function get() {
        return $this->manifest;
    }
}

function asset_path($filepath, $return_uri = true) {
    static $manifest;
    $dist_path = get_template_directory() . '/assets/build/';
    $dist_uri = get_template_directory_uri() . '/assets/build/';
    if (empty($manifest)) {
        $manifest_path = $dist_path . 'assets.json';
        $manifest = new JsonManifest($manifest_path);
    }
    if (array_key_exists($filepath, $manifest->get())) {
        return ($return_uri ? $dist_uri : $dist_path) . $manifest->get()[$filepath];
    } else {
        return ($return_uri ? $dist_uri : $dist_path) . $filepath;
    }
}
