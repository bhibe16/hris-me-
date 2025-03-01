<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'employee') {
            return $next($request);
        }

        // Store intended redirect URL before redirecting to loading page
        session(['redirect_url' => route('admin.dashboard')]);
        return redirect('/loading');
    }
}
