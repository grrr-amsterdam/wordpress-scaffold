<?php namespace Grrr\Providers;

use Grrr\Patterns\AbstractSingleton;
use Grrr\Interfaces\Logger;

class SentryServiceProvider extends AbstractSingleton implements Logger {

    protected $_sentryClient;

    protected function __construct() {
        if (!defined('SENTRY_DSN')) {
            return;
        }

        $this->_sentryClient = new \Raven_Client(SENTRY_DSN, [
            'environment' => WP_ENV,
            'release' => APPLICATION_VERSION,
            'app_path' => ROOT_DIR,
            'tags' => [
                'php_version' => phpversion(),
            ]
        ]);

        $ravenErrorHandler = new \Raven_ErrorHandler($this->_sentryClient);
        $ravenErrorHandler->registerExceptionHandler();
        $ravenErrorHandler->registerErrorHandler();
        $ravenErrorHandler->registerShutdownFunction();
    }

    public function addTags() {
        if (function_exists('get_bloginfo')) {
            $this->_sentryClient->tags_context(([
                'wordpress' => get_bloginfo('version'),
                'language' => get_bloginfo('language'),
                'php_version' => phpversion(),
            ]));
        }
    }

    public function log($message) {
        if (!$this->_sentryClient) {
            return;
        }

        if (is_string($message)) {
            return $this->_sentryClient->captureMessage($message);
        }

        $this->_sentryClient->captureException($message);
    }
}
