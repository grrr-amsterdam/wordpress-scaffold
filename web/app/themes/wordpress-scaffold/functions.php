<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Grrr\Acf;
use Grrr\MetaBoxes;
use Grrr\Shortcodes;
use Grrr\Taxonomies;
use Grrr\PostTypes;


Acf\Setup::init();

PostTypes\Example::init();
