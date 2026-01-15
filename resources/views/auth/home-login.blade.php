<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sleepy Panda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <main class="auth-page">
        <section class="auth-frame auth-frame--home">
            <div class="auth-home-header">
                <div class="auth-logo">
                    <img src="{{ asset('logo-panda.png') }}" alt="Sleepy Panda Logo" class="auth-logo__img">
                </div>
                <h1 class="auth-brand">Sleepy Panda</h1>
            </div>

            <div class="auth-home-bottom">
                <p class="auth-subtitle mb-4">Mulai dengan masuk atau mendaftar untuk melihat analisa tidur mu.</p>
                <div class="auth-home-actions d-flex flex-column gap-3">
                    <a class="auth-btn auth-btn--primary d-flex align-items-center justify-content-center" href="{{ route('login') }}">Masuk</a>
                    <a class="auth-btn auth-btn--secondary d-flex align-items-center justify-content-center" href="{{ route('register') }}">Daftar</a>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
