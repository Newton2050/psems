<?php
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

if (!defined('APP_PATH')) {
    define('APP_PATH', ROOT_PATH . DS . 'app');
}

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', ROOT_PATH . DS . 'config');
}

if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', ROOT_PATH . DS . 'public');
}

if (!defined('STORAGE_PATH')) {
    define('STORAGE_PATH', ROOT_PATH . DS . 'storage');
}

if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', APP_PATH . DS . 'Views');
}

if (!defined('LOG_PATH')) {
    define('LOG_PATH', STORAGE_PATH . DS . 'logs');
}

if (!defined('CACHE_PATH')) {
    define('CACHE_PATH', STORAGE_PATH . DS . 'cache');
}

if (!defined('UPLOAD_PATH')) {
    define('UPLOAD_PATH', PUBLIC_PATH . DS . 'assets' . DS . 'uploads');
}

if (!defined('APP_NAME')) {
    define('APP_NAME', $_ENV['APP_NAME'] ?? 'PSEMS');
}

if (!defined('APP_VERSION')) {
    define('APP_VERSION', '1.0.0');
}

if (!defined('DATE_FORMAT')) {
    define('DATE_FORMAT', 'Y-m-d');
}

if (!defined('DATETIME_FORMAT')) {
    define('DATETIME_FORMAT', 'Y-m-d H:i:s');
}
