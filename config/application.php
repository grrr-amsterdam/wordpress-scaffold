<?php

use Grrr\Root;

/** @var string Directory containing all of the site's files */
$root_dir = dirname(__DIR__);

/**
 * Define root directory
 */
if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', $root_dir);
}

/** @var string Document Root */
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = Dotenv\Dotenv::create($root_dir);
if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
    $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define('WP_ENV', env('WP_ENV') ?: 'production');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

/**
 * URLs
 */
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}

/**
 * DB settings
 */
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Updates & Files
 */
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISALLOW_FILE_EDIT', true);

/**
 * Cron & Cache
 */
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
define('WP_CACHE', env('WP_CACHE') ?: false);

/**
 * Limit post revisions
 */
define('WP_POST_REVISIONS', 30);

/**
 * Versioning
 */
define('APPLICATION_VERSION', (new Root\Versioning)->get_version());

/**
 * Advanced Custom Fields (ACF)
 */
define('ACF_SYNC_WARNING', env('ACF_SYNC_WARNING') ?: false);

/**
 * AWS — Site (used for Redirect post type)
 */
define('AWS_SITE', [
    'key'           => env('AWS_SITE_ACCESS_KEY_ID'),
    'secret'        => env('AWS_SITE_SECRET_ACCESS_KEY'),
    'region'        => env('AWS_SITE_REGION'),
    'bucket'        => env('AWS_SITE_S3_BUCKET'),
    'bucket_acl'    => env('AWS_SITE_S3_BUCKET_ACL'),
    'distribution'  => env('AWS_SITE_CF_DISTRIBUTION_ID'),
    'url'           => env('AWS_SITE_WEBSITE_URL'),
]);

/**
 * AWS — Assets (mainly for consistency, and for preconnecting in `head.twig`)
 */
define('AWS_ASSETS', [
    'key'           => env('AWS_ASSETS_ACCESS_KEY_ID'),
    'secret'        => env('AWS_ASSETS_SECRET_ACCESS_KEY'),
    'region'        => env('AWS_ASSETS_REGION'),
    'bucket'        => env('AWS_ASSETS_S3_BUCKET'),
    'bucket_acl'    => env('AWS_ASSETS_S3_BUCKET_ACL'),
    'distribution'  => env('AWS_ASSETS_CF_DISTRIBUTION_ID'),
    'url'           => env('AWS_ASSETS_WEBSITE_URL'),
]);

/**
 * Simply Static Deploy
 */
define('SIMPLY_STATIC_DEPLOY_CONFIG', [
    'aws' => [
        'key'           => env('AWS_SITE_ACCESS_KEY_ID'),
        'secret'        => env('AWS_SITE_SECRET_ACCESS_KEY'),
        'region'        => env('AWS_SITE_REGION'),
        'bucket'        => env('AWS_SITE_S3_BUCKET'),
        'bucket_acl'    => env('AWS_SITE_S3_BUCKET_ACL'),
        'distribution'  => env('AWS_SITE_CF_DISTRIBUTION_ID'),
    ],
    'url' => env('AWS_SITE_WEBSITE_URL'),
]);

/**
 * WP Offload Media
 */
define('AS3CF_AWS_USE_EC2_IAM_ROLE', env('AS3CF_AWS_USE_EC2_IAM_ROLE'));
define('AS3CF_SETTINGS', serialize([
    'provider'          => 'aws',
    'access-key-id'     => env('AWS_ASSETS_ACCESS_KEY_ID'),
    'secret-access-key' => env('AWS_ASSETS_SECRET_ACCESS_KEY'),
    'bucket'            => env('AWS_ASSETS_S3_BUCKET'),
    'region'            => env('AWS_ASSETS_REGION'),
]));

/**
 * WP Offload SES
 */
define('WP_SES_ACCESS_KEY', env('WP_SES_ACCESS_KEY'));
define('WP_SES_SECRET_KEY', env('WP_SES_SECRET_KEY'));
define('WP_SES_ENDPOINT', env('WP_SES_ENDPOINT'));
define('WP_SES_HIDE_VERIFIED', env('WP_SES_HIDE_VERIFIED'));

/**
 * Analytics & Tracking
 */
define('GOOGLE_TAG_MANAGER_ID', env('GOOGLE_TAG_MANAGER_ID'));

/**
 * Sentry
 */
define('SENTRY_DSN', env('SENTRY_DSN'));

/**
 * Mailchimp
 */
define('MAILCHIMP_API_KEY', env('MAILCHIMP_API_KEY'));
define('MAILCHIMP_LIST_ID', env('MAILCHIMP_LIST_ID'));

/**
 * CloudFront SSL fix
 */
if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
