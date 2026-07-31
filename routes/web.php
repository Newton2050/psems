<?php
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AcademicYearController;
use App\Controllers\ExaminationController;
use App\Controllers\GradeController;
use App\Controllers\MarksController;
use App\Controllers\PupilController;
use App\Controllers\ReportController;
use App\Controllers\ResultsController;
use App\Controllers\SettingsController;
use App\Controllers\StreamController;
use App\Controllers\SubjectController;
use App\Controllers\TeacherController;
use App\Controllers\TermController;

$router = new Router();

// Auth Routes
$router->get('auth/login', [AuthController::class, 'login']);
$router->post('auth/authenticate', [AuthController::class, 'authenticate']);
$router->get('auth/logout', [AuthController::class, 'logout']);
$router->get('auth/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('auth/send-reset-link', [AuthController::class, 'sendResetLink']);
$router->get('auth/reset-password/{token}', [AuthController::class, 'resetPassword']);
$router->post('auth/update-password', [AuthController::class, 'updatePassword']);

// Dashboard
$router->get('dashboard', [DashboardController::class, 'index']);
$router->get('', [DashboardController::class, 'index']);

// Academic Years
$router->get('academic-year', [AcademicYearController::class, 'index']);
$router->get('academic-year/create', [AcademicYearController::class, 'create']);
$router->post('academic-year/store', [AcademicYearController::class, 'store']);
$router->get('academic-year/edit/{id}', [AcademicYearController::class, 'edit']);
$router->post('academic-year/update/{id}', [AcademicYearController::class, 'update']);
$router->get('academic-year/delete/{id}', [AcademicYearController::class, 'delete']);

// Examinations
$router->get('examination', [ExaminationController::class, 'index']);
$router->get('examination/create', [ExaminationController::class, 'create']);
$router->post('examination/store', [ExaminationController::class, 'store']);
$router->get('examination/delete/{id}', [ExaminationController::class, 'delete']);

// Grades
$router->get('grade', [GradeController::class, 'index']);
$router->get('grade/create', [GradeController::class, 'create']);
$router->post('grade/store', [GradeController::class, 'store']);
$router->get('grade/delete/{id}', [GradeController::class, 'delete']);

// Marks
$router->get('marks', [MarksController::class, 'index']);
$router->get('marks/entry', [MarksController::class, 'entry']);
$router->post('marks/store', [MarksController::class, 'store']);

// Pupils
$router->get('pupils', [PupilController::class, 'index']);
$router->get('pupils/create', [PupilController::class, 'create']);
$router->post('pupils/store', [PupilController::class, 'store']);
$router->get('pupils/edit/{id}', [PupilController::class, 'edit']);
$router->post('pupils/update/{id}', [PupilController::class, 'update']);
$router->get('pupils/delete/{id}', [PupilController::class, 'delete']);

// Reports
$router->get('reports', [ReportController::class, 'index']);
$router->get('reports/merit', [ReportController::class, 'merit']);
$router->get('reports/report-card', [ReportController::class, 'reportCard']);

// Results
$router->get('results', [ResultsController::class, 'index']);
$router->get('results/analysis', [ResultsController::class, 'analysis']);

// Settings
$router->get('settings', [SettingsController::class, 'index']);
$router->post('settings/update', [SettingsController::class, 'update']);

// Streams
$router->get('stream', [StreamController::class, 'index']);
$router->get('stream/create', [StreamController::class, 'create']);
$router->post('stream/store', [StreamController::class, 'store']);
$router->get('stream/delete/{id}', [StreamController::class, 'delete']);

// Subjects
$router->get('subject', [SubjectController::class, 'index']);
$router->get('subject/create', [SubjectController::class, 'create']);
$router->post('subject/store', [SubjectController::class, 'store']);
$router->get('subject/delete/{id}', [SubjectController::class, 'delete']);

// Teachers
$router->get('teacher', [TeacherController::class, 'index']);
$router->get('teacher/create', [TeacherController::class, 'create']);
$router->post('teacher/store', [TeacherController::class, 'store']);
$router->get('teacher/delete/{id}', [TeacherController::class, 'delete']);

// Terms
$router->get('term', [TermController::class, 'index']);
$router->get('term/create', [TermController::class, 'create']);
$router->post('term/store', [TermController::class, 'store']);
$router->get('term/delete/{id}', [TermController::class, 'delete']);
