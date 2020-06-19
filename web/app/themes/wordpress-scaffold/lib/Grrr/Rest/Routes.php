<?php namespace Grrr\Rest;

use Garp\Functional as f;
use Grrr\Theme\Config;

class Routes {

    public static function namespace(): string {
        return f\prop('namespace', Config::REST);
    }

    public static function get(string $name): string {
        return f\prop($name, f\prop('routes', Config::REST));
    }

    public static function get_all(bool $full = true): array {
        return f\reduce(function($acc, $route) use ($full) {
            $acc[] = $full
                ? '/' . static::namespace() . '/' . $route
                : $route;
            return $acc;
        }, [], f\prop('routes', Config::REST));
    }

    public static function url(string $name): string {
        return rest_url(f\prop('namespace', Config::REST) . '/' . static::get($name));
    }

}
