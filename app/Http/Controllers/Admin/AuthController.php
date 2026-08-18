<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi tidak cocok.'])
                ->withInput($request->except('password'));
        }

        if (! Auth::user()->is_active) {
            Auth::logout();

            return back()->withErrors(['email' => 'Akun ini dinonaktifkan. Hubungi admin sekolah.'])->withInput($request->except('password'));
        }

        $request->session()->regenerate();

        return redirect()->intended(match (true) {
            Auth::user()->isAdmin() => route('admin.dashboard'),
            Auth::user()->isSiswa() => route('siswa.dashboard'),
            default => route('home'),
        });
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
