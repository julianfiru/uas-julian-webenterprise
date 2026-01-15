<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Tambahkan routes berikut ke file routes/web.php Anda
*/

// Home auth screen (pilihan login / register)
Route::get('/', function () {
    return view('auth.home-login');
})->name('home-login');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');

Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp.post');

Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes (Protected)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/database-user', [DashboardController::class, 'databaseUser'])->name('database-user');
Route::get('/jurnal', function() {
    return redirect()->route('jurnal.daily');
});
Route::get('/jurnal/daily', [DashboardController::class, 'jurnalDaily'])->name('jurnal.daily');
Route::get('/jurnal/weekly', [DashboardController::class, 'jurnalWeekly'])->name('jurnal.weekly');
Route::get('/jurnal/monthly', [DashboardController::class, 'jurnalMonthly'])->name('jurnal.monthly');

// Show JWT Token (untuk copy ke jwt.io)
Route::get('/show-token', function() {
    $token = session('access_token');
    $userName = session('user_name');
    $userEmail = session('user_email');
    
    return view('show-token', [
        'token' => $token,
        'userName' => $userName,
        'userEmail' => $userEmail
    ]);
})->name('show-token');
