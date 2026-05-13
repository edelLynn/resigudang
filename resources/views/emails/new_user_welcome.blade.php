<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { 
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            background-color: #f4f7f6; 
            margin: 0; 
            padding: 20px; 
            line-height: 1.6; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background-color: #ffffff; 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        }
        .header { 
            background-color: #10221f; 
            padding: 30px 20px; 
            text-align: center; 
            border-bottom: 4px solid #13ec37; 
        }
        .header h1 { 
            color: #ffffff; 
            margin: 0; 
            font-size: 26px; 
            letter-spacing: 1px; 
        }
        .header span { 
            color: #13ec37; 
        }
        .content { 
            padding: 40px 30px; 
            color: #333333; 
        }
        .content p { 
            margin-bottom: 15px; 
            font-size: 15px; 
            color: #4b5563;
        }
        .info-box { 
            background-color: #f0fdf4; 
            border: 1px solid #13ec37; 
            border-left: 5px solid #13ec37;
            padding: 20px; 
            border-radius: 8px; 
            margin: 25px 0; 
        }
        .info-box p { 
            margin: 8px 0; 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 16px; 
            color: #10221f; 
        }
        .btn-login { 
            display: inline-block; 
            padding: 14px 30px; 
            background-color: #13ec37; 
            color: #10221f !important; 
            text-decoration: none; 
            font-weight: bold; 
            border-radius: 8px; 
            margin-top: 15px; 
            font-size: 15px;
        }
        .footer { 
            background-color: #f9fafb; 
            padding: 25px 20px; 
            text-align: center; 
            font-size: 12px; 
            color: #9ca3af; 
            border-top: 1px solid #f3f4f6; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Resi<span>Gudang</span></h1>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Selamat bergabung! Akun Anda sebagai <strong>{{ strtoupper(str_replace('_', ' ', $user->role)) }}</strong> telah berhasil didaftarkan oleh Super Admin Pusat ke dalam sistem.</p>
            
            <p>Berikut adalah informasi rahasia yang telah didaftarkan untuk masuk ke akun Anda:</p>
            
            <div class="info-box">
                <p><strong>Email Login :</strong> {{ $user->email }}</p>
                <p><strong>Password    :</strong> {{ $password }}</p>
            </div>

            <p><em>*Sangat penting: Demi keamanan data Anda, kami menyarankan untuk segera masuk ke sistem dan mengubah password ini secara berkala. Pastikan tidak memberikan informasi ini kepada siapapun.</em></p>
            
            <div style="text-align: center; margin-top: 35px;">
                <a href="{{ $activationUrl }}" class="btn-login">Verifikasi & Aktifkan Akun</a>
            </div>
            <p style="text-align: center; margin-top: 15px; font-size: 12px; color: #ef4444;">
                <em>*Akun Anda tidak dapat digunakan sebelum menekan tombol di atas.</em>
            </p>
            
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem IT PT. ResiGudang.<br>Mohon untuk tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} PT. ResiGudang. All rights reserved.</p>
        </div>
    </div>
</body>
</html>