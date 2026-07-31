<?php
// app/Middleware/MiddlewareInterface.php
interface MiddlewareInterface {
    /**
     * Handle an incoming request.
     * @param mixed $request
     * @return mixed
     */
    public function handle($request);
}
