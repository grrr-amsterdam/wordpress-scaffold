<?php

namespace Roots\Sage\Assets;

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

    public function getPath($key = '', $default = null) {
        $collection = $this->manifest;
        if (is_null($key)) {
            return $collection;
        }
        if (isset($collection[$key])) {
            return $collection[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (!isset($collection[$segment])) {
                return $default;
            } else {
                $collection = $collection[$segment];
            }
        }
        return $collection;
    }
}

function asset_path($filename) {
    $dist_path = get_template_directory() . '/assets/build/';

    $directory = dirname($filename) . '/';
    $file = basename($filename);
    static $manifest;

    if (empty($manifest)) {
        $manifest_path = $dist_path . 'assets.json';
        $manifest = new JsonManifest($manifest_path);
    }

    $dist_uri = get_template_directory_uri() . '/assets/build/';
    if (array_key_exists($file, $manifest->get())) {
        return $dist_uri . $directory . $manifest->get()[$file];
    } else {
        return $dist_uri . $directory . $file;
    }
}

function asset_import($filename) {
    $dist_path = get_template_directory() . '/assets/build/';

    $directory = dirname($filename) . '/';
    $file = basename($filename);
    static $manifest;

    if (empty($manifest)) {
        $manifest_path = $dist_path . 'assets.json';
        $manifest = new JsonManifest($manifest_path);
    }

    if (array_key_exists($file, $manifest->get())) {
        return $dist_path . $directory . $manifest->get()[$file];
    } else {
        return $dist_path . $directory . $file;
    }
}
