<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Ensure the Admin model is defined correctly
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Render the admin login page using Inertia.js
        return Inertia::render('Admin/Login');
    }

    public function register()
    {
        // Create a new admin user
        $user = new Admin();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('admin'); // Hash the password before saving
        $user->save();

        return redirect()->route('admin.login')->with('success', 'User created successfully');
    }

    public function authenticate(Request $request)
    {
        // Validate the request input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the admin using the 'admin' guard
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate session to prevent session fixation

            return redirect()->intended('admin/dashboard'); // Redirect to the intended page or dashboard
        }

        // Return back with an error if authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        // Log out the admin user
        Auth::guard('admin')->logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login'); // Redirect to the login page
    }

    public function dashboard()
    {
        // Render the admin dashboard page using Inertia.js
        $leaderboard = Leaderboard::orderBy('score', 'desc')->get();
        return Inertia::render('Admin/Dashboard', [
            'leaderboard' => $leaderboard,
        ]);
    }

   
}
