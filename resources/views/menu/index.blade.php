<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - DariKopi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #F9F6F0; font-family: 'Poppins', sans-serif; color: #2b2d42; }
        
        /* ================= SIDEBAR PREMIUM ================= */
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
        
        .btn-brown { background-color: #8a5a36; color: white; font-weight: 500; border-radius: 10px; padding: 10px 20px; border: none; transition: 0.2s; }
        .btn-brown:hover { background-color: #734a2c; color: white; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #EBE3DB; font-size: 13px; padding: 10px 16px; box-shadow: none; }
        .form-control:focus, .form-select:focus { border-color: #8a5a36; box-shadow: none; }
        
        .search-wrapper { display: flex; align-items: center; border: 1px solid #EBE3DB; border-radius: 8px; background-color: #ffffff; padding: 0 16px; transition: all 0.2s ease; width: 300px; height: 42px; margin: 0; }
        .search-wrapper:focus-within { border-color: #8a5a36; }
        .search-wrapper input { border: none; background: transparent; box-shadow: none; padding: 10px 0 10px 12px; width: 100%; font-size: 13px; margin: 0; }

        /* --- Custom Dropdown Filters --- */
        .filter-box {
            background: white; border-radius: 12px; padding: 0 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border: 1px solid #EBE3DB; color: #64748b; font-size: 13px; cursor: pointer; transition: 0.2s; height: 42px; margin: 0;
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
        .search-wrapper input:focus { outline: none; box-shadow: none; }
        .search-wrapper svg { color: #94a3b8; transition: 0.2s; }
        .search-wrapper:focus-within svg { color: #8a5a36; }

        .btn-close:focus { box-shadow: 0 0 0 0.25rem rgba(138, 90, 54, 0.25); }
        .pagination .page-link:focus { box-shadow: 0 0 0 0.25rem rgba(138, 90, 54, 0.25); color: #8a5a36; }
        .pagination .page-link:hover { color: #8a5a36; background-color: #FCF9F6; border-color: #EBE3DB; }
        .pagination .page-item .page-link { border: 1px solid #EBE3DB; color: #94a3b8; border-radius: 8px; margin: 0 4px; font-size: 13px; font-weight: 500; }
        .pagination .page-item.active .page-link { background-color: #8a5a36; border-color: #8a5a36; color: white; }
        
        .modal-content { border-radius: 20px; border: none; padding: 16px; }
        .modal-header { border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; }
        .modal-title { font-size: 20px; font-weight: 600; }
        .kategori-list-item { background: #faf7f5; border: 1px solid #EBE3DB; border-radius: 10px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;}
        .form-label-custom { color: #4b5563; font-weight: 500; font-size: 13px; margin-bottom: 6px; }
        .action-btn { width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; margin-right: 4px;}
        .btn-edit-icon { background-color: #F4EFEA; color: #8a5a36; }
        .btn-del-icon { background-color: #fee2e2; color: #ef4444; }

        .menu-card { background: #ffffff; border-radius: 16px; padding: 16px; border: 1px solid #EBE3DB; transition: 0.2s; height: 100%; display: flex; flex-direction: column;}
        .menu-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(138,90,54,0.08); border-color: #8a5a36;}
        .menu-img-placeholder { width: 100%; aspect-ratio: 4/3; background-color: #F4EFEA; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 600; color: #D7C5B1; margin-bottom: 16px; object-fit: cover; }
        .menu-title { font-size: 15px; font-weight: 700; color: #2b2d42; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;}
        .menu-category { font-size: 12px; color: #94a3b8; margin-bottom: 12px; }
        .menu-price { font-size: 18px; font-weight: 700; color: #8a5a36; margin-bottom: 16px; }
        
        .badge-status { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 11px; border: 1px solid transparent; }
        .status-aktif { background-color: #dcfce7; color: #10b981; border-color: #bbf7d0; }
        .status-habis { background-color: #fee2e2; color: #ef4444; border-color: #fecaca; }
        .btn-card-action { padding: 4px 16px; font-size: 11px; font-weight: 600; border-radius: 8px; border: none; transition: 0.2s;}
        .btn-edit-card { background-color: #F4EFEA; color: #8a5a36; }
        .btn-edit-card:hover { background-color: #EBE1D7; }
        .btn-del-card { background-color: #fee2e2; color: #ef4444; }
        .btn-del-card:hover { background-color: #fecaca; }

        .upload-area { border: 2px dashed #EBE3DB; border-radius: 16px; background-color: #FCF9F6; padding: 32px 24px; text-align: center; cursor: pointer; transition: all 0.2s; }
        .upload-area:hover { border-color: #8a5a36; background-color: #FAF5F0; }
        .upload-icon { color: #8a5a36; margin-bottom: 12px; }
        .upload-title { font-size: 15px; font-weight: 600; color: #2b2d42; margin-bottom: 4px; }
        .upload-subtitle { font-size: 11px; color: #94a3b8; margin-bottom: 16px; }
        
        .form-switch .form-check-input { width: 40px; height: 20px; background-color: #e2e8f0; border: none; transition: 0.3s; cursor: pointer; }
        .form-switch .form-check-input:checked { background-color: #10b981; }
        .form-switch .form-check-input:focus,
        .form-switch .form-check-input:active { 
            box-shadow: none !important; border: none !important; outline: none !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%28255, 255, 255, 1%29'/%3e%3c/svg%3e");
        }
        
        .toggle-label { font-size: 14px; font-weight: 600; color: #10b981; transition: 0.3s; margin-left: 8px; margin-top: 1px; cursor: pointer; }
        .toggle-label.habis { color: #ef4444; }

        .input-group-text.rp-text { 
            background-color: white; border: 1px solid #EBE3DB; border-right: none; 
            color: #64748b; font-weight: 600; font-size: 13px; 
            border-top-left-radius: 8px; border-bottom-left-radius: 8px; 
        }
        .input-rp { 
            border-left: none; padding-left: 0; 
            border-top-right-radius: 8px !important; border-bottom-right-radius: 8px !important; 
        }
        .input-rp:focus { border-left: none; }
        .input-group:focus-within .rp-text { border-color: #8a5a36; color: #8a5a36; }
        .input-group:focus-within .input-rp { border-color: #8a5a36; }
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
        <a href="/menu" class="active"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 4.99992L16.6667 16.6666M9.99999 4.99992V16.6666M6.66666 6.66659V16.6666M3.33333 3.33325V16.6666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Menu</a>
        <a href="/bahan-baku"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 18.3334V10.0001M10 10.0001L2.74167 5.83341M10 10.0001L17.2583 5.83341M6.25 3.55841L13.75 7.85008M9.16667 18.1084C9.42003 18.2547 9.70744 18.3317 10 18.3317C10.2926 18.3317 10.58 18.2547 10.8333 18.1084L16.6667 14.7751C16.9198 14.6289 17.13 14.4188 17.2763 14.1658C17.4225 13.9127 17.4997 13.6257 17.5 13.3334V6.66675C17.4997 6.37448 17.4225 6.08742 17.2763 5.83438C17.13 5.58134 16.9198 5.37122 16.6667 5.22508L10.8333 1.89175C10.58 1.74547 10.2926 1.66846 10 1.66846C9.70744 1.66846 9.42003 1.74547 9.16667 1.89175L3.33333 5.22508C3.08022 5.37122 2.86998 5.58134 2.72372 5.83438C2.57745 6.08742 2.5003 6.37448 2.5 6.66675V13.3334C2.5003 13.6257 2.57745 13.9127 2.72372 14.1658C2.86998 14.4188 3.08022 14.6289 3.33333 14.7751L9.16667 18.1084Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Bahan Baku</a>
        <a href="/laporan"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 2.5V15.8333C2.5 16.2754 2.67559 16.6993 2.98816 17.0118C3.30072 17.3244 3.72464 17.5 4.16667 17.5H17.5M5.83333 13.3333H12.5M5.83333 9.16667H15.8333M5.83333 5H8.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Laporan</a>
        <a href="/akun"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Akun</a>
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
        <h2 class="topbar-title">Menu</h2>
        <div class="clock-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6V12L16 14" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span id="realtime-clock">--:-- WIB</span>
        </div>
    </div>

    <!-- Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title">
            <h3 class="fw-bold mb-1" style="color: #2b2d42;">Menu</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">Kelola seluruh menu makanan dan minuman.</p>
        </div>
        <button class="btn-brown d-flex align-items-center gap-2" onclick="openTambahMenuModal()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Menu
        </button>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('menu.index') }}" class="d-flex align-items-center gap-3 mb-4" id="formFilterMenu">
        <div class="search-wrapper">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" id="searchInput" placeholder="Cari Nama Menu..." value="{{ request('search') }}" autocomplete="off">
        </div>
        
        <!-- Custom Dropdown Kategori -->
        <div class="position-relative filter-status-container" id="customDropdownKategori" style="min-width: 170px;">
            <input type="hidden" name="kategori" id="kategoriInput" value="{{ $kategori_filter }}">
            <button type="button" class="filter-box w-100" onclick="toggleDropdown('dropdownMenuKategori')">
                <span class="fw-medium" id="labelKategori">
                    {{ $kategori_filter == 'tak_berkategori' ? 'Tak Berkategori' : ($kategori_filter ?: 'Semua Kategori') }}
                </span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <ul class="dropdown-menu-custom position-absolute w-100 d-none" id="dropdownMenuKategori" style="top: 100%; left: 0; margin-top: 8px; margin-bottom: 0; z-index: 9999; background: white; list-style: none;">
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $kategori_filter == '' ? 'active' : '' }}" href="#" onclick="pilihKategori(event, '', 'Semua Kategori')">Semua Kategori</a></li>
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $kategori_filter == 'tak_berkategori' ? 'active' : '' }}" href="#" onclick="pilihKategori(event, 'tak_berkategori', 'Tak Berkategori')">Tak Berkategori</a></li>
                @foreach($kategoris as $k)
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $kategori_filter == $k->nama_kategori ? 'active' : '' }}" href="#" onclick="pilihKategori(event, '{{ $k->nama_kategori }}', '{{ $k->nama_kategori }}')">{{ $k->nama_kategori }}</a></li>
                @endforeach
            </ul>
        </div>

        <!-- Custom Dropdown Status -->
        <div class="position-relative filter-status-container" id="customDropdownStatus" style="min-width: 150px;">
            <input type="hidden" name="status" id="statusInput" value="{{ $status_filter }}">
            <button type="button" class="filter-box w-100" onclick="toggleDropdown('dropdownMenuStatus')">
                <span class="fw-medium" id="labelStatus">
                    {{ $status_filter ?: 'Semua Status' }}
                </span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <ul class="dropdown-menu-custom position-absolute w-100 d-none" id="dropdownMenuStatus" style="top: 100%; left: 0; margin-top: 8px; margin-bottom: 0; z-index: 9999; background: white; list-style: none;">
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == '' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, '', 'Semua Status')">Semua Status</a></li>
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == 'Tersedia' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Tersedia', 'Tersedia')">Tersedia</a></li>
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == 'Habis' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Habis', 'Habis')">Habis</a></li>
            </ul>
        </div>
        
        <div class="ms-auto">
            <span id="totalMenuBadge" class="badge border border-secondary-subtle text-dark bg-white rounded-pill px-3 py-2 fw-medium" style="font-size: 13px;">Total Menu: {{ $totalMenu }}</span>
        </div>
    </form>

    <!-- Menu Grid -->
    <div id="menuGridContainer">
        <div class="row g-4 mb-4">
            @forelse($menus as $menu)
            <div class="col-md-3">
                <div class="menu-card">
                    @if($menu->foto_menu)
                        <img src="{{ asset('storage/menus/' . $menu->foto_menu) }}" class="menu-img-placeholder" style="object-fit: cover;" alt="{{ $menu->nama_menu }}">
                    @else
                        <div class="menu-img-placeholder">{{ strtoupper(substr($menu->nama_menu, 0, 2)) }}</div>
                    @endif
                    
                    <h6 class="menu-title">{{ $menu->nama_menu }}</h6>
                    <div class="menu-category">{{ $menu->kategori ? $menu->kategori->nama_kategori : 'Tak Berkategori' }}</div>
                    
                    <div class="mt-auto">
                        <div class="menu-price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="badge-status {{ $menu->status == 'Tersedia' ? 'status-aktif' : 'status-habis' }}">{{ $menu->status }}</span>
                            
                            <div class="d-flex gap-2">
                                <!-- BUTTON YANG DIBIKIN ANTI ERROR -->
                                <button class="btn-card-action btn-edit-card" data-menu="{{ base64_encode(json_encode($menu)) }}" onclick="openEditMenuModal(this)">Edit</button>
                                <button class="btn-card-action btn-del-card" data-id="{{ $menu->id }}" data-nama="{{ $menu->nama_menu }}" onclick="openDeleteMenuModal(this)">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fw-medium">Belum ada menu yang ditemukan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="d-flex justify-content-end align-items-center mt-4">
        @if ($menus->hasPages())
        <ul class="pagination mb-0 gap-1">
            @foreach ($menus->linkCollection() as $link)
                @if ($loop->first)
                    @if ($link['url'])
                        <li class="page-item"><a class="page-link d-flex align-items-center justify-content-center" href="{{ $link['url'] }}" style="width: 32px; height: 32px; padding: 0; color: #8a5a36;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></span></li>
                    @endif
                @elseif ($loop->last)
                    @if ($link['url'])
                        <li class="page-item"><a class="page-link d-flex align-items-center justify-content-center" href="{{ $link['url'] }}" style="width: 32px; height: 32px; padding: 0; color: #8a5a36;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span></li>
                    @endif
                @else
                    @if ($link['active'])
                        <li class="page-item active"><span class="page-link d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;">{{ $link['label'] }}</span></li>
                    @elseif ($link['url'] === null)
                        <li class="page-item disabled"><span class="page-link d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;">...</span></li>
                    @else
                        <li class="page-item"><a class="page-link d-flex align-items-center justify-content-center" href="{{ $link['url'] }}" style="width: 32px; height: 32px; padding: 0; color: #64748b;">{{ $link['label'] }}</a></li>
                    @endif
                @endif
            @endforeach
        </ul>
        @endif
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. Modal Tambah Menu -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Tambah Menu</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <hr style="border-color: #EBE3DB; margin: 0 0 20px 0;">
            
            <div class="modal-body p-0">
                <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" id="formTambahMenu" onsubmit="clearMenuSession()">
                    @csrf
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label-custom">Nama Menu</label>
                            <input type="text" name="nama_menu" id="tambah_nama" class="form-control" placeholder="Contoh: Kopi Susu Dari" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Kategori</label>
                            <select name="kategori_menu_id" id="tambah_kategori" class="form-select">
                                <option value="" selected>Tak Berkategori</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <div class="text-end mt-1">
                                <a href="#" class="text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 12px; color: #8a5a36; font-weight:600;" onclick="bukaKelolaKategori('modalTambah')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                    Kelola Kategori
                                </a>
                            </div>
                        </div>

                        <div class="col-12"><hr style="border-color: #EBE3DB; margin: 8px 0;"></div>
                        
                        <div class="col-6 mt-1">
                            <label class="form-label-custom">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text rp-text">Rp</span>
                                <input type="text" id="input_harga_tambah" class="form-control input-rp" placeholder="Masukkan harga" onkeyup="formatRupiahUI(this)" required>
                                <input type="hidden" name="harga" id="real_harga_tambah">
                            </div>
                        </div>
                        
                        <!-- FIX STATUS ADA DI SINI -->
                        <div class="col-6 mt-1">
                            <label class="form-label-custom">Status</label>
                            <div class="form-check form-switch d-flex align-items-center mt-1 ps-0 gap-1">
                                <input type="hidden" name="status" value="Habis">
                                <input class="form-check-input ms-0 mt-0" type="checkbox" name="status" value="Tersedia" id="switchTambah" checked onchange="toggleStatusText('switchTambah', 'labelTambah')">
                                <label class="form-check-label toggle-label" id="labelTambah" for="switchTambah">Tersedia</label>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="form-label-custom">Foto Menu</label>
                            <input type="file" name="foto_menu" id="fileFotoTambah" accept=".jpg,.png,.jpeg" class="d-none" onchange="previewImage(this, 'previewImgTambah', 'uploadUI_Tambah')">
                            
                            <div class="upload-area" id="uploadUI_Tambah" onclick="document.getElementById('fileFotoTambah').click()">
                                <svg class="upload-icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <div class="upload-title">Unggah Foto Menu</div>
                                <div class="upload-subtitle">Format JPG atau PNG • Maksimal 2 MB</div>
                                <button type="button" class="btn-brown rounded-3 px-4 py-2" style="font-size: 13px;">Pilih Gambar</button>
                            </div>

                            <div id="previewImgTambah" class="d-none position-relative mt-2 text-center">
                                <img src="" alt="Preview" class="img-fluid rounded-4" style="max-height: 200px; border: 1px solid #EBE3DB;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 start-50 translate-middle-x mt-2 rounded-3 shadow" onclick="hapusPreview('fileFotoTambah', 'previewImgTambah', 'uploadUI_Tambah', event)">Hapus Foto</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end mt-4 pt-2">
                        <button type="button" class="btn btn-light border px-4 py-2 rounded-3 me-2" data-bs-dismiss="modal" style="font-weight: 500; font-size: 14px;">Batal</button>
                        <button type="submit" class="btn-brown px-4 py-2" style="font-size: 14px;">Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Edit Menu -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Edit Menu</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <hr style="border-color: #EBE3DB; margin: 0 0 20px 0;">
            
            <div class="modal-body p-0">
                <form id="formEditMenu" method="POST" enctype="multipart/form-data" onsubmit="clearMenuSession()">
                    @csrf @method('PUT')
                    
                    <!-- INPUT SILUMAN BUAT NGASIH TAU CONTROLLER FOTO MAU DIHAPUS -->
                    <input type="hidden" name="hapus_foto_lama" id="hapus_foto_lama" value="0">
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label-custom">Nama Menu</label>
                            <input type="text" name="nama_menu" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Kategori</label>
                            <select name="kategori_menu_id" id="edit_kategori" class="form-select">
                                <option value="">Tak Berkategori</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <div class="text-end mt-1">
                                <a href="#" class="text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 12px; color: #8a5a36; font-weight:600;" onclick="bukaKelolaKategori('modalEdit')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                    Kelola Kategori
                                </a>
                            </div>
                        </div>

                        <div class="col-12"><hr style="border-color: #EBE3DB; margin: 8px 0;"></div>
                        
                        <div class="col-6 mt-1">
                            <label class="form-label-custom">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text rp-text">Rp</span>
                                <input type="text" id="input_harga_edit" class="form-control input-rp" onkeyup="formatRupiahUI(this)" required>
                                <input type="hidden" name="harga" id="real_harga_edit">
                            </div>
                        </div>

                        <!-- FIX STATUS ADA DI SINI -->
                        <div class="col-6 mt-1">
                            <label class="form-label-custom">Status</label>
                            <div class="form-check form-switch d-flex align-items-center mt-1 ps-0 gap-1">
                                <input type="hidden" name="status" value="Habis">
                                <input class="form-check-input ms-0 mt-0" type="checkbox" name="status" value="Tersedia" id="switchEdit" onchange="toggleStatusText('switchEdit', 'labelEdit')">
                                <label class="form-check-label toggle-label" id="labelEdit" for="switchEdit">Tersedia</label>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="form-label-custom">Foto Menu</label>
                            <input type="file" name="foto_menu" id="fileFotoEdit" accept=".jpg,.png,.jpeg" class="d-none" onchange="previewImage(this, 'previewImgEdit', 'uploadUI_Edit')">
                            
                            <div class="upload-area" id="uploadUI_Edit" onclick="document.getElementById('fileFotoEdit').click()">
                                <svg class="upload-icon" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <div class="upload-title">Ubah Foto Menu</div>
                                <div class="upload-subtitle">Format JPG atau PNG • Maksimal 2 MB</div>
                                <button type="button" class="btn-brown rounded-3 px-4 py-2" style="font-size: 13px;">Pilih Gambar Baru</button>
                            </div>

                            <div id="previewImgEdit" class="d-none position-relative mt-2 text-center">
                                <img src="" alt="Preview" class="img-fluid rounded-4" style="max-height: 200px; border: 1px solid #EBE3DB;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 start-50 translate-middle-x mt-2 rounded-3 shadow" onclick="hapusPreview('fileFotoEdit', 'previewImgEdit', 'uploadUI_Edit', event)">Hapus Foto</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end mt-4 pt-2">
                        <button type="button" class="btn btn-light border px-4 py-2 rounded-3 me-2" data-bs-dismiss="modal" style="font-weight: 500; font-size: 14px;">Batal</button>
                        <button type="submit" class="btn-brown px-4 py-2" style="font-size: 14px;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 3. Modal Hapus Menu -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Hapus Menu</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <hr style="border-color: #EBE3DB; margin: 0 0 24px 0;">
            <div class="modal-body p-0 text-center">
                <div class="mb-4">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#e75343" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h5 class="mb-3" style="color: #2b2d42; font-size: 18px; font-weight: 500;">
                    Hapus <span id="hapus_item_nama" class="fw-bold"></span>?
                </h5>
                <p class="text-muted mb-1" style="font-size: 14px;">Menu beserta fotonya akan dihapus permanen.</p>
                <p class="text-muted mb-4" style="font-size: 14px;">Pastikan menu ini sudah tidak digunakan</p>
                
                <form id="formHapusItem" method="POST" class="d-flex justify-content-end gap-2 mt-4 pt-2">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-light border px-4 py-2 rounded-3" data-bs-dismiss="modal" style="font-weight: 500; font-size: 14px;">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 py-2 rounded-3" style="font-weight: 500; font-size: 14px; background-color: #E75343; border-color: #E75343;">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 4. Modal Kelola Kategori -->
<div class="modal fade" id="modalKategori" tabindex="-1" style="z-index: 1060;" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Kelola Kategori</h4>
                <button type="button" class="btn-close" onclick="tutupKelolaKategori()"></button>
            </div>
            <hr style="border-color: #EBE3DB; margin: 0 0 20px 0;">
            <div class="modal-body p-0">
                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #2b2d42;">Tambah Kategori</h6>
                <form action="{{ route('kategori_menu.store') }}" method="POST" class="mb-4">
                    @csrf
                    <label class="form-label text-muted mb-1" style="font-size: 12px;">Nama Kategori</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan nama kategori..." required autocomplete="off">
                        <button type="submit" class="btn-brown px-4 d-flex align-items-center gap-1" style="white-space: nowrap;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Tambah
                        </button>
                    </div>
                </form>
                <hr style="border-color: #EBE3DB; margin: 24px 0 20px 0;">
                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #2b2d42;">Daftar Kategori ({{ $kategoris->count() }})</h6>
                <div style="max-height: 250px; overflow-y: auto; padding-right: 4px;">
                    @foreach($kategoris as $k)
                    <div class="kategori-list-item" id="kat_row_{{ $k->id }}" style="background-color: #FCF9F6; border: 1px solid #EBE3DB; border-radius: 10px; padding: 12px 16px; margin-bottom: 12px;">
                        <div class="view-state w-100 d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="font-size: 14px; color: #2b2d42;">{{ $k->nama_kategori }} ({{ $k->menus_count ?? 0 }})</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="action-btn btn-edit-icon" onclick="editKategori({{ $k->id }}, '{{ $k->nama_kategori }}')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button type="button" class="action-btn btn-del-icon" onclick="hapusKategori({{ $k->id }}, '{{ $k->nama_kategori }}')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </div>
                        </div>
                        <form action="{{ route('kategori_menu.update', $k->id) }}" method="POST" class="edit-state w-100 d-none justify-content-between align-items-center">
                            @csrf @method('PUT')
                            <input type="text" name="nama_kategori_baru" class="form-control me-2" id="input_kat_{{ $k->id }}" required>
                            <div class="d-flex gap-2">
                                <button type="submit" class="action-btn" style="background:#dcfce7; color:#10b981;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </button>
                                <button type="button" class="action-btn btn-del-icon" onclick="cancelEditKategori({{ $k->id }})">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer border-0 p-0 mt-4 d-flex justify-content-end">
                <button type="button" class="btn-brown px-4 py-2 rounded-3" onclick="tutupKelolaKategori()" style="font-size: 14px;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- 5. Modal Hapus Kategori -->
<div class="modal fade" id="modalHapusKategori" tabindex="-1" style="z-index: 1070;" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Hapus Kategori</h4>
                <button type="button" class="btn-close" onclick="batalHapusKategori()"></button>
            </div>
            <hr style="border-color: #EBE3DB; margin: 0 0 24px 0;">
            <div class="modal-body p-0 text-center">
                <div class="mb-4">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#e75343" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h5 class="mb-3" style="color: #2b2d42; font-size: 18px; font-weight: 500;">
                    Hapus kategori <span id="nama_kat_del" class="fw-bold"></span>?
                </h5>
                <p class="text-muted mb-1" style="font-size: 14px;">Item dalam kategori ini akan diubah menjadi <span class="fw-bold">Tak Berkategori</span>.</p>
                <p class="text-muted mb-4" style="font-size: 14px;">Apakah anda yakin ingin menghapus kategori ini?</p>
                <form id="formHapusKategori" method="POST" class="d-flex justify-content-end gap-2 mt-4 pt-2">
                     @csrf @method('DELETE')
                     <button type="button" class="btn btn-light border px-4 py-2 rounded-3" onclick="batalHapusKategori()" style="font-weight: 500; font-size: 14px;">Batal</button>
                     <button type="submit" class="btn btn-danger px-4 py-2 rounded-3" style="font-weight: 500; font-size: 14px; background-color: #E75343; border-color: #E75343;">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ==========================================
    // JS KHUSUS UI MENU (HARGA & GAMBAR)
    // ==========================================
    function formatRupiahUI(inputElement) {
        let rawValue = inputElement.value.replace(/[^,\d]/g, '').toString();
        let splitValue = rawValue.split(',');
        let sisa = splitValue[0].length % 3;
        let rupiah = splitValue[0].substr(0, sisa);
        let ribuan = splitValue[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');
        rupiah = splitValue[1] != undefined ? rupiah + ',' + splitValue[1] : rupiah;
        inputElement.value = rupiah;
        document.getElementById(inputElement.id === 'input_harga_tambah' ? 'real_harga_tambah' : 'real_harga_edit').value = rawValue;
    }

    function toggleStatusText(switchId, labelId) {
        let toggle = document.getElementById(switchId);
        let label = document.getElementById(labelId);
        if (toggle.checked) {
            label.textContent = "Tersedia"; label.classList.remove("habis"); toggle.value = "Tersedia";
        } else {
            label.textContent = "Habis"; label.classList.add("habis"); toggle.value = "Habis";
        }
    }

    function previewImage(input, imgDivId, uploadUiId) {
        let previewDiv = document.getElementById(imgDivId);
        let uploadArea = document.getElementById(uploadUiId);
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                previewDiv.querySelector('img').src = e.target.result;
                uploadArea.classList.add('d-none');
                previewDiv.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

   function hapusPreview(inputId, imgDivId, uploadUiId, event) {
        event.stopPropagation();
        document.getElementById(inputId).value = "";
        document.getElementById(imgDivId).classList.add('d-none');
        document.getElementById(uploadUiId).classList.remove('d-none');

        // Kalau yang dipencet hapus itu di form EDIT, aktifkan flag silumannya!
        if (inputId === 'fileFotoEdit') {
            document.getElementById('hapus_foto_lama').value = "1";
        }
    }

    // ==========================================
    // JS MODAL BERTINGKAT (SISTEM ANTREAN PRO MAX)
    // ==========================================
    let originModal = sessionStorage.getItem('originModalMenu') || 'modalTambah'; 
    let queuedModal = null; 

    document.addEventListener('hidden.bs.modal', function (event) {
        if (queuedModal) {
            bootstrap.Modal.getOrCreateInstance(document.getElementById(queuedModal)).show();
            queuedModal = null; 
        } else {
            if (!document.querySelector('.modal.show')) {
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = '';
                document.body.style.overflow = '';
                
                sessionStorage.removeItem('originModalMenu');
                sessionStorage.removeItem('editMenuData'); 
                sessionStorage.removeItem('tambahMenuData'); 
            }
        }
    });

    function bukaKelolaKategori(asal) {
        originModal = asal; 
        sessionStorage.setItem('originModalMenu', asal); 
        
        if (asal === 'modalEdit') {
            let currentEditData = {
                id: document.getElementById('formEditMenu').action.split('/').pop(),
                nama_menu: document.getElementById('edit_nama').value,
                kategori_menu_id: document.getElementById('edit_kategori').value,
                harga: document.getElementById('real_harga_edit').value,
                status: document.getElementById('switchEdit').checked ? 'Tersedia' : 'Habis'
            };
            sessionStorage.setItem('editMenuData', JSON.stringify(currentEditData));
        } else if (asal === 'modalTambah') {
            let currentTambahData = {
                nama_menu: document.getElementById('tambah_nama').value,
                kategori_menu_id: document.getElementById('tambah_kategori').value,
                harga: document.getElementById('real_harga_tambah').value,
                status: document.getElementById('switchTambah').checked ? 'Tersedia' : 'Habis'
            };
            sessionStorage.setItem('tambahMenuData', JSON.stringify(currentTambahData));
        }
        queuedModal = 'modalKategori'; 
        let modalAsal = bootstrap.Modal.getInstance(document.getElementById(asal));
        if(modalAsal) modalAsal.hide(); 
    }

    function tutupKelolaKategori() {
        queuedModal = originModal; 
        let modKat = bootstrap.Modal.getInstance(document.getElementById('modalKategori'));
        if(modKat) modKat.hide();
    }

    function hapusKategori(id, nama) {
        document.getElementById('nama_kat_del').innerText = nama;
        document.getElementById('formHapusKategori').action = `/menu/kategori/${id}`; 
        queuedModal = 'modalHapusKategori'; 
        let modKat = bootstrap.Modal.getInstance(document.getElementById('modalKategori'));
        if(modKat) modKat.hide();
    }

    function batalHapusKategori() {
        queuedModal = 'modalKategori'; 
        let modHapus = bootstrap.Modal.getInstance(document.getElementById('modalHapusKategori'));
        if(modHapus) modHapus.hide();
    }

    function editKategori(id, nama) {
        document.querySelector(`#kat_row_${id} .view-state`).classList.add('d-none');
        document.querySelector(`#kat_row_${id} .edit-state`).classList.remove('d-none');
        document.querySelector(`#kat_row_${id} .edit-state`).classList.add('d-flex');
        document.getElementById(`input_kat_${id}`).value = nama;
    }
    function cancelEditKategori(id) {
        document.querySelector(`#kat_row_${id} .view-state`).classList.remove('d-none');
        document.querySelector(`#kat_row_${id} .edit-state`).classList.add('d-none');
        document.querySelector(`#kat_row_${id} .edit-state`).classList.remove('d-flex');
    }

    // ==========================================
    // JS PASSING DATA KE MODAL EDIT & HAPUS
    // (Udah anti-error 100% dari tanda kutip di nama menu)
    // ==========================================
    function openEditMenuModal(btnElement) {
        let item = JSON.parse(atob(btnElement.getAttribute('data-menu')));
        sessionStorage.setItem('editMenuData', JSON.stringify(item));
        
        document.getElementById('formEditMenu').action = `/menu/${item.id}`;
        document.getElementById('edit_nama').value = item.nama_menu;
        document.getElementById('edit_kategori').value = item.kategori_menu_id || "";
        
        // Reset flag hapus foto tiap kali modal edit dibuka
        document.getElementById('hapus_foto_lama').value = "0";
        
        let inputHarga = document.getElementById('input_harga_edit');
        inputHarga.value = item.harga; 
        formatRupiahUI(inputHarga); 

        let toggle = document.getElementById('switchEdit');
        toggle.checked = item.status === 'Tersedia';
        toggleStatusText('switchEdit', 'labelEdit');

        document.getElementById('fileFotoEdit').value = "";
        document.getElementById('previewImgEdit').classList.add('d-none');
        document.getElementById('uploadUI_Edit').classList.remove('d-none');

        if(item.foto_menu) {
            document.querySelector('#previewImgEdit img').src = `/storage/menus/${item.foto_menu}`;
            document.getElementById('uploadUI_Edit').classList.add('d-none');
            document.getElementById('previewImgEdit').classList.remove('d-none');
        }
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    function openDeleteMenuModal(btnElement) {
        let id = btnElement.getAttribute('data-id');
        let nama = btnElement.getAttribute('data-nama');
        
        document.getElementById('hapus_item_nama').innerText = nama;
        document.getElementById('formHapusItem').action = `/menu/${id}`;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }

    function openTambahMenuModal() {
        // Hapus sisa data session jika ada
        clearMenuSession();
        
        // Reset form
        document.getElementById('formTambahMenu').reset();
        document.getElementById('real_harga_tambah').value = '';
        document.getElementById('input_harga_tambah').value = '';
        document.getElementById('fileFotoTambah').value = '';
        
        // Reset foto preview
        document.getElementById('previewImgTambah').classList.add('d-none');
        document.getElementById('uploadUI_Tambah').classList.remove('d-none');
        
        // Reset status switch
        document.getElementById('switchTambah').checked = true;
        toggleStatusText('switchTambah', 'labelTambah');

        new bootstrap.Modal(document.getElementById('modalTambah')).show();
    }

    function clearMenuSession() {
        sessionStorage.removeItem('originModalMenu');
        sessionStorage.removeItem('tambahMenuData');
        sessionStorage.removeItem('editMenuData');
    }

    // ==========================================
    // JS RESTORE DATA JIKA HABIS RELOAD KELOLA KATEGORI
    // ==========================================
    document.addEventListener("DOMContentLoaded", function() {
        let origin = sessionStorage.getItem('originModalMenu');
        
        if (origin === 'modalEdit') {
            let savedData = sessionStorage.getItem('editMenuData');
            if (savedData) {
                let item = JSON.parse(savedData);
                document.getElementById('formEditMenu').action = `/menu/${item.id}`;
                document.getElementById('edit_nama').value = item.nama_menu;
                document.getElementById('edit_kategori').value = item.kategori_menu_id || "";
                
                let inputHarga = document.getElementById('input_harga_edit');
                inputHarga.value = item.harga; 
                if(item.harga) formatRupiahUI(inputHarga); 

                let toggle = document.getElementById('switchEdit');
                toggle.checked = item.status === 'Tersedia';
                toggleStatusText('switchEdit', 'labelEdit');
            }
        } else if (origin === 'modalTambah') {
            let savedData = sessionStorage.getItem('tambahMenuData');
            if (savedData) {
                let item = JSON.parse(savedData);
                document.getElementById('tambah_nama').value = item.nama_menu;
                document.getElementById('tambah_kategori').value = item.kategori_menu_id || "";
                
                let inputHarga = document.getElementById('input_harga_tambah');
                inputHarga.value = item.harga; 
                if(item.harga) formatRupiahUI(inputHarga); 

                let toggle = document.getElementById('switchTambah');
                toggle.checked = item.status === 'Tersedia';
                toggleStatusText('switchTambah', 'labelTambah');
            }
        }
    });
</script>

<!-- Auto-open Kategori Modal -->
@if(session('open_kategori'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new bootstrap.Modal(document.getElementById('modalKategori')).show();
        });
    </script>
@endif

<!-- Script Jam Real-Time -->
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

<!-- Script Real-Time AJAX Search -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const kategoriFilter = document.getElementById('kategoriFilter');
    const statusFilter = document.getElementById('statusFilter');
    const formFilterMenu = document.getElementById('formFilterMenu');
    
    let debounceTimer;

    function fetchFilteredData(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Ganti isi Grid
                document.getElementById('menuGridContainer').innerHTML = doc.getElementById('menuGridContainer').innerHTML;
                
                // Ganti isi Pagination
                document.getElementById('paginationContainer').innerHTML = doc.getElementById('paginationContainer').innerHTML;
                
                // Update Badge Total Menu
                const oldTotal = document.getElementById('totalMenuBadge');
                const newTotal = doc.getElementById('totalMenuBadge');
                if (oldTotal && newTotal) {
                    oldTotal.innerHTML = newTotal.innerHTML;
                }
                
                // Pasang lagi event click pada link pagination yang baru
                attachPaginationListeners();
            })
            .catch(err => console.error("Gagal mengambil data:", err));
    }

    function triggerSearch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const formData = new FormData(formFilterMenu);
            const params = new URLSearchParams(formData);
            const url = formFilterMenu.action + '?' + params.toString();
            
            // Update URL di browser tanpa reload (supaya kalau di-refresh tetap jalan)
            window.history.replaceState({}, '', url);
            
            fetchFilteredData(url);
        }, 300); // 300ms delay agar tidak fetch saat user sedang ngetik
    }
    
    // Expose ke global supaya bisa dipanggil onclick dropdown
    window.triggerSearch = triggerSearch;

    // Pasang Event Listeners
    if (searchInput) searchInput.addEventListener('input', triggerSearch);
    
    if (formFilterMenu) {
        formFilterMenu.addEventListener('submit', function(e) {
            e.preventDefault();
            triggerSearch();
        });
    }

    // Tangani Pagination pakai AJAX juga!
    function attachPaginationListeners() {
        document.querySelectorAll('#paginationContainer .page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url) {
                    window.history.replaceState({}, '', url);
                    fetchFilteredData(url);
                }
            });
        });
    }
    
    attachPaginationListeners();
});

// Dropdown filter JS
function toggleDropdown(id) {
    document.querySelectorAll('.dropdown-menu-custom').forEach(el => {
        if(el.id !== id) el.classList.add('d-none');
    });
    document.getElementById(id).classList.toggle('d-none');
}

function pilihKategori(event, val, label) {
    event.preventDefault();
    document.getElementById('kategoriInput').value = val;
    document.getElementById('labelKategori').innerText = label;
    document.getElementById('dropdownMenuKategori').classList.add('d-none');
    
    document.querySelectorAll('#dropdownMenuKategori .dropdown-item-custom').forEach(el => el.classList.remove('active'));
    event.target.classList.add('active');
    
    if (window.triggerSearch) window.triggerSearch();
}

function pilihStatus(event, val, label) {
    event.preventDefault();
    document.getElementById('statusInput').value = val;
    document.getElementById('labelStatus').innerText = label;
    document.getElementById('dropdownMenuStatus').classList.add('d-none');
    
    document.querySelectorAll('#dropdownMenuStatus .dropdown-item-custom').forEach(el => el.classList.remove('active'));
    event.target.classList.add('active');
    
    if (window.triggerSearch) window.triggerSearch();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-status-container')) {
        document.querySelectorAll('.dropdown-menu-custom').forEach(el => el.classList.add('d-none'));
    }
});
</script>

</body>
</html>
