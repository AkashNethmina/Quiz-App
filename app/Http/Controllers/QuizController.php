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

    public function submitQuiz(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
            'answers.*.time_taken' => 'required|integer|min:0',
        ]);

        $score = 0;
        $negativeMarking = 0;

        foreach ($validatedData['answers'] as $userAnswer) {
            $question = Question::find($userAnswer['question_id']);
            $answer = Answer::find($userAnswer['answer_id']);
            
            if ($answer->correct_answer) {
                $score++;
            } else {
                $negativeMarking++;
            }
        }

        $finalScore = $score - $negativeMarking;
        $totalTimeTaken = array_sum(array_column($validatedData['answers'], 'time_taken'));

        // Save the result in the database
        Leaderboard::create([
            'name' => $validatedData['name'],
            'score' => $finalScore,
            'total_questions' => count($validatedData['answers']),
            'percentage' => ceil(($finalScore / count($validatedData['answers'])) * 100),
            'time_taken' => $totalTimeTaken,
        ]);

        $percentage = ceil(($finalScore / count($validatedData['answers'])) * 100);

        $comment = match (true) {
            $percentage >= 80 && $percentage <= 100 => 'Congratulations',
            $percentage >= 60 && $percentage <= 79 => 'Impressive',
            $percentage >= 40 && $percentage <= 59 => 'Almost there!',
            $percentage < 39 => 'Uh-Oh',
            default => 'Well how did you reach here?'
        };

        return Inertia::render('Result', [
            'name' => $validatedData['name'],
            'score' => $finalScore,
            'total_questions' => count($validatedData['answers']),
            'percentage' => $percentage,
            'comment' => $comment,
            'time_taken' => $totalTimeTaken,
        ]);
    }
}
