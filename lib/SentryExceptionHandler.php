<?php namespace Grrr\Root;

class SentryExceptionHandler {

    private $rethrow;

    public function __construct() {
        set_exception_handler([$this, 'handler']);
    }

    public function handler(\Throwable $e) {
        \Sentry\captureException($e);
        $this->rethrow = $e;
    }

    public function __destruct() {
        if ($this->rethrow) {
            throw $this->rethrow;
        }
    }

}
