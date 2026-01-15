<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Menampilkan halaman forgot password
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses login dengan validasi custom dan OAuth2 Passport
     */
    public function login(Request $request)
    {
        // VALIDASI 1: Field tidak boleh kosong
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Username/Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->email;
        $password = $request->password;

        // VALIDASI 2: Format email harus valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Username/Password incorrect'])
                ->withInput();
        }

        // VALIDASI 3: Domain email - harus valid, bukan domain yang tidak diizinkan
        $emailParts = explode('@', $email);
        if (count($emailParts) === 2) {
            $domain = $emailParts[1];
            
            // Domain yang tidak diizinkan
            $invalidDomains = ['ganteng.com', 'test.com', 'invalid.com'];
            
            if (in_array($domain, $invalidDomains)) {
                return redirect()->back()
                    ->withErrors(['login_error' => 'Username/Password incorrect'])
                    ->withInput();
            }
        }

        // VALIDASI 4: Password minimal 8 karakter
        if (strlen($password) < 8) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Username/Password incorrect'])
                ->withInput();
        }

        // VALIDASI 5: Cek user di database
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Username/Password incorrect'])
                ->withInput();
        }

        // Verifikasi password dari hashed_password dengan decrypt
        if (!Hash::check($password, $user->hashed_password)) {
            return redirect()->back()
                ->withErrors(['login_error' => 'Username/Password incorrect'])
                ->withInput();
        }

        // Login berhasil - Create Passport Token (OAuth2)
        $token = $user->createToken('SleepyPandaApp')->accessToken;
        
        // Simpan token dan user info ke session
        // Simpan token dan user info ke session
        // Derive name from email (e.g. "julian" from "julian@email.com")
        $derivedName = explode('@', $user->email)[0];
        
        session([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $derivedName,
            'access_token' => $token
        ]);
        
        // Login user ke Laravel Auth
        Auth::login($user);
        
        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    /**
     * Proses register dengan menyimpan password ke hashed_password
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validasi domain email
        $email = $request->email;
        $emailParts = explode('@', $email);
        
        if (count($emailParts) !== 2) {
            return redirect()->back()
                ->withErrors(['email' => 'Format email tidak valid'])
                ->withInput();
        }

        $domain = $emailParts[1];

        // Daftar domain yang tidak diizinkan (fake/test domains)
        $invalidDomains = [
            'ganteng.com', 'test.com', 'invalid.com', 'fake.com', 
            'example.com', 'example.org', 'example.net',
            'mailinator.com', 'tempmail.com', 'throwaway.com',
            'asdf.com', 'qwerty.com', 'abc.com', 'xyz.com'
        ];

        if (in_array(strtolower($domain), $invalidDomains)) {
            return redirect()->back()
                ->withErrors(['email' => 'Domain email "' . $domain . '" tidak diizinkan untuk registrasi'])
                ->withInput();
        }

        // Cek apakah domain memiliki record DNS MX yang valid
        if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
            return redirect()->back()
                ->withErrors(['email' => 'Domain email "' . $domain . '" tidak valid atau tidak ditemukan'])
                ->withInput();
        }

        // Simpan user baru dengan hashed_password
        $user = User::create([
            'email' => $request->email,
            'hashed_password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Proses forgot password - kirim OTP via email
     */
    /**
     * Proses forgot password - kirim OTP via email
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan dalam sistem'
            ], 404);
        }

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(15);
        
        // Simpan OTP ke tabel users
        DB::table('users')->where('email', $email)->update([
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt
        ]);

        // Kirim email dengan OTP
        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Halo,\n\n" .
                "Anda telah meminta reset password untuk akun Sleepy Panda Anda.\n\n" .
                "Kode OTP Anda adalah: {$otp}\n\n" .
                "Kode ini berlaku selama 15 menit.\n\n" .
                "Jika Anda tidak meminta reset password, abaikan email ini.\n\n" .
                "Terima kasih,\n" .
                "Tim Sleepy Panda",
                function ($message) use ($email) {
                    $message->to($email)
                            ->subject('Reset Password - Kode OTP Sleepy Panda');
                }
            );
            
            // Also log for debugging
            \Log::info("OTP sent to $email: $otp");
            
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP (6 Digit) telah dikirim ke email Anda.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Email Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
             return response()->json([
                'success' => false,
                'message' => 'Kode OTP harus 6 digit angka.'
            ], 422);
        }

        $email = $request->email;
        $otp = $request->otp;

        $user = DB::table('users')->where('email', $email)->first();

        if (!$user || $user->otp_code !== $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah atau tidak valid.'
            ], 400);
        }

        if (now()->gt($user->otp_expires_at)) {
             return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.'
            ], 400);
        }

        // OTP valid - save to session for reset password page
        session(['reset_email' => $email, 'otp_verified' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'OTP Berhasil diverifikasi.',
            'redirect' => route('reset-password')
        ]);
    }

    /**
     * Menampilkan halaman reset password
     */
    public function showResetPassword()
    {
        if (!session('otp_verified')) {
            return redirect()->route('login')->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }
        return view('auth.reset-password');
    }

    /**
     * Proses reset password (Form POST)
     */
    public function resetPassword(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('login')->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Update password & clear OTP
        $user->hashed_password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Clear session
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru.');
    }

    /**
     * Logout - revoke Passport token
     */
    public function logout(Request $request)
    {
        // Revoke all tokens for the authenticated user
        if (Auth::check()) {
            $user = Auth::user();
            $user->tokens()->delete();
        }
        
        // Clear session
        session()->flush();
        Auth::logout();
        
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
