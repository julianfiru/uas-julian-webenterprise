# ============================================
# PANDUAN LENGKAP SETUP GMAIL SMTP
# ============================================

## LANGKAH 1: AKTIFKAN 2-STEP VERIFICATION
1. Buka https://myaccount.google.com/
2. Klik "Security" di sidebar kiri
3. Scroll ke bawah cari "2-Step Verification"
4. Klik "Get Started" dan ikuti petunjuk
5. Verifikasi dengan nomor HP kamu

## LANGKAH 2: BUAT APP PASSWORD
1. Setelah 2-Step Verification aktif
2. Kembali ke https://myaccount.google.com/security
3. Scroll ke "2-Step Verification"
4. Di bawahnya ada "App passwords" - KLIK INI
5. Di halaman App passwords:
   - Select app: pilih "Mail"
   - Select device: pilih "Other (Custom name)"
   - Ketik nama: "Laravel Sleepy Panda"
   - Klik "Generate"
6. Akan muncul password 16 karakter dengan format: abcd efgh ijkl mnop
7. COPY password ini (HAPUS SEMUA SPASI)

## LANGKAH 3: EDIT FILE .env
Buka file .env di project Laravel, lalu update/tambahkan:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailkamu@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=emailkamu@gmail.com
MAIL_FROM_NAME="Sleepy Panda"
```

PENTING:
- MAIL_USERNAME harus email Gmail lengkap
- MAIL_PASSWORD adalah 16 digit tanpa spasi
- BUKAN password Gmail biasa!
- Semua huruf kecil
- Tidak pakai tanda kutip

## LANGKAH 4: CLEAR CACHE
Jalankan di terminal:
```bash
php artisan config:clear
php artisan cache:clear
```

## LANGKAH 5: TEST
1. Buka halaman forgot password
2. Masukkan email yang terdaftar
3. Klik "Reset Password"
4. Cek inbox email

## TROUBLESHOOTING

### Error: Authentication failed
❌ Username atau password salah
✅ Solusi:
- Pastikan MAIL_USERNAME = email Gmail lengkap
- Pastikan MAIL_PASSWORD = App Password 16 digit (bukan password Gmail)
- Hapus semua spasi di password
- Generate ulang App Password jika perlu

### Error: Connection timeout
❌ Koneksi internet atau firewall
✅ Solusi:
- Cek koneksi internet
- Coba ganti:
  MAIL_PORT=465
  MAIL_ENCRYPTION=ssl

### Error: Email tidak masuk
❌ Email mungkin masuk ke spam
✅ Solusi:
- Cek folder Spam/Junk
- Tunggu 1-2 menit
- Pastikan email user terdaftar di database

## ALTERNATIF: PAKAI MAILTRAP (TESTING)
Jika Gmail susah, pakai Mailtrap untuk testing:

1. Daftar di https://mailtrap.io (gratis)
2. Buka inbox
3. Copy kredensial SMTP
4. Edit .env:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=kredensial-dari-mailtrap
MAIL_PASSWORD=kredensial-dari-mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@sleepypanda.test"
MAIL_FROM_NAME="Sleepy Panda"
```

Email akan tertangkap di inbox Mailtrap, tidak dikirim beneran.
