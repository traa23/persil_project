<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Persil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Poppins:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.12.6/build/spline-viewer.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #1565C0 0%, #283593 50%, #0D47A1 100%);
        }

        /* Spline Background - Full Coverage */
        .spline-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .spline-background spline-viewer {
            width: 100%;
            height: 100%;
        }

        /* Gradient Overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(21, 101, 192, 0.3) 0%, rgba(13, 71, 161, 0.6) 100%);
            pointer-events: none;
            z-index: 2;
        }

        /* Main Container */
        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            height: 100vh;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 24px;
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            padding: 48px 38px;
            animation: slideUp 0.6s ease-out;
            margin-right: 40px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .login-header {
            margin-bottom: 36px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 40px;
            font-weight: 800;
            color: white;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }

        .login-header h1 i {
            color: #FFD54F;
            text-shadow: 0 4px 12px rgba(255, 213, 79, 0.4);
        }

        .login-header p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-left: 4px solid #FFD54F;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 28px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .info-box i {
            font-size: 16px;
            color: #FFD54F;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .info-text strong {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .info-text div {
            margin: 2px 0;
            opacity: 0.9;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group:first-of-type {
            margin-top: 0;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 10px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label i {
            color: #FFD54F;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            outline: none;
            border-color: #FFD54F;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 6px rgba(255, 213, 79, 0.15);
            transform: translateY(-2px);
        }

        /* Alert */
        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            font-weight: 500;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.15);
            border: 1px solid rgba(244, 67, 54, 0.4);
            color: #FFCDD2;
        }

        .alert-error i {
            color: #FF8A80;
            font-size: 18px;
        }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #FFD54F 0%, #FFC107 100%);
            color: #1565C0;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 20px rgba(255, 213, 79, 0.3);
            position: relative;
            overflow: hidden;
            margin-top: 12px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.4s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(255, 213, 79, 0.4);
        }

        .btn-login:active:not(:disabled) {
            transform: translateY(-1px);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-login i {
            font-size: 16px;
            position: relative;
            z-index: 1;
        }

        /* Footer */
        .login-footer {
            margin-top: 32px;
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-footer p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            margin: 0;
        }

        /* Error Input */
        .form-control.is-invalid {
            border-color: #FF8A80;
            background: rgba(244, 67, 54, 0.1);
        }

        .invalid-feedback {
            color: #FFCDD2;
            font-size: 11px;
            margin-top: 6px;
            display: block;
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .login-wrapper {
                justify-content: center;
            }

            .login-container {
                max-width: 100%;
                padding: 42px 32px;
                margin-right: 0;
            }

            .login-header h1 {
                font-size: 36px;
            }

            .login-header p {
                font-size: 13px;
            }

            .form-control {
                padding: 13px 15px;
                font-size: 16px;
                border-radius: 11px;
            }

            .btn-login {
                padding: 15px 22px;
                font-size: 13px;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .login-wrapper {
                padding: 16px;
                height: auto;
                min-height: 100vh;
                justify-content: center;
            }

            .login-container {
                padding: 36px 24px;
                max-width: 100%;
                width: 100%;
                margin-right: 0;
            }

            .login-header {
                margin-bottom: 30px;
            }

            .login-header h1 {
                font-size: 28px;
                gap: 10px;
            }

            .login-header p {
                font-size: 12px;
                line-height: 1.4;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-label {
                font-size: 12px;
                gap: 6px;
            }

            .form-label i {
                font-size: 14px;
            }

            .form-control {
                padding: 12px 14px;
                font-size: 16px;
                border-radius: 10px;
                border-width: 2px;
            }

            .btn-login {
                padding: 14px 18px;
                font-size: 12px;
                gap: 8px;
                margin-top: 10px;
                border-radius: 11px;
            }

            .btn-login i {
                font-size: 14px;
            }

            .login-footer {
                margin-top: 24px;
                padding-top: 16px;
            }

            .login-footer p {
                font-size: 11px;
                line-height: 1.3;
            }

            .invalid-feedback {
                font-size: 10px;
                margin-top: 5px;
            }
        }

        /* Small Phones (Extra Small) */
        @media (max-width: 360px) {
            .login-container {
                padding: 24px 16px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .login-header p {
                font-size: 11px;
            }

            .form-control {
                padding: 11px 12px;
                font-size: 15px;
            }

            .btn-login {
                padding: 12px 16px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <!-- Spline Background -->
    <div class="spline-background">
        <spline-viewer url="https://prod.spline.design/dAELVACqCsJoyBPs/scene.splinecode"></spline-viewer>
    </div>

    <!-- Login Wrapper -->
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Header -->
            <div class="login-header">
                <h1><i class="fas fa-map-location-dot"></i> Persil</h1>
                <p>Sistem Informasi Pengelolaan Data Persil Pertanahan</p>
            </div>

            <!-- Error Alert -->
            <div id="errorAlert"></div>

            <!-- Login Form -->
            <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan email Anda"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password Anda"
                        required
                    >
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                </button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <p>© 2024 Sistem Informasi Persil. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        let splineViewer = null;
        let splineReady = false;

        // Initialize Spline and setup interactions
        document.addEventListener('DOMContentLoaded', function() {
            const splineElement = document.querySelector('spline-viewer');

            if (splineElement) {
                // Wait for Spline to load
                splineElement.addEventListener('load', function() {
                    splineViewer = splineElement;
                    splineReady = true;
                    setupFormSynchronization();
                    console.log('✓ Spline loaded successfully');
                });

                // Fallback - try to initialize after a delay
                setTimeout(function() {
                    if (!splineReady && splineElement) {
                        splineViewer = splineElement;
                        splineReady = true;
                        setupFormSynchronization();
                        console.log('✓ Spline initialized (fallback)');
                    }
                }, 2000);
            }
        });

        function setupFormSynchronization() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const loginBtn = document.querySelector('.btn-login');
            const form = document.getElementById('loginForm');

            // Email focus - trigger animation
            emailInput.addEventListener('focus', function() {
                triggerSplineEvent('emailFocus');
                emailInput.style.transition = 'all 0.3s ease';
            });

            emailInput.addEventListener('blur', function() {
                triggerSplineEvent('emailBlur');
            });

            // Password focus - different trigger
            passwordInput.addEventListener('focus', function() {
                triggerSplineEvent('passwordFocus');
            });

            passwordInput.addEventListener('blur', function() {
                triggerSplineEvent('passwordBlur');
            });

            // Button hover effects
            loginBtn.addEventListener('mouseenter', function() {
                triggerSplineEvent('buttonHover');
            });

            loginBtn.addEventListener('mouseleave', function() {
                triggerSplineEvent('buttonLeave');
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                triggerSplineEvent('formSubmit');
                loginBtn.disabled = true;
                loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                // Simulate delay
                setTimeout(function() {
                    // Form will submit normally
                }, 1500);
            });
        }

        function triggerSplineEvent(eventName) {
            if (!splineReady || !splineViewer) return;

            // Try to emit events to Spline objects
            // You may need to adjust these names based on your Spline scene objects
            const events = {
                'emailFocus': { name: 'mouseDown', object: 'robot' },
                'passwordFocus': { name: 'mouseDown', object: 'robot' },
                'buttonHover': { name: 'mouseHover', object: 'robot' },
                'buttonLeave': { name: 'mouseLeave', object: 'robot' },
                'formSubmit': { name: 'mouseDown', object: 'robot' }
            };

            const event = events[eventName];
            if (event && splineViewer.emitEvent) {
                try {
                    splineViewer.emitEvent(event.name, event.object);
                } catch (e) {
                    console.log('Note: Spline event "' + event.name + '" not available');
                }
            }
        }

        // Handle error display
        document.addEventListener('DOMContentLoaded', function() {
            const errors = document.querySelectorAll('.invalid-feedback');
            if (errors.length > 0) {
                const errorAlert = document.getElementById('errorAlert');
                let errorHTML = '<div class="alert alert-error">';
                errorHTML += '<i class="fas fa-circle-exclamation"></i>';
                errorHTML += '<div><strong>Login Gagal!</strong>';

                errors.forEach(error => {
                    errorHTML += '<div>' + error.textContent + '</div>';
                });

                errorHTML += '</div></div>';
                errorAlert.innerHTML = errorHTML;
            }
        });
    </script>
</body>
</html>
