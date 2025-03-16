<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation attacks
            return redirect()->intended(route('admin.index')); // Redirect admin page
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。'
        ]);
    }
}
