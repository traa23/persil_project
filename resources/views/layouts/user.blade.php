<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>@yield('title', 'User Dashboard') - Sistem Persil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                width: 64;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                position: relative;
                z-index: 10;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .hamburger-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background: transparent;
                border: none;
                cursor: pointer;
                color: #1f2937;
                font-size: 24px;
            }
        }
        @media (min-width: 769px) {
            .hamburger-btn {
                display: none;
            }
            .sidebar {
                position: relative;
                transform: translateX(0);
            }
            .sidebar-overlay {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Alert Notifications -->
    @include('components.alerts')

    <!-- SIDEBAR OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="flex h-screen">
        <!-- SIDEBAR -->
        <div class="sidebar w-64 bg-teal-800 text-white p-6 overflow-y-auto" id="sidebar">
            <!-- Mobile Close Button -->
            <button class="hamburger-btn lg:hidden absolute top-4 right-4 text-white" id="closeSidebarBtn">
                <i class="fas fa-times"></i>
            </button>

            <!-- Logo -->
            <div class="mb-8 mt-8 lg:mt-0">
                <h2 class="text-2xl font-bold">Persil</h2>
                <p class="text-teal-300 text-sm">User Panel</p>
            </div>

            <!-- User Info -->
            @if(isset($warga) && $warga)
            <div class="mb-6 p-4 bg-teal-700 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-teal-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-sm">{{ $warga->nama ?? 'User' }}</p>
                        <p class="text-teal-300 text-xs">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('user.dashboard') ? 'bg-teal-600' : 'hover:bg-teal-700' }} transition">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('user.persil.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('user.persil.*') ? 'bg-teal-600' : 'hover:bg-teal-700' }} transition">
                    <i class="fas fa-map"></i>
                    <span>Persil</span>
                </a>

                <a href="{{ route('user.dokumen.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('user.dokumen.*') ? 'bg-teal-600' : 'hover:bg-teal-700' }} transition">
                    <i class="fas fa-file-alt"></i>
                    <span>Dokumen Persil</span>
                </a>

                <a href="{{ route('user.peta.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('user.peta.*') ? 'bg-teal-600' : 'hover:bg-teal-700' }} transition">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Peta Persil</span>
                </a>

                <a href="{{ route('user.sengketa.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('user.sengketa.*') ? 'bg-teal-600' : 'hover:bg-teal-700' }} transition">
                    <i class="fas fa-balance-scale"></i>
                    <span>Sengketa Persil</span>
                </a>

                <a href="{{ route('user.jenis-penggunaan.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('user.jenis-penggunaan.*') ? 'bg-teal-600' : 'hover:bg-teal-700' }} transition">
                    <i class="fas fa-tags"></i>
                    <span>Jenis Penggunaan</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="mt-8 pt-8 border-t border-teal-600">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 rounded w-full hover:bg-teal-700 font-medium text-base transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content flex-1 flex flex-col overflow-hidden w-full">
            <!-- TOP BAR -->
            <div class="bg-white shadow px-6 py-4 flex items-center justify-between">
                <!-- Hamburger Menu Button (Mobile Only) -->
                <button class="hamburger-btn" id="hamburgerBtn">
                    <i class="fas fa-bars"></i>
                </button>

                <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium">User</span>
                </div>
            </div>

            <!-- PAGE CONTENT -->
            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Hamburger menu functionality
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        }

        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', openSidebar);
        }
        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeSidebar);
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
    </script>
</body>
</html>
