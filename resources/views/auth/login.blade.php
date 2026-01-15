<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sleepy Panda</title>
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
                <p class="auth-subtitle">Masuk menggunakan akun yang sudah kamu daftarkan</p>
            </div>

            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif

            @if($errors->has('login_error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('login_error') }}
            </div>
            @endif

            <div class="alert alert-danger" id="validationError" style="display: none;">
                <i class="fas fa-exclamation-circle me-2"></i><span id="validationMessage"></span>
            </div>

            <form class="auth-form" action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf
                <div>
                    <div class="auth-field">
                        <i class="fas fa-envelope auth-field__icon"></i>
                        <input type="text" class="auth-input @error('email') is-invalid @enderror"
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

                <div class="auth-row auth-row--right">
                    <a class="auth-link" id="forgotPasswordLink" href="#">Lupa password?</a>
                </div>
            </form>

            <div class="auth-actions">
                <button type="submit" form="loginForm" class="auth-btn auth-btn--primary" id="loginBtn">Masuk</button>
                <div class="auth-footer">
                    Belum memiliki akun?
                    <a class="auth-link" href="{{ route('register') }}">daftar sekarang</a>
                </div>
            </div>

            <!-- OVERLAY -->
            <div class="auth-overlay" id="authOverlay"></div>

            <!-- FORGOT PASSWORD MODAL -->
            <div class="auth-modal" id="forgotPasswordModal">
                <div class="auth-modal__handle" id="closeForgotModal"></div>
                <h3 class="auth-modal__title">Lupa password?</h3>
                <p class="auth-modal__text">Instruksi untuk melakukan reset password akan dikirim melalui email yang kamu gunakan untuk mendaftar</p>
                
                <div class="w-100">
                    <div class="auth-field mb-4">
                        <i class="fas fa-envelope auth-field__icon"></i>
                        <input type="email" class="auth-input" id="forgotEmail" placeholder="Email" required>
                    </div>
                    <button type="button" class="auth-btn" id="sendResetBtn">Reset Password</button>
                </div>
            </div>

            <!-- OTP MODAL -->
            <div class="auth-modal" id="otpModal">
                <div class="auth-modal__handle" id="closeOtpModal"></div>
                <h3 class="auth-modal__title">Verifikasi OTP</h3>
                <p class="auth-modal__text">Masukkan kode 6 digit yang telah kami kirimkan ke email Anda.</p>
                
                <div class="w-100">
                    <div class="otp-inputs">
                        <input type="text" class="otp-field" maxlength="1">
                        <input type="text" class="otp-field" maxlength="1">
                        <input type="text" class="otp-field" maxlength="1">
                        <input type="text" class="otp-field" maxlength="1">
                        <input type="text" class="otp-field" maxlength="1">
                        <input type="text" class="otp-field" maxlength="1">
                    </div>
                    <button type="button" class="auth-btn" id="verifyOtpBtn">Verifikasi</button>
                    <div class="auth-footer mt-3">
                        <a href="#" class="auth-link" id="resendOtpLink">Kirim ulang kode</a>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Login Form Validation
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const validationError = document.getElementById('validationError');
        const validationMessage = document.getElementById('validationMessage');

        let hasSubmitted = false;

        function validateEmail(email) {
            if (!email) return { valid: false, message: 'Email tidak boleh kosong' };
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) return { valid: false, message: 'Format email tidak valid' };
            return { valid: true };
        }

        function validatePassword(password) {
            if (!password) return { valid: false, message: 'Password tidak boleh kosong' };
            if (password.length < 8) return { valid: false, message: 'Password minimal 8 karakter' };
            return { valid: true };
        }

        function validateForm() {
            if (!hasSubmitted) return true;
            const emailVal = validateEmail(emailInput.value);
            const passVal = validatePassword(passwordInput.value);
            if (!emailVal.valid) {
                validationMessage.textContent = emailVal.message;
                validationError.style.display = 'block';
                return false;
            }
            if (!passVal.valid) {
                validationMessage.textContent = passVal.message;
                validationError.style.display = 'block';
                return false;
            }
            validationError.style.display = 'none';
            return true;
        }

        emailInput.addEventListener('input', validateForm);
        passwordInput.addEventListener('input', validateForm);
        loginForm.addEventListener('submit', function(e) {
            hasSubmitted = true;
            if (!validateForm()) e.preventDefault();
        });

        // =====================================================
        // MODAL LOGIC
        // =====================================================
        const overlay = document.getElementById('authOverlay');
        const forgotLink = document.getElementById('forgotPasswordLink');
        const forgotModal = document.getElementById('forgotPasswordModal');
        const otpModal = document.getElementById('otpModal');
        
        const sendResetBtn = document.getElementById('sendResetBtn');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        const resendOtpLink = document.getElementById('resendOtpLink');
        
        const closeForgot = document.getElementById('closeForgotModal');
        const closeOtp = document.getElementById('closeOtpModal');
        
        const forgotEmailInput = document.getElementById('forgotEmail');
        const otpFields = document.querySelectorAll('.otp-field');

        let currentEmail = '';
        const csrfToken = document.querySelector('input[name="_token"]').value;

        function openModal(modal) {
            overlay.classList.add('show');
            modal.classList.add('show');
        }

        function closeAllModals() {
            overlay.classList.remove('show');
            forgotModal.classList.remove('show');
            otpModal.classList.remove('show');
        }

        // Open forgot password modal
        forgotLink.addEventListener('click', function(e) {
            e.preventDefault();
            forgotEmailInput.value = '';
            openModal(forgotModal);
        });

        // Close modals
        overlay.addEventListener('click', closeAllModals);
        closeForgot.addEventListener('click', closeAllModals);
        closeOtp.addEventListener('click', closeAllModals);

        // STEP 1: Send OTP
        sendResetBtn.addEventListener('click', async function() {
            const email = forgotEmailInput.value.trim();
            if (!email) {
                alert('Harap masukkan email');
                return;
            }
            
            sendResetBtn.disabled = true;
            sendResetBtn.textContent = 'Mengirim...';
            
            try {
                const response = await fetch('{{ route("forgot-password.post") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    currentEmail = email;
                    
                    // Tutup forgot modal
                    forgotModal.classList.remove('show');
                    
                    // Clear OTP fields
                    otpFields.forEach(field => field.value = '');
                    
                    // Buka OTP modal (tanpa notifikasi)
                    setTimeout(function() {
                        openModal(otpModal);
                        otpFields[0].focus();
                    }, 300);
                } else {
                    alert(result.message || 'Gagal mengirim OTP');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            } finally {
                sendResetBtn.disabled = false;
                sendResetBtn.textContent = 'Reset Password';
            }
        });

        // Resend OTP
        resendOtpLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentEmail) {
                forgotEmailInput.value = currentEmail;
                sendResetBtn.click();
            }
        });

        // STEP 2: Verify OTP -> Redirect to Reset Password Page
        verifyOtpBtn.addEventListener('click', async function() {
            let otpCode = '';
            otpFields.forEach(field => otpCode += field.value);
            
            if (otpCode.length < 6) {
                alert('Harap masukkan 6 digit kode OTP');
                return;
            }
            
            verifyOtpBtn.disabled = true;
            verifyOtpBtn.textContent = 'Memverifikasi...';
            
            try {
                const response = await fetch('{{ route("verify-otp.post") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: currentEmail, otp: otpCode })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // OTP berhasil - redirect ke halaman reset password
                    window.location.href = result.redirect;
                } else {
                    alert(result.message || 'OTP tidak valid');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan verifikasi');
            } finally {
                verifyOtpBtn.disabled = false;
                verifyOtpBtn.textContent = 'Verifikasi';
            }
        });

        // OTP Input Auto-focus
        otpFields.forEach(function(input, index) {
            input.addEventListener('input', function(e) {
                if (e.target.value.length === 1 && index < otpFields.length - 1) {
                    otpFields[index + 1].focus();
                }
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                    otpFields[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>
