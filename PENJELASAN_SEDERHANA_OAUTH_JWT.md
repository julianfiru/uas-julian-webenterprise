# PENJELASAN SEDERHANA: OAuth2 & JWT
## Apa Fungsinya & Bedanya dengan Login Biasa?

---

## 🤔 Pertanyaan: "Sebenernya fungsi OAuth sama JWT buat apaan sih?"

### Analogi Sederhana:

Bayangkan kamu pergi ke kantor atau kampus:

#### **Login Biasa (Sistem Lama):**
```
Kamu datang → Satpam cek KTP → Tulis nama di buku tamu → Boleh masuk
Setiap mau masuk ruangan lain → Harus tunjukkan KTP lagi → Cek buku tamu lagi
```

**Masalah:**
- ❌ Ribet, harus cek database terus-terusan
- ❌ Kalau buku tamu hilang/server down, kamu gabisa masuk
- ❌ Satpam harus selalu ingat muka kamu
- ❌ Lambat karena harus cek berkali-kali

#### **Login dengan OAuth2 + JWT (Sistem Baru):**
```
Kamu datang → Satpam cek KTP → Kasih KARTU AKSES (token/JWT)
Mau masuk ruangan manapun → Tap kartu akses → Langsung masuk
Kartu expired setelah 30 menit → Harus perpanjang
```

**Keuntungan:**
- ✅ Cepat, tinggal tap kartu (cek token)
- ✅ Satpam ga perlu cek database tiap saat
- ✅ Kartu bisa dipake di banyak tempat (multi-service)
- ✅ Kartu punya masa berlaku (security)
- ✅ Kalau kartu hilang, tinggal revoke (logout)

---

## 🔐 OAUTH2: Sistem Keamanan Modern

### Apa itu OAuth2?

**Bahasa Teknis:**
> OAuth2 adalah protokol authorization yang memungkinkan aplikasi mendapatkan akses terbatas ke akun user.

**Bahasa Sederhana:**
> OAuth2 adalah sistem yang kasih "izin akses" ke aplikasi tanpa harus kasih password asli.

### Contoh Nyata OAuth2:

#### Tanpa OAuth2 (Bahaya!):
```
Kamu: "Saya mau login ke Aplikasi X"
Aplikasi X: "Kasih email & password Gmail kamu"
Kamu: "Ini: user@gmail.com, password: rahasia123"
Aplikasi X: "OK, saya simpan password kamu"
```
**Masalah:** Aplikasi X tahu password asli kamu! 😱

#### Dengan OAuth2 (Aman!):
```
Kamu: "Saya mau login ke Aplikasi X pakai Gmail"
Aplikasi X: "Saya redirect kamu ke Google"
Google: "Halo user@gmail.com, Aplikasi X minta akses. Boleh?"
Kamu: "Boleh"
Google: "OK, ini token untuk Aplikasi X" → kasih TOKEN
Aplikasi X: "Terima token, kamu boleh masuk"
```
**Keuntungan:** Aplikasi X TIDAK TAHU password Gmail kamu! 🎉

### OAuth2 di Project Sleepy Panda:

Yang kamu buat tadi itu **Laravel Passport** = OAuth2 server sendiri

**Alurnya:**
```
User → Login dengan email/password
Sistem → Cek password (Hash::check)
Sistem → Generate TOKEN (OAuth2 access token)
Sistem → Kasih token ke user
User → Simpan token
User → Pakai token untuk akses dashboard/API
```

**Kenapa pakai OAuth2?**
1. **Scalable**: Bisa dipakai untuk mobile app, web app, API
2. **Secure**: Token bisa expired, bisa revoke
3. **Standard**: Industri standard, semua orang pakai
4. **Flexible**: Bisa kasih akses berbeda-beda (scope)

---

## 🎫 JWT: Kartu Akses Digital

### Apa itu JWT?

**Bahasa Teknis:**
> JWT (JSON Web Token) adalah standar terbuka untuk membuat token yang berisi informasi terenkripsi.

**Bahasa Sederhana:**
> JWT adalah "kartu akses digital" yang isinya ada informasi kamu, tapi udah di-encrypt dan ada tanda tangannya (signature).

### Analogi JWT = KTP Elektronik:

#### KTP Biasa:
```
Nama: John Doe
NIK: 1234567890
Alamat: Jakarta
Foto: [foto]
```
- Bisa dipalsuin
- Mudah rusak
- Susah verifikasi

#### KTP Elektronik (seperti JWT):
```
Data terenkripsi: a1b2c3d4e5f6...
Digital signature: x7y8z9...
Expired: 30 menit lagi
```
- Susah dipalsuin (ada signature)
- Bisa verifikasi otomatis
- Ada masa berlaku
- Self-contained (semua info ada di kartu)

### Struktur JWT:

```
eyJ0eXAiOiJKV1QiLCJhbGc.eyJzdWIiOiIxMjM0NTY3ODkw.SflKxwRJSMeKKF2QT4fwpM
│                        │                    │
│                        │                    └─ SIGNATURE (tanda tangan)
│                        └─ PAYLOAD (isi data)
└─ HEADER (info token)
```

#### 1. HEADER:
```json
{
  "typ": "JWT",
  "alg": "RS256"  ← Algoritma SHA-256
}
```
**Artinya:** "Ini adalah JWT token, ditandatangani dengan algoritma RS256 (SHA-256)"

#### 2. PAYLOAD:
```json
{
  "sub": "1",           ← User ID
  "name": "John Doe",
  "email": "john@example.com",
  "iat": 1705234567,    ← Issued at (kapan dibuat)
  "exp": 1705236367     ← Expire (30 menit kemudian)
}
```
**Artinya:** "Ini data user John Doe, token dibuat jam 12:30, expired jam 13:00"

#### 3. SIGNATURE:
```
HMACSHA256(
  base64UrlEncode(header) + "." + base64UrlEncode(payload),
  private_key
)
```
**Artinya:** "Ini tanda tangan digital yang proof bahwa token asli, bukan palsu"

### Kenapa Pakai JWT?

#### Tanpa JWT (Session Lama):
```
User login → Server simpan session di database
User request → Server cek database: "User ini siapa ya?"
User request lagi → Server cek database lagi
User request lagi → Server cek database lagi...
```
**Masalah:**
- Database keberatan (banyak query)
- Lambat (harus query terus)
- Server harus punya storage session

#### Dengan JWT:
```
User login → Server kasih JWT token
User request → Server baca JWT token: "Oh ini John Doe, expired jam 13:00"
User request lagi → Server baca token lagi (ga perlu database)
User request lagi → Server baca token lagi (ga perlu database)
```
**Keuntungan:**
- ✅ Cepat (ga perlu database)
- ✅ Stateless (server ga perlu nyimpen apa-apa)
- ✅ Scalable (bisa distributed system)
- ✅ Self-contained (semua info ada di token)

### JWT di Project Sleepy Panda:

**Yang kamu buat:**
- Token expire: **30 menit** (sesuai requirement)
- Hash algorithm: **SHA-256** (sesuai requirement)
- Stored in: Session & Database

**Cara kerja:**
```
1. User login
2. System generate JWT token dengan SHA-256
3. Token berisi: user_id, email, name, expire_time
4. Token disimpan di session
5. Setiap request, system cek token
6. Kalau token valid & belum expire → allow access
7. Kalau token expire → redirect ke login
```

---

## 🆚 PERBANDINGAN: Sebelum vs Sesudah

### SEBELUM (Login Biasa):

#### 1. Register:
```php
// Simpan password plain text atau hash sederhana
DB::table('users')->insert([
    'email' => 'user@example.com',
    'password' => Hash::make('password123'),  // Kolom: password
]);
```

#### 2. Login:
```php
// Cek password
$user = DB::table('users')->where('email', $email)->first();
if (Hash::check($password, $user->password)) {
    // Simpan ke session biasa
    session(['user_id' => $user->id]);
    
    // Redirect dashboard
    return redirect('/dashboard');
}
```

#### 3. Setiap Request:
```php
// Harus cek session & query database
if (!session('user_id')) {
    return redirect('/login');
}

$user = DB::table('users')->find(session('user_id'));  // Query DB!
```

**Karakteristik:**
- ✅ Simple & mudah
- ❌ Ga ada token
- ❌ Ga bisa dipakai untuk API/mobile
- ❌ Session based (server harus nyimpen)
- ❌ Ga ada expiry time yang jelas
- ❌ Susah scale ke multiple server

### SESUDAH (OAuth2 + JWT):

#### 1. Register:
```php
// Simpan ke kolom hashed_password (lebih eksplisit)
User::create([
    'email' => 'user@example.com',
    'hashed_password' => Hash::make('password123'),  // Kolom: hashed_password
]);
```

#### 2. Login:
```php
// Cek password
$user = User::where('email', $email)->first();
if (Hash::check($password, $user->hashed_password)) {
    // Generate OAuth2 token (JWT)
    $token = $user->createToken('SleepyPandaApp')->accessToken;
    
    // Simpan token ke session
    session([
        'user_id' => $user->id,
        'access_token' => $token,  // JWT token!
    ]);
    
    // Login ke Laravel Auth
    Auth::login($user);
    
    // Redirect dashboard
    return redirect('/dashboard');
}
```

#### 3. Setiap Request:
```php
// Option 1: Pakai session (untuk web)
if (Auth::check()) {
    $user = Auth::user();  // Sudah ter-cache
}

// Option 2: Pakai token (untuk API)
$token = session('access_token');
// Token berisi semua info, ga perlu query DB berkali-kali
```

**Karakteristik:**
- ✅ Modern & secure
- ✅ Ada token (JWT)
- ✅ Bisa dipakai untuk web, API, mobile
- ✅ Stateless (bisa distributed)
- ✅ Ada expiry time (30 menit)
- ✅ Mudah scale ke multiple server
- ✅ Industry standard

---

## 📊 TABEL PERBANDINGAN

| Aspek | Login Biasa | OAuth2 + JWT |
|-------|-------------|--------------|
| **Authentication** | Session based | Token based |
| **Kolom Password** | `password` | `hashed_password` |
| **Token** | ❌ Tidak ada | ✅ JWT token |
| **Expiry** | Session timeout | 30 menit (configurable) |
| **API Support** | ❌ Susah | ✅ Mudah |
| **Mobile App** | ❌ Ribet | ✅ Gampang |
| **Scalability** | ⚠️ Terbatas | ✅ Unlimited |
| **Security** | ⚠️ Cukup | ✅ Tinggi |
| **Database Load** | ⚠️ Banyak query | ✅ Minimal query |
| **Industry Standard** | ❌ Old school | ✅ Modern |

---

## 🎯 KENAPA REQUIREMENT MINTA OAUTH2 + JWT?

### Alasan 1: **Persiapan untuk Aplikasi Modern**

Project Sleepy Panda mungkin akan berkembang:
```
Sekarang: Web only
Nanti: Web + Mobile App + API + Third-party integration
```

Dengan OAuth2 + JWT, sudah siap untuk:
- Android app
- iOS app
- API untuk developer lain
- Integration dengan service lain

### Alasan 2: **Industry Best Practice**

Semua perusahaan besar pakai:
- Google → OAuth2 + JWT
- Facebook → OAuth2 + JWT
- Twitter → OAuth2 + JWT
- GitHub → OAuth2 + JWT
- Microsoft → OAuth2 + JWT

Jadi kamu belajar standar industri yang sebenarnya dipakai di dunia kerja.

### Alasan 3: **Security Requirements**

Requirement spesifik:
- **Hash SHA-256**: Untuk signing JWT token (proof asli)
- **Token expire 30 menit**: Security, kalau token dicuri, cuma bisa dipake 30 menit
- **hashed_password**: Eksplisit bahwa password di-hash, bukan plain text

### Alasan 4: **Scalability & Performance**

**Skenario Real:**
```
1 user → 1 session → OK
100 user → 100 session → OK
10,000 user → 10,000 session → ⚠️ Database keberatan
1,000,000 user → 1,000,000 session → ❌ Server mati
```

**Dengan JWT:**
```
1,000,000 user → 1,000,000 token → ✅ Server ringan
```

Karena JWT ga perlu query database setiap request!

---

## 🔍 CONTOH REAL WORLD

### Contoh 1: Mobile App Sleepy Panda

**Tanpa OAuth2/JWT:**
```
User login di Android app
→ Harus simpan email & password di device ❌
→ Setiap request kirim email & password ❌
→ Kalau password berubah, app broken ❌
```

**Dengan OAuth2/JWT:**
```
User login di Android app
→ Dapat JWT token ✅
→ Simpan token di device (secure storage) ✅
→ Setiap request kirim token ✅
→ Token expire → refresh atau login lagi ✅
→ Password berubah? Token tetap valid ✅
```

### Contoh 2: Smartwatch Integration

Bayangkan Sleepy Panda punya smartwatch app:

```
User pakai smartwatch → tracking tidur
Smartwatch kirim data → API Sleepy Panda
API butuh authentication → pakai JWT token!
```

**Tanpa JWT:** Smartwatch harus simpan password ❌  
**Dengan JWT:** Smartwatch cuma simpan token ✅

### Contoh 3: Third-Party Integration

Developer lain mau integrate dengan Sleepy Panda:

```python
# Developer's code
import requests

# Login
response = requests.post('https://sleepypanda.com/api/login', json={
    'email': 'user@example.com',
    'password': 'password123'
})

token = response.json()['access_token']  # JWT token

# Get sleep data
headers = {'Authorization': f'Bearer {token}'}
sleep_data = requests.get('https://sleepypanda.com/api/sleep-data', headers=headers)
```

Mudah kan? Karena pakai standard OAuth2 + JWT!

---

## 💡 KESIMPULAN SEDERHANA

### OAuth2 itu:
> **"Sistem keamanan yang kasih kartu akses (token) tanpa harus kasih password asli"**

**Fungsi:**
- Generate token
- Validate token
- Revoke token
- Manage permissions

### JWT itu:
> **"Kartu akses digital yang isinya data terenkripsi + tanda tangan + masa berlaku"**

**Fungsi:**
- Simpan info user
- Self-contained (ga perlu database)
- Secure (ada signature)
- Portable (bisa dipake dimana aja)

### Bedanya dengan Login Biasa:

| | Login Biasa | OAuth2 + JWT |
|---|---|---|
| **Analogi** | Buku tamu | Kartu akses |
| **Speed** | 🐢 Lambat (query DB) | 🚀 Cepat (baca token) |
| **Security** | ⚠️ Cukup | ✅ Tinggi |
| **Scalability** | 📱 Web only | 📱💻⌚ Multi-platform |
| **Modern** | 👴 Old school | 🚀 Industry standard |

### Kenapa Harus Pakai?

1. **Kamu lulus kuliah** → Apply kerja → Semua perusahaan pakai OAuth2/JWT
2. **Bikin startup** → Butuh API → Sudah siap
3. **Bikin mobile app** → Butuh authentication → Tinggal pakai token
4. **Sistem scale besar** → Server ga keberatan → JWT stateless

### Intinya:

> **OAuth2 + JWT adalah cara MODERN untuk handle authentication yang AMAN, CEPAT, dan SCALABLE. Ini yang dipake di industri sekarang!**

Kamu belajar ini = kamu siap kerja di perusahaan tech modern! 🎉

---

## 🤓 Fun Fact

**Perusahaan yang pakai OAuth2 + JWT:**
- Google (Gmail, YouTube, Drive)
- Facebook (Login with Facebook)
- Twitter (Twitter API)
- GitHub (GitHub Apps)
- Microsoft (Office 365, Azure)
- Amazon (AWS)
- Spotify (Spotify API)
- Netflix (Netflix API)
- Uber (Uber API)
- Airbnb (Airbnb API)

**Basically... SEMUA perusahaan tech besar!** 🌟

Jadi yang kamu buat tadi itu sistem authentication yang sama kayak yang dipake Google, Facebook, dll. Keren kan? 😎
