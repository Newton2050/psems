<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Examination;
use App\Models\Stream;
use App\Models\Subject;
use App\Models\Mark;

class ResultsController extends Controller
{
    public function index(): void
    {
        $examModel = new Examination();
        $streamModel = new Stream();
        
        $examinations = $examModel->all();
        $streams = $streamModel->all();
        
        $this->view('results/index', [
            'title' => 'Results Analysis - PSEMS',
            'examinations' => $examinations,
            'streams' => $streams
        ]);
    }
    
    public function analysis(): void
    {
        $examId = $_GET['exam_id'] ?? null;
        $streamId = $_GET['stream_id'] ?? null;
        
        $examModel = new Examination();
        $streamModel = new Stream();
        $subjectModel = new Subject();
        $markModel = new Mark();
        
        $exam = $examModel->find($examId);
        $stream = $streamModel->find($streamId);
        $subjects = $subjectModel->all();
        
        $subjectAnalysis = [];
        foreach ($subjects as $subject) {
            $scores = $markModel->getSubjectScores($examId, $subject['id']);
            $subjectAnalysis[] = [
                'subject' => $subject,
                'count' => count($scores),
                'average' => count($scores) > 0 ? array_sum($scores) / count($scores) : 0,
                'highest' => count($scores) > 0 ? max($scores) : 0,
                'lowest' => count($scores) > 0 ? min($scores) : 0
            ];
        }
        
        $this->view('results/analysis', [
            'title' => 'Results Analysis - PSEMS',
            'exam' => $exam,
            'stream' => $stream,
            'subjectAnalysis' => $subjectAnalysis
        ]);
    }
}
