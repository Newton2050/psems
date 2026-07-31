<?php
namespace App\Core;

class App
{
    protected Router $router;
    
    public function __construct()
    {
        $this->router = new Router();
        Session::start();
        $this->registerRoutes();
    }
    
    protected function registerRoutes(): void
    {
        if (file_exists(ROOT_PATH . '/routes/web.php')) {
            require_once ROOT_PATH . '/routes/web.php';
        }
    }
    
    public function run(): void
    {
        try {
            $this->router->dispatch();
        } catch (\Throwable $e) {
            $debug = $_ENV['APP_DEBUG'] ?? false;
            if ($debug) {
                echo '<h1>Error</h1><p>' . $e->getMessage() . '</p>';
                echo '<pre>' . $e->getTraceAsString() . '</pre>';
            } else {
                http_response_code(500);
                echo '<h1>System Error</h1><p>Please try again later.</p>';
            }
        }
    }
}
