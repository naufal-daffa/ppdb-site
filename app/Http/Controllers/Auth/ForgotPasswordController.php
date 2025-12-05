<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use App\Mail\NewPasswordNotification;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan formulir permintaan email.
     * Route: password.request
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('forgot');
    }

    /**
     * Mengirimkan kata sandi baru ke email.
     * Route: password.email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendNewPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.exists' => 'Alamat email ini tidak terdaftar.'
        ]);

        $email = $request->email;

        try {
            $user = DB::table('users')->where('email', $email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
            }

            $newPassword = Str::random(8) . Str::upper(Str::random(2)) . rand(10, 99);

            $hashedPassword = Hash::make($newPassword);

            DB::table('users')->where('email', $email)->update(['password' => $hashedPassword]);

            Mail::to($email)->send(new NewPasswordNotification($newPassword));

            return redirect()->route('login')
                ->with('success', 'Kata sandi baru telah berhasil dibuat dan dikirim ke alamat email Anda. Silakan cek kotak masuk/spam Anda.');

        } catch (\Exception $e) {
            Log::error('Kesalahan Reset Password untuk email: ' . $email . '. Error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Gagal memproses permintaan reset password. Silakan coba lagi atau hubungi administrator.'])->withInput();
        }
    }
}
