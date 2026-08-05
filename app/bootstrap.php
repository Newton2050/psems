<?php
// app/bootstrap.php - application bootstrap: autoload, env loading, database init, basic constants

// Ensure ROOT_PATH is defined (so other files can rely on it)
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

// Composer autoload if available
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}

// If vlucas/phpdotenv is installed, load .env
if (class_exists(\Dotenv\Dotenv::class)) {
    try {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT_PATH);
        $dotenv->load();
    } catch (\Throwable $e) {
        // ignore if .env not present or cannot be read
    }
}

// Ensure a default VIEW_PATH constant exists
if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', ROOT_PATH . '/app/Views');
}

// Initialize database config from environment variables if Database class exists
if (class_exists(\App\Core\Database::class)) {
    $dbConfig = [
        'host' => getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? '127.0.0.1'),
        'port' => (int)(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? 3306)),
        'database' => getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? ($_ENV['DB_NAME'] ?? '')),
        'username' => getenv('DB_USERNAME') ?: ($_ENV['DB_USERNAME'] ?? ($_ENV['DB_USER'] ?? 'root')),
        'password' => getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? ($_ENV['DB_PASS'] ?? '')),
        'charset' => getenv('DB_CHARSET') ?: ($_ENV['DB_CHARSET'] ?? 'utf8mb4')
    ];

    try {
        \App\Core\Database::init($dbConfig);
    } catch (\Throwable $e) {
        // Do not break bootstrap on DB init failure; controllers/models will throw clear errors.
    }
}
