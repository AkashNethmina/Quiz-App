<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Render the login page with Inertia
        return Inertia::render('Admin/Login');
    }

    public function register()
    {
        // Render the register page with Inertia
        return Inertia::render('Admin/Register');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Redirect to the dashboard on successful login
            return redirect()->route('admin.dashboard');
        }

        // Redirect back to login with an error message
        return redirect()->back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function logout()
    {
        // Logout the admin and redirect to the login page
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        // Render the dashboard page with Inertia
        return Inertia::render('Admin/Dashboard', [
            // Pass any necessary data here
            'user' => Auth::guard('admin')->user(),
        ]);
    }
}
