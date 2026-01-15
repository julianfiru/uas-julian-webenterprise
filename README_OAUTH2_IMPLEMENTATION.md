# IMPLEMENTASI OAUTH2 DENGAN LARAVEL PASSPORT
## Sleepy Panda - UAS Project

---

## ✅ A. DATABASE SETUP

### Database Name: **sleepypanda**

### Tabel Users dengan kolom **hashed_password**:
```sql
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Authorization Server: **OAuth2 dengan Laravel Passport**
Laravel Passport adalah implementasi full OAuth2 server yang mudah diintegrasikan dengan Laravel.

---

## ✅ B. JSON WEB TOKENIZER (JWT)

### Konfigurasi JWT:
- **Hash Algorithm**: SHA-256
- **Access Token Expire**: 30 minutes

### File Konfigurasi `.env`:
```env
DB_DATABASE=sleepypanda

# Passport Configuration
PASSPORT_HASH_ALGORITHM=sha256
PASSPORT_TOKEN_EXPIRE_MINUTES=30
```

### File `config/passport.php`:
```php
'token_expire_minutes' => env('PASSPORT_TOKEN_EXPIRE_MINUTES', 30),
'hash_algorithm' => env('PASSPORT_HASH_ALGORITHM', 'sha256'),
```

### AppServiceProvider Setup:
```php
use Laravel\Passport\Passport;

public function boot(): void
{
    $tokenExpireMinutes = (int) config('passport.token_expire_minutes', 30);
    Passport::tokensExpireIn(now()->addMinutes($tokenExpireMinutes));
    Passport::refreshTokensExpireIn(now()->addDays(30));
    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
}
```

---

## ✅ C. REGISTRASI - Menyimpan ke hashed_password

### File: `app/Http/Controllers/AuthController.php`

```php
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Simpan user baru dengan hashed_password
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'hashed_password' => Hash::make($request->password), // ← Password di-hash
    ]);

    return redirect()->route('login')
        ->with('success', 'Registrasi berhasil! Silakan login.');
}
```

**Penjelasan:**
- Password di-encrypt menggunakan `Hash::make()`
- Disimpan di kolom `hashed_password` (bukan `password`)
- Menggunakan bcrypt algorithm (Laravel default)

---

## ✅ D. LOGIN - Decrypt Password & Redirect ke Dashboard

### File: `app/Http/Controllers/AuthController.php`

```php
public function login(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Cek user di database
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->back()
            ->withErrors(['login_error' => 'Username/Password incorrect'])
            ->withInput();
    }

    // DECRYPT PASSWORD - Verifikasi password dari hashed_password
    if (!Hash::check($request->password, $user->hashed_password)) {
        return redirect()->back()
            ->withErrors(['login_error' => 'Username/Password incorrect'])
            ->withInput();
    }

    // GENERATE OAUTH2 TOKEN
    $token = $user->createToken('SleepyPandaApp')->accessToken;
    
    // Simpan ke session
    session([
        'user_id' => $user->id,
        'user_email' => $user->email,
        'user_name' => $user->name,
        'access_token' => $token
    ]);
    
    // Login user
    Auth::login($user);
    
    // REDIRECT KE DASHBOARD
    return redirect()->route('dashboard')->with('success', 'Login berhasil!');
}
```

**Penjelasan:**
1. **Decrypt Password**: `Hash::check($password, $user->hashed_password)`
   - Membandingkan password input dengan hash di database
   - Laravel otomatis decrypt dan compare
   
2. **Generate OAuth2 Token**: `$user->createToken('SleepyPandaApp')->accessToken`
   - Membuat JWT token dengan SHA-256
   - Token expire dalam 30 menit
   - Token disimpan di tabel `oauth_access_tokens`
   
3. **Auto Redirect**: `redirect()->route('dashboard')`
   - Setelah login berhasil, langsung ke admin dashboard
   - Session berisi user info dan access token

---

## User Model Setup

### File: `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'hashed_password',
        'reset_token',
    ];

    protected $hidden = [
        'hashed_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'hashed_password' => 'hashed',
        ];
    }

    /**
     * Override authentication password field
     */
    public function getAuthPassword()
    {
        return $this->hashed_password;
    }
}
```

---

## Auth Guard Configuration

### File: `config/auth.php`

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'passport',  // ← OAuth2 Passport driver
        'provider' => 'users',
        'hash' => false,
    ],
],
```

---

## Logout - Revoke Tokens

```php
public function logout(Request $request)
{
    // Revoke all Passport tokens
    if (Auth::check()) {
        $user = Auth::user();
        $user->tokens()->delete();
    }
    
    session()->flush();
    Auth::logout();
    
    return redirect()->route('login')->with('success', 'Berhasil logout');
}
```

---

## OAuth2 Database Tables (Auto-created by Passport)

1. **oauth_access_tokens** - Menyimpan JWT access tokens
2. **oauth_refresh_tokens** - Refresh tokens untuk perpanjang session
3. **oauth_clients** - OAuth2 clients
4. **oauth_auth_codes** - Authorization codes
5. **oauth_device_codes** - Device codes
6. **oauth_personal_access_clients** - Personal access clients

---

## Testing Flow

1. **Register**:
   - Buka: `http://127.0.0.1:8000/register`
   - Input: name, email, password, password_confirmation
   - Password disimpan di kolom `hashed_password`

2. **Login**:
   - Buka: `http://127.0.0.1:8000/login`
   - Input: email, password
   - Sistem decrypt `hashed_password`
   - Generate OAuth2 JWT token (expire 30 min)
   - Auto redirect ke dashboard

3. **Dashboard**:
   - URL: `http://127.0.0.1:8000/dashboard`
   - Session berisi access_token
   - User authenticated dengan Passport

4. **Logout**:
   - Revoke semua tokens
   - Clear session
   - Redirect ke login

---

## Keamanan

✅ **Password Encryption**: bcrypt (Laravel default)  
✅ **OAuth2 Server**: Laravel Passport  
✅ **JWT Algorithm**: SHA-256  
✅ **Token Security**: 30 minutes expiry  
✅ **Token Storage**: Database (oauth_access_tokens)  
✅ **Password Field**: hashed_password (tidak plain text)  
✅ **Password Verification**: Hash::check() untuk decrypt  

---

## Installation Commands

```bash
# Install Passport
composer require laravel/passport --ignore-platform-req=ext-sodium

# Run migrations & install
php artisan passport:install

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run server
php artisan serve
```

---

## Summary Checklist

- [x] Database `sleepypanda` created
- [x] Tabel `users` dengan kolom `hashed_password`
- [x] OAuth2 implementation dengan Laravel Passport
- [x] JWT dengan Hash SHA-256
- [x] Access token expire 30 minutes
- [x] Registrasi menyimpan ke `hashed_password`
- [x] Login decrypt password dengan `Hash::check()`
- [x] Auto generate OAuth2 token setelah login
- [x] Auto redirect ke dashboard setelah login
- [x] Logout revoke all tokens

**Status: ✅ COMPLETED**
