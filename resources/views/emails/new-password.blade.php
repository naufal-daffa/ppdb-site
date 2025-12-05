<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kata Sandi Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .password-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #d63384;
            letter-spacing: 2px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SMK Wikrama Bogor</h1>
            <p>Reset Kata Sandi</p>
        </div>

        <div class="content">
            <h2>Halo,</h2>
            <p>Anda telah meminta reset kata sandi untuk akun Anda di sistem PPDB SMK Wikrama Bogor.</p>

            <p>Berikut adalah kata sandi baru Anda:</p>

            <div class="password-box">
                {{ $password }}
            </div>

            <div class="warning">
                <strong>PENTING:</strong>
                <p>1. Segera login dengan kata sandi baru ini</p>
                <p>2. Ganti kata sandi ini dengan yang lebih mudah diingat setelah login</p>
                <p>3. Jangan bagikan kata sandi ini kepada siapapun</p>
            </div>

            <p>Untuk login, silakan kunjungi:</p>
            <a href="{{ url('/login') }}" class="btn">Login Sekarang</a>

            <p>Jika Anda tidak meminta reset kata sandi, abaikan email ini atau hubungi administrator.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SMK Wikrama Bogor. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
