<?php

namespace Grrr\Root;

class Versioning {

    const VERSION_FILENAME = 'VERSION';

    protected static $_cached = '';

    protected $_path;

    public static function bust_cache() {
        static::$_cached = '';
    }

    public function __construct($path = null) {
        $this->_path = $path ?: $this->_get_default_version_location();
    }

    public function get_version(): string {
        if (static::$_cached) {
            return static::$_cached;
        }
        if (file_exists($this->_path)) {
            static::$_cached = file_get_contents($this->_path);
        }
        return static::$_cached;
    }

    protected function _get_default_version_location(): string {
        return ROOT_DIR . '/' . static::VERSION_FILENAME;
    }

}
