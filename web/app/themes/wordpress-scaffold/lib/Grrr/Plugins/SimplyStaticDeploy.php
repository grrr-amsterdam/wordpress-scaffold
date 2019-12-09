<?php namespace Grrr\Plugins;

use Sentry;
use WP_Error;
use Garp\Functional as f;

/**
 * Register actions and filters for Simply Static Deploy.
 *
 * @author Harmen Janssen <harmen@grrr.nl>
 * @author Koen Schaft <koen@grrr.nl>
 */
final class SimplyStaticDeploy {

    public function register() {
        add_filter('simply_static_deploy_php_execution_time', [$this, 'set_execution_time']);
        add_action('simply_static_deploy_error', [$this, 'handle_error']);
        add_filter('simply_static_deploy_clear_directory', [$this, 'clear_directory']);
    }

    public function set_execution_time(int $time): int {
        return 600;
    }

    public function clear_directory(bool $value): bool {
        return true;
    }

    public function handle_error(WP_Error $error) {
        Sentry\captureMessage($error->get_error_message());
    }

}
