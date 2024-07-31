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
        $leaderboard = Leaderboard::orderBy('score', 'desc')->get();
        return Inertia::render('Leaderboard', [
            'leaderboard' => $leaderboard,
        ]);
    }

    /**
     * Store a new score in the leaderboard.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'score' => 'required|integer|min:0',
            'total_questions' => 'required|integer|min:1',
        ]);

        try {
            Leaderboard::create($request->all());
            return redirect()->back()->with('success', 'Score added to leaderboard');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add score to leaderboard');
        }
    }
    
}
