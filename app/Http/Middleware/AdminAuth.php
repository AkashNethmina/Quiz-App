<?php

// app/Http/Middleware/AdminAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated as an admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
