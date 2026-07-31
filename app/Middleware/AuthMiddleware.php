<?php
// app/Middleware/AuthMiddleware.php
require_once __DIR__ . '/MiddlewareInterface.php';

class AuthMiddleware implements MiddlewareInterface {
    public function handle($request) {
        // TODO: implement authentication check (return true to continue, false to block)
        return true;
    }
}
