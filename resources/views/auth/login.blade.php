<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Persil Pertanahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* Background Animated */
        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(rgba(30, 60, 114, 0.5), rgba(42, 82, 152, 0.5)),
                url('/pertanahan.jpg') center / cover fixed no-repeat;
            z-index: 1;
        }

        .auth-gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(126, 34, 206, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(0, 0, 0, 0.2) 0%, transparent 100%);
            z-index: 3;
        }

        /* Animated blobs */
        .blob {
            position: absolute;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            opacity: 0.08;
            animation: blobMove 8s infinite;
            z-index: 2;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background: white;
            top: -100px;
            left: -100px;
            animation: blobMove1 20s ease-in-out infinite;
        }

        .blob-2 {
            width: 300px;
            height: 300px;
            background: #7e22ce;
            bottom: -50px;
            right: -50px;
            animation: blobMove2 24s ease-in-out infinite;
        }

        @keyframes blobMove1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(40px, -60px) scale(1.1); }
            50% { transform: translate(-30px, 30px) scale(0.9); }
            75% { transform: translate(60px, 60px) scale(1.05); }
        }

        @keyframes blobMove2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-40px, 60px) rotate(90deg); }
            50% { transform: translate(30px, -30px) rotate(180deg); }
            75% { transform: translate(-60px, -60px) rotate(270deg); }
        }

        .auth-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 40px 20px;
        }

        .auth-logo {
            width: 100%;
            padding: 20px;
            text-align: center;
            margin-bottom: auto;
            animation: fadeInDown 0.8s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-logo-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 32px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            letter-spacing: 1px;
        }

        .auth-logo-brand:hover {
            transform: scale(1.05);
            text-shadow: 0 4px 20px rgba(126, 34, 206, 0.4);
        }

        .auth-logo-brand i {
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .auth-container {
            width: 100%;
            max-width: 480px;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            animation: fadeInUp 0.8s ease 0.2s both, floatForm 8s ease-in-out infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatForm {
            0%, 100% {
                transform: translateY(0px);
                filter: drop-shadow(0 25px 50px rgba(0, 0, 0, 0.15));
            }
            25% {
                transform: translateY(-8px);
                filter: drop-shadow(0 35px 60px rgba(0, 0, 0, 0.2));
            }
            50% {
                transform: translateY(-12px);
                filter: drop-shadow(0 40px 70px rgba(0, 0, 0, 0.25));
            }
            75% {
                transform: translateY(-8px);
                filter: drop-shadow(0 35px 60px rgba(0, 0, 0, 0.2));
            }
        }

        .auth-card {
            width: 100%;
            background: linear-gradient(135deg, rgba(30, 60, 114, 0.85) 0%, rgba(59, 130, 246, 0.75) 50%, rgba(126, 34, 206, 0.8) 100%);
            backdrop-filter: blur(30px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.15) inset,
                        0 8px 32px rgba(59, 130, 246, 0.3),
                        0 0 80px rgba(126, 34, 206, 0.25);
            padding: 56px 44px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: cardGlow 8s ease-in-out infinite;
        }

        @keyframes cardGlow {
            0%, 100% {
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3),
                            0 0 0 1px rgba(255, 255, 255, 0.15) inset,
                            0 8px 32px rgba(59, 130, 246, 0.3),
                            0 0 80px rgba(126, 34, 206, 0.25);
            }
            50% {
                box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4),
                            0 0 0 1px rgba(255, 255, 255, 0.2) inset,
                            0 12px 40px rgba(59, 130, 246, 0.4),
                            0 0 100px rgba(126, 34, 206, 0.35);
            }
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .auth-title {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .auth-subtitle {
            font-size: 14px;
            color: #e0e7ff;
            margin-bottom: 36px;
            font-weight: 500;
            animation: subtleFloat 8s ease-in-out infinite;
            opacity: 0.95;
        }

        @keyframes subtleFloat {
            0%, 100% {
                opacity: 0.8;
                transform: translateY(0px);
            }
            50% {
                opacity: 1;
                transform: translateY(-4px);
            }
        }

        .form-group {
            margin-bottom: 24px;
            animation: fadeInUp 0.6s ease backwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.3s; }
        .form-group:nth-child(2) { animation-delay: 0.4s; }
        .form-group:nth-child(3) { animation-delay: 0.5s; }
        .form-group:nth-child(4) { animation-delay: 0.6s; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            user-select: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }

        .form-input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            backdrop-filter: blur(10px);
            /* iOS OPTIMIZATION: Min font 16px untuk prevent auto-zoom */
            min-height: 48px;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2),
                        0 8px 24px rgba(126, 34, 206, 0.3);
            transform: translateY(-2px);
        }

        .form-input:-autofill,
        .form-input:-autofill:hover,
        .form-input:-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 0.15) inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }

        .form-error {
            display: block;
            font-size: 12px;
            color: #fecaca;
            margin-top: 8px;
            font-weight: 600;
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* CUSTOM VALIDATION TOOLTIP */
        .validation-tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-8px);
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            color: #7f1d1d;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .validation-tooltip.show {
            opacity: 1;
            transform: translateX(-50%) translateY(-12px);
        }

        .validation-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #fecaca;
        }

        .form-input.invalid {
            border-color: #fca5a5 !important;
            background: rgba(252, 165, 165, 0.1) !important;
            box-shadow: 0 0 0 4px rgba(252, 165, 165, 0.15),
                        0 8px 24px rgba(220, 38, 38, 0.2) !important;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 2px solid #fca5a5;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 28px;
            animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error-title {
            font-size: 14px;
            font-weight: 700;
            color: #991b1b;
            margin-bottom: 10px;
        }

        .alert-error-list {
            margin: 0;
            padding-left: 20px;
        }

        .alert-error-list li {
            color: #dc2626;
            font-size: 13px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #ffffff;
            border-radius: 6px;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .checkbox-input:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .checkbox-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .forgot-password-link {
            font-size: 13px;
            color: #e0e7ff;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
            position: relative;
        }

        .forgot-password-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #e0e7ff, #ffffff);
            transition: width 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #ffffff;
        }

        .forgot-password-link:hover::after {
            width: 100%;
        }

        .submit-button {
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #7e22ce 50%, #6d28d9 100%);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.35),
                        0 0 20px rgba(126, 34, 206, 0.25);
            animation: buttonPulse 8s ease-in-out infinite;
            backdrop-filter: blur(10px);
        }

        @keyframes buttonPulse {
            0%, 100% {
                box-shadow: 0 10px 30px rgba(59, 130, 246, 0.35),
                            0 0 20px rgba(126, 34, 206, 0.25);
            }
            50% {
                box-shadow: 0 15px 40px rgba(59, 130, 246, 0.45),
                            0 0 30px rgba(126, 34, 206, 0.35);
            }
        }

        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .submit-button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #6d28d9 50%, #5b21b6 100%);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.45),
                        0 0 30px rgba(126, 34, 206, 0.35);
        }

        .submit-button:hover::before {
            left: 100%;
        }

        .submit-button:active {
            transform: translateY(-1px);
        }

        .submit-button i {
            margin-right: 8px;
            animation: slideRight 0.6s ease 0.2s backwards;
        }

        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .auth-footer {
            width: 100%;
            text-align: center;
            padding: 24px;
            color: white;
            margin-top: auto;
            animation: fadeIn 1s ease 0.4s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .auth-footer-text {
            font-size: 13px;
            margin-bottom: 8px;
            opacity: 0.95;
            font-weight: 500;
        }

        .auth-footer-content {
            font-size: 12px;
            opacity: 0.85;
            line-height: 1.6;
        }

        .auth-footer-content strong {
            opacity: 1;
            font-weight: 700;
        }

        /* Responsive */
        /* TABLET & IPAD OPTIMIZATION (768px and below) */
        @media (max-width: 768px) {
            .auth-card {
                padding: 40px 32px;
            }

            .auth-title {
                font-size: 28px;
            }

            .auth-container {
                max-width: 100%;
            }

            .blob-1 {
                width: 250px;
                height: 250px;
            }

            .blob-2 {
                width: 200px;
                height: 200px;
            }
        }

        /* MOBILE PHONE OPTIMIZATION (480px and below - iPhone, Android Phone) */
        @media (max-width: 480px) {
            .auth-wrapper {
                padding: 16px 12px;
            }

            /* CARD PADDING - Lebih besar di mobile agar form lebih mudah dibaca dan digunakan */
            .auth-card {
                padding: 36px 24px;
                border-radius: 20px;
            }

            .auth-title {
                font-size: 26px;
                margin-bottom: 12px;
            }

            .auth-subtitle {
                font-size: 13px;
                margin-bottom: 28px;
            }

            /* FORM LABEL - Diperbesar untuk keterbacaan lebih baik di layar kecil */
            .form-label {
                font-size: 13px;
                font-weight: 700;
            }

            /* FORM INPUT - Padding lebih besar untuk kemudahan tap di touchscreen Android/iOS */
            .form-input {
                padding: 14px 16px;
                font-size: 16px;
                border-radius: 10px;
                height: 48px;
            }

            /* FORM GROUP - Jarak lebih besar di mobile untuk UX lebih baik */
            .form-group {
                margin-bottom: 20px;
            }

            .checkbox-group {
                flex-direction: column;
                gap: 12px;
                margin-bottom: 20px;
            }

            /* SUBMIT BUTTON - Diperbesar agar mudah diklik di mobile */
            .submit-button {
                padding: 14px 16px;
                font-size: 15px;
                letter-spacing: 0.5px;
                height: 48px;
                border-radius: 10px;
                margin-top: 8px;
            }

            /* LOGO - Lebih kecil di mobile */
            .auth-logo-brand {
                font-size: 28px;
            }

            .blob-1, .blob-2 {
                display: none;
            }
        }

        /* ULTRA SMALL DEVICES (320px and below - Small Android phone) */
        @media (max-width: 320px) {
            .auth-card {
                padding: 28px 16px;
            }

            .auth-title {
                font-size: 22px;
            }

            .form-input {
                font-size: 15px;
                padding: 12px 14px;
            }
        }
    </style>
</head>
<body>
    <!-- ============================================
         BACKGROUND & VISUAL EFFECTS
         ============================================
         Background dengan image parallax + gradient overlay
         - auth-background: Background image dengan zoom animation
         - auth-gradient-overlay: Overlay untuk kontras text
         - blob: Animated decorative elements
         ============================================ -->
    <div class="auth-background">
        <div class="auth-gradient-overlay"></div>
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <!-- ============================================
         MAIN LOGIN CONTAINER
         Responsif design untuk:
         - Desktop: Full size form dengan animations
         - Tablet (768px): Medium size form
         - Mobile (480px): Large form untuk touchscreen
         - Small Android (320px): Extra compact mode
         ============================================ -->
    <div class="auth-wrapper">
        <!-- LOGO SECTION -->
        <!-- Ditampilkan di semua device, auto-scale sesuai screen -->
        <div class="auth-logo">
            <a href="{{ url('/') }}" class="auth-logo-brand">
                <i class="fas fa-map-location-dot"></i>
                <span>PERSIL</span>
            </a>
        </div>

        <!-- LOGIN FORM CONTAINER -->
        <!-- Responsive: max-width 480px di desktop, 100% di mobile -->
        <div class="auth-container">
            <div class="auth-card">
                <!-- FORM HEADER -->
                <h1 class="auth-title">Login</h1>
                <p class="auth-subtitle">Sistem Informasi Persil Pertanahan</p>

                <!-- ERROR MESSAGES SECTION -->
                <!-- Ditampilkan jika ada error validasi dari server -->
                @if ($errors->any())
                    <div class="alert-error">
                        <div class="alert-error-title">
                            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                            Gagal Login
                        </div>
                        <ul class="alert-error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.submit') }}" method="POST" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope" style="margin-right: 6px; color: #7e22ce;"></i>
                            Email
                        </label>
                        <div class="form-input-wrapper" style="position: relative;">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-input @error('email') border-red-500 @enderror"
                                placeholder="Masukkan email Anda"
                                required
                            >
                            <div class="validation-tooltip" id="emailTooltip"></div>
                        </div>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock" style="margin-right: 6px; color: #7e22ce;"></i>
                            Password
                        </label>
                        <div class="form-input-wrapper" style="position: relative;">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input @error('password') border-red-500 @enderror"
                                placeholder="Masukkan password"
                                required
                            >
                            <div class="validation-tooltip" id="passwordTooltip"></div>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember & Forgot Password -->
                    <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
                        <label class="checkbox-group" style="margin-bottom: 0;">
                            <input type="checkbox" class="checkbox-input" name="remember" id="remember">
                            <span class="checkbox-label">Ingat saya</span>
                        </label>
                        <a href="#" class="forgot-password-link">Lupa password?</a>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="submit-button">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="auth-footer">
            <p class="auth-footer-text">© 2025 PERSIL. Semua hak dilindungi.</p>
            <div class="auth-footer-content">
                Sistem Informasi Persil Pertanahan
            </div>
        </div>
    </div>

    <script>
        /**
         * ========================================
         * CUSTOM VALIDATION MESSAGE
         * ========================================
         * Custom tooltip untuk mengganti default browser validation
         * Dengan styling yang match dengan form design
         *
         * Validation hanya muncul saat user klik tombol LOGIN
         * Tidak akan muncul saat user blur atau sedang mengetik
         */
        function setupCustomValidation() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailTooltip = document.getElementById('emailTooltip');
            const passwordTooltip = document.getElementById('passwordTooltip');
            const form = document.querySelector('form');

            console.log('Validation setup started'); // Debug log
            console.log('Email input:', emailInput);
            console.log('Password input:', passwordInput);
            console.log('Form:', form);

            // Prevent default browser validation
            emailInput.addEventListener('invalid', function(e) {
                e.preventDefault();
                console.log('Email invalid event prevented');
            });
            passwordInput.addEventListener('invalid', function(e) {
                e.preventDefault();
                console.log('Password invalid event prevented');
            });

            // Clear error saat user mulai mengetik
            emailInput.addEventListener('input', function() {
                hideValidationError(this, emailTooltip);
            });

            passwordInput.addEventListener('input', function() {
                hideValidationError(this, passwordTooltip);
            });

            // Submit button validation - HANYA SAAT KLIK LOGIN
            form.addEventListener('submit', function(e) {
                console.log('Form submit triggered'); // Debug log

                let isValid = true;
                let hasEmailError = false;
                let hasPasswordError = false;

                // Validasi email
                console.log('Email value:', emailInput.value); // Debug
                if (!emailInput.value || emailInput.value.trim() === '') {
                    console.log('Email is empty - showing error'); // Debug
                    e.preventDefault();
                    showValidationError(emailInput, emailTooltip, 'Email tidak boleh kosong');
                    hasEmailError = true;
                    isValid = false;
                } else if (!emailInput.validity.valid) {
                    console.log('Email format invalid'); // Debug
                    e.preventDefault();
                    showValidationError(emailInput, emailTooltip, 'Format email tidak valid');
                    hasEmailError = true;
                    isValid = false;
                } else {
                    console.log('Email valid'); // Debug
                    hideValidationError(emailInput, emailTooltip);
                }

                // Validasi password
                console.log('Password value:', passwordInput.value); // Debug
                if (!passwordInput.value || passwordInput.value.trim() === '') {
                    console.log('Password is empty - showing error'); // Debug
                    e.preventDefault();
                    showValidationError(passwordInput, passwordTooltip, 'Password tidak boleh kosong');
                    hasPasswordError = true;
                    isValid = false;
                } else {
                    console.log('Password valid'); // Debug
                    hideValidationError(passwordInput, passwordTooltip);
                }

                console.log('Is valid:', isValid); // Debug
                console.log('Has email error:', hasEmailError); // Debug
                console.log('Has password error:', hasPasswordError); // Debug

                // Focus ke field pertama yang error
                if (!isValid) {
                    if (hasEmailError) {
                        emailInput.focus();
                    } else if (hasPasswordError) {
                        passwordInput.focus();
                    }
                }
            });
        }

        function showValidationError(inputElement, tooltipElement, message) {
            console.log('Showing error:', message); // Debug
            inputElement.classList.add('invalid');
            tooltipElement.textContent = message;
            tooltipElement.classList.add('show');
        }

        function hideValidationError(inputElement, tooltipElement) {
            console.log('Hiding error'); // Debug

        // FUNCTION 1: DETECT DEVICE TYPE
        // Fungsi untuk mendeteksi jenis device (Android, iOS, atau Desktop)
        function detectDevice() {
            const ua = navigator.userAgent.toLowerCase();
            const isAndroid = /android/.test(ua);
            const isIOS = /iphone|ipad|ipod/.test(ua);
            const isMobile = isAndroid || isIOS;

            return {
                isAndroid: isAndroid,  // True jika device Android
                isIOS: isIOS,          // True jika device iOS/iPhone/iPad
                isMobile: isMobile     // True jika device mobile (baik Android maupun iOS)
            };
        }

        // Simpan hasil deteksi device
        const device = detectDevice();

        // FUNCTION 2: SMOOTH SCROLL BEHAVIOR
        // Untuk memberikan pengalaman scroll yang smooth di semua device
        document.documentElement.style.scrollBehavior = 'smooth';

        // FUNCTION 3: FORM INPUT FOCUS ANIMATION
        // Fungsi untuk menambah animasi scale saat input field mendapat focus
        // Ini membantu user tahu field mana yang sedang aktif, terutama di mobile
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            // ANDROID OPTIMIZATION: Disable scale animation di Android untuk performa lebih baik
            if (!device.isAndroid) {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            }

            // iOS OPTIMIZATION: Prevent zoom on double-tap di iOS
            if (device.isIOS) {
                input.style.fontSize = '16px'; // Font min 16px untuk prevent auto zoom di iOS
            }
        });

        // FUNCTION 4: SUBMIT BUTTON RIPPLE EFFECT
        // Fungsi untuk membuat ripple effect saat tombol login diklik
        // Ini memberikan feedback visual yang bagus untuk user experience
        const submitBtn = document.querySelector('.submit-button');
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                // ANDROID OPTIMIZATION: Ripple effect di Android
                if (device.isAndroid) {
                    // Buat ripple element
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                }

                // iOS OPTIMIZATION: Hapus event jika iOS untuk performa lebih baik
                // iOS sudah punya built-in touch feedback
            });
        }

        // FUNCTION 5: PREVENT AUTO-ZOOM ON INPUT DI iOS
        // iOS akan auto-zoom jika font size kurang dari 16px
        // Solusi: Set font-size input ke 16px (sudah di CSS, tapi ini untuk double check)
        if (device.isIOS) {
            inputs.forEach(input => {
                input.style.fontSize = '16px';
            });
        }

        // FUNCTION 6: OPTIMIZE FOR TOUCH DEVICES
        // Tambahkan class 'touch-device' jika device support touch
        // Ini bisa digunakan untuk styling tambahan di CSS jika diperlukan
        if (('ontouchstart' in window) || (navigator.maxTouchPoints > 0)) {
            document.body.classList.add('touch-device');
        }

        // FUNCTION 7: VIEWPORT HEIGHT FIX UNTUK MOBILE
        // Fix issue saat keyboard muncul di mobile (terutama Android)
        // Atur min-height menjadi 100vh actual (bukan 100% yang berubah saat keyboard aktif)
        function setViewportHeight() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', vh + 'px');
            document.querySelector('.auth-wrapper').style.minHeight = 'calc(var(--vh, 1vh) * 100)';
        }

        // Jalankan saat page load
        setViewportHeight();

        // Jalankan ulang saat window di-resize (terutama saat keyboard muncul/hilang)
        window.addEventListener('resize', setViewportHeight);

        // Setup custom validation
        setupCustomValidation();

        // FUNCTION 8: DISABLE ANIMATIONS DI ANDROID UNTUK PERFORMA
        // Jika device performance rendah, disable beberapa animations
        if (device.isAndroid) {
            // Kurangi jumlah animasi yang berjalan bersamaan
            const style = document.createElement('style');
            style.textContent = `
                @media (max-width: 480px) {
                    .auth-card {
                        animation: none;
                    }
                    .auth-logo-brand i {
                        animation: none;
                    }
                    .form-group {
                        animation: none;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // CONSOLE LOG UNTUK DEBUGGING
        console.log('Device Detection:', {
            isAndroid: device.isAndroid,
            isIOS: device.isIOS,
            isMobile: device.isMobile,
            userAgent: navigator.userAgent
        });
    </script>
</body>
</html>
