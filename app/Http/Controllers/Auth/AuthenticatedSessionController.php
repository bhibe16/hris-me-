<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user's account has been terminated
        if ($user->employee && $user->employee->status === 'Terminated') {
            Auth::logout(); // Log out the user
            return redirect()->route('login')->with('error', 'Your account has been terminated by admin.');
        }

        // Redirect based on role after login
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
        } elseif ($user->role === 'employee') {
            return redirect()->route('employee.dashboard'); // Redirect to the employee dashboard
        }

        // Default redirection (optional)
        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}