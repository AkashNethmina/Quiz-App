<?php

// app/Http/Middleware/AdminGuest.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGuest
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is not authenticated as an admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
