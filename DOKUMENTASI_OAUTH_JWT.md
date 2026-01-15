# 📚 DOKUMENTASI OAUTH2 & JWT
## Implementasi pada Sleepy Panda Admin Dashboard

---

# 1. PENJELASAN UMUM

## 1.1 Apa itu OAuth2?

**OAuth2 (Open Authorization 2.0)** adalah standar protokol otorisasi yang memungkinkan aplikasi pihak ketiga mengakses sumber daya pengguna tanpa perlu mengetahui kredensial (username/password) pengguna secara langsung.

### Analogi Sederhana:
> Bayangkan OAuth2 seperti **kartu kunci hotel**. Ketika Anda check-in, Anda memberikan identitas (KTP). Hotel memverifikasi dan memberikan kartu kunci yang hanya bisa membuka kamar Anda selama periode tertentu. Anda tidak perlu memberikan kunci master hotel kepada siapapun.

### Komponen Utama OAuth2:
| Komponen | Deskripsi |
|----------|-----------|
| **Resource Owner** | Pengguna yang memiliki data (user) |
| **Client** | Aplikasi yang ingin mengakses data |
| **Authorization Server** | Server yang mengeluarkan token (Laravel Passport) |
| **Resource Server** | Server yang menyimpan data (API endpoints) |

---

## 1.2 Apa itu JWT?

**JWT (JSON Web Token)** adalah standar terbuka (RFC 7519) untuk mentransmisikan informasi secara aman antara dua pihak dalam bentuk objek JSON yang ditandatangani secara digital.

### Struktur JWT:
```
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
```

JWT terdiri dari 3 bagian yang dipisahkan titik (.):

| Bagian | Nama | Isi |
|--------|------|-----|
| 1 | **Header** | Algoritma (HS256/RS256) dan tipe token |
| 2 | **Payload** | Data/claims (user_id, email, expire time) |
| 3 | **Signature** | Tanda tangan digital untuk verifikasi |

### Analogi Sederhana:
> JWT seperti **tiket konser** yang sudah di-stempel. Tiket berisi informasi nama, kursi, dan tanggal. Stempel (signature) membuktikan tiket asli dari penyelenggara. Siapapun bisa membaca info di tiket, tapi tidak bisa memalsukan stempel.

---

## 1.3 Perbedaan OAuth2 dan JWT

| Aspek | OAuth2 | JWT |
|-------|--------|-----|
| **Jenis** | Protokol/Framework | Format Token |
| **Fungsi** | Mengatur alur otorisasi | Menyimpan data terenkripsi |
| **Hubungan** | Menggunakan JWT sebagai token | Digunakan oleh OAuth2 |
| **Standar** | RFC 6749 | RFC 7519 |

> **Kesimpulan**: OAuth2 adalah **protokol**, JWT adalah **format token**. OAuth2 menggunakan JWT untuk membuat access token.

---

# 2. PERAN DI SLEEPY PANDA

## 2.1 Arsitektur Authentication

```mermaid
sequenceDiagram
    participant U as User
    participant F as Frontend (Blade)
    participant C as AuthController
    participant P as Laravel Passport
    participant DB as Database
    
    U->>F: Input Email & Password
    F->>C: POST /login
    C->>DB: Query User by Email
    DB-->>C: User Data + hashed_password
    C->>C: Hash::check(password)
    C->>P: createToken('SleepyPandaApp')
    P-->>C: JWT Access Token
    C->>C: Store in Session
    C-->>F: Redirect to Dashboard
    F-->>U: Dashboard Page
```

## 2.2 File-file yang Terlibat

| File | Peran |
|------|-------|
| [AppServiceProvider.php](file:///c:/web_enterprise/UAS/julianweb_uas/app/Providers/AppServiceProvider.php) | Konfigurasi token expiration (30 menit) |
| [AuthController.php](file:///c:/web_enterprise/UAS/julianweb_uas/app/Http/Controllers/AuthController.php) | Membuat token saat login |
| [User.php](file:///c:/web_enterprise/UAS/julianweb_uas/app/Models/User.php) | Model dengan `HasApiTokens` trait |
| [.env](file:///c:/web_enterprise/UAS/julianweb_uas/.env) | Konfigurasi hash algorithm & expire time |

---

# 3. CARA KERJA DI SLEEPY PANDA

## 3.1 Proses Registrasi

```php
// AuthController.php - Line 149-153
$user = User::create([
    'email' => $request->email,
    'hashed_password' => Hash::make($request->password), // Bcrypt hash
]);
```

**Alur:**
1. User mengisi form registrasi (email + password)
2. Password di-hash menggunakan **Bcrypt** (12 rounds)
3. Data disimpan ke tabel `users` dengan kolom `hashed_password`

## 3.2 Proses Login

```php
// AuthController.php - Line 100-124

// 1. Verifikasi password dengan hash
if (!Hash::check($password, $user->hashed_password)) {
    return redirect()->back()->withErrors(['login_error' => 'Username/Password incorrect']);
}

// 2. Buat JWT Token via Passport
$token = $user->createToken('SleepyPandaApp')->accessToken;

// 3. Simpan ke session
session([
    'user_id' => $user->id,
    'user_email' => $user->email,
    'user_name' => $derivedName,
    'access_token' => $token  // JWT Token disimpan di sini
]);

// 4. Redirect ke dashboard
return redirect()->route('dashboard');
```

**Alur:**
1. User input email dan password
2. System query user dari database
3. `Hash::check()` membandingkan password input dengan `hashed_password`
4. Jika cocok, Passport membuat **JWT Access Token**
5. Token disimpan di session
6. User diarahkan ke Dashboard

## 3.3 Konfigurasi Token Expiration

```php
// AppServiceProvider.php - Line 23-27
public function boot(): void
{
    // Token expire dalam 30 menit
    $tokenExpireMinutes = (int) config('passport.token_expire_minutes', 30);
    Passport::tokensExpireIn(now()->addMinutes($tokenExpireMinutes));
    Passport::refreshTokensExpireIn(now()->addDays(30));
    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
}
```

**Konfigurasi di .env:**
```env
PASSPORT_HASH_ALGORITHM=sha256
PASSPORT_TOKEN_EXPIRE_MINUTES=30
```

---

# 4. PANDUAN PRESENTASI

## 4.1 Cara Menunjukkan OAuth2 & JWT Sudah Terimplementasi

### ✅ Bukti 1: Tabel oauth_* di Database

Buka phpMyAdmin atau MySQL client dan tunjukkan tabel-tabel berikut:

```sql
SHOW TABLES LIKE 'oauth_%';
```

**Output yang diharapkan:**
- `oauth_access_tokens` - Menyimpan JWT tokens
- `oauth_auth_codes` - Kode otorisasi
- `oauth_clients` - Client applications
- `oauth_personal_access_clients` - Personal access
- `oauth_refresh_tokens` - Refresh tokens

### ✅ Bukti 2: Token di Session

Setelah login, tunjukkan session menggunakan Laravel Tinker:

```bash
php artisan tinker
```

```php
// Di tinker, jalankan:
session()->all();
// Akan menampilkan access_token yang berupa JWT
```

### ✅ Bukti 3: Token di Database

```sql
SELECT * FROM oauth_access_tokens ORDER BY created_at DESC LIMIT 5;
```

Tunjukkan bahwa setiap login membuat record baru di tabel ini.

### ✅ Bukti 4: Decode JWT Token

Gunakan website [jwt.io](https://jwt.io) untuk decode token:

1. Login ke Sleepy Panda
2. Buka Laravel Tinker: `php artisan tinker`
3. Jalankan: `session('access_token')`
4. Copy token yang muncul
5. Paste ke jwt.io
6. Tunjukkan isi payload (user_id, client_id, scopes, expire time)

### ✅ Bukti 5: Kode Sumber

Tunjukkan file-file berikut:

**1. Model User dengan HasApiTokens:**
```php
// app/Models/User.php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
```

**2. Token Creation saat Login:**
```php
// app/Http/Controllers/AuthController.php - Line 107
$token = $user->createToken('SleepyPandaApp')->accessToken;
```

**3. Token Expiration Config:**
```php
// app/Providers/AppServiceProvider.php - Line 25
Passport::tokensExpireIn(now()->addMinutes($tokenExpireMinutes)); // 30 menit
```

### ✅ Bukti 6: Composer Dependencies

```bash
composer show | findstr passport
```

**Output:**
```
laravel/passport     v12.x.x    Laravel Passport provides OAuth2 server support to Laravel.
```

### ✅ Bukti 7: Migration Files

Tunjukkan folder `database/migrations/` yang berisi:
- `create_oauth_auth_codes_table.php`
- `create_oauth_access_tokens_table.php`
- `create_oauth_refresh_tokens_table.php`
- `create_oauth_clients_table.php`
- `create_oauth_device_codes_table.php`

---

## 4.2 Script Presentasi

### Narasi yang Bisa Digunakan:

> "Aplikasi Sleepy Panda menggunakan **Laravel Passport** sebagai implementasi **OAuth2** untuk manajemen autentikasi. Saat user login, sistem:
>
> 1. **Memverifikasi password** dengan membandingkan input terhadap `hashed_password` di database menggunakan `Hash::check()` - ini adalah proses **decrypt** 
>
> 2. **Membuat JWT Token** menggunakan `$user->createToken()` yang disediakan oleh Passport
>
> 3. **Token berlaku 30 menit** sesuai konfigurasi di `AppServiceProvider.php`
>
> 4. Token menggunakan algoritma **SHA256** untuk signing
>
> Buktinya bisa dilihat di tabel `oauth_access_tokens` di database, dan token bisa di-decode di jwt.io untuk melihat payload-nya."

---

# 5. DIAGRAM VISUAL

## 5.1 Flow Authentication

```
┌─────────────┐      ┌─────────────────┐      ┌─────────────────┐
│   Browser   │      │  AuthController │      │    Database     │
└──────┬──────┘      └────────┬────────┘      └────────┬────────┘
       │                      │                        │
       │  POST /login         │                        │
       │  email + password    │                        │
       │─────────────────────>│                        │
       │                      │                        │
       │                      │  SELECT * FROM users   │
       │                      │  WHERE email = ?       │
       │                      │───────────────────────>│
       │                      │                        │
       │                      │  User + hashed_password│
       │                      │<───────────────────────│
       │                      │                        │
       │                      │  Hash::check()         │
       │                      │  (compare passwords)   │
       │                      │                        │
       │                      │  createToken()         │
       │                      │  (generate JWT)        │
       │                      │───────────────────────>│
       │                      │                        │
       │                      │  Store token in        │
       │                      │  oauth_access_tokens   │
       │                      │<───────────────────────│
       │                      │                        │
       │  Redirect /dashboard │                        │
       │  + session(token)    │                        │
       │<─────────────────────│                        │
       │                      │                        │
```

## 5.2 Struktur JWT Token

```
┌──────────────────────────────────────────────────────────────┐
│                        JWT TOKEN                             │
├──────────────────┬────────────────────┬─────────────────────┤
│      HEADER      │      PAYLOAD       │      SIGNATURE       │
├──────────────────┼────────────────────┼─────────────────────┤
│  {               │  {                 │                     │
│    "typ": "JWT", │    "aud": "1",     │  HMACSHA256(        │
│    "alg": "RS256"│    "jti": "abc...",│    base64(header)+  │
│  }               │    "iat": 17684...,│    base64(payload), │
│                  │    "nbf": 17684...,│    secret           │
│                  │    "exp": 17684...,│  )                  │
│                  │    "sub": "123",   │                     │
│                  │    "scopes": []    │                     │
│                  │  }                 │                     │
└──────────────────┴────────────────────┴─────────────────────┘
        │                   │                    │
        ▼                   ▼                    ▼
   Algoritma           Data User            Tanda Tangan
   Enkripsi         & Expire Time            Digital
```

---

# 6. KESIMPULAN

| Aspek | Implementasi di Sleepy Panda |
|-------|------------------------------|
| **OAuth2 Server** | Laravel Passport v12 |
| **Token Format** | JWT (JSON Web Token) |
| **Hash Algorithm** | SHA256 |
| **Token Expire** | 30 menit |
| **Password Hash** | Bcrypt (12 rounds) |
| **Kolom Password** | `hashed_password` |
| **Storage** | Database (`oauth_access_tokens`) + Session |

---

## 📎 REFERENSI

- [RFC 6749 - OAuth 2.0](https://datatracker.ietf.org/doc/html/rfc6749)
- [RFC 7519 - JWT](https://datatracker.ietf.org/doc/html/rfc7519)
- [Laravel Passport Documentation](https://laravel.com/docs/passport)
- [JWT.io - Decode & Verify](https://jwt.io)
