<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return redirect('/login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect('/login');
    }
}
