<?php namespace Grrr\Acf;

class Setup {

    public function __construct() {
        if (!class_exists('acf')) {
            throw new \Exception('Advanced Custom Fields not installed or activated.');
        }
    }

    public function init() {
        (new SyncWarning)->register();
        (new Options\Theme)->register();
        (new FlexibleContent\AdminTitles)->register();
    }

}
