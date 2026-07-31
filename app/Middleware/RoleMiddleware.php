<?php
// app/Middleware/RoleMiddleware.php
require_once __DIR__ . '/MiddlewareInterface.php';

class RoleMiddleware implements MiddlewareInterface {
    public function handle($request) {
        // TODO: implement role-based authorization (return true to continue, false to block)
        return true;
    }
}
