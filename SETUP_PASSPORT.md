# Setup Laravel Passport dengan OAuth2 dan JWT

## A. Database Setup
- **Nama Database**: `sleepypanda`
- **Tabel User** dengan kolom `hashed_password` (bukan `password`)
- **Kolom tambahan**: `reset_token` untuk OTP

## B. OAuth2 Implementation dengan Laravel Passport

### 1. Package yang diinstall:
```bash
composer require laravel/passport --ignore-platform-req=ext-sodium
php artisan passport:install
```

### 2. Konfigurasi JWT dengan Hash SHA-256:
- **File**: `.env`
```env
PASSPORT_HASH_ALGORITHM=sha256
PASSPORT_TOKEN_EXPIRE_MINUTES=30
```

- **Token Expiration**: 30 menit (sesuai requirement)
- **Algoritma**: SHA256 untuk JWT signing

### 3. User Model (`app/Models/User.php`):
- Menggunakan trait `Laravel\Passport\HasApiTokens`
- Field `hashed_password` untuk menyimpan password terenkripsi
- Method `getAuthPassword()` untuk override authentication password field

### 4. Auth Guard Configuration (`config/auth.php`):
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
        'hash' => false,
    ],
],
```

## C. Registrasi
- Password disimpan di kolom `hashed_password` menggunakan `Hash::make()`
- Validasi: nama, email (harus valid dan unique), password (min 8 karakter)

## D. Login & Authentication
1. **Validasi Custom**:
   - Email format harus valid
   - Domain email tidak boleh dari domain invalid (ganteng.com, test.com, etc)
   - Password minimal 8 karakter
   
2. **Decrypt Password**:
   - Menggunakan `Hash::check($password, $user->hashed_password)`
   - Password di-decrypt dan dibandingkan dengan hash di database
   
3. **Generate OAuth2 Token**:
   - Setelah login berhasil, sistem generate Passport Access Token
   - Token disimpan di session: `access_token`
   - Token expire dalam 30 menit (konfigurasi JWT)
   
4. **Redirect ke Dashboard**:
   - User otomatis diarahkan ke halaman admin dashboard
   - Session berisi: user_id, user_email, user_name, access_token

## E. Logout
- Revoke semua Passport tokens untuk user tersebut
- Clear session
- Logout dari Laravel Auth

## F. Database Migration
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('hashed_password');
    $table->string('reset_token')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```

## G. OAuth2 Tables (Auto-created by Passport):
- `oauth_access_tokens` - Menyimpan access tokens
- `oauth_auth_codes` - Menyimpan authorization codes
- `oauth_clients` - Menyimpan OAuth clients
- `oauth_personal_access_clients` - Personal access clients
- `oauth_refresh_tokens` - Refresh tokens
- `oauth_device_codes` - Device codes

## H. Testing
1. Register user baru dengan email valid
2. Login dengan email dan password yang telah di-register
3. Sistem akan:
   - Decrypt hashed_password
   - Generate OAuth2 Access Token (JWT dengan SHA256)
   - Token expire dalam 30 menit
   - Redirect ke dashboard

## Catatan Penting:
- ✅ OAuth2 Server: Laravel Passport
- ✅ JWT Hash: SHA-256
- ✅ Token Expire: 30 minutes
- ✅ Password Column: `hashed_password`
- ✅ Password Hashing: bcrypt (Laravel default)
- ✅ Password Verification: Hash::check() untuk decrypt
- ✅ Auto redirect ke dashboard setelah login berhasil
