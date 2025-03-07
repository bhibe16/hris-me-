<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'hr3'])) {
            return $next($request);
        }        

        // Store intended redirect URL before redirecting to loading page
        session(['redirect_url' => route('employee.dashboard')]);
        return redirect('/loading');
    }
}
