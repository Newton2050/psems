<?php
// public/index.php - Front controller
// Simple placeholder front controller for PSEMs. Replace with your framework/router as needed.

// If you use Composer, autoload will be available at ../vendor/autoload.php
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

// Simple routing: serve static files automatically by the webserver; everything else returns a simple HTML response.
http_response_code(200);
header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>PSEMs</title>
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <img src="/assets/images/logo.png" alt="PSEMs Logo" style="height:48px">
        <h1>PSEMs</h1>
    </header>
    <main>
        <p>Welcome to PSEMs. Replace this placeholder with your application front controller and views.</p>
    </main>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
