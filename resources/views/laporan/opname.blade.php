<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Opname - DariKopi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery, Moment.js, & Daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        body { background-color: #F9F6F0; font-family: 'Poppins', sans-serif; color: #2b2d42; }
        
        /* ================= SIDEBAR ================= */
        .sidebar { width: 240px; height: 100vh; background-color: #ffffff; border-right: 1px solid #EBE3DB; position: fixed; display: flex; flex-direction: column; padding: 24px 0; z-index: 100;}
        .sidebar-brand { font-size: 24px; font-weight: 700; color: #8a5a36; padding: 0 24px; line-height: 1.2;}
        .sidebar-subtitle { font-size: 11px; color: #94a3b8; padding: 0 24px; margin-bottom: 24px; }
        .sidebar-divider { border-top: 1px solid #EBE3DB; margin: 0 24px 24px 24px; }
        
        .nav-menu { display: flex; flex-direction: column; gap: 16px; padding: 0 12px; }
        .nav-menu a { display: flex; align-items: center; padding: 12px; color: #64748b; text-decoration: none; font-size: 15px; font-weight: 500; border-radius: 12px; transition: all 0.2s ease; position: relative; margin: 0 12px; }
        .nav-menu a svg { flex-shrink: 0; margin-right: 12px; }
        .nav-menu a:hover { color: #8a5a36; background-color: #faf7f5; }
        
        .nav-menu .active { background-color: #EBE1D7; color: #8a5a36; font-weight: 600; padding-left: 30px; }
        .nav-menu .active::before { content: ""; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 4px; height: 24px; background-color: #8a5a36; border-radius: 10px; }

        .user-card { background: #ffffff; border: 1px solid #f1f5f9; border-radius: 12px; padding: 12px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px; }
        .user-name { font-size: 13px; font-weight: 700; color: #2b2d42; margin-bottom: 2px;}
        .user-role { font-size: 11px; color: #94a3b8; }
        
        .btn-logout { display: flex; justify-content: left; align-items: center; gap: 12px; width: 100%; padding: 12px; border-radius: 12px; background: transparent; border: 1px solid #E8DDD2; color: #8a5a36; font-weight: 600; font-size: 15px; text-decoration: none; transition: 0.2s; }
        .btn-logout:hover { background: #faf7f5; border-color: #8a5a36; color: #8a5a36; }
        
        /* ================= MAIN CONTENT ================= */
        .main-content { margin-left: 240px; padding: 24px 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; background-color: #ffffff; padding: 20px 32px; margin: -24px -32px 32px -32px; border-bottom: 1px solid #EBE3DB; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 24px; font-weight: 700; color: #262626; margin: 0; }
        .clock-badge { display: flex; align-items: center; gap: 8px; padding: 8px 16px; background-color: #ffffff; border: 1px solid #E8DDD2; border-radius: 12px; color: #262626; font-weight: 500; font-size: 14px; }
        
        /* ================= LAPORAN COMPONENTS ================= */
        .top-tabs { border-bottom: 1px solid #EBE3DB; display: flex; gap: 32px; margin-bottom: 24px; padding-bottom: 0; margin-top: 32px;}
        .top-tabs a { color: #94a3b8; text-decoration: none; font-weight: 500; font-size: 14px; padding-bottom: 12px; position: relative; transition: 0.2s;}
        .top-tabs a:hover { color: #8a5a36; }
        .top-tabs a.active { color: #8a5a36; font-weight: 600; }
        .top-tabs a.active::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background-color: #8a5a36; }

        .laporan-card { background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB; }

        /* ================= FILTERS & BADGES ================= */
        .search-box { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; padding: 8px 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: 0.2s; height: 42px;}
        .search-box:focus-within { border-color: #8a5a36; box-shadow: 0 0 0 4px rgba(138, 90, 54, 0.1); }
        .search-box input::placeholder { color: #cbd5e1; font-weight: 400; }
        
        /* --- Custom Dropdown Filters --- */
        .filter-box {
            background: white; border-radius: 12px; padding: 10px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border: 1px solid #EBE3DB; color: #64748b; font-size: 13px; cursor: pointer; transition: 0.2s; height: 42px; margin: 0;
        }
        .filter-box:hover { border-color: #8a5a36; }
        .dropdown-menu-custom {
            border-radius: 12px; border: 1px solid #EBE3DB; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 8px;
        }
        .dropdown-item-custom {
            border-radius: 8px; font-size: 13px; font-weight: 500; color: #64748b; padding: 8px 12px; transition: 0.2s;
        }
        .dropdown-item-custom:hover, .dropdown-item-custom.active {
            background-color: #faf7f5; color: #8a5a36;
        }

        .form-select-custom { background-color: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; padding: 8px 36px 8px 16px; font-size: 14px; font-weight: 500; color: #2b2d42; appearance: none; box-shadow: 0 2px 4px rgba(0,0,0,0.02); height: 42px; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%232b2d42' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; cursor: pointer;}
        .form-select-custom:focus { outline: none; border-color: #8a5a36; }

        .date-filter-group { display: inline-flex; align-items: center; background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); overflow: hidden; height: 42px;}
        .btn-date-custom { background: transparent; border: none; color: #2b2d42; display: flex; align-items: center; justify-content: center; transition: 0.2s; border-radius: 0; padding: 0 12px;}
        .btn-date-custom:hover { background: #faf7f5; color: #8a5a36; }
        .btn-date-center { font-weight: 600; font-size: 14px; padding: 0 16px;}

        .total-item-badge { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; font-size: 14px; font-weight: 600; color: #2b2d42; display: flex; align-items: center; padding: 0 16px; height: 42px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);}
        
        .btn-export { background-color: #8a5a36; color: white; display: flex; align-items: center; gap: 8px; font-weight: 600; border-radius: 12px; padding: 0 24px; border: none; font-size: 14px; transition: 0.2s; height: 42px;}
        .btn-export:hover { background-color: #734a2c; color: white; }

        .opname-info-badge { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 20px; padding: 8px 16px; font-size: 13px; font-weight: 600; color: #2b2d42; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);}

        /* ================= PAGINATION ================= */
        .pagination-container { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid #f1f5f9; }
        .pagination-text { font-size: 13px; color: #64748b; font-weight: 500; }
        .pagination-btns { display: flex; gap: 6px; }
        .page-btn { width: 32px; height: 32px; border-radius: 8px; border: 1px solid #EBE3DB; background: #ffffff; color: #2b2d42; font-weight: 600; font-size: 13px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s; }
        .page-btn:hover:not(.active) { background: #faf7f5; color: #8a5a36; border-color: #8a5a36; }
        .page-btn.active { background: #8a5a36; color: #ffffff; border-color: #8a5a36; }

        /* ================= TABLE ================= */
        .stok-primary { font-weight: 700; color: #1e1e1e; font-size: 14px; margin-bottom: 2px; }
        .stok-secondary { font-size: 12px; color: #64748b; font-weight: 500; }
        .text-selisih { color: #dc2626; font-weight: 600; } /* Warna merah estetik buat minus */

        /* Daterangepicker CSS standard (sama dengan halaman lain) */
        .daterangepicker { font-family: 'Poppins', sans-serif !important; border: 1px solid #EBE3DB !important; border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; padding: 20px !important; margin-top: 8px !important; color: #2b2d42 !important; display: none; }
        .daterangepicker .ranges li.active { background-color: #8a5a36 !important; color: #ffffff !important; border-color: #8a5a36 !important; }
        .daterangepicker td.active { background-color: #8a5a36 !important; color: #ffffff !important; border-radius: 6px !important; box-shadow: 0 2px 6px rgba(138, 90, 54, 0.3) !important; }
        .daterangepicker .applyBtn { background: #8a5a36 !important; border: none !important; color: white !important; font-weight: 600 !important; border-radius: 8px !important; padding: 8px 24px !important; }
        .daterangepicker .cancelBtn { background: transparent !important; border: 1px solid #EBE3DB !important; color: #64748b !important; font-weight: 600 !important; border-radius: 8px !important; padding: 8px 20px !important; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div>
        <div class="sidebar-brand">DariKopi</div>
        <div class="sidebar-subtitle">Back Office</div>
    </div>
    <div class="sidebar-divider"></div>
    <div class="nav-menu">
        <a href="{{ route('dashboard.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 17.5V10.8333C12.5 10.6123 12.4122 10.4004 12.2559 10.2441C12.0996 10.0878 11.8877 9.99999 11.6667 9.99999H8.33333C8.11232 9.99999 7.90036 10.0878 7.74408 10.2441C7.5878 10.4004 7.5 10.6123 7.5 10.8333V17.5M2.5 8.33333C2.49994 8.09088 2.55278 7.85135 2.65482 7.63142C2.75687 7.4115 2.90566 7.21649 3.09083 7.05999L8.92417 2.05999C9.22499 1.80575 9.60613 1.66626 10 1.66626C10.3939 1.66626 10.775 1.80575 11.0758 2.05999L16.9092 7.05999C17.0943 7.21649 17.2431 7.4115 17.3452 7.63142C17.4472 7.85135 17.5001 8.09088 17.5 8.33333V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Dashboard</a>
        <a href="/menu"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 4.99992L16.6667 16.6666M9.99999 4.99992V16.6666M6.66666 6.66659V16.6666M3.33333 3.33325V16.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Menu</a>
        <a href="/bahan-baku"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 18.3334V10.0001M10 10.0001L2.74167 5.83341M10 10.0001L17.2583 5.83341M6.25 3.55841L13.75 7.85008M9.16667 18.1084C9.42003 18.2547 9.70744 18.3317 10 18.3317C10.2926 18.3317 10.58 18.2547 10.8333 18.1084L16.6667 14.7751C16.9198 14.6289 17.13 14.4188 17.2763 14.1658C17.4225 13.9127 17.4997 13.6257 17.5 13.3334V6.66675C17.4997 6.37448 17.4225 6.08742 17.2763 5.83438C17.13 5.58134 16.9198 5.37122 16.6667 5.22508L10.8333 1.89175C10.58 1.74547 10.2926 1.66846 10 1.66846C9.70744 1.66846 9.42003 1.74547 9.16667 1.89175L3.33333 5.22508C3.08022 5.37122 2.86998 5.58134 2.72372 5.83438C2.57745 6.08742 2.5003 6.37448 2.5 6.66675V13.3334C2.5003 13.6257 2.57745 13.9127 2.72372 14.1658C2.86998 14.4188 3.08022 14.6289 3.33333 14.7751L9.16667 18.1084Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Bahan Baku</a>
        <a href="/laporan" class="active"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 2.5V15.8333C2.5 16.2754 2.67559 16.6993 2.98816 17.0118C3.30072 17.3244 3.72464 17.5 4.16667 17.5H17.5M5.83333 13.3333H12.5M5.83333 9.16667H15.8333M5.83333 5H8.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Laporan</a>
        <a href="/akun"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Akun</a>
    </div>
    <div class="mt-auto px-4">
        <!-- Role diganti jadi Owner sesuai mockup -->
        <div class="user-card"><div class="user-name">{{ auth()->user()->name }}</div></div>
        <div style="border-top: 1px solid #EBE3DB; margin: 0 8px 16px 8px;"></div>
        <!-- TOMBOL LOGOUT BARU -->
        <a href="#" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 5.83333L17.5 10L13.3333 14.1667M17.5 10H7.5M7.5 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Keluar
        </a>

        <!-- Form tersembunyi buat eksekusi POST Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="topbar">
        <h2 class="topbar-title">Laporan</h2>
        <div class="clock-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6V12L16 14" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span id="realtime-clock">--:-- WIB</span>
        </div>
    </div>

    <!-- Header -->
    <div>
        <h1 class="fw-bold mb-1" style="color: #2b2d42; font-size: 32px;">Laporan</h1>
        <p class="text-muted" style="font-size: 15px;">Lihat dan ekspor seluruh laporan operasional kedai kopi</p>
    </div>

    <!-- Horizontal Tabs (Shift dihapus) -->
    <div class="top-tabs">
        <a href="/laporan">Penjualan</a>
        <a href="/laporan/transaksi">Transaksi</a>
        <a href="/laporan/opname" class="active">Opname</a>
    </div>

    <!-- Filter & Action Bar (Flexbox) -->
    <form action="{{ route('laporan.opname') }}" method="GET" id="formFilterOpname" class="d-flex justify-content-between align-items-center mb-3">
        
        <!-- Group Kiri: Search, Kategori, Date -->
        <div class="d-flex gap-3 align-items-stretch">
            
            <div class="search-box d-flex align-items-center" style="width: 240px; margin: 0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="search" value="{{ request('search') }}" id="searchInput" placeholder="Cari nama item..." style="border: none; outline: none; background: transparent; width: 100%; margin-left: 10px; font-size: 14px; color: #2b2d42; font-family: 'Poppins', sans-serif;">
            </div>

            <!-- Custom Dropdown Kategori -->
            <div class="position-relative filter-status-container" id="customDropdownKategori" style="min-width: 180px;">
                <input type="hidden" name="kategori" id="kategoriInput" value="{{ request('kategori', 'semua') }}">
                <button type="button" class="filter-box w-100" onclick="toggleDropdown('dropdownMenuKategori')">
                    <span class="fw-medium" id="labelKategori">
                        @php
                            $labelKat = 'Semua Kategori';
                            if (request('kategori') == 'tak_berkategori') {
                                $labelKat = 'Tak Berkategori';
                            }
                            foreach($kategoris as $k) {
                                if (request('kategori') == $k->id) {
                                    $labelKat = $k->nama_kategori;
                                }
                            }
                            echo $labelKat;
                        @endphp
                    </span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <ul class="dropdown-menu-custom position-absolute w-100 d-none" id="dropdownMenuKategori" style="top: 100%; left: 0; margin-top: 8px; margin-bottom: 0; z-index: 9999; background: white; list-style: none;">
                    <li><a class="dropdown-item-custom d-block text-decoration-none {{ request('kategori', 'semua') == 'semua' ? 'active' : '' }}" href="#" onclick="pilihKategori(event, 'semua', 'Semua Kategori')">Semua Kategori</a></li>
                    <li><a class="dropdown-item-custom d-block text-decoration-none {{ request('kategori') == 'tak_berkategori' ? 'active' : '' }}" href="#" onclick="pilihKategori(event, 'tak_berkategori', 'Tak Berkategori')">Tak Berkategori</a></li>
                    @foreach($kategoris as $kat)
                    <li><a class="dropdown-item-custom d-block text-decoration-none {{ request('kategori') == $kat->id ? 'active' : '' }}" href="#" onclick="pilihKategori(event, '{{ $kat->id }}', '{{ $kat->nama_kategori }}')">{{ $kat->nama_kategori }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="date-filter-group">
                <input type="hidden" name="date" id="dateInput" value="{{ $date }}">
                <button type="button" class="btn btn-date-custom" onclick="ubahTanggal(-1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                <button type="button" class="btn btn-date-custom btn-date-center gap-2" id="daterange-btn">
                    <span id="date-text">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <button type="button" class="btn btn-date-custom" onclick="ubahTanggal(1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
            </div>

        </div>

        <!-- Group Kanan: Total Item & Export -->
        <div class="d-flex gap-3 align-items-center">
            <div class="total-item-badge">Total Item: {{ $items->total() }}</div>
            <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="btn-export" style="text-decoration:none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export
            </a>
        </div>
    </form>

    <!-- Info Badge (Siapa yang Opname) -->
    <div class="d-flex gap-3 mb-4">
        <div class="opname-info-badge">Opname Pagi: {{ $picPagi }}</div>
        <div class="opname-info-badge">Opname Sore: {{ $picSore }}</div>
    </div>

    <!-- Kartu Tabel Full Width -->
    <div class="laporan-card">
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: left;">
                <thead>
                    <tr style="background-color: #F4EFEA; color: #64748b; font-size: 13px; font-weight: 600;">
                        <th style="padding: 16px 20px; border-radius: 8px 0 0 8px; width: 30%;">Nama Item</th>
                        <th style="padding: 16px 20px; width: 20%;">Kategori</th>
                        <th style="padding: 16px 20px; width: 15%;">Stok Pagi</th>
                        <th style="padding: 16px 20px; width: 15%;">Stok Sore</th>
                        <th style="padding: 16px 20px; border-radius: 0 8px 8px 0; width: 20%;">Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        @php
                            $riwayat = $item->riwayatOpname->first();
                            $pagiBesar = $riwayat->stok_pagi_besar ?? 0;
                            $pagiKecil = $riwayat->stok_pagi_kecil ?? 0;
                            $soreBesar = $riwayat->stok_sore_besar ?? 0;
                            $soreKecil = $riwayat->stok_sore_kecil ?? 0;
                            
                            $rasio = $item->konversi ?? 1000;
                            
                            $totalPagiKecil = ($pagiBesar * $rasio) + $pagiKecil;
                            $totalSoreKecil = ($soreBesar * $rasio) + $soreKecil;
                            
                            $selisihKecil = $totalSoreKecil - $totalPagiKecil;
                            
                            $isMinus = $selisihKecil < 0;
                            $absKecil = abs($selisihKecil);
                            
                            $outBesar = floor($absKecil / $rasio);
                            $outKecil = $absKecil % $rasio;
                            
                            $selisihText = '-';
                            if ($riwayat) {
                                $prefix = $isMinus ? '- ' : '+ ';
                                $selisihText = $prefix;
                                if ($outBesar > 0) $selisihText .= $outBesar . ' ' . $item->unit_besar . ' ';
                                if ($outKecil > 0 || $outBesar == 0) $selisihText .= $outKecil . ' ' . $item->unit_kecil;
                                
                                if ($item->unit_kecil == '-') {
                                    $selisihText = $prefix . $outBesar . ' ' . $item->unit_besar;
                                    if ($absKecil == 0) $selisihText = '0 ' . $item->unit_besar;
                                }
                            }
                        @endphp
                        <tr>
                            <td style="padding: 20px; font-weight: 700; color: #1e1e1e; border-bottom: 1px solid #f1f5f9; font-size: 14px;">{{ $item->nama_item }}</td>
                            <td style="padding: 20px; font-weight: 600; color: #1e1e1e; border-bottom: 1px solid #f1f5f9; font-size: 14px;">{{ $item->kategori ? $item->kategori->nama_kategori : 'Tak Berkategori' }}</td>
                            <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                                @if($riwayat && (!is_null($riwayat->stok_pagi_besar) || !is_null($riwayat->stok_pagi_kecil)))
                                    <div class="stok-primary">{{ $pagiBesar }} {{ $item->unit_besar }}</div>
                                    @if($item->unit_kecil != '-')
                                    <div class="stok-secondary">{{ $pagiKecil }} {{ $item->unit_kecil }}</div>
                                    @endif
                                @else
                                    <div class="stok-primary">-</div>
                                @endif
                            </td>
                            <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
                                @if($riwayat && (!is_null($riwayat->stok_sore_besar) || !is_null($riwayat->stok_sore_kecil)))
                                    <div class="stok-primary">{{ $soreBesar }} {{ $item->unit_besar }}</div>
                                    @if($item->unit_kecil != '-')
                                    <div class="stok-secondary">{{ $soreKecil }} {{ $item->unit_kecil }}</div>
                                    @endif
                                @else
                                    <div class="stok-primary">-</div>
                                @endif
                            </td>
                            <td style="padding: 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px;">
                                @if($riwayat && (!is_null($riwayat->stok_sore_besar) || !is_null($riwayat->stok_sore_kecil)))
                                    <span class="text-selisih" style="color: {{ $isMinus ? '#dc2626' : '#16a34a' }};">{{ $selisihText }}</span>
                                @else
                                    <span class="text-selisih" style="color: #64748b;">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Bawah Kanan-Kiri) -->
        <div class="pagination-container">
            <div class="pagination-text">Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} item</div>
            <div class="pagination-btns" style="margin-bottom: -15px;">
                {{ $items->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-Update Jam -->
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('realtime-clock').textContent = `${hours}:${minutes} WIB`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<!-- KONFIGURASI DATERANGEPICKER (SINGLE DATE) -->
<script>
    const formFilter = document.getElementById('formFilterOpname');
    const searchInput = document.getElementById('searchInput');
    let typingTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            formFilter.submit();
        }, 600);
    });

    document.addEventListener("DOMContentLoaded", function() {
        if (searchInput.value.length > 0) {
            searchInput.focus();
            let val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }
        
        // Hide default pagination texts inside .pagination-btns
        document.querySelectorAll('.pagination-btns .d-sm-none, .pagination-btns p.small.text-muted').forEach(el => el.style.display = 'none');
    });

    function ubahTanggal(hari) {
        let dateInput = document.getElementById('dateInput');
        let currentDate = new Date(dateInput.value);
        
        currentDate.setDate(currentDate.getDate() + hari);
        
        let year = currentDate.getFullYear();
        let month = String(currentDate.getMonth() + 1).padStart(2, '0');
        let day = String(currentDate.getDate()).padStart(2, '0');
        
        dateInput.value = `${year}-${month}-${day}`;
        formFilter.submit();
    }

    $(function() {
        var selectedDate = moment($('#dateInput').val(), 'YYYY-MM-DD'); 

        // Fungsi update teks cuma butuh 1 parameter tanggal sekarang
        function updateDateText(date) {
            $('#date-text').html(date.format('DD/MM/YYYY'));
        }

        $('#daterange-btn').daterangepicker({
            singleDatePicker: true,      // KUNCI SAKTI: Ubah jadi mode pilih 1 hari
            showDropdowns: true,         // Tambahin dropdown buat milih bulan & tahun (opsional tapi ngebantu)
            startDate: selectedDate,
            opens: 'left', 
            drops: 'down',
            locale: {
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 1
            }
        }, function(start, end, label) {
            $('#dateInput').val(start.format('YYYY-MM-DD'));
            $('#formFilterOpname').submit();
        });

    });

    // ==========================================
    // JS UNTUK DROPDOWN FILTER
    // ==========================================
    function toggleDropdown(id) {
        document.querySelectorAll('.dropdown-menu-custom').forEach(el => {
            if(el.id !== id) el.classList.add('d-none');
        });
        document.getElementById(id).classList.toggle('d-none');
    }

    function pilihKategori(event, val, label) {
        event.preventDefault();
        document.getElementById('kategoriInput').value = val;
        // Opsional: ganti teks sebelum submit
        document.getElementById('labelKategori').innerText = label;
        document.getElementById('formFilterOpname').submit();
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.filter-status-container')) {
            document.querySelectorAll('.dropdown-menu-custom').forEach(el => el.classList.add('d-none'));
        }
    });

</script>

</body>
</html>
