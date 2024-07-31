<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')->get();
        return Inertia::render('Questions', ['questions' => $questions]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|min:2',
            'answers.*.answer' => 'required|string|max:255',
            'answers.*.correct_answer' => 'required|boolean',
            'type' => 'required|string|in:MCQ,True/False',
        ]);

        $question = Question::create([
            'question' => $validatedData['question'],
            'type' => $validatedData['type'],
        ]);

        foreach ($validatedData['answers'] as $answer) {
            Answer::create([
                'answer' => $answer['answer'],
                'correct_answer' => $answer['correct_answer'],
                'question_id' => $question->id,
            ]);
        }

        return redirect()->back()->with('success', 'Question created successfully.');
    }

      /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {

        $id=$request['id'];
        $editQuestion=Question::findOrFail($id);
        $editQuestion->question= $request['question'];
        $editQuestion->save();

        return redirect('/questions')->with('success','Question edited succesfully');
    }


    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return redirect('/questions')->with('success','Question deleted successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete question.'], 500);
        }
    }

}
