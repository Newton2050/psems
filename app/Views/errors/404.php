<?php
// Ensure correct HTTP status is sent
http_response_code(404);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>
    <meta name="robots" content="noindex,follow">
    <link rel="stylesheet" href="<?= htmlspecialchars(asset('css/bootstrap.min.css'), ENT_QUOTES, 'UTF-8') ?>">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .error-card { max-width: 560px; margin: auto; border-radius: 15px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <main role="main" class="container" aria-labelledby="error-heading">
        <div class="card error-card">
            <div class="card-body text-center p-5">
                <h1 id="error-heading" class="display-1 text-primary">404</h1>
                <h2 class="h4">Page Not Found</h2>
                <p class="text-muted">The page you are looking for does not exist.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="<?= htmlspecialchars(url(''), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary">Go Home</a>
                    <a href="javascript:history.back()" class="btn btn-outline-light">Go Back</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
