<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Convert user role and allowed roles to match case
            $userRole = strtolower($user->role);
            $roles = array_map('strtolower', $roles);

            // Allowed system roles
            $allowedRoles = ['admin', 'hr3', 'Employee'];

            // Check if the user's role is valid
            if (!in_array($userRole, $allowedRoles)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors(['role' => 'Invalid role. Access denied.']);
            }

            

            return $next($request);
        }

        return redirect()->route('login')->withErrors(['role' => 'Please log in to continue.']);
    }
}
