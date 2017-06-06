<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Grrr\Acf;
use Grrr\PostTypes;

(new Acf\Setup)->init();
(new PostTypes\Example)->init();
