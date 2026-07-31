<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;

class StreamController extends Controller
{
    public function index(): void
    {
        $streamModel = $this->model('Stream');
        $streams = $streamModel->all();
        
        $this->view('streams/index', [
            'title' => 'Streams - PSEMS',
            'streams' => $streams
        ]);
    }
    
    public function create(): void
    {
        $gradeModel = $this->model('Grade');
        $grades = $gradeModel->all();
        
        $this->view('streams/create', [
            'title' => 'Add Stream - PSEMS',
            'grades' => $grades
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            
            if ($validator->validate([
                'grade_id' => 'required',
                'stream_name' => 'required|min:1|max:50'
            ])) {
                $streamModel = $this->model('Stream');
                $streamModel->create([
                    'grade_id' => trim($_POST['grade_id']),
                    'stream_name' => trim($_POST['stream_name'])
                ]);
                
                Session::flash('success', 'Stream created successfully.');
                $this->redirect('stream');
            } else {
                Session::flash('error', 'Please correct validation errors.');
                $gradeModel = $this->model('Grade');
                $grades = $gradeModel->all();
                
                $this->view('streams/create', [
                    'title' => 'Add Stream - PSEMS',
                    'grades' => $grades,
                    'errors' => $validator->errors(),
                    'old' => $_POST
                ]);
            }
        } else {
            $this->redirect('stream/create');
        }
    }
    
    public function delete($id): void
    {
        $streamModel = $this->model('Stream');
        $streamModel->delete($id);
        Session::flash('success', 'Stream deleted successfully.');
        $this->redirect('stream');
    }
}
