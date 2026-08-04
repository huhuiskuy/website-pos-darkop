<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - DariKopi</title>
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
        .top-tabs { border-bottom: 1px solid #EBE3DB; display: flex; gap: 32px; margin-bottom: 32px; padding-bottom: 0; margin-top: 32px;}
        .top-tabs a { color: #94a3b8; text-decoration: none; font-weight: 500; font-size: 14px; padding-bottom: 12px; position: relative; transition: 0.2s;}
        .top-tabs a:hover { color: #8a5a36; }
        .top-tabs a.active { color: #8a5a36; font-weight: 600; }
        .top-tabs a.active::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background-color: #8a5a36; }

        .btn-export { background-color: #8a5a36; color: white; display: flex; align-items: center; gap: 8px; font-weight: 600; border-radius: 8px; padding: 10px 24px; border: none; font-size: 14px; transition: 0.2s;}
        .btn-export:hover { background-color: #734a2c; color: white; }

        /* Kiri: Sub Menu Laporan */
        .laporan-sidebar { background: #ffffff; border-radius: 16px; padding: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB;}
        .laporan-sidebar a { display: block; padding: 12px 20px; color: #64748b; font-weight: 500; font-size: 14px; text-decoration: none; border-radius: 8px; margin-bottom: 8px; transition: 0.2s;}
        .laporan-sidebar a.active { background: #8a5a36; color: #ffffff; }
        .laporan-sidebar a:hover:not(.active) { background: #faf7f5; color: #8a5a36; }

        /* Kanan: Konten Utama */
        .laporan-card { background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB; }
        .laporan-card-title { font-size: 18px; font-weight: 700; color: #2b2d42; margin-bottom: 24px; }
        
        .summary-card { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 16px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        
        /* Tabel & Efek Clickable */
        .clickable-row { transition: all 0.2s ease; cursor: pointer; }
        .clickable-row:hover { background-color: #faf7f5; }

        /* ================= DATE PICKER & SEARCH CUSTOM ================= */
        .date-filter-group { display: inline-flex; align-items: center; background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); overflow: hidden; }
        .btn-date-custom { background: transparent; border: none; color: #2b2d42; display: flex; align-items: center; justify-content: center; transition: 0.2s; border-radius: 0; }
        .btn-date-custom:hover { background: #faf7f5; color: #8a5a36; }
        .btn-date-center { font-weight: 600; font-size: 14px; padding: 0 16px;}
        
        .search-box { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; padding: 8px 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: 0.2s; }
        .search-box:focus-within { border-color: #8a5a36; box-shadow: 0 0 0 4px rgba(138, 90, 54, 0.1); }
        .search-box input::placeholder { color: #cbd5e1; font-weight: 400; }

        /* ================= MODAL DETAIL ESTETIK ================= */
        .modal-content { border-radius: 20px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.1); font-family: 'Poppins', sans-serif; }
        .modal-header { padding: 24px 32px; border-bottom: 1px dashed #EBE3DB; }
        .modal-body { padding: 32px; }
        .modal-footer { padding: 24px 32px; border-top: 1px dashed #EBE3DB; background-color: #faf7f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; }
        .struk-badge { background-color: #e6f4ea; color: #1e8e3e; font-size: 12px; font-weight: 600; padding: 6px 12px; border-radius: 20px; }
        .struk-item-name { font-weight: 600; color: #2b2d42; font-size: 14px; margin-bottom: 2px; }
        .struk-item-desc { font-size: 13px; color: #64748b; }
        .struk-item-price { font-weight: 600; color: #2b2d42; font-size: 14px; }
        .struk-divider { border-top: 1px dashed #cbd5e1; margin: 20px 0; }

        /* ================= TOMBOL MODAL KONSISTEN ================= */
        .btn-modal-cancel { background: transparent; border: 1px solid #EBE3DB; color: #64748b; font-weight: 600; border-radius: 8px; padding: 10px 24px; font-size: 14px; transition: 0.2s; }
        .btn-modal-cancel:hover { background: #f1f5f9; color: #2b2d42; }
        
        .btn-modal-action { background-color: #8a5a36; color: white; border: none; font-weight: 600; border-radius: 8px; padding: 10px 24px; font-size: 14px; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-modal-action:hover { background-color: #734a2c; color: white; }

        /* Daterangepicker CSS sama seperti index.blade.php */
        .daterangepicker { font-family: 'Poppins', sans-serif !important; border: 1px solid #EBE3DB !important; border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; padding: 20px !important; margin-top: 8px !important; color: #2b2d42 !important; display: none; }
        .daterangepicker .ranges { float: left !important; padding-right: 20px; border-right: 1px solid #f1f5f9 !important; margin-top: 0 !important; }
        .daterangepicker .ranges ul { width: 140px !important; }
        .daterangepicker .ranges li { font-size: 13px !important; font-weight: 500 !important; color: #64748b !important; background-color: #ffffff !important; border: 1px solid #EBE3DB !important; border-radius: 8px !important; padding: 10px 12px !important; margin-bottom: 8px !important; text-align: center !important; transition: all 0.2s ease; }
        .daterangepicker .ranges li:hover { background-color: #faf7f5 !important; color: #8a5a36 !important; border-color: #8a5a36 !important; }
        .daterangepicker .ranges li.active { background-color: #8a5a36 !important; color: #ffffff !important; border-color: #8a5a36 !important; }
        .daterangepicker .drp-calendar { padding: 0 16px !important; }
        .daterangepicker .calendar-table { border: none !important; background-color: transparent !important; }
        .daterangepicker th.month { font-size: 15px !important; font-weight: 700 !important; color: #2b2d42 !important; padding-bottom: 12px !important; }
        .daterangepicker td { width: 32px !important; height: 32px !important; font-size: 13px !important; font-weight: 500 !important; border-radius: 6px !important; transition: 0.2s; }
        .daterangepicker td.in-range { background-color: #F4EFEA !important; color: #8a5a36 !important; border-radius: 0 !important; }
        .daterangepicker td.active { background-color: #8a5a36 !important; color: #ffffff !important; border-radius: 6px !important; box-shadow: 0 2px 6px rgba(138, 90, 54, 0.3) !important; }
        .daterangepicker td.available:hover { background-color: #EBE1D7 !important; color: #8a5a36 !important; }
        .daterangepicker td.off { color: #cbd5e1 !important; background-color: transparent !important; font-weight: 400 !important; }
        .daterangepicker .drp-buttons { border-top: 1px solid #EBE3DB !important; padding: 16px 0 0 0 !important; margin-top: 8px !important; display: flex !important; align-items: center !important; justify-content: flex-end !important; gap: 12px; }
        .daterangepicker .drp-selected { font-size: 13px !important; font-weight: 500 !important; color: #64748b !important; margin-right: auto !important; padding-left: 160px !important; }
        .daterangepicker .cancelBtn { background: transparent !important; border: 1px solid #EBE3DB !important; color: #64748b !important; font-weight: 600 !important; border-radius: 8px !important; padding: 8px 20px !important; }
        .daterangepicker .applyBtn { background: #8a5a36 !important; border: none !important; color: white !important; font-weight: 600 !important; border-radius: 8px !important; padding: 8px 24px !important; }
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
        <a href="{{ route('menu.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 4.99992L16.6667 16.6666M9.99999 4.99992V16.6666M6.66666 6.66659V16.6666M3.33333 3.33325V16.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Menu</a>
        <a href="{{ route('bahan-baku.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 18.3334V10.0001M10 10.0001L2.74167 5.83341M10 10.0001L17.2583 5.83341M6.25 3.55841L13.75 7.85008M9.16667 18.1084C9.42003 18.2547 9.70744 18.3317 10 18.3317C10.2926 18.3317 10.58 18.2547 10.8333 18.1084L16.6667 14.7751C16.9198 14.6289 17.13 14.4188 17.2763 14.1658C17.4225 13.9127 17.4997 13.6257 17.5 13.3334V6.66675C17.4997 6.37448 17.4225 6.08742 17.2763 5.83438C17.13 5.58134 16.9198 5.37122 16.6667 5.22508L10.8333 1.89175C10.58 1.74547 10.2926 1.66846 10 1.66846C9.70744 1.66846 9.42003 1.74547 9.16667 1.89175L3.33333 5.22508C3.08022 5.37122 2.86998 5.58134 2.72372 5.83438C2.57745 6.08742 2.5003 6.37448 2.5 6.66675V13.3334C2.5003 13.6257 2.57745 13.9127 2.72372 14.1658C2.86998 14.4188 3.08022 14.6289 3.33333 14.7751L9.16667 18.1084Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Bahan Baku</a>
        <a href="{{ route('laporan.index') }}" class="active"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 2.5V15.8333C2.5 16.2754 2.67559 16.6993 2.98816 17.0118C3.30072 17.3244 3.72464 17.5 4.16667 17.5H17.5M5.83333 13.3333H12.5M5.83333 9.16667H15.8333M5.83333 5H8.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Laporan</a>
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

    <!-- Horizontal Tabs -->
    <div class="top-tabs">
        <a href="{{ route('laporan.index') }}">Penjualan</a>
        <a href="{{ route('laporan.transaksi') }}" class="active">Transaksi</a>
        <a href="{{ route('laporan.opname') }}">Opname</a>
    </div>

    <!-- Filter & Action Bar (Search, Date, Export) -->
    <form action="{{ route('laporan.transaksi') }}" method="GET" id="formFilterTransaksi" class="d-flex justify-content-between align-items-center mb-4">
        <input type="hidden" name="tab" value="{{ $tab }}">
        
        <div class="d-flex gap-3 align-items-center">
            <!-- Search Bar Custom -->
            <div class="search-box d-flex align-items-center" style="width: 280px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="search" id="searchInput" value="{{ $search }}" placeholder="Cari Nomor Struk" style="border: none; outline: none; background: transparent; width: 100%; margin-left: 12px; font-size: 14px; color: #2b2d42; font-family: 'Poppins', sans-serif;">
            </div>

            <!-- Date Picker -->
            <div class="date-filter-group">
                <input type="hidden" name="start_date" id="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" id="end_date" value="{{ $endDate }}">
                
                <button type="button" class="btn btn-date-custom px-3 py-2" onclick="ubahPeriode(-1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="btn btn-date-custom btn-date-center py-2 gap-2" id="daterange-btn">
                    <span id="date-text">
                        {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} 
                        {{ $startDate != $endDate ? '- ' . \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '' }}
                    </span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <button type="button" class="btn btn-date-custom px-3 py-2" onclick="ubahPeriode(1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>

        <!-- Export Button -->
        <a href="{{ request()->fullUrlWithQuery(['export' => 'true']) }}" class="btn-export" style="text-decoration:none;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export
        </a>
    </form>

    <!-- Konten Bawah (Sidebar Sub Menu & Tabel) -->
    <div class="row g-4">
        
        <!-- Kolom Kiri (Sub Menu) -->
        <div class="col-md-3">
            <div class="laporan-sidebar">
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'sukses']) }}" class="{{ $tab == 'sukses' ? 'active' : '' }}">Pesanan Sukses</a>
                <a href="{{ request()->fullUrlWithQuery(['tab' => 'batal']) }}" class="{{ $tab == 'batal' ? 'active' : '' }}">Pesanan Batal</a>
            </div>
        </div>

        <!-- Kolom Kanan (Card Tabel & Summary) -->
        <div class="col-md-9">
            <div class="laporan-card">
                <h4 class="laporan-card-title mb-4">{{ $tab == 'sukses' ? 'Pesanan Sukses' : 'Pesanan Batal' }}</h4>
                
                <!-- 3 Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div style="font-size: 12px; font-weight: 600; color: #2b2d42; margin-bottom: 12px;">{{ $tab == 'batal' ? 'Transaksi Batal' : 'Transaksi' }}</div>
                            <div style="font-size: 24px; font-weight: 700; color: #2b2d42;">{{ number_format($tab == 'batal' ? $totalTransaksiBatal : $totalTransaksi, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div style="font-size: 12px; font-weight: 600; color: #2b2d42; margin-bottom: 12px;">{{ $tab == 'batal' ? 'Total Nominal Batal' : 'Total Pendapatan' }}</div>
                            <div style="font-size: 24px; font-weight: 700; color: #2b2d42;">Rp{{ number_format($tab == 'batal' ? $totalNominalBatal : $totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="summary-card">
                            <div style="font-size: 12px; font-weight: 600; color: #2b2d42; margin-bottom: 12px;">Penjualan Bersih</div>
                            <div style="font-size: 24px; font-weight: 700; color: #2b2d42;">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Riwayat Transaksi -->
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: separate; border-spacing: 0; font-size: 14px; color: #2b2d42; text-align: left;">
                        <thead>
                            <tr style="background-color: #F4EFEA; color: #64748b; font-size: 13px; font-weight: 600;">
                                <!-- Lengkungan Kiri Atas -->
                                <th style="padding: 16px 20px; border-radius: 8px 0 0 0; width: 20%;">Waktu</th>
                                <th style="padding: 16px 20px; width: 50%;">Menu</th>
                                <!-- Lengkungan Kanan Atas -->
                                <th style="padding: 16px 20px; text-align: right; border-radius: 0 8px 0 0; width: 30%;">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $currentDate = ''; 
                            @endphp
                            
                            @forelse($transaksis as $trx)
                                @php
                                    $trxDate = \Carbon\Carbon::parse($trx->created_at)->format('d F Y');
                                @endphp
                                
                                @if($currentDate != $trxDate)
                                    @php $currentDate = $trxDate; @endphp
                                    <tr style="background-color: #f8f6f3;">
                                        <td colspan="2" style="padding: 16px 20px; font-weight: 600; color: #1e1e1e;">
                                            {{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td style="padding: 16px 20px; font-weight: 600; color: #1e1e1e; text-align: right;"></td>
                                    </tr>
                                @endif
                                
                                <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#detailModal{{ $trx->id }}">
                                    <td style="padding: 20px; border-bottom: 1px solid #f1f5f9;">{{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }}</td>
                                    <td style="padding: 20px; font-weight: 600; color: #1e1e1e; border-bottom: 1px solid #f1f5f9;">
                                        @foreach($trx->detail_transaksis->take(2) as $dt)
                                            {{ $dt->menu ? $dt->menu->nama_menu : 'Item terhapus' }} x {{ $dt->qty }}<br>
                                        @endforeach
                                        @if($trx->detail_transaksis->count() > 2)
                                            <span style="color: #94a3b8; font-size: 12px;">+ {{ $trx->detail_transaksis->count() - 2 }} item lainnya</span>
                                        @endif
                                    </td>
                                    <td style="padding: 20px; font-weight: 600; color: #1e1e1e; text-align: right; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada transaksi ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- ================= MODAL DETAIL PESANAN ================= -->
<!-- ================= MODAL DETAIL PESANAN ================= -->
@foreach($transaksis as $trx)
<div class="modal fade" id="detailModal{{ $trx->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $trx->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; padding: 12px 16px;">
            
            <!-- Modal Header -->
            <div class="modal-header border-0 pb-4 align-items-center"> 
                <h5 class="modal-title fw-bold mb-0" style="color: #000; font-size: 1.15rem;">
                    Detail Transaksi
                </h5>
                
                <div class="d-flex align-items-center gap-3">
                    @if($trx->status == 'Batal')
                        <span class="badge-status status-batal" style="background-color: #fee2e2; color: #dc2626; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">Batal</span>
                    @else
                        <span class="badge-status status-selesai" style="background-color: #e6f4ea; color: #1e8e3e; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 12px;">Selesai</span>
                    @endif
                    
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.8rem;"></button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body pt-1 pb-2" style="font-size: 0.95rem; color: #111;"> 
                
                <!-- Info Meta -->
                <div class="d-flex justify-content-between mb-4">
                    <span>Metode Pembayaran</span>
                    <span class="text-end">{{ $trx->metode_pembayaran ?? 'Tunai' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span>Nomor Struk</span>
                    <span class="text-end">{{ $trx->kode_transaksi }}</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span>Waktu Pembelian</span>
                    <span class="text-end">{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y \p\a\d\a H:i') }}</span>
                </div>

                <!-- Produk Section -->
                <h6 class="fw-bold mb-3" style="font-size: 1rem; color: #000;">Produk</h6>
                
                <div class="text-center py-2 mb-3" style="border-top: 1px solid #EFE8E1; border-bottom: 1px solid #EFE8E1; font-size: 0.85rem;">
                    {{ $trx->tipe_pesanan ?? 'Dine in' }}
                </div>

                <!-- Looping List Produk -->
                @foreach($trx->detail_transaksis as $detail)
                <div class="d-flex justify-content-between pb-2 mb-3" style="border-bottom: 1px solid #EFE8E1;">
                    <span>{{ $detail->menu ? $detail->menu->nama_menu : 'Menu Dihapus' }} x{{ $detail->qty }}</span>
                    <span class="fw-medium">Rp{{ number_format(($detail->menu->harga ?? 0) * $detail->qty, 0, ',', '.') }}</span>
                </div>
                @endforeach

                <!-- Rincian Harga -->
                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Total</span>
                    <span class="fw-bold">Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Pembayaran</span>
                    <span>Rp{{ number_format($trx->uang_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span>Kembalian</span>
                    <span>Rp{{ number_format($trx->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Area Tombol (Dynamic Footer: Batal vs Selesai) -->
            @if($trx->status == 'Batal')
                <!-- FOOTER VERSI BATAL -->
                <div class="mt-2 mb-3 d-flex flex-column gap-2">
                    <!-- Kotak Alasan Pembatalan -->
                    <div class="text-start" style="background-color: #FEF2F2; border: 1px solid #FEE2E2; border-radius: 12px; padding: 16px;">
                        <div class="fw-medium mb-1" style="font-size: 12px; color: #EF4444;">Alasan pembatalan</div>
                        <div class="fw-semibold" style="font-size: 14px; color: #991B1B; line-height: 1.4;">
                            {{ $trx->alasan_batal ?? '-' }}
                        </div>
                    </div>
                    
                    <!-- Tombol Tutup Outline -->
                    <button type="button" class="btn w-100 fw-semibold mt-1" data-bs-dismiss="modal" style="background-color: white; border: 1px solid #EBE3DB; color: #2b2d42; border-radius: 12px; padding: 12px 0; font-size: 14px;">
                        Tutup
                    </button>
                </div>
            @else
                <!-- FOOTER VERSI SELESAI (Normal) -->
                <div class="d-flex gap-3 mt-2 mb-3" style="background-color: #F9F9F9; padding: 12px; border-radius: 12px;">
                    <a href="{{ route('pos.print', $trx->id) }}" target="_blank" class="btn flex-fill fw-bold d-flex align-items-center justify-content-center" style="background-color: #8C593B; color: white; border-radius: 8px; padding: 12px 0; text-decoration: none; font-size: 14px;">
                        Cetak Struk
                    </a>
                    
                    <button type="button" class="btn flex-fill fw-bold" data-bs-dismiss="modal" style="background-color: white; color: #2b2d42; border: 1px solid #EBE3DB; border-radius: 8px; padding: 12px 0; font-size: 14px;">
                        Tutup
                    </button>
                </div>
            @endif
            
        </div>
    </div>
</div>
@endforeach

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

<!-- KONFIGURASI DATERANGEPICKER -->
<script>
    const formFilter = document.getElementById('formFilterTransaksi');
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
    });

    function ubahPeriode(offset) {
        var start = moment($('#start_date').val());
        var end = moment($('#end_date').val());
        
        start.add(offset, 'days');
        end.add(offset, 'days');
        
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        formFilter.submit();
    }

    $(function() {
        var start = moment($('#start_date').val()); 
        var end = moment($('#end_date').val());

        function updateDateText(start, end) {
            if(start.isSame(end, 'day')) {
                $('#date-text').html(start.format('DD/MM/YYYY'));
            } else {
                $('#date-text').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }
        }

        $('#daterange-btn').daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'right',
            drops: 'down',
            alwaysShowCalendars: true,
            ranges: {
               'Hari Ini': [moment(), moment()],
               'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Minggu Ini': [moment().startOf('week'), moment().endOf('week')],
               'Bulan Ini': [moment().startOf('month'), moment().endOf('month')]
            },
            locale: {
                customRangeLabel: 'Kustom Tanggal',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 1
            }
        }, function(start, end) {
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            formFilter.submit();
        });

        updateDateText(start, end);
    });
</script>

</body>
</html>
