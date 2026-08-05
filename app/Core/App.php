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
        if (file_exists((defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__)) . '/routes/web.php')) {
            require_once (defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__)) . '/routes/web.php';
        }
    }
    
    public function run(): void
    {
        try {
            $this->router->dispatch();
        } catch (\Throwable $e) {
            // Normalize APP_DEBUG to boolean so strings like "false" don't evaluate true
            $envDebug = getenv('APP_DEBUG');
            if ($envDebug === false) {
                $envDebug = $_ENV['APP_DEBUG'] ?? false;
            }
            $debug = filter_var($envDebug, FILTER_VALIDATE_BOOLEAN);

            if ($debug) {
                echo '<h1>Error</h1><p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<pre>' . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre>';
            } else {
                http_response_code(500);
                echo '<h1>System Error</h1><p>Please try again later.</p>';
            }
        }
    }
}
