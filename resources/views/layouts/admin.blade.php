<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Sistem Informasi Persil')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Poppins:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1565C0;
            --secondary: #626EE9;
            --success: #4CAF50;
            --danger: #F44336;
            --warning: #FF9800;
            --info: #2196F3;
            --light: #ECEFF1;
            --dark: #263238;
            --border: #CFD8DC;
        }

        body {
            font-family: 'DM Sans', 'Poppins', sans-serif;
            background-color: #F5F5F5;
            color: #263238;
            line-height: 1.6;
        }

        /* Header Styling */
        header#header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 16px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header#header .logo {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header#header .logo a {
            font-size: 22px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        header#header .logo span {
            color: #FFD700;
            margin-left: 8px;
            font-style: italic;
        }

        header#header a[href="#menu"] {
            display: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            background: none;
            border: none;
        }

        /* Navigation */
        nav#menu {
            background: white;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 60px;
            z-index: 999;
        }

        nav#menu ul.links {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            list-style: none;
            align-items: center;
        }

        nav#menu ul.links li {
            margin: 0;
        }

        nav#menu ul.links li a,
        nav#menu ul.links li button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 16px 16px;
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            position: relative;
        }

        nav#menu ul.links li a:hover,
        nav#menu ul.links li button:hover {
            color: var(--primary);
            border-bottom-color: var(--primary);
            background-color: rgba(21, 101, 192, 0.05);
        }

        nav#menu ul.links li:last-child {
            margin-left: auto;
        }

        nav#menu ul.links li:last-child button {
            color: var(--danger);
        }

        nav#menu ul.links li:last-child button:hover {
            border-bottom-color: var(--danger);
            color: var(--danger);
        }

        /* Main Content */
        main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Banner Section */
        section#banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 50px 0;
            margin: 0 0 40px 0;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        section#banner .inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        section#banner .major h1 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        section#banner .content {
            margin-top: 16px;
            font-size: 16px;
            opacity: 0.95;
        }

        /* Alert Messages */
        .alert-success {
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(102, 187, 106, 0.1) 100%);
            border-left: 4px solid var(--success);
            padding: 16px 20px;
            margin: 20px 0;
            border-radius: 8px;
            color: #2E7D32;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(244, 67, 54, 0.1) 0%, rgba(229, 57, 53, 0.1) 100%);
            border-left: 4px solid var(--danger);
            padding: 16px 20px;
            margin: 20px 0;
            border-radius: 8px;
            color: #B71C1C;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Buttons */
        .btn-primary,
        .btn-success,
        .btn-danger,
        .btn-secondary {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(21, 101, 192, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(21, 101, 192, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #45A049 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(76, 175, 80, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #E53935 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(244, 67, 54, 0.4);
        }

        .btn-secondary {
            background: #90A4AE;
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-secondary:hover {
            background: #78909C;
            transform: translateY(-2px);
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 13px;
        }

        /* Forms */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
            background-color: #FAFBFC;
        }

        input[type="text"]:disabled,
        input[type="email"]:disabled,
        input[type="password"]:disabled,
        input[type="number"]:disabled,
        select:disabled,
        textarea:disabled {
            background-color: #FAFAFA;
            color: #9E9E9E;
            cursor: not-allowed;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }

        .card h2 {
            margin: 0 0 20px 0;
            color: var(--dark);
            font-size: 20px;
            font-weight: 800;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--light);
        }

        .card h3 {
            margin: 0 0 12px 0;
            color: var(--dark);
            font-size: 16px;
            font-weight: 700;
        }

        /* Tables */
        .table-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            margin: 20px 0;
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-wrapper table thead {
            background: linear-gradient(135deg, #F5F5F5 0%, #EEEEEE 100%);
            border-bottom: 2px solid var(--border);
        }

        .table-wrapper table thead th {
            padding: 16px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--dark);
        }

        .table-wrapper table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--light);
            font-size: 14px;
            color: #424242;
        }

        .table-wrapper table tbody tr:hover {
            background-color: #FAFBFC;
        }

        .table-wrapper table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-admin {
            background: linear-gradient(135deg, rgba(98, 110, 233, 0.2) 0%, rgba(156, 39, 176, 0.2) 100%);
            color: #512DA8;
        }

        .badge-guest {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.2) 0%, rgba(25, 118, 210, 0.2) 100%);
            color: #1565C0;
        }

        /* Footer */
        footer#footer {
            background: linear-gradient(135deg, var(--dark) 0%, #37474F 100%);
            color: white;
            padding: 40px 0;
            margin-top: 60px;
            text-align: center;
            border-top: 1px solid var(--border);
        }

        footer#footer .icons {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        footer#footer .icons a {
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        footer#footer .icons a:hover {
            color: var(--secondary);
            transform: scale(1.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            section#banner {
                padding: 40px 0;
            }

            section#banner .major h1 {
                font-size: 28px;
            }

            nav#menu ul.links {
                flex-direction: column;
                padding: 0;
            }

            nav#menu ul.links li a,
            nav#menu ul.links li button {
                padding: 12px 16px;
                border-bottom: none;
                border-left: 4px solid transparent;
            }

            nav#menu ul.links li a:hover,
            nav#menu ul.links li button:hover {
                border-left-color: var(--primary);
            }

            nav#menu ul.links li:last-child {
                margin-left: 0;
            }

            main {
                padding: 20px 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-dashboard"></i> Admin <span>Persil</span></a>
            <a href="#menu" style="margin-left: auto;"><i class="fas fa-bars"></i></a>
        </div>
    </header>

    <!-- Navigation -->
    <nav id="menu">
        <ul class="links">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="{{ route('admin.users.create') }}"><i class="fas fa-user-plus"></i> Add User</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer">
        <ul class="icons">
            <li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
        </ul>
        <p>&copy; 2024 Admin Sistem Persil. All rights reserved.</p>
    </footer>

    @stack('scripts')

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('✅ {{ session('success') }}');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('❌ {{ session('error') }}');
            });
        </script>
    @endif
</body>
</html>
