<?php namespace Grrr\Theme;

final class Config {

    /**
     * Mapping of post type names to their class names.
     */
    const POST_TYPES = [
        'comment' => 'Comment',
        'example' => 'Example',
        'faq'     => 'Faq',
        'page'    => 'Page',
        'post'    => 'Post',
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

}
