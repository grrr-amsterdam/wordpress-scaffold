<?php namespace Grrr\Theme;

final class Config {

    /**
     * Post type registration names and their class names.
     */
    const POST_TYPES = [
        'comment' => 'Comment',
        'example' => 'Example',
        'faq'     => 'Faq',
        'page'    => 'Page',
        'post'    => 'Post',
    ];

    /**
     * Image sizes.
     */
    const IMAGE_SIZES = [

        // Regular images
        ['image--tiny', 640, 0, false],
        ['image--small', 960, 0, false],
        ['image--medium', 1280, 0, false],
        ['image--large', 1920, 0, false],
        ['image--huge', 2560, 0, false],

        // Cropped images
        ['image-cropped--tiny', 640, 360, true],
        ['image-cropped--small', 960, 540, true],
        ['image-cropped--medium', 1280, 720, true],
        ['image-cropped--large', 1920, 1280, true],
        ['image-cropped--huge', 2560, 1440, true],

    ];

    /**
     * Navigation menus.
     */
    const NAV_MENUS = [
        [
            'location' => 'primary_navigation',
            'description' => 'Primary Navigation',
        ],
        [
            'location' => 'footer_primary_navigation',
            'description' => 'Footer Primary Navigation',
        ],
        [
            'location' => 'footer_secondary_navigation',
            'description' => 'Footer Secondary Navigation',
        ],
    ];

    /**
     * Custom REST routes.
     * See also `Rest\Routes` and `Utils\Security`.
     */
    const REST = [
        'namespace' => 'grrr/v1',
        'routes' => [
            'newsletter' => 'newsletter/subscribe',
        ],
    ];

}
