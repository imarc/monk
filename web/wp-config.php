<?php
$root_dir = dirname(__DIR__);

if (file_exists($root_dir . '/vendor/autoload.php')) {
    require_once($root_dir. '/vendor/autoload.php');
}

// load .env

$dotenv = new Dotenv\Dotenv($root_dir);

if (file_exists($root_dir . '/.env')) {
    $dotenv->load();
}

$dotenv->required([
    'DB_HOST',
    'DB_NAME',
    'DB_USER',
    'DB_PASSWORD',
    'WP_HOME',
    'WP_SITEURL'
]);

// load env() helper method

Env::init();

// ==============================================================
// Urls / Content Dirs
// ==============================================================

define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));
define('WP_CONTENT_URL', WP_HOME . '/wp-content');
define('WP_CONTENT_DIR', __DIR__ . '/wp-content' );

// ==============================================================
// DB settings
// ==============================================================

define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '' );

$table_prefix  = env('DB_PREFIX') ?: 'wp_';

// ==============================================================
// Salts, for security
// ==============================================================

define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

// ================================
// Language
// ================================

define('WPLANG', '');

// =====================================
// Dev Mode / Error handling / Debugging
// =====================================

define('WP_DEV_MODE', env('WP_DEV_MODE') ?: false);

if (WP_DEV_MODE) {
    ini_set('display_errors', 1);
    define('SAVEQUERIES', true);
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('SCRIPT_DEBUG', true);
    define('DISALLOW_FILE_MODS', false);
    define('DISALLOW_FILE_EDIT', false);
    define('AUTOMATIC_UPDATER_DISABLED', true);
} else {
    ini_set('display_errors', 0);
    define('SAVEQUERIES', false);
    define('WP_DEBUG', false);
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
    define('DISALLOW_FILE_MODS', true);
    define('DISALLOW_FILE_EDIT', true);
    define('AUTOMATIC_UPDATER_DISABLED', true);
}

// ==========
// Cron
// ==========

define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);

// ===================
// Bootstrap WordPress
// ===================

if (!defined('ABSPATH')) {
    define('ABSPATH', dirname( __FILE__ ) . '/wordpress/');
}

require_once( ABSPATH . 'wp-settings.php' );
