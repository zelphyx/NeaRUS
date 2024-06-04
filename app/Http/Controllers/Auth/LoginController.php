<?php

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to intended page
            return redirect()->intended('/owners');
        }

        // Authentication failed, redirect back to login with input and errors
        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
