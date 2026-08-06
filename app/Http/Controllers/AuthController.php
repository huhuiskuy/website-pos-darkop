<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->username)->first();
        if ($user && $user->role !== 'owner') {
            return back()->withErrors([
                'username' => 'Akses ditolak. Anda bukan owner.',
            ])->onlyInput('username');
        }

        if (Auth::guard('owner')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin'); 
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function loginPos(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->username)->first();
        if ($user && $user->role !== 'barista') {
            return back()->withErrors([
                'username' => 'Akses ditolak. Anda bukan kasir.',
            ])->onlyInput('username');
        }

        if (Auth::guard('barista')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended('/pos'); 
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        if ($request->input('source') === 'pos') {
            Auth::guard('barista')->logout();
            return redirect()->route('login.pos');
        }
        
        Auth::guard('owner')->logout();
        return redirect()->route('login.admin');
    }
}