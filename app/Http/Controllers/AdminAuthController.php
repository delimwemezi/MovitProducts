<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return back()->with('error', 'You are not an admin.');
        }

        return back()->with('error', 'Invalid email or password.');
    }
}
