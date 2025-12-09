<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Show login page
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Your login blade
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate form
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string','min:6'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Try login
        if (Auth::attempt($credentials, $remember)) {

            // Regenerate session
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard'); // Redirect after login
        }

        // If failed
        throw ValidationException::withMessages([
            'email' => 'Invalid login details.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
