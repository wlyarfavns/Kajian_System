<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="darkreader-lock">

    <title>Verifikasi OTP - KajianKu</title>

    <meta name="view-transition" content="same-origin" />
    <meta name="layout" content="landing" data-turbo-track="reload">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500;1,9..144,600&family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
    <style>
        :root {
            --parchment: #F4EEDC;
            --parchment-deep: #E9DFC2;
            --paper: #FBF7EC;
            --ink: #152A20;
            --ink-soft: #4B5D52;
            --jade-950: #0A2B20;
            --jade-900: #0C3B2A;
            --jade-800: #0F5137;
            --gold: #B8863B;
            --gold-soft: #E7C77E;
            --line: rgba(21,42,32,0.14);
        }
        * { box-sizing: border-box; }
        body.auth-body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--ink);
            background: var(--jade-950);
            line-height: 1.6;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        
        .auth-hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
            background: radial-gradient(900px 500px at 82% -10%, rgba(184,134,59,0.20), transparent 60%), linear-gradient(180deg, #0A2B20 0%, #0C3B2A 55%, #0F5137 100%);
        }
        .auth-hero-lattice {
            position: absolute;
            inset: 0;
            opacity: 0.16;
            pointer-events: none;
            width: 100%;
            height: 100%;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: var(--parchment);
            border-radius: 32px;
            padding: 36px 48px;
            box-shadow: 0 40px 80px rgba(6,26,19,0.4);
            position: relative;
            z-index: 10;
            border: 1px solid rgba(231,199,126,0.3);
            max-height: 90vh;
            overflow-y: auto;
            width: 100%;
        }

        .otp-input-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin: 16px 0;
        }

        .otp-input {
            width: 48px;
            height: 56px;
            border-radius: 12px;
            border: 2px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            outline: none;
            transition: all 0.2s;
            padding: 0;
        }

        .otp-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(184,134,59, 0.15);
            background: #fff;
        }

        .auth-btn-solid {
            background: var(--jade-900);
            color: var(--parchment);
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 14px 30px rgba(10,43,32,0.28);
        }
        .auth-btn-solid:hover { background: var(--jade-800); transform: translateY(-2px); }

    </style>
</head>
<body class="auth-body">

<header class="auth-hero">
  <svg class="auth-hero-lattice" viewBox="0 0 1180 700" preserveAspectRatio="xMidYMid slice">
    <defs>
      <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
        <g stroke="#E7C77E" stroke-width="1" fill="none">
          <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#star8)"/>
  </svg>

  <div class="auth-wrapper">
    <div class="auth-card">
            
            <div style="text-align: left; margin-bottom: 16px;">
                <a href="{{ route('password.request') }}" style="display:inline-flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--jade-900); text-transform:uppercase; letter-spacing:1px; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Batal
                </a>
            </div>

            <div style="margin-bottom: 28px; text-align: center;">
                <div style="margin-bottom:8px;">
                    <h1 style="font-family:'Fraunces',serif; font-size:32px; font-weight:700; margin:0; color:var(--jade-950);">Verifikasi <em style="color:var(--gold); font-style:normal;">Kode</em></h1>
                </div>
                <p style="color:var(--ink-soft); font-size:14px; margin:0;">
                    Kami telah mengirimkan 6 digit kode OTP ke email<br>
                    <strong>{{ $email ?? 'email Anda' }}</strong>
                </p>
            </div>

            <form method="POST" action="{{ route('password.verify-otp.store') }}" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                @php
                    $oldOtp = old('otp', '');
                @endphp

                <div>
                    <div class="otp-input-container">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" autocomplete="off" autofocus value="{{ substr($oldOtp, 0, 1) }}">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" autocomplete="off" value="{{ substr($oldOtp, 1, 1) }}">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" autocomplete="off" value="{{ substr($oldOtp, 2, 1) }}">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" autocomplete="off" value="{{ substr($oldOtp, 3, 1) }}">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" autocomplete="off" value="{{ substr($oldOtp, 4, 1) }}">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" autocomplete="off" value="{{ substr($oldOtp, 5, 1) }}">
                    </div>
                    <!-- Hidden real input -->
                    <input type="hidden" name="otp" id="real-otp" value="{{ $oldOtp }}" required>
                    
                    <x-input-error :messages="$errors->get('otp')" style="margin-top:6px; color:#dc2626; font-size:12px; text-align:center;" />
                </div>

                <button type="submit" class="auth-btn-solid" style="margin-top: 12px;">Verifikasi & Ganti Sandi</button>
            </form>

        </div>
    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputs = document.querySelectorAll('.otp-input');
    const realInput = document.getElementById('real-otp');
    const form = document.querySelector('form');

    inputs.forEach((input, index) => {
        // Filter non-numbers on input
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            updateRealInput();
        });

        // Handle navigation on keyup
        input.addEventListener('keyup', function(e) {
            // Move forward if a number was typed
            if (this.value.length === 1 && e.key >= '0' && e.key <= '9') {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value.length === 0) {
                if (index > 0) {
                    inputs[index - 1].focus();
                }
            }
        });

        // Paste support
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            if (pastedData) {
                for(let i=0; i<pastedData.length; i++) {
                    if(inputs[i]) {
                        inputs[i].value = pastedData[i];
                    }
                }
                if(inputs[pastedData.length]) {
                    inputs[pastedData.length].focus();
                } else {
                    inputs[5].focus();
                }
                updateRealInput();
            }
        });
    });

    function updateRealInput() {
        let otp = '';
        inputs.forEach(input => {
            otp += input.value;
        });
        realInput.value = otp;
    }

    form.addEventListener('submit', function() {
        updateRealInput();
    });
});
</script>

</body>
</html>
