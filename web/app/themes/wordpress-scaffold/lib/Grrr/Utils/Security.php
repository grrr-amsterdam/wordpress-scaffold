<?php namespace Grrr\Utils;

use Grrr\Rest\Routes;
use Garp\Functional as f;

/**
 * Disable XML-RPC.
 * Note: this is also disabled in the `.htaccess` file.
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Disable REST API link in HTTP headers, such as:
 * `Link: <https://example.com/wp-json/>; rel="https://api.w.org/"`
 */
remove_action('template_redirect', 'rest_output_link_header', 11);

/**
 * Disable all non-custom REST API endpoints for unauthenticated users.
 */
function remove_rest_endpoints(array $endpoints) {
    if (is_user_logged_in()) {
        return $endpoints;
    }
    return f\reduce_assoc(
        function ($acc, $value, $key) {
            // Allow global `/wp/v2/` routes listing call. This is made in the admin on
            // each visit. It doesn't work with the `is_user_logged_in` check, since it
            // doesn't add the `X-WP-Nonce` header. The call is stored in SessionStorage,
            // under the key `wp-api-schema-model<url>`.
            if ($key === '/wp/v2') {
                $acc[$key] = $value;
            }
            // If the route is a custom route, allow it. Note that the custom route
            // might have a `permission_callback` implemented, so this does not
            // automatically make it public.
            if (f\contains($key, Routes::get_all())) {
                $acc[$key] = $value;
            }
            return $acc;
        },
        [],
        $endpoints
    );
}
add_filter('rest_endpoints', __NAMESPACE__ . '\\remove_rest_endpoints');
