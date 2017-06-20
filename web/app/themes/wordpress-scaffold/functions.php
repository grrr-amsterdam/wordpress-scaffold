<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Grrr\Acf;
use Grrr\PostTypes;

try {
    (new Acf\Setup)->init();
} catch(\Exception $e) {
    // Let if fail silently
}

(new PostTypes\Example)->init();
