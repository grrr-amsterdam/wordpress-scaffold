<?php namespace Grrr\Root\Util;

use Composer\Composer;
use Dotenv\Dotenv as DotEnvLib;

class DotEnv {

    protected $_envPath;
    protected $_rootPath;

    public function __construct($rootPath) {
        $this->_rootPath = $rootPath;
        $this->_envPath = $rootPath . '/.env';
    }

    public function get($key) {
        $dotenv = DotEnvLib::createImmutable($this->_rootPath);
        $dotenv->load();
        return getenv($key);
    }

    public function replaceVariables(array $data) {
        $dotEnvContent = file_get_contents($this->_envPath);
        foreach ($data as $key => $value) {
            $dotEnvContent = preg_replace('/(' . $key  . '=)(.*)$/m', '${1}'.$value, $dotEnvContent);
        }
        file_put_contents($this->_envPath, $dotEnvContent);
    }


}
