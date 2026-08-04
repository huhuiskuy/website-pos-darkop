<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DariKopi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- jQuery, Moment.js, & Daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <style>
        body { background-color: #F9F6F0; font-family: 'Poppins', sans-serif; color: #2b2d42; }
        
        /* ================= SIDEBAR (Sama Persis) ================= */
        .sidebar { width: 240px; height: 100vh; background-color: #ffffff; border-right: 1px solid #EBE3DB; position: fixed; display: flex; flex-direction: column; padding: 24px 0; z-index: 100;}
        .sidebar-brand { font-size: 24px; font-weight: 700; color: #8a5a36; padding: 0 24px; line-height: 1.2;}
        .sidebar-subtitle { font-size: 11px; color: #94a3b8; padding: 0 24px; margin-bottom: 24px; }
        .sidebar-divider { border-top: 1px solid #EBE3DB; margin: 0 24px 24px 24px; }
        
        .nav-menu { display: flex; flex-direction: column; gap: 16px; padding: 0 12px; }
        .nav-menu a { display: flex; align-items: center; padding: 12px; color: #64748b; text-decoration: none; font-size: 15px; font-weight: 500; border-radius: 12px; transition: all 0.2s ease; position: relative; margin: 0 12px; }
        .nav-menu a svg { flex-shrink: 0; margin-right: 12px; }
        .nav-menu a:hover { color: #8a5a36; background-color: #faf7f5; }
        
        /* Dashboard yang aktif sekarang */
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
        
        /* ================= KOMPONEN DASHBOARD ================= */
        .dash-card { background: #ffffff; border-radius: 16px; padding: 24px; border: 1px solid #EBE3DB; box-shadow: 0 4px 15px rgba(0,0,0,0.02); height: 100%; }
        .dash-title-sm { font-size: 13px; font-weight: 600; color: #2b2d42; margin-bottom: 12px; display: block; }
        .dash-value { font-size: 24px; font-weight: 700; color: #2b2d42; margin-bottom: 8px; }
        .dash-subtext { font-size: 12px; color: #94a3b8; }
        
        .badge-trend { background-color: #dcfce7; color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;}
        
        .section-title { font-size: 18px; font-weight: 700; color: #2b2d42; margin-bottom: 20px; margin-top: 32px;}
        
        /* ================= DATE PICKER CUSTOM ================= */
        .date-filter-group { 
            margin-top: 24px; 
            margin-bottom: 24px; 
            display: inline-flex; 
            align-items: center;
            background: #ffffff; 
            border: 1px solid #EBE3DB; /* Border dipindah ke wadah utama */
            border-radius: 12px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            overflow: hidden; /* Biar efek hover tombol di ujung gak keluar jalur kotak */
        }
        .btn-date-custom { 
            background: transparent; 
            border: none; /* Hilangin garis pisah antar tombol */
            color: #2b2d42; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            transition: 0.2s;
            border-radius: 0; /* Reset bawaan bootstrap */
        }
        .btn-date-custom:hover { background: #faf7f5; color: #8a5a36; }
        .btn-date-custom:focus { outline: none; box-shadow: none; }
        .btn-date-center { font-weight: 600; font-size: 14px; padding: 0 16px;}

        /* Tabel Menu Terlaris */
        .table-menu-terlaris { width: 100%; margin-bottom: 0; }
        .table-menu-terlaris th { background-color: #F4EFEA; color: #64748b; font-weight: 600; font-size: 13px; padding: 12px 16px; border: none; }
        .table-menu-terlaris th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .table-menu-terlaris th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
        .table-menu-terlaris td { font-size: 14px; font-weight: 600; color: #2b2d42; padding: 16px; border-bottom: 1px solid #f1f5f9; }
        .table-menu-terlaris tr:last-child td { border-bottom: none; }

        /* ================= DATERANGEPICKER PREMIUM CUSTOM ================= */
        .daterangepicker {
            font-family: 'Poppins', sans-serif !important;
            border: 1px solid #EBE3DB !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
            padding: 20px !important;
            margin-top: 8px !important;
            color: #2b2d42 !important;
            display: none;
        }
        
        /* Panel Kiri (Pilihan Rentang Waktu) */
        .daterangepicker .ranges {
            float: left !important;
            padding-right: 20px;
            border-right: 1px solid #f1f5f9 !important;
            margin-top: 0 !important;
        }
        .daterangepicker .ranges ul { width: 140px !important; }
        .daterangepicker .ranges li {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            background-color: #ffffff !important;
            border: 1px solid #EBE3DB !important;
            border-radius: 8px !important;
            padding: 10px 12px !important;
            margin-bottom: 8px !important;
            text-align: center !important;
            transition: all 0.2s ease;
        }
        .daterangepicker .ranges li:hover {
            background-color: #faf7f5 !important;
            color: #8a5a36 !important;
            border-color: #8a5a36 !important;
        }
        .daterangepicker .ranges li.active {
            background-color: #8a5a36 !important;
            color: #ffffff !important;
            border-color: #8a5a36 !important;
        }

        /* Kalender (Tengah) */
        .daterangepicker .drp-calendar { padding: 0 16px !important; }
        .daterangepicker .calendar-table {
            border: none !important;
            background-color: transparent !important;
        }
        .daterangepicker th.month {
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #2b2d42 !important;
            padding-bottom: 12px !important;
        }
        .daterangepicker th.prev span, .daterangepicker th.next span { border-color: #94a3b8 !important; }
        .daterangepicker th.prev:hover, .daterangepicker th.next:hover { background-color: transparent !important; }
        .daterangepicker th.prev:hover span, .daterangepicker th.next:hover span { border-color: #8a5a36 !important; }
        
        .daterangepicker th { color: #94a3b8 !important; font-weight: 500 !important; font-size: 12px !important; }
        
        /* Sel Tanggal di Kalender */
        .daterangepicker td {
            width: 32px !important;
            height: 32px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            border-radius: 6px !important;
            transition: 0.2s;
        }
        .daterangepicker td.in-range {
            background-color: #F4EFEA !important;
            color: #8a5a36 !important;
            border-radius: 0 !important; /* Kotak nyambung pas milih range */
        }
        .daterangepicker td.active, .daterangepicker td.active:hover {
            background-color: #8a5a36 !important;
            color: #ffffff !important;
            border-radius: 6px !important; /* Bikin bulet/rounded pas di-klik */
            box-shadow: 0 2px 6px rgba(138, 90, 54, 0.3) !important;
        }
        .daterangepicker td.available:hover {
            background-color: #EBE1D7 !important;
            color: #8a5a36 !important;
        }
        .daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date {
            color: #cbd5e1 !important;
            background-color: transparent !important;
            font-weight: 400 !important;
        }

        /* Panel Bawah (Tombol Apply & Cancel) */
        .daterangepicker .drp-buttons {
            border-top: 1px solid #EBE3DB !important;
            padding: 16px 0 0 0 !important;
            margin-top: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 12px;
        }
        .daterangepicker .drp-selected {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-right: auto !important; /* Dorong teks ke kiri */
            padding-left: 160px !important;
        }
        .daterangepicker .cancelBtn {
            background: transparent !important;
            border: 1px solid #EBE3DB !important;
            color: #64748b !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            padding: 8px 20px !important;
        }
        .daterangepicker .cancelBtn:hover { background: #f1f5f9 !important; }
        .daterangepicker .applyBtn {
            background: #8a5a36 !important;
            border: none !important;
            color: white !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            padding: 8px 24px !important;
        }
        .daterangepicker .applyBtn:hover { background: #734a2c !important; }
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
        <a href="{{ route('dashboard.index') }}" class="active"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 17.5V10.8333C12.5 10.6123 12.4122 10.4004 12.2559 10.2441C12.0996 10.0878 11.8877 9.99999 11.6667 9.99999H8.33333C8.11232 9.99999 7.90036 10.0878 7.74408 10.2441C7.5878 10.4004 7.5 10.6123 7.5 10.8333V17.5M2.5 8.33333C2.49994 8.09088 2.55278 7.85135 2.65482 7.63142C2.75687 7.4115 2.90566 7.21649 3.09083 7.05999L8.92417 2.05999C9.22499 1.80575 9.60613 1.66626 10 1.66626C10.3939 1.66626 10.775 1.80575 11.0758 2.05999L16.9092 7.05999C17.0943 7.21649 17.2431 7.4115 17.3452 7.63142C17.4472 7.85135 17.5001 8.09088 17.5 8.33333V15.8333C17.5 16.2754 17.3244 16.6993 17.0118 17.0118C16.6993 17.3244 16.2754 17.5 15.8333 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V8.33333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Dashboard</a>
        <a href="{{ route('menu.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 4.99992L16.6667 16.6666M9.99999 4.99992V16.6666M6.66666 6.66659V16.6666M3.33333 3.33325V16.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Menu</a>
        <a href="{{ route('bahan-baku.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 18.3334V10.0001M10 10.0001L2.74167 5.83341M10 10.0001L17.2583 5.83341M6.25 3.55841L13.75 7.85008M9.16667 18.1084C9.42003 18.2547 9.70744 18.3317 10 18.3317C10.2926 18.3317 10.58 18.2547 10.8333 18.1084L16.6667 14.7751C16.9198 14.6289 17.13 14.4188 17.2763 14.1658C17.4225 13.9127 17.4997 13.6257 17.5 13.3334V6.66675C17.4997 6.37448 17.4225 6.08742 17.2763 5.83438C17.13 5.58134 16.9198 5.37122 16.6667 5.22508L10.8333 1.89175C10.58 1.74547 10.2926 1.66846 10 1.66846C9.70744 1.66846 9.42003 1.74547 9.16667 1.89175L3.33333 5.22508C3.08022 5.37122 2.86998 5.58134 2.72372 5.83438C2.57745 6.08742 2.5003 6.37448 2.5 6.66675V13.3334C2.5003 13.6257 2.57745 13.9127 2.72372 14.1658C2.86998 14.4188 3.08022 14.6289 3.33333 14.7751L9.16667 18.1084Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Bahan Baku</a>
        <a href="{{ route('laporan.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 2.5V15.8333C2.5 16.2754 2.67559 16.6993 2.98816 17.0118C3.30072 17.3244 3.72464 17.5 4.16667 17.5H17.5M5.83333 13.3333H12.5M5.83333 9.16667H15.8333M5.83333 5H8.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Laporan</a>
        <a href="{{ route('akun.index') }}"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Akun</a>
    </div>
    <div class="mt-auto px-4">
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
        <h2 class="topbar-title">Dashboard</h2>
        <div class="clock-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6V12L16 14" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span id="realtime-clock">--:-- WIB</span>
        </div>
    </div>

    <!-- Header & Welcome -->
    <div>
        <h1 class="fw-bold mb-1" style="color: #2b2d42; font-size: 32px;">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}</h1>
        <p class="text-muted" style="font-size: 15px;">Berikut ringkasan operasional kedai hari ini</p>
    </div>
    
    <!-- Date Picker Custom -->
    <form id="filterForm" action="{{ route('dashboard.index') }}" method="GET" class="date-filter-group">
        <input type="hidden" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}">
        <input type="hidden" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}">
        <button type="button" class="btn btn-date-custom px-3 py-2" onclick="ubahHari(-1)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>
        
        <!-- Tombol Utama yang bisa diklik buat buka Kalender -->
        <button type="button" class="btn btn-date-custom btn-date-center py-2 gap-2" id="daterange-btn">
            <span id="date-text">
                @if($startDate->isSameDay($endDate))
                    {{ $startDate->format('d/m/Y') }}
                @else
                    {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
                @endif
            </span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        
        <button type="button" class="btn btn-date-custom px-3 py-2" onclick="ubahHari(1)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
    </form>

    <!-- 1. RINGKASAN PENJUALAN (4 Kotak Atas) -->
    <h4 class="section-title">Ringkasan Penjualan</h4>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="dash-card">
                <span class="dash-title-sm">Pendapatan</span>
                <div class="dash-value">Rp{{ number_format($pendapatan, 0, ',', '.') }}</div>
                @if($trendPersen >= 0)
                <span class="badge-trend"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>+{{ number_format($trendPersen, 1, ',', '.') }}% VS KEMARIN</span>
                @else
                <span class="badge-trend" style="background-color: #fee2e2; color: #ef4444;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>{{ number_format($trendPersen, 1, ',', '.') }}% VS KEMARIN</span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="dash-card">
                <span class="dash-title-sm">Transaksi</span>
                <div class="dash-value">{{ $jumlahTransaksi }}</div>
                <span class="dash-subtext">Transaksi Selesai</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dash-card">
                <span class="dash-title-sm">Menu Terjual</span>
                <div class="dash-value">{{ $menuTerjual }}</div>
                <span class="dash-subtext">Menu Periode Ini</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dash-card">
                <span class="dash-title-sm">Menu Terlaris</span>
                <div class="dash-value" style="font-size: 20px;">{{ $menuTerlaris }}</div>
                <span class="dash-subtext">{{ $menuTerlarisJml }} Terjual</span>
            </div>
        </div>
    </div>

    <!-- 2. GRAFIK UTAMA (Bar & Area) -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="dash-card">
                <span class="dash-title-sm">Jumlah Penjualan Harian Dalam Seminggu</span>
                <div id="chart-mingguan"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dash-card">
                <span class="dash-title-sm">Jumlah Penjualan Per Jam</span>
                <div id="chart-perjam"></div>
            </div>
        </div>
    </div>

    <!-- 3. RINGKASAN MENU (Tabel Top Menu) -->
    <h4 class="section-title">Ringkasan Menu</h4>
    <div class="dash-card mb-4" style="padding: 24px;">
        <span class="dash-title-sm mb-3">Top Menu</span>
        <div class="table-responsive">
            <table class="table table-menu-terlaris">
                <thead>
                    <tr>
                        <th style="width: 40%;">Nama Menu</th>
                        <th style="width: 30%;">Menu Terjual</th>
                        <th style="width: 30%;">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($top3Menu as $menu)
                    <tr>
                        <td>{{ $menu['menu']->nama_menu }}</td>
                        <td>{{ $menu['terjual'] }}</td>
                        <td>Rp{{ number_format($menu['pendapatan'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada data penjualan menu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. GRAFIK DONUT (Kategori) -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="dash-card text-center relative">
                <span class="dash-title-sm text-start">Kategori Berdasarkan Volume</span>
                <div class="d-flex justify-content-center">
                    <div id="chart-donut-volume"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dash-card text-center">
                <span class="dash-title-sm text-start">Kategori Berdasarkan Penjualan</span>
                <div class="d-flex justify-content-center">
                    <div id="chart-donut-pendapatan"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. GRAFIK BAR BAWAH (Top Menu Berdasarkan Kategori) -->
    <div class="dash-card">
        <span class="dash-title-sm">Top Menu Berdasarkan Kategori Terlaris</span>
        <div class="row mt-4">
            @forelse($topMenuPerKategori as $index => $item)
            <div class="col-md-4 text-center">
                <span style="font-size: 13px; color: #64748b; font-weight: 500;">{{ $item['kategori'] }}</span>
                <div id="chart-bar-kat{{ $index }}" style="margin-top: -10px;"></div>
                <span style="font-size: 11px; color: #94a3b8; font-weight: 500;">Total Kategori Ini: {{ array_sum($item['volumes']) }} Terjual</span>
            </div>
            @empty
            <div class="col-12 text-center text-muted">Belum ada data penjualan untuk kategori</div>
            @endforelse
        </div>
    </div>

</div>

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

<!-- ================= KONFIGURASI APEXCHARTS ================= -->
<script>
    // Palet Warna Sesuai Mockup
    const colorBrown = '#8a5a36';
    const colorGreen = '#729E65';
    const colorYellow = '#DCAD56';
    const colorBgChart = '#9c7b64'; // Brown agak soft buat bar chart

   // =======================================================
    // 1. Chart Bar Mingguan
    // =======================================================
    var labelMingguan = @json($labelMingguan); 
    var transMingguan = @json($transaksiMingguan); 
    var pendMingguan  = @json($pendapatanMingguan);

    var optMingguan = {
        series: [{ name: 'Penjualan', data: pendMingguan }],
        chart: { type: 'bar', height: 250, toolbar: { show: false } },
        colors: [colorBgChart],
        plotOptions: { bar: { borderRadius: 2, columnWidth: '60%' } },
        dataLabels: { enabled: false },
        xaxis: { 
            categories: labelMingguan, // Panggil dari gudang
            axisBorder: {show: false}, axisTicks: {show: false}, crosshairs: {show: false} 
        },
        yaxis: { labels: { formatter: function (val) { return val + "k" } } },
        grid: { show: false },
        tooltip: {
            custom: function({series, seriesIndex, dataPointIndex}) {
                let val = series[seriesIndex][dataPointIndex];
                
                // AMBIL LANGSUNG DARI GUDANG (Pasti akurat)
                let hari = labelMingguan[dataPointIndex]; 
                let trans = transMingguan[dataPointIndex]; 
                
                return `
                <div style="padding: 10px 14px; background: #ffffff; border: 1px solid #EBE3DB; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: 'Poppins', sans-serif;">
                    <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 8px;">${hari}</div>
                    <div style="display: flex; align-items: center; margin-bottom: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: ${colorBgChart}; margin-right: 8px;"></span>
                        <span style="font-size: 13px; color: #2b2d42;">Penjualan: <b>${val}k</b></span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: ${colorGreen}; margin-right: 8px;"></span>
                        <span style="font-size: 13px; color: #2b2d42;">Transaksi: <b>${trans}</b></span>
                    </div>
                </div>`;
            }
        }
    };
    new ApexCharts(document.querySelector("#chart-mingguan"), optMingguan).render();

    // =======================================================
    // 2. Chart Area Per Jam
    // =======================================================
    var labelPerJam = @json($labelPerJam);
    var transPerJam = @json($transaksiPerJam); 
    var pendPerJam  = @json($pendapatanPerJam);

    var optPerJam = {
        series: [{ name: 'Penjualan', data: pendPerJam }],
        chart: { type: 'area', height: 250, toolbar: { show: false }, zoom: {enabled: false} },
        colors: [colorBgChart],
        fill: { type: 'solid', opacity: 1 },
        dataLabels: { enabled: false },
        stroke: { curve: 'straight', width: 0 },
        xaxis: { 
            categories: labelPerJam, // Panggil dari gudang
            axisBorder: {show: false}, axisTicks: {show: false}, crosshairs: {show: false},
            labels: { style: { fontSize: '10px' } }
        },
        yaxis: { labels: { formatter: function (val) { return val + "k" }, style: { fontSize: '10px' } } },
        grid: { show: false },
        tooltip: {
            custom: function({series, seriesIndex, dataPointIndex}) {
                let val = series[seriesIndex][dataPointIndex];
                
                // AMBIL LANGSUNG DARI GUDANG (Pasti akurat)
                let jam = labelPerJam[dataPointIndex]; 
                let trans = transPerJam[dataPointIndex];
                
                return `
                <div style="padding: 10px 14px; background: #ffffff; border: 1px solid #EBE3DB; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: 'Poppins', sans-serif;">
                    <div style="font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Pukul ${jam}:00 WIB</div>
                    <div style="display: flex; align-items: center; margin-bottom: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: ${colorBgChart}; margin-right: 8px;"></span>
                        <span style="font-size: 13px; color: #2b2d42;">Penjualan: <b>${val}k</b></span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background-color: ${colorYellow}; margin-right: 8px;"></span>
                        <span style="font-size: 13px; color: #2b2d42;">Transaksi: <b>${trans}</b></span>
                    </div>
                </div>`;
            }
        }
    };
    new ApexCharts(document.querySelector("#chart-perjam"), optPerJam).render();

    // =======================================================
    // 3. Chart Donut (Volume)
    // =======================================================
    var volumeAsli = @json($volumeKategori); 

    var optDonutVol = {
        series: @json(empty($persenVolume) ? [0] : $persenVolume),
        chart: { type: 'donut', height: 280 },
        labels: @json(empty($labelKategori) ? ['Tidak ada data'] : $labelKategori),
        colors: [colorBrown, colorYellow, colorGreen],
        plotOptions: { pie: { donut: { size: '30%' }, expandOnClick: false } },
        dataLabels: { enabled: true, formatter: function (val) { return val + "%" }, dropShadow: { enabled: false }, style: {colors: ['#fff']} },
        legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px', markers: { radius: 12 } },
        stroke: { width: 4, colors: ['#fff'] },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    // Ambil angka volume dari gudang dummy berdasarkan urutannya
                    let vol = volumeAsli[opts.seriesIndex];
                    // Format jadi: 17 (63.2%)
                    return vol + " (" + val + "%)";
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#chart-donut-volume"), optDonutVol).render();

    // =======================================================
    // 4. Chart Donut (Pendapatan)
    // =======================================================
    var pendapatanAsli = @json($pendapatanKategori); 

    var optDonutPendapatan = {
        series: @json(empty($persenPendapatan) ? [0] : $persenPendapatan),
        chart: { type: 'donut', height: 280 },
        labels: @json(empty($labelKategori) ? ['Tidak ada data'] : $labelKategori),
        colors: [colorBrown, colorYellow, colorGreen],
        plotOptions: { pie: { donut: { size: '30%' }, expandOnClick: false } },
        dataLabels: { enabled: true, formatter: function (val) { return val + "%" }, dropShadow: { enabled: false } },
        legend: { position: 'top', horizontalAlign: 'right', fontSize: '11px', markers: { radius: 12 } },
        stroke: { width: 4, colors: ['#fff'] },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    // Ambil angka Rupiah dari gudang dummy
                    let rp = pendapatanAsli[opts.seriesIndex];
                    // Format jadi: Rp345.000 (68.2%)
                    return rp + " (" + val + "%)";
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#chart-donut-pendapatan"), optDonutPendapatan).render();

    // 5. Chart Bar Bawah (Kategori)
    var optBarKategori = {
        chart: { type: 'bar', height: 180, toolbar: { show: false } },
        colors: [colorBrown],
        plotOptions: { bar: { columnWidth: '50%', borderRadius: 2 } },
        dataLabels: { enabled: true, style: { fontSize: '10px', colors: ['#fff'] } },
        xaxis: { 
            labels: { show: true, style: { fontSize: '9px' } }, 
            axisBorder: {show: false}, 
            axisTicks: {show: false} 
        },
        yaxis: { labels: { show: false } },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 0, position: 'back', xaxis: {lines: {show: false}}, yaxis: {lines: {show: false}} }
    };

    // Render masing-masing bar chart kecil
    var topMenuData = @json($topMenuPerKategori);
    topMenuData.forEach(function(item, index) {
        new ApexCharts(document.querySelector("#chart-bar-kat" + index), { 
            ...optBarKategori, 
            series: [{ name: 'Terjual', data: item.volumes }],
            xaxis: { ...optBarKategori.xaxis, categories: item.labels }
        }).render();
    });
</script>

<!-- ================= KONFIGURASI DATERANGEPICKER ================= -->
<script>
    $(function() {
        // Ambil waktu dari input tersembunyi
        var start = moment($('#start_date').val(), 'YYYY-MM-DD'); 
        var end = moment($('#end_date').val(), 'YYYY-MM-DD');

        window.ubahHari = function(hari) {
            let s = moment($('#start_date').val(), 'YYYY-MM-DD').add(hari, 'days').format('YYYY-MM-DD');
            let e = moment($('#end_date').val(), 'YYYY-MM-DD').add(hari, 'days').format('YYYY-MM-DD');
            $('#start_date').val(s);
            $('#end_date').val(e);
            $('#filterForm').submit();
        };

        // Fungsi buat ngubah teks tanggal pas dipilih
        function updateDateText(start, end) {
            if(start.isSame(end, 'day')) {
                $('#date-text').html(start.format('DD/MM/YYYY'));
            } else {
                $('#date-text').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }
        }

        // Settingan Pop-up Kalendernya
        $('#daterange-btn').daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'right',
            drops: 'down',
            alwaysShowCalendars: true, // <--- INI KUNCI BIAR KALENDER SELALU TAMPIL
            applyButtonClasses: 'btn-brown',
            ranges: {
               'Hari Ini': [moment(), moment()],
               'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Minggu Ini': [moment().startOf('week'), moment().endOf('week')],
               'Minggu Lalu': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
               'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
               'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                customRangeLabel: 'Kustom Tanggal',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 1
            }
        }, function(start, end, label) {
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            $('#filterForm').submit();
        });

        // Jalankan pas pertama kali load
        updateDateText(start, end);
    });
</script>

</body>
</html>
