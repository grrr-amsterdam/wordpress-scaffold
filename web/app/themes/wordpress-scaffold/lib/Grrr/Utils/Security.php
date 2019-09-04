<?php namespace Grrr\Utils;

/**
 * Disable XML-RPC.
 * Note: this is also disabled in the `.htaccess` file.
 */
add_filter('xmlrpc_enabled', '__return_false');
