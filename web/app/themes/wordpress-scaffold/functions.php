<?php

use Grrr\Acf;
use Grrr\Cli;
use Grrr\Newsletter;
use Grrr\Plugins;
use Grrr\PostTypes;
use Grrr\Shortcodes;
use Grrr\Taxonomies;
use Grrr\Theme;
use Grrr\Twig;

/**
 * Utils
 */
new Grrr\UtilsLoader();

/**
 * Theme setup
 * Fails when Timber plugin is not activated.
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
 * Taxonomies
 */
(new Taxonomies\ExampleType)->register();

/**
 * Post Types
 */
(new PostTypes\Comment)->register();
(new PostTypes\Post)->register();
(new PostTypes\Page)->register();
(new PostTypes\Example)->register();

/**
 * Shortcodes
 */
(new Shortcodes\Footnote)->register();

/**
 * Plugin settings
 */
(new Plugins\BetterSearchReplace)->register();
(new Plugins\SimplyStaticDeploy)->register();
(new Plugins\Yoast)->register();

/**
 * Newsletter
 */
(new Newsletter\Api)->register();

/**
 * WP-CLI
 */
(new Cli\Setup)->register();
