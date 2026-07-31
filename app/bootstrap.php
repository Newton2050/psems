<?php
// app/bootstrap.php - application bootstrap: autoload, env loading, database init, basic constants

// Composer autoload if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

// If vlucas/phpdotenv is installed, load .env
if (class_exists(\Dotenv\Dotenv::class)) {
    try {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    } catch (Exception $e) {
        // ignore if .env not present
    }
}

// Fallback PSR-4 autoloader for App\ namespace so the app can run without Composer installed
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    // only handle App\ classes
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Ensure a default VIEW_PATH constant exists
if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', __DIR__ . '/Views');
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
    } catch (Throwable $e) {
        // Do not break bootstrap on DB init failure; controllers/models will throw clear errors.
    }
}
