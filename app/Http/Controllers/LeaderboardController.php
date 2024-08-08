<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard.
     */

    public function index()
    {
        $leaderboard = Leaderboard::orderBy('score', 'desc')
            ->orderBy('time_taken', 'asc')
            ->get();

        return Inertia::render('Leaderboard', [
            'leaderboard' => $leaderboard,
        ]);
    }


    /**
     * Store a new score in the leaderboard.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'score' => 'required|integer',
    //         'total_questions' => 'required|integer',
    //         'percentage' => 'required|numeric',
    //         'time_taken' => 'required|integer',
    //     ]);

    //     // Retrieve inputs from the request
    //     $name = $request->input('name');
    //     $score = $request->input('score');
    //     $totalQuestions = $request->input('total_questions');
    //     $percentage = $request->input('percentage');
    //     $timeTaken = $request->input('time_taken');


    //     // Create a new leaderboard entry
    //     Leaderboard::create([
    //         'name' => $name,
    //         'score' => $score,
    //         'total_questions' => $totalQuestions,
    //         'percentage' => $percentage,
    //         'time_taken' => $timeTaken,
    //     ]);



    //     try {
    //         Leaderboard::create($request->all());
    //         return redirect()->back()->with('success', 'Score added to leaderboard');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Failed to add score to leaderboard');
    //     }
    // }
}
