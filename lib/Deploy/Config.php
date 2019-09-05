<?php namespace Grrr\Root\Deploy;

use Garp\Functional as f;

/**
 * Represents a Capistrano deploy configuration.
 * Note: this was originally taken from Garp 3.
 */
class Config {

    const GENERIC_CONFIG_PATH = '/config/deploy.rb';
    const ENV_CONFIG_PATH = '/config/deploy/';

    protected $_generic_content;

    protected $_deploy_params = [
        'server',
        'deploy_to',
        'user',
        'application',
        'repo_url',
        'branch',
    ];

    public function __construct() {
        $this->_generic_content = $this->_fetch_generic_content();
    }

    /**
     * Returns the deploy parameters for a specific environment.
     *
     * @param String $env The environment to get parameters for (i.e. 'staging').
     * @return Array List of deploy parameters (i.e. 'server', 'user', 'deploy_to').
     */
    public function get_params(string $env): array {
        $generic_params = $this->_parse_content($this->_generic_content);
        $env_params = $this->_parse_content($this->_fetch_env_content($env));

        return f\concat($generic_params, $env_params);
    }

    /**
     * Parses the generic configuration.
     *
     * @param String $content
     * @return Array
     */
    protected function _parse_content(string $content): array {
        $output = [];
        $matches = [];
        $paramsString = implode('|', $this->_deploy_params);
        $pattern = '/:?(?P<paramName>' . $paramsString
            . ')[,:]? [\'"](?P<paramValue>[^\'"]*)[\'"]/';

        if (!preg_match_all($pattern, $content, $matches)) {
            throw new \Exception(
                "Could not extract deploy parameters from "
                . self::GENERIC_CONFIG_PATH
            );
        }

        foreach ($this->_deploy_params as $p) {
            $indices = f\keys(
                array_filter(
                    $matches['paramName'], function ($pn) use ($p) {
                        return $pn === $p;
                    }
                )
            );
            if (!count($indices)) {
                continue;
            }
            $output[$p] = array_values(f\pick($indices, f\prop('paramValue', $matches)));

            // Treat the server param as array (since it's common for it to be
            // an array, in the case of a multi-server setup).
            if ($p !== 'server') {
                $output[$p] = f\prop_in([$p, 0], $output);
            }
        }

        return $output;
    }

    /**
     * Returns the raw content of the Capistrano
     * deploy configuration (in Ruby) per environment.
     *
     * @param String $env Environment (i.e. 'staging') of which to retrieve config params.
     * @return String The raw contents of the Capistrano deploy configuration file.
     */
    protected function _fetch_env_content(string $env): string {
        $env_path = $this->_create_path_from_env($env);
        if (!file_exists($env_path)) {
            throw new \Exception(
                "Could not find the configuration file for the '{$env}' environment."
            );
        }
        $env_config = file_get_contents($env_path);

        if ($env_config === false) {
            throw new \Exception(
                "Could not read the configuration file for the '{$env}' environment."
            );
        }

        return $env_config;
    }

    protected function _create_path_from_env($env) {
        return realpath(ABSPATH . '/../../' . self::ENV_CONFIG_PATH . $env . '.rb');
    }

    protected function _fetch_generic_content() {
        return file_get_contents(realpath(ABSPATH . '/../../' . self::GENERIC_CONFIG_PATH));
    }
}
