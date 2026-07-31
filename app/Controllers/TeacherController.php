<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;

class TeacherController extends Controller
{
    public function index(): void
    {
        $teacherModel = $this->model('Teacher');
        $teachers = $teacherModel->all();
        
        $this->view('teachers/index', [
            'title' => 'Teachers - PSEMS',
            'teachers' => $teachers
        ]);
    }
    
    public function create(): void
    {
        $this->view('teachers/create', [
            'title' => 'Add Teacher - PSEMS'
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:1|max:50',
                'email' => 'required|email',
                'phone' => 'required|min:10|max:15'
            ])) {
                $teacherModel = $this->model('Teacher');
                $teacherModel->create([
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'full_name' => trim($_POST['first_name']) . ' ' . trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone'])
                ]);
                
                Session::flash('success', 'Teacher registered successfully.');
                $this->redirect('teacher');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $this->view('teachers/create', [
                    'title' => 'Add Teacher - PSEMS',
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('teacher/create');
        }
    }
    
    public function delete($id): void
    {
        $teacherModel = $this->model('Teacher');
        $teacherModel->delete($id);
        Session::flash('success', 'Teacher deleted successfully.');
        $this->redirect('teacher');
    }
}
