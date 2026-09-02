<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Anda</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F4EEDC; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <div style="background-color: #0A2B20; padding: 30px; text-align: center;">
            <h1 style="color: #F4EEDC; margin: 0; font-size: 28px;">Kajian<span style="color: #B8863B;">Ku</span></h1>
        </div>
        <div style="padding: 40px 30px; text-align: center;">
            <h2 style="color: #152A20; font-size: 24px; margin-top: 0;">Permintaan Reset Kata Sandi</h2>
            <p style="color: #4B5D52; font-size: 16px; line-height: 1.5; margin-bottom: 30px;">
                Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda. 
                Gunakan kode OTP berikut untuk melanjutkan proses pengaturan ulang kata sandi:
            </p>
            
            <div style="background-color: #FBF7EC; border: 2px dashed #E7C77E; border-radius: 8px; padding: 20px; display: inline-block; margin-bottom: 30px;">
                <span style="font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #0F5137;">{{ $otp }}</span>
            </div>

            <p style="color: #4B5D52; font-size: 14px; line-height: 1.5; margin-bottom: 0;">
                Kode ini akan kedaluwarsa dalam waktu 15 menit.<br>
                Jika Anda tidak meminta reset kata sandi, abaikan email ini.
            </p>
        </div>
        <div style="background-color: #F9F9F9; padding: 20px; text-align: center; border-top: 1px solid #EEEEEE;">
            <p style="color: #999999; font-size: 12px; margin: 0;">
                &copy; {{ date('Y') }} KajianKu. Hak Cipta Dilindungi.
            </p>
        </div>
    </div>
</body>
</html>
