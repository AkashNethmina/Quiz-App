<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function update(Request $request, Answer $answer)
    {
        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*.id' => 'required|integer|exists:answers,id',
            'answers.*.answer' => 'required|string|max:255',
            'answers.*.correct_answer' => 'required|boolean',
        ]);

        foreach ($validatedData['answers'] as $answerData) {
            $existingAnswer = Answer::findOrFail($answerData['id']);
            $existingAnswer->update([
                'answer' => $answerData['answer'],
                'correct_answer' => $answerData['correct_answer'],
            ]);
        }

        return response()->json(['message' => 'Answers updated successfully.'], 200);
    }
}
