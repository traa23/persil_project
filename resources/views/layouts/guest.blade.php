<!DOCTYPE HTML>
<html>
<head>
    <title>@yield('title', 'Sistem Informasi Persil')</title>
    <meta charset="utf-8">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('guest-tamplate/assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Enhanced Header & Nav for Logout */
        header#header {
            position: relative;
            z-index: 1000;
        }

        nav#menu ul.links li {
            position: relative;
            width: 100%;
        }

        nav#menu ul.links li form {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        nav#menu ul.links li button[type="submit"] {
            background: transparent !important;
            border: none !important;
            color: inherit !important;
            cursor: pointer !important;
            text-decoration: none !important;
            padding: 0 !important;
            font-family: inherit !important;
            font-size: inherit !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            width: 100% !important;
            text-align: left !important;
        }

        nav#menu ul.links li button[type="submit"]:hover {
            color: #ff6b6b !important;
            text-decoration: underline !important;
        }

        nav#menu ul.links li button[type="submit"]:focus {
            outline: none !important;
        }

        nav#menu ul.links li button[type="submit"] i {
            font-size: 16px !important;
        }

        /* Logout Section Styling */
        nav#menu ul.links li[data-logout="true"] {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }

        nav#menu ul.links li[data-logout="true"] button {
            color: #e74c3c !important;
            font-weight: 600 !important;
        }

        nav#menu ul.links li[data-logout="true"] button:hover {
            color: #c0392b !important;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header -->
    <header id="header" @if(!isset($isHome)) class="alt" @endif>
        <div class="logo">
            <a href="{{ route('guest.persil.index') }}"><i class="fas fa-map-location-dot"></i> Sistem Persil <span>Pertanahan</span></a>
        </div>
        <a href="#menu"><i class="fas fa-bars"></i> Menu</a>
    </header>

    <!-- Nav -->
    <nav id="menu">
        <ul class="links">
            <li><a href="{{ route('guest.persil.index') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('guest.persil.create') }}"><i class="fas fa-plus-circle"></i> Tambah Data</a></li>
            <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i> Profil</a></li>
            <li data-logout="true" style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="
                        background: none;
                        border: none;
                        color: #ffffff;
                        cursor: pointer;
                        text-decoration: none;
                        padding: 0;
                        font-family: inherit;
                        font-size: inherit;
                        font-weight: 600;
                        transition: all 0.3s ease;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        width: 100%;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    " onmouseover="this.style.color='#ff6b6b'; this.style.textDecoration='underline'" onmouseout="this.style.color='#ffffff'; this.style.textDecoration='none'">
                        <i class="fas fa-sign-out-alt"></i> Logout ({{ auth()->user()->name }})
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <ul class="icons">
                <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
            </ul>
        </div>
    </footer>

    <div class="copyright">
        Sistem Informasi Persil Pertanahan &copy; {{ date('Y') }}
    </div>

    <!-- Scripts -->
    <script src="{{ asset('guest-tamplate/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('guest-tamplate/assets/js/jquery.scrollex.min.js') }}"></script>
    <script src="{{ asset('guest-tamplate/assets/js/skel.min.js') }}"></script>
    <script src="{{ asset('guest-tamplate/assets/js/util.js') }}"></script>
    <script src="{{ asset('guest-tamplate/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
