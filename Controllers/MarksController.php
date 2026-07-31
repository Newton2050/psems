<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Session;
class MarksController extends Controller
{
    public function index(): void
    {
        $examModel = $this->model('Examination');
        $streamModel = $this->model('Stream');
        
        $examinations = $examModel->all();
        $streams = $streamModel->all();
        
        $this->view('marks/index', [
            'title' => 'Marks Management - PSEMS',
            'examinations' => $examinations,
            'streams' => $streams
        ]);
    }
    
    public function entry(): void
    {
        $examId = $_GET['exam_id'] ?? null;
        $streamId = $_GET['stream_id'] ?? null;
        
        if (!$examId || !$streamId) {
            Session::flash('error', 'Please select both examination and stream.');
            $this->redirect('marks');
            return;
        }
        
        $examModel = $this->model('Examination');
        $streamModel = $this->model('Stream');
        $pupilModel = $this->model('Pupil');
        $subjectModel = $this->model('Subject');
        
        $exam = $examModel->find($examId);
        $stream = $streamModel->find($streamId);
        $pupils = $pupilModel->all();
        $subjects = $subjectModel->all();
        
        $this->view('marks/entry', [
            'title' => 'Marks Entry - PSEMS',
            'examId' => $examId,
            'exam' => $exam,
            'stream' => $stream,
            'pupils' => $pupils,
            'subjects' => $subjects
        ]);
    }
    
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $examId = $_POST['exam_id'] ?? null;
            $marksData = $_POST['marks'] ?? [];
            
            $markModel = $this->model('Mark');
            
            foreach ($marksData as $pupilId => $subjects) {
                foreach ($subjects as $subjectId => $score) {
                    if ($score !== '') {
                        $markModel->create([
                            'examination_id' => $examId,
                            'pupil_id' => $pupilId,
                            'subject_id' => $subjectId,
                            'score' => $score
                        ]);
                    }
                }
            }
            
            Session::flash('success', 'Marks saved successfully.');
            $this->redirect('marks/entry?exam_id=' . $examId);
        }
    }
}
