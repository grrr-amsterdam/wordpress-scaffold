<?php namespace Grrr\Rest;

use Garp\Functional as f;
use Grrr\Config;

class Routes {

    const NAMESPACE = 'grrr/v1';

    const ROUTES = [
        'newsletter' => 'newsletter/subscribe',
    ];

    public static function get(string $name): string {
        return f\prop($name, static::ROUTES);
    }

    public static function get_all(bool $full = true): array {
        return f\reduce(function($acc, $route) use ($full) {
            $acc[] = $full
                ? '/' . static::NAMESPACE . '/' . $route
                ? '/' . f\prop('namespace', Config::REST) . '/' . $route
                : $route;
            return $acc;
        }, [], static::ROUTES);
        }, [], f\prop('routes', Config::REST));
    }

    public static function url(string $name): string {
        return rest_url(static::NAMESPACE . '/' . static::get($name));
        return rest_url(f\prop('namespace', Config::REST) . '/' . static::get($name));
    }

}
