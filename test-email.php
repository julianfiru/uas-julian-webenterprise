<?php

// Test SMTP Configuration
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST SMTP EMAIL ===\n\n";

// Show current config
echo "Konfigurasi SMTP saat ini:\n";
echo "MAIL_MAILER: " . config('mail.default') . "\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n\n";

// Test send email
try {
    echo "Mencoba mengirim test email...\n\n";
    
    Mail::raw('Ini adalah test email dari Laravel Sleepy Panda', function ($message) {
        $message->to(config('mail.mailers.smtp.username'))
                ->subject('Test Email - Sleepy Panda');
    });
    
    echo "✅ EMAIL BERHASIL DIKIRIM!\n";
    echo "Silakan cek inbox email Anda.\n";
    
} catch (Exception $e) {
    echo "❌ GAGAL MENGIRIM EMAIL\n\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    // Diagnosis error
    if (str_contains($e->getMessage(), 'authentication')) {
        echo "SOLUSI: Username atau Password salah\n";
        echo "- Pastikan MAIL_USERNAME adalah email Gmail lengkap (xxx@gmail.com)\n";
        echo "- Pastikan MAIL_PASSWORD adalah App Password (16 digit tanpa spasi)\n";
        echo "- Bukan password Gmail biasa!\n";
    } elseif (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'timed out')) {
        echo "SOLUSI: Masalah koneksi\n";
        echo "- Pastikan koneksi internet stabil\n";
        echo "- Cek firewall tidak memblokir port 587\n";
        echo "- Coba ganti MAIL_PORT ke 465 dan MAIL_ENCRYPTION ke ssl\n";
    } else {
        echo "SOLUSI: Cek konfigurasi di file .env\n";
    }
}
