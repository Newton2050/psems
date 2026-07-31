<?php
// public/index.php - Front controller (uses app/Views/layouts/main.php)
// Simple placeholder front controller for PSEMS. Replace with your framework/router as needed.

// If you use Composer, autoload will be available at ../vendor/autoload.php
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

// Define VIEW_PATH used by controllers and views if not already defined
if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', __DIR__ . '/../app/Views');
}

// Simple asset helper used by views/layouts/main.php
if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return '/assets/' . ltrim($path, '/');
    }
}

// Simple routing: serve static files automatically by the webserver; everything else returns a rendered view using the layout.
http_response_code(200);
header('Content-Type: text/html; charset=utf-8');

// Page variables for the layout
$title = 'PSEMs';

// Build the page content (this will be injected into the layout via $content)
ob_start();
?>
<header class="container py-3 d-flex align-items-center">
    <img src="<?= asset('images/logo.png') ?>" alt="PSEMs Logo" style="height:48px" class="me-3">
    <h1 class="h4 mb-0">PSEMs</h1>
</header>
<main class="container py-4">
    <p>Welcome to PSEMs. Replace this placeholder with your application front controller and views.</p>
</main>

<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= asset('js/script.js') ?>"></script>
<?php
$content = ob_get_clean();

// Render the layout (app/Views/layouts/main.php)
$layoutPath = VIEW_PATH . '/layouts/main.php';
if (file_exists($layoutPath)) {
    require_once $layoutPath;
} else {
    // Fallback: echo content directly
    echo $content;
}
