<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medicali — Register</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0faf6;
        }

        .left-panel {
            width: 55%;
            background: linear-gradient(145deg, #085041 0%, #0F6E56 40%, #1D9E75 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -100px;
            right: -100px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px;
            left: -80px;
        }

        .left-logo {
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .left-logo img {
            width: 120px;
            height: auto;
            filter: brightness(0) invert(1);
        }

        .left-tagline {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .left-tagline h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.3;
            margin-bottom: 16px;
        }

        .left-tagline p {
            font-size: 1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.7;
            max-width: 360px;
        }

        .features {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 380px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 18px;
        }

        .feature-text {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
        }

        .right-panel {
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 50px;
            background: #ffffff;
            overflow-y: auto;
        }

        .register-box {
            width: 100%;
            max-width: 380px;
        }

        .register-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #085041;
            margin-bottom: 6px;
        }

        .register-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 36px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #111827;
            background: #f9fafb;
            transition: all 0.2s;
            outline: none;
            font-family: 'Figtree', sans-serif;
        }

        .form-input:focus {
            border-color: #1D9E75;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-input {
            padding-right: 46px;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .toggle-password:hover { color: #1D9E75; }

        .btn-register {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1D9E75, #085041);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            font-family: 'Figtree', sans-serif;
            letter-spacing: 0.3px;
        }

        .btn-register:hover { opacity: 0.92; transform: translateY(-1px); }
        .btn-register:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }

        .divider hr {
            flex: 1;
            border: none;
            border-top: 1px solid #e5e7eb;
        }

        .divider span { font-size: 0.75rem; color: #9ca3af; }

        .login-link {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .login-link a {
            color: #1D9E75;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover { color: #085041; }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .error-box p {
            font-size: 0.8rem;
            color: #b91c1c;
        }

        .field-error {
            font-size: 0.78rem;
            color: #b91c1c;
            margin-top: 5px;
        }

        .bottom-brand {
            margin-top: 40px;
            text-align: center;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 40px 24px; }
        }
    </style>
</head>
<body>

    {{-- Left Panel --}}
    <div class="left-panel">
        <div class="left-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Medicali">
        </div>

        <div class="left-tagline">
            <h1>Join Medicali Today</h1>
            <p>Set up your pharmacy account and start managing your operations smarter from day one.</p>
        </div>

        <div class="features">
            <div class="feature-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                <span class="feature-text">Real-time inventory tracking with expiry alerts</span>
            </div>
            <div class="feature-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="feature-text">Fast-track checkout with automatic discounts</span>
            </div>
            <div class="feature-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                <span class="feature-text">Sales reports and revenue dashboard</span>
            </div>
            <div class="feature-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span class="feature-text">Role-based access for your entire team</span>
            </div>
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="right-panel">
        <div class="register-box">

            <h2 class="register-title">Create account</h2>
            <p class="register-subtitle">Sign up for your Medicali account</p>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input id="name" type="text" name="name"
                           class="form-input" value="{{ old('name') }}"
                           required autofocus autocomplete="name"
                           placeholder="Juan dela Cruz">
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" type="email" name="email"
                           class="form-input" value="{{ old('email') }}"
                           required autocomplete="username"
                           placeholder="yourname@email.com">
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="password-wrapper">
                        <input id="password" type="password" name="password"
                               class="form-input" required
                               autocomplete="new-password"
                               placeholder="••••••••">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', 'eye-icon-1', 'eye-off-icon-1')">
                            <svg id="eye-icon-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye-off-icon-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="password-wrapper">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-input" required
                               autocomplete="new-password"
                               placeholder="••••••••">
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'eye-icon-2', 'eye-off-icon-2')">
                            <svg id="eye-icon-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye-off-icon-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-register">Create Account</button>

                <div class="divider">
                    <hr><span>or</span><hr>
                </div>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>

            </form>

            <div class="bottom-brand">
                © {{ date('Y') }} Medicali — Pharmacy Management System
            </div>

        </div>
    </div>

<script>
    function togglePassword(inputId, eyeId, eyeOffId) {
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById(eyeId);
        const eyeOffIcon = document.getElementById(eyeOffId);

        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.style.display = 'none';
            eyeOffIcon.style.display = 'block';
        } else {
            input.type = 'password';
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
        }
    }
</script>

</body>
</html>