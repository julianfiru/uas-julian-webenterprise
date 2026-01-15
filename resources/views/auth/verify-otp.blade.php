<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Sleepy Panda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <main class="auth-page">
        <section class="auth-frame">
            <div class="auth-logo">
                <img src="{{ asset('logo-panda.png') }}" alt="Sleepy Panda Logo" class="auth-logo__img">
            </div>

            <h1 class="auth-title">Masukkan Kode OTP</h1>
            <p class="auth-subtitle">Kami telah mengirim kode 6 digit ke email Anda. Masukkan kode tersebut di bawah ini.</p>

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="auth-form" action="{{ route('verify-otp.post') }}" method="POST" id="verifyOtpForm">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                
                <div>
                    <div class="auth-field">
                        <i class="fas fa-key auth-field__icon"></i>
                        <input type="text" class="auth-input" id="otp" name="otp" 
                               placeholder="Masukkan 6 digit OTP" maxlength="6" 
                               pattern="[0-9]{6}" required>
                    </div>
                    <small class="text-muted" style="font-size: 11px;">Kode OTP berlaku selama 15 menit</small>
                </div>

                <button type="submit" class="auth-btn auth-btn--primary">Verifikasi OTP</button>
            </form>

            <div class="auth-footer">
                Belum menerima kode?
                <a class="auth-link" href="{{ route('forgot-password') }}">kirim ulang</a>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const otpInput = document.getElementById('otp');
        
        // Auto focus
        otpInput.focus();
        
        // Only allow numbers
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
