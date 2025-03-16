<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisteredUserController extends Controller
{
    // Display register form
    public function create()
    {
        return view('auth.register');
    }

    // Register user
    public function store(RegisterRequest $request)
    {
        // Create user and hash the password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit');
    }
}
