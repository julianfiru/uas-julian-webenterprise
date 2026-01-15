<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JWT Token Viewer</title>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #1a1f3a; 
            color: #fff; 
            padding: 40px;
            margin: 0;
            min-height: 100vh;
        }
        .container { max-width: 900px; margin: 0 auto; }
        h1 { color: #19b7a7; margin-bottom: 10px; }
        .info { color: #8F9BB3; margin-bottom: 30px; }
        .token-box {
            background: #232845;
            border: 1px solid #3d4470;
            border-radius: 10px;
            padding: 20px;
            word-break: break-all;
            font-family: 'Consolas', monospace;
            font-size: 11px;
            line-height: 1.6;
            margin-bottom: 20px;
            max-height: 200px;
            overflow-y: auto;
        }
        .btn {
            background: #19b7a7;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover { background: #22c6b5; }
        .btn-secondary { background: #5b8ee5; }
        .btn-secondary:hover { background: #6a9af0; }
        .label { color: #19b7a7; font-weight: 600; margin-bottom: 8px; }
        .no-token { 
            background: #3d2020; 
            border: 1px solid #5a3030;
            padding: 20px;
            border-radius: 10px;
            color: #ff6b6b;
        }
        a { color: #19b7a7; }
        .back-link { margin-top: 30px; display: block; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 JWT Token Viewer</h1>
        <p class="info">Copy token ini ke <a href="https://jwt.io" target="_blank">jwt.io</a> untuk decode</p>

        @if($token)
            <p class="label">User: {{ $userName ?? 'N/A' }} ({{ $userEmail ?? 'N/A' }})</p>
            
            <p class="label">Access Token:</p>
            <div class="token-box" id="tokenBox">{{ $token }}</div>
            
            <button class="btn" onclick="copyToken()">📋 Copy Token</button>
            <a href="https://jwt.io/#debugger-io?token={{ urlencode($token) }}" target="_blank" class="btn btn-secondary">🔗 Buka di JWT.io</a>
            
            <script>
                function copyToken() {
                    const token = document.getElementById('tokenBox').innerText;
                    navigator.clipboard.writeText(token).then(() => {
                        alert('Token berhasil dicopy!');
                    });
                }
            </script>
        @else
            <div class="no-token">
                <strong>⚠️ Belum ada token!</strong><br><br>
                Anda harus <a href="{{ route('login') }}">login</a> terlebih dahulu untuk mendapatkan JWT token.
            </div>
        @endif
        
        <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>
    </div>
</body>
</html>
