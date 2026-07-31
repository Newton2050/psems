<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;

class SubjectController extends Controller
{
    public function index(): void
    {
        $subjectModel = $this->model('Subject');
        $subjects = $subjectModel->all();
        
        $this->view('subjects/index', [
            'title' => 'Subjects - PSEMS',
            'subjects' => $subjects
        ]);
    }
    
    public function create(): void
    {
        $this->view('subjects/create', [
            'title' => 'Add Subject - PSEMS'
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'subject_name' => 'required|min:2|max:100',
                'subject_code' => 'required|min:2|max:20'
            ])) {
                $subjectModel = $this->model('Subject');
                $subjectModel->create([
                    'subject_name' => trim($_POST['subject_name']),
                    'subject_code' => trim($_POST['subject_code']),
                    'description' => trim($_POST['description'] ?? '')
                ]);
                
                Session::flash('success', 'Subject created successfully.');
                $this->redirect('subject');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $this->view('subjects/create', [
                    'title' => 'Add Subject - PSEMS',
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('subject/create');
        }
    }
    
    public function delete($id): void
    {
        $subjectModel = $this->model('Subject');
        $subjectModel->delete($id);
        Session::flash('success', 'Subject deleted successfully.');
        $this->redirect('subject');
    }
}
