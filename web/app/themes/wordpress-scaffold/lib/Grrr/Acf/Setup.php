<?php

namespace Grrr\Acf;

class Setup {

    const ACF_FIELDS_VERSION = '0.0.0';

    public function __construct() {
        if (!class_exists('acf')) {
            throw new \Exception('Advanced Custom Fields not installed or activated.');
        }
        if (!defined('ACF_FIELDS_VERSION')) {
            define('ACF_FIELDS_VERSION', self::ACF_FIELDS_VERSION);
        }
    }

    public function init() {
        (new OptionsPage)->init();
    }

}
