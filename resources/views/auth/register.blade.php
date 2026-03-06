<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — Workshop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(ellipse at 0% 100%, #2a0e5a 0%, #0c1340 35%, #06082a 70%);
            overflow: hidden;
            position: relative;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
        }
        .blob-1 { width: 400px; height: 400px; background: rgba(80, 40, 160, 0.5); top: -80px; left: -80px; }
        .blob-2 { width: 350px; height: 350px; background: rgba(50, 20, 130, 0.45); bottom: -80px; right: -80px; }

        .wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 360px;
            padding: 0 20px;
        }

        /* Main glass card */
        .glass-card {
            background: rgba(255,255,255,0.035);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 32px;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            padding: 44px 36px 36px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.45);
        }

        /* Avatar */
        .avatar {
            width: 96px; height: 96px;
            background: transparent;
            border-radius: 50%;
            margin: 0 auto 32px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            box-shadow: none;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }

        /* Error */
        .error-msg {
            color: #ff9191;
            text-align: center;
            font-size: 13px;
            margin-bottom: 16px;
        }

        /* Input rows */
        .input-row {
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.38);
            padding-bottom: 8px;
            margin-bottom: 28px;
        }
        .input-row svg { width: 20px; height: 20px; color: rgba(255,255,255,0.75); flex-shrink: 0; margin-right: 12px; }
        .input-row input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }
        .input-row input::placeholder { color: rgba(255,255,255,0.7); }
        .input-row input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
            -webkit-text-fill-color: white !important;
        }

        /* Actions row */
        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 32px;
        }
        .btn-login {
            background: rgba(240,240,245,0.92);
            color: #111;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 10px 32px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(0,0,0,0.25);
            transition: transform 0.15s, background 0.15s;
        }
        .btn-login:hover { background: #fff; transform: translateY(-2px); }
        .forgot-link {
            color: rgba(255,255,255,0.75);
            font-style: italic;
            font-size: 13.5px;
            text-decoration: none;
            transition: color 0.15s;
        }
        .forgot-link:hover { color: #fff; }

        /* Login link box */
        .bottom-box {
            background: rgba(255,255,255,0.035);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 20px;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            padding: 18px 24px;
            margin-top: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background 0.2s;
        }
        .bottom-box:hover { background: rgba(255,255,255,0.07); }
        .bottom-box span {
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #fff;
        }
        .dots {
            position: absolute;
            right: -6px;
            bottom: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .dot-sm { width: 13px; height: 13px; border-radius: 50%; background: rgba(245,245,250,0.9); }
        .dot-lg { width: 18px; height: 18px; border-radius: 50%; background: rgba(245,245,250,0.9); }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="wrapper">

        <!-- ===== MAIN REGISTER CARD ===== -->
        <div class="glass-card">

            <!-- Avatar -->
            <div class="avatar">
                <img src="{{ asset('images/default-avatar.png') }}" alt="User Avatar">
            </div>

            @if ($errors->any())
                <p class="error-msg">Please check your inputs.</p>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="input-row">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus autocomplete="name">
                </div>

                <!-- Email -->
                <div class="input-row">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email ID" required autocomplete="username">
                </div>

                <!-- Password -->
                <div class="input-row">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input id="password" type="password" name="password" placeholder="Password" required autocomplete="new-password">
                </div>

                <!-- Confirm Password -->
                <div class="input-row">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                </div>

                <!-- Register -->
                <div class="actions">
                    <button type="submit" class="btn-login">REGISTER</button>
                    <a href="{{ route('login') }}" class="forgot-link">Already registered?</a>
                </div>
            </form>
        </div>

        <!-- ===== LOGIN BOX ===== -->
        <div class="bottom-box" onclick="window.location='{{ route('login') }}'">
            <span>LOGIN</span>
            <div class="dots">
                <div class="dot-sm"></div>
                <div class="dot-lg"></div>
            </div>
        </div>

    </div>
</body>
</html>
