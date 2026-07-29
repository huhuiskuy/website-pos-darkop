<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginAdmin(Request $request)
    {
        // 1. Validasi inputan (wajib diisi)
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 2. Cek ke database (dengan fitur Remember Me aktif permanen)
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            
            // Cek sumber loginnya dari input hidden (login_source)
            if ($request->login_source == 'pos') {
                // Lempar ke halaman mesin kasir POS
                return redirect('/pos'); 
            }

            // Default lempar ke Back Office
            return redirect()->intended('/'); 
        }

        // 3. Kalau salah, balikin ke halaman login bawa pesan error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->input('source') === 'pos') {
            return redirect('/login-pos');
        }
        
        return redirect('/login-admin');
    }
}