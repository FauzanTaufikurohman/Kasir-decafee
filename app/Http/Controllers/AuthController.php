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

            return redirect()->route($redirectMap[$user->level] ?? 'dashboard')->with('success', 'Login berhasil!');
        }

        // Cek apakah email ada di database
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Email tidak ditemukan. Silahkan periksa email Anda atau hubungi administrator.',
            ]);
        }

        // Email ada tapi password salah
        return back()->withInput($request->only('email'))->withErrors([
            'password' => 'Password yang Anda masukkan salah. Silahkan coba lagi.',
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
