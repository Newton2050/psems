<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
class ExaminationController extends Controller
{
    public function index(): void
    {
        $examModel = $this->model('Examination');
        $examinations = $examModel->all();
        
        $this->view('examinations/index', [
            'title' => 'Examinations - PSEMS',
            'examinations' => $examinations
        ]);
    }
    
    public function create(): void
    {
        $termModel = $this->model('Term');
        $terms = $termModel->all();
        
        $this->view('examinations/create', [
            'title' => 'Create Examination - PSEMS',
            'terms' => $terms
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'term_id' => 'required',
                'exam_name' => 'required|min:3|max:100',
                'exam_date' => 'required'
            ])) {
                $examModel = $this->model('Examination');
                $examModel->create([
                    'term_id' => trim($_POST['term_id']),
                    'exam_name' => trim($_POST['exam_name']),
                    'exam_date' => trim($_POST['exam_date']),
                    'description' => trim($_POST['description'] ?? '')
                ]);
                
                Session::flash('success', 'Examination created successfully.');
                $this->redirect('examination');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $termModel = $this->model('Term');
                $terms = $termModel->all();
                
                $this->view('examinations/create', [
                    'title' => 'Create Examination - PSEMS',
                    'terms' => $terms,
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('examination/create');
        }
    }
  
    public function delete($id): void
    {
        $examModel = $this->model('Examination');
        $examModel->delete($id);
        Session::flash('success', 'Examination deleted successfully.');
        $this->redirect('examination');
    }
}
