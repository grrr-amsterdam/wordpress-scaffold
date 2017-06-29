<?php

namespace Grrr\Acf;

use Grrr\Root\Semver;

class Setup {

    public function __construct() {
        if (!class_exists('acf')) {
            throw new \Exception('Advanced Custom Fields not installed or activated.');
        }
        if (!defined('ACF_FIELDS_VERSION')) {
            define('ACF_FIELDS_VERSION', SEMVER);
        }
    }

    public function init() {
        (new OptionsPage)->init();
    }

}
