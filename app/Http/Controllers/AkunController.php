<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AkunController extends Controller
{
    public function index()
    {
        $barista = User::where('role', 'barista')->first();
        return view('akun.index', compact('barista'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth('owner')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        return back()->with('success', 'Profil owner berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.min' => 'Password baru minimal 8 karakter.'
        ]);

        $user = auth('owner')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password owner berhasil diperbarui!');
    }

    public function updateBarista(Request $request)
    {
        $barista = User::where('role', 'barista')->first();
        if (!$barista) {
            return back()->with('error', 'Akun barista tidak ditemukan.');
        }

        $rules = [
            'barista_username' => 'required|string|max:255|unique:users,username,' . $barista->id,
        ];

        if ($request->filled('barista_new_password')) {
            $rules['barista_current_password'] = 'required';
            $rules['barista_new_password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules, [
            'barista_new_password.min' => 'Password barista minimal 8 karakter.',
            'barista_new_password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        if ($request->filled('barista_new_password')) {
            if (!Hash::check($request->barista_current_password, $barista->password)) {
                throw ValidationException::withMessages([
                    'barista_current_password' => 'Password saat ini salah.'
                ]);
            }
        }

        $updateData = [
            'username' => $request->barista_username,
        ];

        if ($request->filled('barista_new_password')) {
            $updateData['password'] = Hash::make($request->barista_new_password);
        }

        $barista->update($updateData);

        return back()->with('success', 'Akun barista berhasil diperbarui!');
    }
}