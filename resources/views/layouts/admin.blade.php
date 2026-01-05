<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
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
                <h2 class="text-2xl font-bold">Persil</h2>
                <p class="text-gray-400 text-sm">Admin Panel</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.persil.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('admin.persil.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                    <i class="fas fa-map"></i>
                    <span>Data Persil</span>
                </a>

                <a href="{{ route('admin.guest.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('admin.guest.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                    <i class="fas fa-users"></i>
                    <span>Kelola Guest</span>
                </a>

                <a href="{{ route('admin.user.create') }}" class="flex items-center space-x-3 px-4 py-3 rounded font-medium text-base {{ request()->routeIs('admin.user.*') ? 'bg-purple-600' : 'hover:bg-gray-800' }} transition">
                    <i class="fas fa-user-plus"></i>
                    <span>Buat User</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="mt-8 pt-8 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="button" class="flex items-center space-x-3 px-4 py-3 rounded w-full hover:bg-gray-800 font-medium text-base transition" onclick="confirmLogout()">
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
                <button class="hamburger-btn lg:hidden text-gray-800" id="openSidebarBtn">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Page Title -->
                <h1 class="text-2xl font-bold text-gray-800 flex-1">@yield('page-title', 'Dashboard')</h1>

                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600 hidden sm:inline">{{ auth()->user()->name }}</span>
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
        /**
         * HAMBURGER MENU FUNCTIONALITY
         * ================================
         * Untuk mobile (Android/iOS):
         * - Klik icon garis 3 (hamburger) untuk buka sidebar
         * - Klik overlay gelap atau tombol close untuk tutup sidebar
         *
         * Untuk desktop:
         * - Sidebar selalu visible (tidak ada hamburger menu)
         */

        // Get DOM elements
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');

        // FUNCTION 1: Buka sidebar
        // Saat hamburger menu (icon garis 3) diklik di mobile
        function openSidebar() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling saat sidebar open
        }

        // FUNCTION 2: Tutup sidebar
        // Saat overlay diklik atau close button diklik di mobile
        function closeSidebar() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = 'auto'; // Enable scrolling
        }

        // FUNCTION 3: Toggle sidebar
        // Saat hamburger button diklik
        function toggleSidebar() {
            if (sidebar.classList.contains('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // EVENT LISTENERS
        // ===============

        // Buka sidebar saat hamburger button diklik
        openSidebarBtn?.addEventListener('click', openSidebar);

        // Tutup sidebar saat close button diklik
        closeSidebarBtn?.addEventListener('click', closeSidebar);

        // Tutup sidebar saat overlay diklik (dark background)
        sidebarOverlay?.addEventListener('click', closeSidebar);

        // Tutup sidebar saat menu item diklik (untuk UX yang lebih baik)
        const menuLinks = sidebar?.querySelectorAll('nav a');
        menuLinks?.forEach(link => {
            link.addEventListener('click', closeSidebar);
        });

        // Tutup sidebar saat window di-resize ke desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });

        // Konfirmasi logout
        function confirmLogout() {
            // Show beautiful logout confirmation modal
            const modal = document.createElement('div');
            modal.id = 'logoutModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4 p-6 transform transition-all duration-300 scale-100">
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
    </script>
</body>
</html>
