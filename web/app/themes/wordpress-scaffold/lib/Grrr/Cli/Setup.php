<?php namespace Grrr\Cli;

class Setup {

    public function register() {
        if (!defined('WP_CLI') || !WP_CLI) {
            return;
        }
    }

}
