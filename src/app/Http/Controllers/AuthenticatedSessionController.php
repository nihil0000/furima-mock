<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    // Display login form
    public function create()
    {
        return view('auth.login');
    }

    // Login
    public function store(LoginRequest $request)
    {
        // Validate email and password
        $credentials = $request->validated();

        // Attempt authentication
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation attacks
            return redirect()->intended(route('product.index')); // Redirect admin page
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。'
        ]);
    }

    // Logout
    public function destroy(Request $request)
    {
        auth()->logout(); // Logout the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect('login'); // Redirect to login page
    }
}
