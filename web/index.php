<?php
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once(dirname(__DIR__) . '/vendor/autoload.php');
}

define('WP_USE_THEMES', true);

require(__DIR__ . '/wp-core/wp-blog-header.php');
