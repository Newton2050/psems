<?php
// routes/web.php
// Placeholder web routes for PSEMs.
// Replace this with your framework's routing system (Laravel/Slim/Symfony) or include these routes from your front controller.

$routes = [
    '/' => function () {
        echo 'Welcome to PSEMs';
    },
    '/dashboard' => function () {
        echo 'Dashboard (protected)';
    },
];

// Simple dispatcher — suitable for a small app or to be replaced by a proper router.
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (isset($routes[$uri])) {
    $routes[$uri]();
} else {
    http_response_code(404);
    echo 'Not Found';
}
