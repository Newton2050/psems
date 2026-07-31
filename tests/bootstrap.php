<?php
// tests/bootstrap.php

// Load Composer autoloader if available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

// Basic environment for tests
// You can expand this to set environment variables, load helpers, or initialize a test database.

// Example: define a constant for test mode
if (!defined('APP_ENV')) {
    define('APP_ENV', 'testing');
}
