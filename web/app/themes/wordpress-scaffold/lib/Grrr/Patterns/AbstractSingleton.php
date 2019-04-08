<?php namespace Grrr\Patterns;

/**
* AbstractSingleton.
*
* Implements a modern Singleton pattern that can be extended by service providers.
*
* PHP magic methods are made private to make sure no one can clone/serialize/unserialize
* the instance.
*/
abstract class AbstractSingleton {

    public static function instance() {
        static $instance = false;

        if( $instance === false ) {
            $instance = new static();
        }

        return $instance;
    }

    abstract protected function __construct();

    private function __clone() {}

    private function __sleep() {}

    private function __wakeup() {}
}
