<?php namespace Grrr\PostTypes;

use Grrr\PostTypes\PostTypeAbstract;
use Garp\Functional as f;
use Grrr\Config;

final class PostTypeRegistry {

    const NAMESPACE = '\\Grrr\\PostTypes\\';

    public static function register() {
        foreach (Config::POST_TYPES as $name => $className) {
            $classFull = static::compose_full_class($className);
            (new $classFull)->register();
        }
    }

    public static function create_class(string $name) {
        $class =  static::get_class($name);
        return new $class();
    }

    public static function get_class(string $name): string {
        return static::compose_full_class(f\prop($name, Config::POST_TYPES));
    }

    protected static function compose_full_class(string $class): string {
        return __NAMESPACE__ . '\\' . $class;
    }

}
