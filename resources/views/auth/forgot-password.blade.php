<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sleepy Panda</title>
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

            <h1 class="auth-title">Lupa password?</h1>
            <p class="auth-subtitle">Masukkan email untuk melakukan reset password dan klik tombol reset.</p>

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
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

            <div class="alert alert-danger" id="validationError" style="display: none;">
                <i class="fas fa-exclamation-circle me-2"></i><span id="validationMessage"></span>
            </div>

            <form class="auth-form" action="{{ route('forgot-password.post') }}" method="POST" id="forgotPasswordForm">
                @csrf
                <div>
                    <div class="auth-field">
                        <i class="fas fa-envelope auth-field__icon"></i>
                        <input type="email" class="auth-input @error('email') is-invalid @enderror"
                               id="email" name="email" placeholder="Email"
                               value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-btn auth-btn--primary" id="resetBtn">Reset Password</button>
            </form>

            <div class="auth-footer">
                Sudah ingat password?
                <a class="auth-link" href="{{ route('login') }}">kembali ke login</a>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const forgotPasswordForm = document.getElementById('forgotPasswordForm');
        const emailInput = document.getElementById('email');
        const resetBtn = document.getElementById('resetBtn');
        const validationError = document.getElementById('validationError');
        const validationMessage = document.getElementById('validationMessage');

        let hasSubmitted = false;

        // Valid email domains - Real email providers only
        const validDomains = [
            // Google
            'gmail.com',
            // Yahoo
            'yahoo.com', 'yahoo.co.id', 'yahoo.co.uk', 'ymail.com',
            // Microsoft
            'outlook.com', 'hotmail.com', 'live.com', 'msn.com',
            // Apple
            'icloud.com', 'me.com', 'mac.com',
            // Other major providers
            'protonmail.com', 'proton.me',
            'mail.com',
            'aol.com',
            'zoho.com',
            'yandex.com', 'yandex.ru',
            'gmx.com', 'gmx.net',
            'inbox.com',
            'fastmail.com',
            'tutanota.com',
            'mailfence.com',
            'runbox.com',
            'posteo.de'
        ];

        function validateEmail(email) {
            if (!email) {
                return { valid: false, message: 'Email tidak boleh kosong' };
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                return { valid: false, message: 'Email Anda Salah' };
            }

            const domain = email.split('@')[1];
            if (!validDomains.includes(domain)) {
                return { valid: false, message: 'Email Anda Salah' };
            }

            return { valid: true };
        }

        function validateForm() {
            if (!hasSubmitted) return true;

            const emailValidation = validateEmail(emailInput.value);

            if (!emailValidation.valid) {
                validationMessage.textContent = emailValidation.message;
                validationError.style.display = 'block';
                resetBtn.disabled = true;
                resetBtn.style.opacity = '0.6';
                resetBtn.style.cursor = 'not-allowed';
                return false;
            }

            validationError.style.display = 'none';
            resetBtn.disabled = false;
            resetBtn.style.opacity = '1';
            resetBtn.style.cursor = 'pointer';
            return true;
        }

        emailInput.addEventListener('input', validateForm);

        forgotPasswordForm.addEventListener('submit', function(e) {
            hasSubmitted = true;
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
