<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Reset Kata Sandi Anda - KajianKu</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #0A2B20;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .card {
            background-color: #FBF7EC;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
            border: 1px solid #E9DFC2;
        }
        .logo {
            font-size: 32px;
            font-weight: 700;
            color: #0A2B20;
            margin-bottom: 24px;
            text-decoration: none;
        }
        .logo span {
            color: #B8863B;
        }
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #0A2B20;
            margin-bottom: 16px;
        }
        .text {
            font-size: 15px;
            color: #4B5D52;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .btn {
            display: inline-block;
            background-color: #0C3B2A;
            color: #F4EEDC !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(10,43,32,0.2);
        }
        .footer {
            font-size: 13px;
            color: #8c9b93;
            margin-top: 32px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">Kajian<span>Ku</span></div>
            
            <div class="title">Reset Kata Sandi Anda</div>
            
            <div class="text">
                Halo!<br><br>
                Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun KajianKu Anda. Silakan klik tombol di bawah ini untuk membuat kata sandi baru.
            </div>
            
            <a href="{{ $url }}" class="btn">Reset Kata Sandi</a>
            
            <div class="text" style="font-size: 13px; margin-bottom: 0;">
                Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit.<br>
                Jika Anda tidak meminta reset kata sandi, abaikan saja email ini.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} KajianKu. Hak cipta dilindungi undang-undang.
        </div>
    </div>
</body>
</html>
