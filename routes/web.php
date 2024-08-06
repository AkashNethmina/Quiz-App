<?php


// Web routes
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

// Admin routes
Route::group(['prefix' => 'admin'], function () {
    // Admin guest middleware
    Route::get('login', [AdminController::class, 'index'])
        ->name('admin.login')
        ->middleware(\App\Http\Middleware\AdminGuest::class);

    Route::get('register', [AdminController::class, 'register'])
        ->name('admin.register')
        ->middleware(\App\Http\Middleware\AdminGuest::class);

    Route::post('login', [AdminController::class, 'authenticate'])
        ->name('admin.authenticate')
        ->middleware(\App\Http\Middleware\AdminGuest::class);

    // Admin authenticated middleware
    Route::get('logout', [AdminController::class, 'logout'])
        ->name('admin.logout')
        ->middleware(\App\Http\Middleware\AdminAuth::class);

    Route::get('dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard')
        ->middleware(\App\Http\Middleware\AdminAuth::class);

    // Question routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('admin.questions')->middleware(\App\Http\Middleware\AdminAuth::class);
    Route::post('/questions', [QuestionController::class, 'store'])->middleware(\App\Http\Middleware\AdminAuth::class);
    Route::put('/questions', [QuestionController::class, 'update'])->middleware(\App\Http\Middleware\AdminAuth::class);
    Route::get('/questions/{question}', [QuestionController::class, 'destroy'])->middleware(\App\Http\Middleware\AdminAuth::class);
    // Answer routes
    Route::put('/answers/{answer}', [AnswerController::class, 'update'])->middleware(\App\Http\Middleware\AdminAuth::class);

});







// Quiz routes
Route::get('quiz', [QuizController::class, 'index']);
Route::post('/results', [QuizController::class, 'results']);

// Leaderboard routes
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::post('/leaderboard', [LeaderboardController::class, 'store']);

// Fallback route
Route::fallback(function () {
    return Inertia::render('Home');
});
