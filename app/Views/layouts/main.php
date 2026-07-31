<?php
// app/Views/layouts/main.php - main layout for views (absolute /assets paths, includes nav and flash messages)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'PSEMS') ?></title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php require_once VIEW_PATH . '/partials/nav.php'; ?>

    <main class="container py-4">
        <?php // Flash messages
        if (class_exists('\App\Core\Session')) {
            $success = \App\Core\Session::getFlash('success');
            $error = \App\Core\Session::getFlash('error');
            if ($success) {
                echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($success) . '</div>';
            }
            if ($error) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($error) . '</div>';
            }
        }
        ?>

        <?= $content ?? '' ?>
    </main>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
