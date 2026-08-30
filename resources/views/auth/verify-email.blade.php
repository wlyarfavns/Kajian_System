<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verifikasi Email - KajianKu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500;1,9..144,600&family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root{
            --parchment:#F4EEDC;
            --parchment-deep:#E9DFC2;
            --paper:#FBF7EC;
            --ink:#152A20;
            --ink-soft:#4B5D52;
            --jade-950:#0A2B20;
            --jade-900:#0C3B2A;
            --jade-800:#0F5137;
            --gold:#B8863B;
            --gold-soft:#E7C77E;
            --gold-pale:#F3E3B8;
            --line:rgba(21,42,32,.14);
        }
        *{box-sizing:border-box}
        html, body{
            margin:0;
            padding:0;
            width:100%;
            height:100%;
            overflow:hidden;
        }
        body{
            font-family:"Plus Jakarta Sans",ui-sans-serif,system-ui,sans-serif;
            color:var(--ink);
            background:var(--jade-950);
            line-height:1.6;
            -webkit-font-smoothing:antialiased;
        }
        a{color:inherit;text-decoration:none}
        .container{max-width:1180px;margin:0 auto;padding:0 28px}
        
        .btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:14px 26px;
            border-radius:999px;
            font-weight:700;
            font-size:14px;
            border:1px solid transparent;
            cursor:pointer;
            transition:transform .25s ease, box-shadow .25s ease, background .25s ease;
        }
        .btn:hover{transform:translateY(-2px)}
        .btn-solid{
            background:var(--jade-900);
            color:var(--parchment);
            box-shadow:0 14px 30px rgba(10,43,32,.28);
        }
        .btn-solid:hover{background:var(--jade-800)}
        .btn-outline{
            border-color:var(--gold);
            color:var(--ink);
            background:transparent;
        }
        .btn-outline:hover{background:var(--gold-pale)}

        .hero{
            position:relative;
            background:
                radial-gradient(ellipse 900px 500px at 82% -10%, rgba(184,134,59,.20), transparent 60%),
                linear-gradient(180deg,var(--jade-950) 0%, var(--jade-900) 55%, var(--jade-800) 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .hero-lattice{
            position:absolute;inset:0;
            opacity:.16;
            pointer-events:none;
            width: 100%;
            height: 100%;
        }
        .hero-grid{
            position:relative;
            display:grid;
            grid-template-columns: 1fr;
            max-width: 520px;
            margin: 0 auto;
            gap:20px;
            align-items:center;
            width: 100%;
        }
        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<header class="hero">
  <svg class="hero-lattice" viewBox="0 0 1180 700" preserveAspectRatio="xMidYMid slice">
    <defs>
      <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
        <g stroke="#E7C77E" stroke-width="1" fill="none">
          <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#star8)"/>
  </svg>

  <div class="container hero-grid">
    <!-- Bagian Form Verify Email -->
    <div style="background: var(--parchment); border-radius: 32px; padding: 36px 48px; box-shadow: 0 40px 80px rgba(6,26,19,0.4); position: relative; z-index: 10; border: 1px solid rgba(231,199,126,0.3); max-height: 90vh; overflow-y: auto;">
        
        <div style="margin-bottom: 24px; text-align: center;">
            <div style="font-family:'Amiri',serif; font-size:24px; color:var(--gold); margin-bottom: 8px; font-weight:700;">
                بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ
            </div>
            <div style="margin-bottom:12px;">
                <h1 style="font-family:'Fraunces',serif; font-size:32px; font-weight:700; margin:0; color:var(--jade-950);">Kajian<em style="color:var(--gold); font-style:normal;">Ku</em></h1>
            </div>
            
            <p style="color:var(--jade-950); font-size:16px; font-weight:700; margin:0 0 12px;">Verifikasi Email</p>
            <p style="color:var(--ink-soft); font-size:13px; margin:0;">
                Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami dapat mengirimkan ulang.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div style="margin-bottom:30px; font-weight:600; font-size:14px; color:var(--jade-700); background:rgba(22, 107, 72, 0.1); padding:16px 20px; border-radius:12px; border:1px solid rgba(22,107,72,0.2);">
                Tautan verifikasi baru telah dikirim ke alamat email Anda.
            </div>
        @endif

        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:20px; flex-wrap:wrap; gap:20px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-solid" style="padding:14px 24px; font-size:14px; border-radius:14px;">
                    Kirim Ulang Tautan
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="padding:14px 24px; font-size:14px; border-radius:14px; border-color:var(--line); background:var(--paper);">
                    Keluar Akun
                </button>
            </form>
        </div>

    </div>



  </div>
</header>

</body>
</html>
