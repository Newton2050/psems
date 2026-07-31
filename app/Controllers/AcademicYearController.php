<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
class AcademicYearController extends Controller
{
    public function index(): void
    {
        $academicYearModel = $this->model('AcademicYear');
        $academicYears = $academicYearModel->all();
        
        $this->view('academic_years/index', [
            'title' => 'Academic Years - PSEMS',
            'academicYears' => $academicYears
        ]);
    }
    
    public function create(): void
    {
        $this->view('academic_years/create', [
            'title' => 'Add Academic Year - PSEMS'
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'year_name' => 'required|min:4|max:20',
                'start_date' => 'required',
                'end_date' => 'required'
            ])) {
                $academicYearModel = $this->model('AcademicYear');
                $academicYearModel->create([
                    'year_name' => trim($_POST['year_name']),
                    'start_date' => trim($_POST['start_date']),
                    'end_date' => trim($_POST['end_date']),
                    'is_active' => $_POST['is_active'] ?? 0
                ]);
                
                Session::flash('success', 'Academic year created successfully.');
                $this->redirect('academic-year');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $this->view('academic_years/create', [
                    'title' => 'Add Academic Year - PSEMS',
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('academic-year/create');
        }
    }
    
    public function delete($id): void
    {
        $academicYearModel = $this->model('AcademicYear');
        $academicYearModel->delete($id);
        Session::flash('success', 'Academic year deleted successfully.');
        $this->redirect('academic-year');
    }
}
