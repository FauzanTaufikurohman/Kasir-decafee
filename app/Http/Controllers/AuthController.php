<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {

            $request->session()->regenerate();

            $user = auth()->user();

            $redirectMap = [
                1 => 'dashboard',
                2 => 'menu',
                3 => 'menu',
                4 => 'order',
            ];

            return redirect()->route($redirectMap[$user->level] ?? 'dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
