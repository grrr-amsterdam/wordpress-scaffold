<?php namespace Grrr\Root\Cli\Commands;

use WP_CLI;
use Grrr\Root\Deploy;
use Garp\Functional as f;

/**
 * Quickly connect to a server configured a Capistrano deploy task.
 */
class Ssh {

    protected $_command = 'ssh';
    protected $_config = [
        'shortdesc' => 'Quickly connect to a server configured in one of the deploy tasks.',
        'synopsis' => [
            [
                'type'        => 'positional',
                'name'        => 'environment',
                'description' => 'The environment to connect to.',
                'optional'    => false,
                'repeating'   => false,
            ],
            [
                'type'        => 'assoc',
                'name'        => 'server',
                'description' => 'The server number to connect to.',
                'optional'    => true,
                'default'     => 1,
            ],
        ],
        'when' => 'after_wp_load',
        'longdesc' => '## EXAMPLES' . "\n\n" . 'wp ssh staging',
    ];

    public function register() {
        WP_CLI::add_command($this->_command, [$this, 'connect'], $this->_config);
    }

    public function connect($args, $assoc_args) {
        $environment = f\prop(0, $args);
        $server_index = f\prop('server', $assoc_args) ?: 1;

        try {
            $config = new Deploy\Config();
            $params = $config->get_params($environment);
        } catch (\Exception $e) {
            return WP_CLI::error("No settings found for environment '{$environment}'.");
        }

        if (!$params) {
            return WP_CLI::error("No settings found for environment '{$environment}'.");
        }

        $server = f\prop_in(['server', $server_index - 1], $params);
        if (!$server) {
            return WP_CLI::error("It seems server '{$server_index}' is not configured.");
        }

        $this->_execute_ssh_command($server, f\prop('user', $params));
    }

    protected function _execute_ssh_command($server, $user) {
        passthru(
            'ssh ' . escapeshellarg($user) .
            '@' . escapeshellarg($server)
        );
    }

}
