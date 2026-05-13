<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            Auth::logout();
            return back()->withErrors('Not admin account');
        }

        return back()->withErrors('Invalid login');
    }

    
}

