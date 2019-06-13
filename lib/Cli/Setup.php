<?php namespace Grrr\Root\Cli;

class Setup {

    public static function register() {
        if (!defined('WP_CLI') || !WP_CLI) {
            return;
        }

        (new Commands\Ssh)->register();
    }

}
