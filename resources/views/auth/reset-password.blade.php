<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sleepy Panda</title>
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

                <p class="auth-subtitle">Masukkan password baru untuk akun Anda</p>
            </div>

            <!-- Alerts Section -->
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

            <form class="auth-form" action="{{ route('reset-password.post') }}" method="POST" id="resetForm">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                
                <div>
                    <div class="auth-field">
                        <i class="fas fa-lock auth-field__icon"></i>
                        <input type="password" class="auth-input @error('password') is-invalid @enderror"
                               id="password" name="password" placeholder="Password Baru" required>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <div class="auth-field">
                        <i class="fas fa-lock auth-field__icon"></i>
                        <input type="password" class="auth-input"
                               id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>
                </div>
            </form>

            <div class="auth-actions">
                <button type="submit" form="resetForm" class="auth-btn auth-btn--primary" id="resetBtn">Simpan Password</button>

                <div class="auth-footer">
                    Ingat password?
                    <a class="auth-link" href="{{ route('login') }}">masuk sekarang</a>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const resetBtn = document.getElementById('resetBtn');

        function validatePasswords() {
            if (passwordInput.value.length < 8) {
                return false;
            }
            if (passwordInput.value !== confirmInput.value) {
                return false;
            }
            return true;
        }

        document.getElementById('resetForm').addEventListener('submit', function(e) {
            if (passwordInput.value.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter');
                return;
            }
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert('Password tidak cocok');
                return;
            }
        });
    </script>
</body>
</html>
