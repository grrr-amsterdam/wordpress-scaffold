<?php

namespace Grrr\Root;

use Symfony\Component\Yaml\Yaml;

class Semver {

    protected static $_cached = null;

    protected $_path;

    public function __construct($path = null) {
        $this->_path = $path ?: $this->_getDefaultSemverLocation();
    }

    public function get_version() {
        if (static::$_cached) {
            return static::$_cached;
        }
        try {
            $version = Yaml::parse(file_get_contents($this->_path), true);
            if (!is_array($version)) {
                return 'v0.0.0';
            }
        } catch (ParseException $e) {
            return 'v0.0.0';
        }
        $version = "v{$version[':major']}.{$version[':minor']}" .
            ".{$version[':patch']}" . $this->_getSpecial($version);

        static::$_cached = $version;
        return $version;
    }

    protected function _getDefaultSemverLocation() {
        return ROOT_DIR . '/' . '.semver';
    }

    protected function _getSpecial($version) {
        $special = '';
        if (!$this->_specialIsEmpty($version)) {
            $special = '-' . $version[':special'];
        }
        return $special;
    }

    protected function _specialIsEmpty($version) {
        return !$version[':special']
            || $version[':special'] === "''"
            || $version[':special'] === "'";
    }
}
