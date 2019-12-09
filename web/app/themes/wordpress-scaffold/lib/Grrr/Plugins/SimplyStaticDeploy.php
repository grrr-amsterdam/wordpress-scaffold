<?php namespace Grrr\Plugins;

use Sentry;
use WP_Error;

/**
 * Register actions and filters for Simply Static Deploy.
 *
 * @author Harmen Janssen <harmen@grrr.nl>
 */
final class SimplyStaticDeploy {

    public function register() {
        add_filter('grrr_simply_static_deploy_php_execution_time', [$this, 'set_execution_time']);
        add_action('grrr_simply_static_deploy_error', [$this, 'handle_error']);
    }

    public function set_execution_time(int $time): int {
        return 600;
    }

    public function handle_error(WP_Error $error) {
        Sentry\captureMessage($error->get_error_message());
    }

}
