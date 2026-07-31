<?php
// app/Views/layouts/main.php - main layout for views
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PSEMS' ?></title>
    <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <?= $content ?? '' ?>
    <script src="<?= asset('js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
