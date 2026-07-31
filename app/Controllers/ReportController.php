<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Examination;
use App\Models\Stream;
use App\Models\Pupil;
use App\Models\Mark;
use App\Models\Subject;

class ReportController extends Controller
{
    public function index(): void
    {
        $examModel = new Examination();
        $streamModel = new Stream();
        
        $examinations = $examModel->all();
        $streams = $streamModel->all();
        
        $this->view('reports/index', [
            'title' => 'Reports - PSEMS',
            'examinations' => $examinations,
            'streams' => $streams
        ]);
    }
    
    public function merit(): void
    {
        $examId = $_GET['exam_id'] ?? null;
        $streamId = $_GET['stream_id'] ?? null;
        
        $examModel = new Examination();
        $streamModel = new Stream();
        $pupilModel = new Pupil();
        $markModel = new Mark();
        $subjectModel = new Subject();
        
        $exam = $examModel->find($examId);
        $stream = $streamModel->find($streamId);
        $pupils = $pupilModel->all();
        $subjects = $subjectModel->all();
        
        $rankings = [];
        foreach ($pupils as $pupil) {
            $marks = $markModel->getPupilMarks($examId, $pupil['id']);
            $total = array_sum($marks);
            $rankings[] = [
                'pupil' => $pupil,
                'marks' => $marks,
                'total' => $total,
                'average' => count($marks) > 0 ? $total / count($marks) : 0
            ];
        }
        
        usort($rankings, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });
        
        $this->view('reports/merit', [
            'title' => 'Merit List - PSEMS',
            'exam' => $exam,
            'stream' => $stream,
            'subjects' => $subjects,
            'rankings' => $rankings
        ]);
    }
}
