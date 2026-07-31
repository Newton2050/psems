<?php
// Ensure correct HTTP status is sent
http_response_code(500);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error</title>
    <meta name="robots" content="noindex,nofollow">
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
                <h1 id="error-heading" class="display-1 text-danger">500</h1>
                <h2 class="h4">Server Error</h2>
                <p class="text-muted" aria-live="polite">Something went wrong on our end. Please try again later.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="<?= htmlspecialchars(url(''), ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary">Go Home</a>
                    <a href="javascript:location.reload()" class="btn btn-outline-light">Retry</a>
                </div>
                <!-- Do not display debug info here. Log the error on server-side instead. -->
            </div>
        </div>
    </main>
</body>
</html>
