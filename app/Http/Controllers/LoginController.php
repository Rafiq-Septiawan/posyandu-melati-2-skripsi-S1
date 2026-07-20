<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $loginKey = $request->input('email');
        $fieldType = filter_var($loginKey, FILTER_VALIDATE_EMAIL) ? 'email' : 'no_hp';

        $credentials = [
            $fieldType => $loginKey,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'ketua'     => redirect('/ketua/dashboard'),
                'kader'     => redirect('/kader/dashboard'),
                'bidan'     => redirect('/bidan/dashboard'),
                'orang_tua' => redirect('/orang-tua/dashboard'),
                default     => redirect('/'),
            };
        }

        return back()->with('error', 'Email/Nomor WhatsApp atau password salah')->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'no_hp'    => 'required|string|max:20|unique:users,no_hp',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'no_hp.required'     => 'Nomor WhatsApp wajib diisi.',
            'no_hp.unique'       => 'Nomor WhatsApp sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password),
            'role'     => 'orang_tua',
            'status'   => 'aktif',
            'email'    => null,
        ]);

        Auth::login($user);

        return redirect('/orang-tua/dashboard')->with('success', 'Pendaftaran berhasil. Selamat datang!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
