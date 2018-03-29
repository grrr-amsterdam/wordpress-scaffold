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
$dotenv = new Dotenv\Dotenv($root_dir);
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
 * Versioning
 */
define('APPLICATION_VERSION', (new Root\Versioning)->get_version());

/**
 * AWS & S3
 */
define('DBI_AWS_ACCESS_KEY_ID', env('DBI_AWS_ACCESS_KEY_ID'));
define('DBI_AWS_SECRET_ACCESS_KEY', env('DBI_AWS_SECRET_ACCESS_KEY'));
define('AS3CF_BUCKET', env('AS3CF_BUCKET'));
define('AS3CF_REGION', env('AS3CF_REGION'));

/**
 * SES
 */
define('WP_SES_ACCESS_KEY', env('WP_SES_ACCESS_KEY'));
define('WP_SES_SECRET_KEY', env('WP_SES_SECRET_KEY'));
define('WP_SES_ENDPOINT', env('WP_SES_ENDPOINT'));
define('WP_SES_HIDE_VERIFIED', env('WP_SES_HIDE_VERIFIED'));

/**
 * Sentry
 */
define('SENTRY_DSN', env('SENTRY_DSN'));

/**
 * CloudFront SSL fix
 */
if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
