<?php
// app/Helpers/functions.php
// Small collection of helper functions used across the app.

if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = rtrim($protocol . $host, '/');
        if ($path === '') {
            return $base;
        }
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        return base_url($path);
    }
}

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('old')) {
    function old($key, $default = '')
    {
        return $_POST[$key] ?? $default;
    }
}

if (!function_exists('e')) {
    function e($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
