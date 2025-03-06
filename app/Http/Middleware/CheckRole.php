<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Convert the roles passed to the middleware to ucfirst to match the case stored in the database
            $userRole = ucfirst($user->role);
            $roles = array_map('ucfirst', $roles);

            // If the user's role is not in the allowed roles, log them out and redirect to login page
            if (!in_array($userRole, $roles)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors(['role' => 'Invalid role. Please contact your administrator.']);
            }
        }

        return $next($request);
    }
}
