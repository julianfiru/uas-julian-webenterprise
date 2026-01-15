<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sleepy Panda</title>
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
            <div class="auth-header">
                <div class="auth-logo">
                    <img src="{{ asset('logo-panda.png') }}" alt="Sleepy Panda Logo" class="auth-logo__img">
                </div>

                <p class="auth-subtitle">Daftar menggunakan email yang valid</p>

                <!-- Alerts moved outside header -->
            </div>

            <!-- Alerts Section -->
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
            </div>

            <form class="auth-form" action="{{ route('register.post') }}" method="POST" id="registerForm">
                @csrf
                <!-- Name field removed -->

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

                <div>
                    <div class="auth-field">
                        <i class="fas fa-lock auth-field__icon"></i>
                        <input type="password" class="auth-input @error('password') is-invalid @enderror"
                               id="password" name="password" placeholder="Password" required>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password confirmation removed -->
            </form>

            <div class="auth-actions">
                <button type="submit" form="registerForm" class="auth-btn auth-btn--primary" id="registerBtn">Daftar</button>

                <div class="auth-footer">
                    Sudah memiliki akun?
                    <a class="auth-link" href="{{ route('login') }}">masuk sekarang</a>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const registerForm = document.getElementById('registerForm');
        // Name input removed
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        // Password confirmation removed
        const registerBtn = document.getElementById('registerBtn');
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
            if (!email) return { valid: false, message: 'Email tidak boleh kosong' };
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                return { valid: false, message: 'username/password incorrect' };
            }

            const domain = email.split('@')[1];
            if (!validDomains.includes(domain)) {
                return { valid: false, message: 'username/password incorrect' };
            }

            return { valid: true };
        }

        function validatePassword(password) {
            if (!password) return { valid: false, message: 'Password tidak boleh kosong' };
            if (password.length < 8) {
                return { valid: false, message: 'Password harus lebih dari 8 karakter' };
            }
            return { valid: true };
        }

        function validateForm() {
            if (!hasSubmitted) return true;

            const emailValidation = validateEmail(emailInput.value);
            const passwordValidation = validatePassword(passwordInput.value);

            if (!emailValidation.valid) {
                validationMessage.textContent = emailValidation.message;
                validationError.style.display = 'block';
                registerBtn.disabled = true;
                registerBtn.style.opacity = '0.6';
                registerBtn.style.cursor = 'not-allowed';
                return false;
            }

            if (!passwordValidation.valid) {
                validationMessage.textContent = passwordValidation.message;
                validationError.style.display = 'block';
                registerBtn.disabled = true;
                registerBtn.style.opacity = '0.6';
                registerBtn.style.cursor = 'not-allowed';
                return false;
            }

            // Password confirmation check removed

            validationError.style.display = 'none';
            registerBtn.disabled = false;
            registerBtn.style.opacity = '1';
            registerBtn.style.cursor = 'pointer';
            return true;
        }

        // nameInput listener removed
        emailInput.addEventListener('input', validateForm);
        passwordInput.addEventListener('input', validateForm);
        // passwordConfirmation listener removed

        registerForm.addEventListener('submit', function(e) {
            hasSubmitted = true;
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
