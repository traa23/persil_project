<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Sistem Persil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #0d9488, #14b8a6); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #0f766e, #0d9488); }

        /* Glass Morphism */
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .glass-dark { background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }

        /* Gradients */
        .gradient-primary { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 50%, #2dd4bf 100%); }
        .gradient-secondary { background: linear-gradient(135deg, #1e3a5f 0%, #0f766e 100%); }

        /* Animated Background */
        .animated-bg { background: linear-gradient(-45deg, #0f766e, #14b8a6, #0d9488, #115e59); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

        /* Card Hover */
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }

        /* Nav Item */
        .nav-item { position: relative; overflow: hidden; transition: all 0.3s ease; }
        .nav-item::before { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 0; background: linear-gradient(90deg, rgba(255,255,255,0.2), transparent); transition: width 0.3s ease; }
        .nav-item:hover::before { width: 100%; }
        .nav-item.active { background: rgba(255, 255, 255, 0.15); border-left: 4px solid #2dd4bf; }

        /* Floating Animation */
        .float-animation { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }

        /* Pulse Glow */
        .pulse-glow { animation: pulseGlow 2s ease-in-out infinite; }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 20px rgba(20, 184, 166, 0.3); } 50% { box-shadow: 0 0 40px rgba(20, 184, 166, 0.6); } }

        /* Shimmer */
        .shimmer { position: relative; overflow: hidden; }
        .shimmer::after { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); animation: shimmer 2s infinite; }
        @keyframes shimmer { 100% { left: 100%; } }

        /* Mobile */
        @media (max-width: 1024px) {
            .sidebar { position: fixed; left: 0; top: 0; height: 100vh; z-index: 50; transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 40; }
            .sidebar-overlay.active { display: block; }
        }
        @media (min-width: 1025px) {
            .hamburger-btn { display: none !important; }
            .sidebar-overlay { display: none !important; }
        }

        /* Table */
        .table-luxury { border-collapse: separate; border-spacing: 0; }
        .table-luxury thead th { background: linear-gradient(135deg, #f8fafc, #f1f5f9); font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
        .table-luxury tbody tr { transition: all 0.2s ease; }
        .table-luxury tbody tr:hover { background: linear-gradient(90deg, rgba(20, 184, 166, 0.05), transparent); }

        .badge { font-size: 0.7rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }

        /* Line Clamp */
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        /* Custom Pagination Styling */
        nav[role="navigation"] .flex { flex-wrap: wrap; justify-content: center; gap: 0.25rem; }
        nav[role="navigation"] a, nav[role="navigation"] span { padding: 0.5rem 1rem; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 500; transition: all 0.3s ease; }
        nav[role="navigation"] a:hover { background: linear-gradient(135deg, #0f766e, #14b8a6); color: white; transform: translateY(-2px); }
        nav[role="navigation"] span[aria-current="page"] span { background: linear-gradient(135deg, #0f766e, #14b8a6); color: white; }

        /* Input Focus States */
        input:focus, select:focus, textarea:focus { outline: none; ring: 2px; ring-color: rgba(20, 184, 166, 0.5); border-color: #14b8a6; }

        /* Button Transitions */
        button, a { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 via-gray-50 to-slate-100 min-h-screen">
    @include('components.alerts')
    @include('components.confirm-modal')

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="flex h-screen">
        <!-- SIDEBAR -->
        <div class="sidebar w-72 glass-dark text-white overflow-y-auto" id="sidebar">
            <button class="lg:hidden absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition" id="closeSidebarBtn">
                <i class="fas fa-times"></i>
            </button>

            <!-- Logo -->
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl gradient-primary flex items-center justify-center shadow-lg pulse-glow">
                        <i class="fas fa-layer-group text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Bina Desa</h2>
                        <p class="text-teal-300 text-xs font-medium tracking-wider">USER PORTAL</p>
                    </div>
                </div>
            </div>

            <!-- User Card -->
            @php $warga = \App\Models\Warga::where('email', auth()->user()->email)->first(); @endphp
            <div class="p-4">
                <div class="bg-gradient-to-br from-teal-600/30 to-teal-800/30 rounded-2xl p-4 border border-teal-500/20">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-14 h-14 rounded-full gradient-primary flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-slate-900 flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white truncate">{{ $warga->nama ?? auth()->user()->name }}</p>
                            <p class="text-teal-300 text-xs truncate">{{ auth()->user()->email }}</p>
                            @if($warga)
                            <p class="text-teal-400 text-xs mt-1"><i class="fas fa-id-card mr-1"></i>{{ $warga->no_ktp }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-4 pb-4 space-y-1">
                <p class="text-teal-400 text-xs font-semibold uppercase tracking-wider px-4 mb-2">Menu Utama</p>

                <a href="{{ route('user.dashboard') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.dashboard') ? 'active' : 'hover:bg-white/10' }} transition-all group">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('user.dashboard') ? 'gradient-primary' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition">
                        <i class="fas fa-home text-lg"></i>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>

                <p class="text-teal-400 text-xs font-semibold uppercase tracking-wider px-4 mt-6 mb-2">Data Persil</p>

                <a href="{{ route('user.persil.list') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.persil.*') ? 'active' : 'hover:bg-white/10' }} transition-all group">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('user.persil.*') ? 'gradient-primary' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition">
                        <i class="fas fa-map text-lg"></i>
                    </div>
                    <span class="font-medium">Persil Saya</span>
                </a>

                <a href="{{ route('user.dokumen.list') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.dokumen.*') ? 'active' : 'hover:bg-white/10' }} transition-all group">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('user.dokumen.*') ? 'gradient-primary' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    <span class="font-medium">Dokumen</span>
                </a>

                <a href="{{ route('user.peta.list') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.peta.*') ? 'active' : 'hover:bg-white/10' }} transition-all group">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('user.peta.*') ? 'gradient-primary' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition">
                        <i class="fas fa-map-marked-alt text-lg"></i>
                    </div>
                    <span class="font-medium">Peta</span>
                </a>

                <a href="{{ route('user.sengketa.list') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.sengketa.*') ? 'active' : 'hover:bg-white/10' }} transition-all group">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('user.sengketa.*') ? 'gradient-primary' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition">
                        <i class="fas fa-gavel text-lg"></i>
                    </div>
                    <span class="font-medium">Sengketa</span>
                </a>

                <p class="text-teal-400 text-xs font-semibold uppercase tracking-wider px-4 mt-6 mb-2">Referensi</p>

                <a href="{{ route('user.jenis-penggunaan.list') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.jenis-penggunaan.*') ? 'active' : 'hover:bg-white/10' }} transition-all group">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('user.jenis-penggunaan.*') ? 'gradient-primary' : 'bg-white/10 group-hover:bg-white/20' }} flex items-center justify-center transition">
                        <i class="fas fa-tags text-lg"></i>
                    </div>
                    <span class="font-medium">Jenis Penggunaan</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 mt-auto border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 transition-all group">
                        <div class="w-10 h-10 rounded-lg bg-red-500/20 group-hover:bg-red-500/30 flex items-center justify-center transition">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </div>
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- TOP BAR -->
            <header class="glass shadow-lg border-b border-white/20 px-6 py-4 sticky top-0 z-30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button class="hamburger-btn lg:hidden w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center hover:bg-teal-700 transition" id="hamburgerBtn">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-gray-500 text-sm">@yield('page-subtitle', 'Selamat datang di portal pengguna')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <button class="relative w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition group">
                            <i class="fas fa-bell text-gray-600 group-hover:text-teal-600 transition"></i>
                        </button>
                        <div class="hidden md:flex items-center gap-3 px-4 py-2 rounded-xl bg-gradient-to-r from-teal-50 to-cyan-50 border border-teal-100">
                            <div class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-xs text-teal-600 font-medium">User Account</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="glass border-t border-white/20 px-6 py-4">
                <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} Bina Desa - Sistem Manajemen Persil</p>
                    <p class="mt-2 md:mt-0"><i class="fas fa-heart text-red-500 mx-1"></i> Laravel & Tailwind CSS</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() { sidebar.classList.add('active'); sidebarOverlay.classList.add('active'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.remove('active'); sidebarOverlay.classList.remove('active'); document.body.style.overflow = ''; }

        hamburgerBtn?.addEventListener('click', openSidebar);
        closeSidebarBtn?.addEventListener('click', closeSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);

        function animateCountUp(el, target, duration = 1500) {
            let start = 0; const inc = target / (duration / 16);
            const timer = setInterval(() => { start += inc; if (start >= target) { el.textContent = target.toLocaleString('id-ID'); clearInterval(timer); } else { el.textContent = Math.floor(start).toLocaleString('id-ID'); } }, 16);
        }
        document.addEventListener('DOMContentLoaded', () => { document.querySelectorAll('[data-count]').forEach(el => animateCountUp(el, parseInt(el.dataset.count))); });
    </script>
    @stack('scripts')
</body>
</html>
