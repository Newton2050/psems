<?php
namespace App\Controllers;
use App\Core\Controller;
class DashboardController extends Controller
{
    public function index(): void
    {
        $pupilModel = $this->model('Pupil');
        $teacherModel = $this->model('Teacher');
        $examModel = $this->model('Examination');
        
        $this->view('dashboard/index', [
            'title' => 'Dashboard - PSEMS',
            'totalPupils' => $pupilModel->countAll(),
            'totalTeachers' => $teacherModel->countAll(),
            'totalExams' => $examModel->countAll(),
        ]);
    }
}
