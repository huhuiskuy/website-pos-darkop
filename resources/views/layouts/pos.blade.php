<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Point of Sale - DariKopi')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        :root {
            /* Penyesuaian warna biar lebih identik dengan mockup */
            --primary-brown: #7A4E33; /* Cokelat gelap untuk teks/icon aktif */
            --bg-body: #F5EFE9;
            --bg-sidebar: #FFFFFF;
            --text-dark: #382A22;
            --text-gray: #756D67; /* Abu-abu kecokelatan untuk menu tidak aktif */
            --border-color: #EAE3DB;
            --active-bg: #F4EBE1; /* Beige terang untuk background menu aktif */
            --btn-border: #E8D8CA;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            margin: 0;
            /* Jangan overflow: hidden global jika konten panjang. Default auto atau handle per view */
        }

        /* ================= SIDEBAR (Responsive via Bootstrap Offcanvas) ================= */
        .sidebar {
            width: 250px; 
            background-color: var(--bg-sidebar) !important;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px; 
            z-index: 1045;
        }

        @media (min-width: 992px) {
            .sidebar {
                position: fixed;
                height: 100vh;
                top: 0;
                left: 0;
            }
        }

        .brand {
            margin-bottom: 0; /* Dikasih jarak lebih lega karena divider dihapus */
        }
        .brand-name {
            font-size: 24px; 
            font-weight: 800;
            color: var(--primary-brown);
            line-height: 1;
            letter-spacing: -0.5px;
        }
        .brand-sub {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 6px;
            font-weight: 500;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--text-gray);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px; 
            transition: all 0.2s ease;
            gap: 16px; 
            position: relative; 
        }
        
        .nav-item.active {
            background-color: var(--active-bg);
            color: var(--primary-brown);
            padding-left: 24px; 
        }
        
        .nav-item.active::before {
            content: "";
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            height: 18px;
            width: 3px;
            background-color: var(--primary-brown);
            border-radius: 4px;
        }

        .nav-item:hover:not(.active) {
            background-color: #FAFAFA;
            color: var(--primary-brown);
        }

        /* Area Bawah: Profil & Keluar */
        .sidebar-bottom {
            margin-top: auto; 
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* ================= DIVIDER ================= */
        .divider {
            height: 1px;
            background-color: var(--border-color); 
            margin: 16px 0; 
            width: 100%; 
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: flex-start; 
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid var(--border-color); 
            color: var(--primary-brown);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            background: white;
            transition: all 0.2s ease;
        }
        .btn-logout:hover {
            background: #FAFAFA;
            border-color: var(--primary-brown);
        }

        /* ================= NAVBAR TOP ================= */
        .navbar-top {
            background-color: var(--bg-sidebar);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 70px;
            z-index: 99;
            position: sticky;
            top: 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        @media (max-width: 991px) {
            .navbar-top { padding: 0 16px; }
        }

        .navbar-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .time-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            background: white;
        }
        
        /* Tombol Hamburger di HP */
        .btn-menu-mobile {
            display: none;
            background: none;
            border: none;
            color: var(--text-dark);
            padding: 0;
            cursor: pointer;
        }
        
        @media (max-width: 991px) {
            .btn-menu-mobile { display: block; }
            .navbar-title-text { display: none; } /* Sembunyikan teks judul panjang di HP */
        }

        /* ================= MAIN CONTENT ================= */
        .main-wrapper {
            display: flex;
            padding: 32px;
            gap: 24px;
            /* Height 100vh calculation is best left to specific views (like POS index) */
        }

        @media (min-width: 992px) {
            .main-wrapper, .navbar-top {
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper { padding: 16px; }
        }
    </style>
</head>
<body>

    <!-- ================= SIDEBAR OFFCANVAS ================= -->
    <div class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebarMenu">
        <div>
            <!-- Tombol Close hanya muncul di Mobile -->
            <div class="d-flex justify-content-between align-items-center d-lg-none mb-3">
                <span class="fw-bold" style="color: var(--primary-brown);">Menu POS</span>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>
            
            <div class="brand">
                <div class="brand-name">DariKopi</div>
                <div class="brand-sub">Point of Sales</div>
            </div>
        </div>
        
        <!-- Divider di bawah subtitle -->
        <div class="divider mt-4"></div>
        
        <ul class="nav-menu">
            <a href="{{ url('/pos') }}" class="nav-item {{ request()->is('pos') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                Point of Sale
            </a>
            <a href="{{ route('pos.aktivitas') }}" class="nav-item {{ request()->routeIs('pos.aktivitas') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Aktivitas
            </a>
            <a href="{{ route('pos.opname') }}" class="nav-item {{ request()->routeIs('pos.opname') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                Opname
            </a>
        </ul>

        <div class="sidebar-bottom">
            <!-- Divider di atas tombol logout -->
            <div class="divider"></div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="source" value="pos">
            </form>
            <a href="#" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Keluar
            </a>
        </div>
    </div>

    <!-- ================= NAVBAR TOP ================= -->
    <div class="navbar-top">
        <h1 class="navbar-title">
            <!-- Tombol Hamburger Mobile -->
            <button class="btn-menu-mobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
            <span class="navbar-title-text">@yield('page_title', 'Point of Sale')</span>
        </h1>
        
        <div class="d-flex align-items-center gap-2">
            @yield('navbar_actions')
            <div class="time-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span id="realtime-clock">--:-- WIB</span>
            </div>
        </div>
    </div>

    <!-- ================= MAIN CONTENT ================= -->
    @yield('content')

    <!-- Bootstrap JS (Wajib untuk Modal & Offcanvas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Jam Realtime -->
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const clockEl = document.getElementById('realtime-clock');
            if (clockEl) clockEl.textContent = `${hours}:${minutes} WIB`;
        }
        setInterval(updateClock, 1000);
        updateClock(); 
    </script>

    @stack('scripts')
</body>
</html>
