<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});




Route::get('/questions',[QuestionController::class,'index'])->name('questions');
Route::post('/questions',[QuestionController::class,'store']);


Route::put('/questions',[QuestionController::class,'update']);



Route::get('/questions/{question}',[QuestionController::class,'destroy']);


Route::put('/answers/{answer}', [AnswerController::class, 'update']);



Route::get('quiz',[QuizController::class,'index']);
Route::post('/results',[QuizController::class,'results']);


Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::post('/leaderboard', [LeaderboardController::class, 'store']);

Route::fallback(function(){
    return Inertia('Home');
});
