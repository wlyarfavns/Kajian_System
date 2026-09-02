<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class VerifyOtpController extends Controller
{
    /**
     * Tampilkan halaman verifikasi OTP.
     */
    public function create(Request $request)
    {
        // Jika tidak ada session email, kembalikan ke lupa sandi
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp', [
            'email' => $request->session()->get('reset_email')
        ]);
    }

    /**
     * Cek OTP yang dimasukkan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $record = DB::table('password_reset_otps')
                    ->where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        if (!$record) {
            return back()->withInput($request->only('email'))->withErrors([
                'otp' => 'Kode OTP tidak valid atau salah.',
            ]);
        }

        // Cek kedaluwarsa (misalnya 15 menit)
        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('password_reset_otps')->where('email', $request->email)->delete();
            return back()->withInput($request->only('email'))->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta ulang.',
            ]);
        }

        // Jika valid, kita generate token rahasia Laravel yang sebenarnya
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        $token = Password::broker()->createToken($user);

        // Hapus OTP setelah berhasil diverifikasi agar tidak bisa dipakai ulang
        DB::table('password_reset_otps')->where('email', $request->email)->delete();

        // Arahkan ke halaman reset password bawaan dengan token tersebut
        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }
}
