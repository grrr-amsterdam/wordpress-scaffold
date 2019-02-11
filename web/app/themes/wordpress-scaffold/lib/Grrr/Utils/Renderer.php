<?php

namespace Grrr\Utils;

class Renderer {

    private $_file;
    private $_args;

    public function __get($name) {
        if (isset($this->_args[$name])) {
            return $this->_args[$name];
        }
    }

    public function __isset($name): bool {
        return isset($this->_args[$name]);
    }

    public function __construct(string $file, array $args = []) {
        if (strpos($file, '.php') === false) {
            $file .= '.php';
        }
        $this->_file = $file;
        $this->_args = $args;
    }

    public function render() {
        switch (true):
            case locate_template($this->_file):
                include(locate_template($this->_file));
                break;
            case locate_template('templates/' . $this->_file):
                include(locate_template('templates/' . $this->_file));
                break;
        endswitch;
    }

    public static function get(string $file, array $args = []): string {
        ob_start();
        self::render($file, $args);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
