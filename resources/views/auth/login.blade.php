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
            background: linear-gradient(135deg, #1565C0 0%, #283593 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 1200px;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        /* 3D Animation Section */
        .animation-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        spline-viewer {
            width: 100%;
            height: 100%;
        }

        /* Login Section */
        .login-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 36px;
            font-weight: 800;
            color: white;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
        }

        /* Login Card */
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: #263238;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label i {
            color: #1565C0;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #E0E0E0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.3s ease;
            background: #FAFAFA;
        }

        .form-control:focus {
            outline: none;
            border-color: #1565C0;
            background: white;
            box-shadow: 0 0 0 4px rgba(21, 101, 192, 0.1);
        }

        .form-control::placeholder {
            color: #BDBDBD;
        }

        /* Alert Messages */
        .alert {
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid #F44336;
            color: #B71C1C;
        }

        .alert-error i {
            color: #F44336;
            font-size: 18px;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid #4CAF50;
            color: #2E7D32;
        }

        .alert-success i {
            color: #4CAF50;
            font-size: 18px;
        }

        /* Buttons */
        .btn-login {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(21, 101, 192, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 16px;
        }

        /* Footer Links */
        .login-footer {
            margin-top: 32px;
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #E0E0E0;
        }

        .login-footer p {
            color: #757575;
            font-size: 14px;
            margin: 0;
        }

        .login-footer a {
            color: #1565C0;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            color: #0D47A1;
            text-decoration: underline;
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, rgba(21, 101, 192, 0.1) 0%, rgba(25, 118, 210, 0.1) 100%);
            border-left: 4px solid #1565C0;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #1565C0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box i {
            margin-top: 2px;
            font-size: 18px;
            flex-shrink: 0;
        }

        .info-text {
            flex: 1;
        }

        .info-text strong {
            display: block;
            margin-bottom: 4px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .animation-section {
                display: none;
            }

            .login-header h1 {
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 24px 16px;
                gap: 24px;
            }

            .login-card {
                padding: 24px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .login-header p {
                font-size: 14px;
            }

            body {
                padding: 20px;
            }
        }

        /* Loading State */
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-login:disabled:hover {
            transform: none;
            box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
        }

        /* Error Input */
        .form-control.is-invalid {
            border-color: #F44336;
            background: rgba(244, 67, 54, 0.05);
        }

        .invalid-feedback {
            color: #F44336;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Animation Section -->
        <div class="animation-section">
            <spline-viewer url="https://prod.spline.design/f6AezzZ2rnZYhy5X/scene.splinecode"></spline-viewer>
        </div>

        <!-- Login Section -->
        <div class="login-section">
            <div class="login-header">
                <h1><i class="fas fa-map-location-dot"></i> Persil</h1>
                <p>Sistem Informasi Pengelolaan Data Persil Pertanahan</p>
            </div>

            <div class="login-card">
                <!-- Error Alert -->
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>
                            <strong>Login Gagal!</strong>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="info-box">
                    <i class="fas fa-circle-info"></i>
                    <div class="info-text">
                        <strong>Demo Credentials:</strong>
                        <div>Admin: admin@persil.test / password</div>
                        <div>Guest: guest1@persil.test / password</div>
                    </div>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" novalidate>
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

                <!-- Footer Links -->
                <div class="login-footer">
                    <p>© 2024 Sistem Informasi Persil. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add loading state to button
        document.querySelector('form')?.addEventListener('submit', function() {
            const btn = document.querySelector('.btn-login');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        });

        // Add responsive check
        function checkResponsive() {
            const animSection = document.querySelector('.animation-section');
            if (window.innerWidth <= 1024 && animSection.style.display !== 'none') {
                animSection.style.display = 'none';
            }
        }

        window.addEventListener('resize', checkResponsive);
        checkResponsive();
    </script>
</body>
</html>
