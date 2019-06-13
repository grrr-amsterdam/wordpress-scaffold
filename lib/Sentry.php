<?php namespace Grrr\Root;

class Sentry {

    public static function init() {
        if (!defined('SENTRY_DSN') || !SENTRY_DSN) {
            return;
        }

        \Sentry\init([
            'dsn' => SENTRY_DSN,
            'environment' => WP_ENV,
            'release' => APPLICATION_VERSION,
        ]);
    }

    public static function setTags() {
        \Sentry\configureScope(function(\Sentry\State\Scope $scope): void {
            $scope->setTag('wordpress', get_bloginfo('version'));
            $scope->setTag('language', get_bloginfo('language'));
            $scope->setTag('php_version', phpversion());
        });
    }

}
