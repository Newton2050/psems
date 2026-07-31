<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . DS . 'app');
define('CONFIG_PATH', ROOT_PATH . DS . 'config');
define('PUBLIC_PATH', ROOT_PATH . DS . 'public');
define('STORAGE_PATH', ROOT_PATH . DS . 'storage');
define('VIEW_PATH', APP_PATH . DS . 'Views');
define('LOG_PATH', STORAGE_PATH . DS . 'logs');
define('CACHE_PATH', STORAGE_PATH . DS . 'cache');
define('UPLOAD_PATH', PUBLIC_PATH . DS . 'assets' . DS . 'uploads');
define('APP_NAME', $_ENV['APP_NAME'] ?? 'PSEMS');
define('APP_VERSION', '1.0.0');
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');
