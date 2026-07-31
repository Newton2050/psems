<?php
namespace App\Core;
abstract class Controller
{
    protected array $data = [];
    protected string $layout = 'main';
    
    public function __construct(bool $requireAuth = true)
    {
        if ($requireAuth && !Auth::check()) {
            Session::flash('error', 'Please login to continue.');
            $this->redirect('auth/login');
        }
    }
    
    protected function model(string $model): object
    {
        $modelClass = "App\\Models\\{$model}";
        if (!class_exists($modelClass)) {
            throw new \RuntimeException("Model {$modelClass} not found");
        }
        return new $modelClass();
    }
    
    protected function view(string $view, array $data = []): void
    {
        $this->data = array_merge($this->data, $data);
        $viewPath = VIEW_PATH . '/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View {$view} not found");
        }
        extract($this->data);
        ob_start();
        require_once $viewPath;
        $content = ob_get_clean();
        $layoutPath = VIEW_PATH . '/layouts/' . $this->layout . '.php';
        if (file_exists($layoutPath)) {
            require_once $layoutPath;
        } else {
            echo $content;
        }
    }
    
    protected function redirect(string $url): void
    {
        header("Location: " . url($url));
        exit;
    }
    
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function authorize(string $role): void
    {
        if (!Auth::hasRole($role)) {
            Session::flash('error', 'Unauthorized access.');
            $this->redirect('dashboard');
        }
    }
    
    protected function getPaginationParams(): array
    {
        return [
            'page' => max(1, (int)($_GET['page'] ?? 1)),
            'limit' => min(100, max(1, (int)($_GET['limit'] ?? 15))),
            'search' => trim($_GET['search'] ?? ''),
            'sort' => $_GET['sort'] ?? 'id',
            'direction' => in_array($_GET['direction'] ?? 'DESC', ['ASC', 'DESC']) ? $_GET['direction'] : 'DESC'
        ];
    }
    
    protected function verifyCsrf(): bool
    {
        $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        $sessionToken = Session::get('csrf_token');
        if (!$token || !$sessionToken) {
            return false;
        }
        return hash_equals($sessionToken, $token);
    }
    
    protected function csrfField(): string
    {
        $token = Session::get('csrf_token', bin2hex(random_bytes(32)));
        Session::set('csrf_token', $token);
        return '<input type="hidden" name="_token" value="' . htmlspecialchars($token) . '">';
    }
}
