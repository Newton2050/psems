<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
class PupilController extends Controller
{
    public function index(): void
    {
        $pupilModel = $this->model('Pupil');
        $pupils = $pupilModel->all();
        
        $this->view('pupils/index', [
            'title' => 'Pupils - PSEMS',
            'pupils' => $pupils
        ]);
    }
    
    public function create(): void
    {
        $streamModel = $this->model('Stream');
        $streams = $streamModel->all();
        
        $this->view('pupils/create', [
            'title' => 'Register Pupil - PSEMS',
            'streams' => $streams
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'admission_number' => 'required|min:2|max:50',
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:1|max:50',
                'gender' => 'required',
                'stream_id' => 'required'
            ])) {
                $pupilModel = $this->model('Pupil');
                $pupilModel->create([
                    'admission_number' => trim($_POST['admission_number']),
                    'first_name' => trim($_POST['first_name']),
                    'last_name' => trim($_POST['last_name']),
                    'full_name' => trim($_POST['first_name']) . ' ' . trim($_POST['last_name']),
                    'gender' => trim($_POST['gender']),
                    'stream_id' => trim($_POST['stream_id']),
                    'date_of_birth' => trim($_POST['date_of_birth'] ?? ''),
                    'guardian_name' => trim($_POST['guardian_name'] ?? ''),
                    'guardian_phone' => trim($_POST['guardian_phone'] ?? '')
                ]);
                
                Session::flash('success', 'Pupil registered successfully.');
                $this->redirect('pupils');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $streamModel = $this->model('Stream');
                $streams = $streamModel->all();
                
                $this->view('pupils/create', [
                    'title' => 'Register Pupil - PSEMS',
                    'streams' => $streams,
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('pupils/create');
        }
    }
    
    public function edit($id): void
    {
        $pupilModel = $this->model('Pupil');
        $streamModel = $this->model('Stream');
        
        $pupil = $pupilModel->find($id);
        $streams = $streamModel->all();
        
        $this->view('pupils/edit', [
            'title' => 'Edit Pupil - PSEMS',
            'pupil' => $pupil,
            'streams' => $streams
        ]);
    }
    
    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pupilModel = $this->model('Pupil');
            
            $pupilModel->update($id, [
                'admission_number' => trim($_POST['admission_number']),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'full_name' => trim($_POST['first_name']) . ' ' . trim($_POST['last_name']),
                'gender' => trim($_POST['gender']),
                'stream_id' => trim($_POST['stream_id']),
                'date_of_birth' => trim($_POST['date_of_birth'] ?? ''),
                'guardian_name' => trim($_POST['guardian_name'] ?? ''),
                'guardian_phone' => trim($_POST['guardian_phone'] ?? '')
            ]);
            
            Session::flash('success', 'Pupil updated successfully.');
            $this->redirect('pupils');
        }
    }
    
    public function delete($id): void
    {
        $pupilModel = $this->model('Pupil');
        $pupilModel->delete($id);
        Session::flash('success', 'Pupil deleted successfully.');
        $this->redirect('pupils');
    }
}
