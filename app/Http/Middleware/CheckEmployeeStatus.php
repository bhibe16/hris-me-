<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmployeeStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has an associated employee record
        if (Auth::check() && Auth::user()->employee && Auth::user()->employee->status === 'Terminated') {
            Auth::logout(); // Log out the user
            return redirect()->route('login')->with('error', 'Your account has been terminated by admin.');
        }

        return $next($request);
    }
}