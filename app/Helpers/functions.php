<?php
// Helpers: app/Helpers/functions.php
// Common helper functions for the application

if (!function_exists('base_url')) {
    function base_url($path = '') {
        return rtrim((isset($_SERVER['BASE_URL']) ? $_SERVER['BASE_URL'] : '/'), '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
