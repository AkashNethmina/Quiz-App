<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')->get();
        return Inertia::render('Quiz', [
            'questions' => $questions
        ]);
    }

    public function results(Request $request)
    {
        $results = $request->input('results');

        if ($results) {
            $name = $results['name'];
            $score = $results['score'] ?? 0;
            $totalQuestions = $results['totalQuestions'] ?? 1;
            $timeTaken = $results['timeTaken'] ?? 0;

            $percentage = ceil(($score / $totalQuestions) * 100);

            $comment = match (true) {
                $percentage >= 80 && $percentage <= 100 => 'Congratulations',
                $percentage >= 60 && $percentage <= 79 => 'Impressive',
                $percentage >= 40 && $percentage <= 59 => 'Almost there!',
                $percentage < 39 => 'Uh-Oh',
                default => 'Well how did you reach here?'
            };

            
            
            Leaderboard::create([
                'name' => $name,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'percentage' => $percentage,
                'time_taken' => $timeTaken,
            ]);



            return Inertia::render('Result', [
                'name' =>  $name,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'percentage' => $percentage,
                'comment' => $comment,
                'time_taken' => $timeTaken,
            ]);
        } else {
            return response()->json(['error' => 'Invalid data provided'], 400);
        }
    }


    
}
