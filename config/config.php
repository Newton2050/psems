<?php
return [
    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'PSEMS',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => $_ENV['APP_DEBUG'] === 'true',
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'timezone' => $_ENV['APP_TIMEZONE'] ?? 'Africa/Nairobi',
    ],
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => (int)($_ENV['DB_PORT'] ?? 3306),
        'database' => $_ENV['DB_NAME'] ?? 'psems_db',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? '',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    ],
    'session' => [
        'lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 7200),
    ],
    'security' => [
        'csrf_lifetime' => (int)($_ENV['CSRF_TOKEN_LIFETIME'] ?? 1800),
        'login_attempts' => (int)($_ENV['LOGIN_ATTEMPTS'] ?? 5),
        'login_lockout' => (int)($_ENV['LOGIN_LOCKOUT_TIME'] ?? 300),
    ],
];
