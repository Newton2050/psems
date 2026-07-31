<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct(false);
    }
    
    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }
        $this->view('auth/login', [
            'title' => 'Login - PSEMS',
            'error' => Session::getFlash('error')
        ]);
    }
    
    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            Auth::login($user);
            Session::flash('success', 'Welcome back, ' . $user['full_name'] . '!');
            $this->redirect('dashboard');
        } else {
            Session::flash('error', 'Invalid email or password.');
            $this->redirect('auth/login');
        }
    }
    
    public function logout(): void
    {
        Auth::logout();
        Session::flash('success', 'You have been logged out.');
        $this->redirect('auth/login');
    }
}
