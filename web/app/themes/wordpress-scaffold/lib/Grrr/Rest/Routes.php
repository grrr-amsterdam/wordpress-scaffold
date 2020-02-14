<?php namespace Grrr\Rest;

use Garp\Functional as f;
use Grrr\Theme\Config;

class Routes {

    public static function get(string $name): string {
        return f\prop($name, static::ROUTES);
    }

    public static function get_all(bool $full = true): array {
        return f\reduce(function($acc, $route) use ($full) {
            $acc[] = $full
                ? '/' . f\prop('namespace', Config::REST) . '/' . $route
                : $route;
            return $acc;
        }, [], f\prop('routes', Config::REST));
    }

    public static function url(string $name): string {
        return rest_url(f\prop('namespace', Config::REST) . '/' . static::get($name));
    }

}
