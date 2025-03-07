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
    
        // Check if the user has a valid role (Employee, hr3, or admin)
        if (!in_array($user->role, ['Employee', 'hr3', 'admin'])) {
            // Log the user out if the role is not valid
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            // Redirect back to the login page with an error message
            return redirect()->route('login')->withErrors(['role' => 'Invalid role. Please contact your administrator.']);
        }
    
        if ($user->role === 'admin' || $user->role === 'hr3') {
            return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
        } elseif ($user->role === 'Employee') {
            return redirect()->route('employee.dashboard'); // Redirect to the employee dashboard
        }
    
        // Default redirection (optional)
        return redirect()->route('login')->withErrors(['login' => 'Invalid credentials']);
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login'); // Or '/login'
    }
}