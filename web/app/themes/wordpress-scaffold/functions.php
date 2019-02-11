<?php

use Grrr\Acf;
use Grrr\API;
use Grrr\Twig;
use Grrr\Theme;
use Grrr\Taxonomies;
use Grrr\PostTypes;

/**
 * Utils.
 */
new Grrr\UtilsLoader();

/**
 * Theme setup. Fails when Timber plugin is not activated.
 */
if (class_exists('Timber')) {
    (new Theme\Setup)->register();
    (new Twig\Filters)->register();
    (new Twig\Functions)->register();
} else {
    (new Theme\NoTimber)->register();
}

/**
 * Advanced Custom Fields
 */
if (class_exists('acf')) {
    (new Acf\Setup)->register();
}

/**
 * Post Types
 */
(new PostTypes\Post)->register();
(new PostTypes\Page)->register();
(new PostTypes\Example)->register();

/**
 * API
 */
(new Api\Newsletter)->register();
