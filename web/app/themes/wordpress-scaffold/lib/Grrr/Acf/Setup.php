<?php

namespace Grrr\Acf;

class Setup {

    private const ACF_FIELDS_VERSION = '0.0.0';

    public function __construct() {
        if (!defined('ACF_FIELDS_VERSION')) {
            define('ACF_FIELDS_VERSION', self::ACF_FIELDS_VERSION);
        }
    }

    public function init() {
        (new OptionsPage)->init();
    }

}
