<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
class GradeController extends Controller
{
    public function index(): void
    {
        $gradeModel = $this->model('Grade');
        $grades = $gradeModel->all();
        
        $this->view('grades/index', [
            'title' => 'Grades - PSEMS',
            'grades' => $grades
        ]);
    }
    
    public function create(): void
    {
        $this->view('grades/create', [
            'title' => 'Add Grade - PSEMS'
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'grade_name' => 'required|min:2|max:50'
            ])) {
                $gradeModel = $this->model('Grade');
                $gradeModel->create([
                    'grade_name' => trim($_POST['grade_name']),
                    'description' => trim($_POST['description'] ?? '')
                ]);
                
                Session::flash('success', 'Grade created successfully.');
                $this->redirect('grade');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $this->view('grades/create', [
                    'title' => 'Add Grade - PSEMS',
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('grade/create');
        }
    }
    
    public function delete($id): void
    {
        $gradeModel = $this->model('Grade');
        $gradeModel->delete($id);
        Session::flash('success', 'Grade deleted successfully.');
        $this->redirect('grade');
    }
}
