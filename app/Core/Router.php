<?php
namespace App\Core;

class Router
{
    protected array $routes = ['GET' => [], 'POST' => [], 'PUT' => [], 'DELETE' => []];
    
    public function get(string $path, $handler): self
    {
        return $this->addRoute('GET', $path, $handler);
    }
    
    public function post(string $path, $handler): self
    {
        return $this->addRoute('POST', $path, $handler);
    }
    
    public function put(string $path, $handler): self
    {
        return $this->addRoute('PUT', $path, $handler);
    }
    
    public function delete(string $path, $handler): self
    {
        return $this->addRoute('DELETE', $path, $handler);
    }
    
    protected function addRoute(string $method, string $path, $handler): self
    {
        $path = '/' . trim($path, '/');
        $this->routes[$method][$path] = $handler;
        return $this;
    }
    
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getRequestUri();
        $uri = '/' . trim($uri, '/');
        
        if (isset($this->routes[$method][$uri])) {
            $this->handleRoute($this->routes[$method][$uri]);
            return;
        }
        
        foreach ($this->routes[$method] as $routePath => $handler) {
            $params = $this->matchRoute($routePath, $uri);
            if ($params !== null) {
                $this->handleRoute($handler, $params);
                return;
            }
        }
        
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
    }
    
    protected function matchRoute(string $routePath, string $uri): ?array
    {
        $routeSegments = explode('/', trim($routePath, '/'));
        $uriSegments = explode('/', trim($uri, '/'));
        if (count($routeSegments) !== count($uriSegments)) {
            return null;
        }
        $params = [];
        foreach ($routeSegments as $index => $segment) {
            if ($segment === $uriSegments[$index]) continue;
            if (str_starts_with($segment, '{') && str_ends_with($segment, '}')) {
                $params[trim($segment, '{}')] = $uriSegments[$index];
                continue;
            }
            return null;
        }
        return $params;
    }
    
    protected function handleRoute($handler, array $params = []): void
    {
        if (is_array($handler)) {
            [$controllerClass, $method] = $handler;
            $controller = new $controllerClass();
            $controller->$method(...$params);
            return;
        }
        if ($handler instanceof \Closure) {      
            $handler($params);
            return;
        }
        throw new \RuntimeException("Invalid route handler");
    }
    
    protected function getRequestUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($uri, PHP_URL_PATH);
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
        $basePath = dirname($scriptName);
        if ($basePath !== '/' && $basePath !== '\\') {
            $uri = substr($uri, strlen($basePath));
        }
        return $uri;
    }
}
