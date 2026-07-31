<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
class TermController extends Controller
{
    public function index(): void
    {
        $termModel = $this->model('Term');
        $terms = $termModel->all();
        
        $this->view('terms/index', [
            'title' => 'Terms - PSEMS',
            'terms' => $terms
        ]);
    }
    
    public function create(): void
    {
        $academicYearModel = $this->model('AcademicYear');
        $academicYears = $academicYearModel->all();
        
        $this->view('terms/create', [
            'title' => 'Add Term - PSEMS',
            'academicYears' => $academicYears
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'academic_year_id' => 'required',
                'term_name' => 'required|min:3|max:50',
                'start_date' => 'required',
                'end_date' => 'required'
            ])) {
                $termModel = $this->model('Term');
                $termModel->create([
                    'academic_year_id' => trim($_POST['academic_year_id']),
                    'term_name' => trim($_POST['term_name']),
                    'start_date' => trim($_POST['start_date']),
                    'end_date' => trim($_POST['end_date']),
                    'is_active' => $_POST['is_active'] ?? 0
                ]);
                
                Session::flash('success', 'Term created successfully.');
                $this->redirect('term');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $academicYearModel = $this->model('AcademicYear');
                $academicYears = $academicYearModel->all();
                
                $this->view('terms/create', [
                    'title' => 'Add Term - PSEMS',
                    'academicYears' => $academicYears,
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('term/create');
        }
    }
    
    public function delete($id): void
    {
        $termModel = $this->model('Term');
        $termModel->delete($id);
        Session::flash('success', 'Term deleted successfully.');
        $this->redirect('term');
    }
}
