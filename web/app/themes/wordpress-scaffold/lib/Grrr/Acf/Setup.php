<?php

namespace Grrr\Acf;

class Setup {

    public function __construct() {
        if (!class_exists('acf')) {
            throw new \Exception('Advanced Custom Fields not installed or activated.');
        }
        if (!defined('ACF_FIELDS_VERSION') && defined('APPLICATION_VERSION')) {
            define('ACF_FIELDS_VERSION', APPLICATION_VERSION);
        }
    }

    public function init() {
        (new OptionsPage)->init();
    }

}
