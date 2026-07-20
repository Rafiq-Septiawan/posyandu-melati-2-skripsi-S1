<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim.');
        }

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

       
        $resetUrl = config('app.url') . '/reset-password/' . $token . '?email=' . urlencode($request->email);
        $nama     = $user->nama;

        Mail::send([], [], function ($message) use ($request, $resetUrl, $nama) {
            $message->to($request->email)
                ->subject('Reset Password — Posyandu Melati 2')
                ->html("
                    <div style='font-family:DM Sans,sans-serif;max-width:520px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);'>
                        <div style='background:linear-gradient(135deg,#0d3b38,#0f8075);padding:32px 36px;text-align:center;'>
                            <div style='font-size:28px;font-weight:700;color:#fff;'>Posyandu Melati 2</div>
                            <div style='font-size:13px;color:rgba(255,255,255,.7);margin-top:4px;'>Sistem Informasi Kesehatan</div>
                        </div>
                        <div style='padding:32px 36px;'>
                            <h2 style='font-size:20px;font-weight:700;color:#1e293b;margin-bottom:8px;'>Reset Password</h2>
                            <p style='font-size:14px;color:#64748b;line-height:1.7;margin-bottom:24px;'>
                                Halo <strong style='color:#1e293b;'>{$nama}</strong>, kami menerima permintaan reset password untuk akun Anda.
                                Klik tombol di bawah untuk membuat password baru.
                            </p>
                            <div style='text-align:center;margin-bottom:24px;'>
                                <a href='{$resetUrl}' style='display:inline-block;padding:14px 32px;background:linear-gradient(135deg,#0f8075,#14a398);color:#fff;border-radius:10px;font-size:15px;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(15,128,117,.3);'>
                                    Reset Password Sekarang
                                </a>
                            </div>
                            <div style='background:#f1f5f9;border-radius:10px;padding:14px 16px;margin-bottom:20px;'>
                                <p style='font-size:12px;color:#64748b;margin:0;'>
                                    Link ini hanya berlaku selama <strong>60 menit</strong>.<br>
                                    Jika Anda tidak meminta reset password, abaikan email ini.
                                </p>
                            </div>
                            <p style='font-size:12px;color:#94a3b8;'>
                                Atau copy link ini ke browser:<br>
                                <span style='color:#0f8075;word-break:break-all;'>{$resetUrl}</span>
                            </p>
                        </div>
                        <div style='background:#f8fafc;padding:20px 36px;text-align:center;border-top:1px solid #e2e8f0;'>
                            <p style='font-size:12px;color:#94a3b8;margin:0;'>© " . date('Y') . " Posyandu Melati 2. All rights reserved.</p>
                        </div>
                    </div>
                ");
        });

        return back()->with('status', 'Link reset password telah dikirim ke email Anda. Cek inbox atau folder spam.');
    }

    // Tampilkan form reset password
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        if (!$token || !$email) {
            return redirect()->route('login')->with('error', 'Link reset password tidak valid.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required'     => 'Email wajib diisi.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek token di database
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->with('error', 'Link reset password tidak valid atau sudah kadaluarsa.');
        }

        // Cek token expired (60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->with('error', 'Link reset password sudah kadaluarsa. Silakan minta ulang.');
        }

        // Verifikasi token
        if (!Hash::check($request->token, $record->token)) {
            return back()->with('error', 'Link reset password tidak valid.');
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Akun tidak ditemukan.');
        }

        $user->update([
            'password'            => Hash::make($request->password),
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }
}