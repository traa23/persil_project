<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Sistem Persil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* HAMBURGER MENU STYLES FOR MOBILE */
        /* Desktop: Sidebar always visible */
        /* Mobile: Hamburger icon, sidebar slides in/out */

        @media (max-width: 768px) {
            .sidebar {
                /* Sidebar di mobile: position fixed, slide dari kiri */
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                width: 64;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            /* Saat sidebar active: slide masuk dari kiri */
            .sidebar.active {
                transform: translateX(0);
            }

            /* Main content: pastikan tidak tersembunyi di bawah sidebar */
            .main-content {
                position: relative;
                z-index: 10;
            }

            /* Overlay untuk menutup sidebar saat di mobile */
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

            /* Hamburger button style */
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

        /* Desktop: Hamburger button hidden */
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

    <!-- Confirmation Modal -->
    @include('components.confirm-modal')

    <!-- SIDEBAR OVERLAY - untuk close sidebar saat di mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="flex h-screen">
        <!-- SIDEBAR - Responsive: Desktop visible, Mobile hamburger menu -->
        <div class="sidebar w-64 bg-gray-900 text-white p-6 overflow-y-auto" id="sidebar">
            <!-- Mobile Close Button -->
            <button class="hamburger-btn lg:hidden absolute top-4 right-4 text-white" id="closeSidebarBtn">
                <i class="fas fa-times"></i>
            </button>

            <!-- Logo -->
            <div class="mb-8 mt-8 lg:mt-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Bina Desa</h2>
                        <p class="text-gray-400 text-xs">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ getAdminRoute('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-sm {{ request()->routeIs('*.dashboard') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Master Section -->
                <div class="pt-4">
                    <p class="px-4 text-xs text-gray-500 uppercase tracking-wider mb-2">Data Master</p>
                    <a href="{{ getAdminRoute('warga.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.warga.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-users w-5"></i>
                        <span>Data Warga</span>
                    </a>
                    <a href="{{ getAdminRoute('persil.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.persil.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Data Persil</span>
                    </a>
                </div>

                <!-- Pertanahan Section -->
                <div class="pt-4">
                    <p class="px-4 text-xs text-gray-500 uppercase tracking-wider mb-2">Pertanahan</p>
                    <a href="{{ getAdminRoute('dokumen.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.dokumen.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-file-alt w-5"></i>
                        <span>Dokumen Persil</span>
                    </a>
                    <a href="{{ getAdminRoute('peta.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.peta.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-map w-5"></i>
                        <span>Peta Persil</span>
                    </a>
                    <a href="{{ getAdminRoute('sengketa.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.sengketa.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-gavel w-5"></i>
                        <span>Sengketa Persil</span>
                    </a>
                    <a href="{{ getAdminRoute('jenis-penggunaan.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.jenis-penggunaan.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-tags w-5"></i>
                        <span>Jenis Penggunaan</span>
                    </a>
                </div>

                <!-- User Management Section -->
                <div class="pt-4">
                    <p class="px-4 text-xs text-gray-500 uppercase tracking-wider mb-2">User</p>
                    <a href="{{ getAdminRoute('user.list') }}" class="flex items-center space-x-3 px-4 py-2 rounded text-sm {{ request()->routeIs('*.user.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                        <i class="fas fa-user-cog w-5"></i>
                        <span>User Management</span>
                    </a>
                </div>
            </nav>

            <!-- Logout -->
            <div class="mt-8 pt-8 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="button" class="flex items-center space-x-3 px-4 py-3 rounded w-full hover:bg-gray-800 font-medium text-sm transition" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt w-5"></i>
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
                <button class="hamburger-btn lg:hidden text-gray-800" id="openSidebarBtn">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Page Title -->
                <h1 class="text-2xl font-bold text-gray-800 flex-1">@yield('page-title', 'Dashboard')</h1>

                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium hidden sm:inline">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="flex-1 overflow-auto p-4 lg:p-6">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FOR HAMBURGER MENU -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');

        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        openSidebarBtn?.addEventListener('click', openSidebar);
        closeSidebarBtn?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        const menuLinks = sidebar?.querySelectorAll('nav a');
        menuLinks?.forEach(link => {
            link.addEventListener('click', closeSidebar);
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        /*
        ========================================
        OLD LOGOUT FUNCTION (COMMENTED OUT)
        ========================================
        function confirmLogout() {
            const modal = document.createElement('div');
            modal.id = 'logoutModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4 p-6">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Konfirmasi Logout</h3>
                    <p class="text-center text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari akun ini?</p>
                    <div class="flex gap-3">
                        <button onclick="document.getElementById('logoutModal').remove()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium transition">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button onclick="document.getElementById('logoutForm').submit()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
        */

        // NEW: confirmLogout is now defined in confirm-modal.blade.php with 2-step verification
    </script>
</body>
</html>
