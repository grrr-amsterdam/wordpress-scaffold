<?php namespace Grrr;

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
     * All custom REST routes.
     * See also `Rest\Routes` and `Utils\Security`.
     */
    const REST = [
        'namespace' => 'grrr/v1',
        'routes' => [
            'newsletter' => 'newsletter/subscribe',
        ],
    ];

}
