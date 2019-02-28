<?php namespace Grrr\Root;

class Sentry {

    public static function init() {
        if (!defined('SENTRY_DSN') || WP_ENV === 'development') {
            return;
        }

        $ravenClient = new \Raven_Client(SENTRY_DSN, [
            'environment' => WP_ENV,
            'release' => APPLICATION_VERSION,
            'app_path' => ROOT_DIR,
            'tags' => [
                'wordpress' => get_bloginfo('version'),
                'language' => get_bloginfo('language'),
                'php_version' => phpversion(),
            ]
        ]);
        $ravenErrorHandler = new \Raven_ErrorHandler($ravenClient);
        $ravenErrorHandler->registerExceptionHandler();
        $ravenErrorHandler->registerErrorHandler();
        $ravenErrorHandler->registerShutdownFunction();
    }

}
