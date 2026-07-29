<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bahan Baku - DariKopi</title>
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
        .nav-menu a {
            display: flex; align-items: center; padding: 12px;
            color: #64748b; text-decoration: none; font-size: 15px; font-weight: 500; 
            border-radius: 12px; transition: all 0.2s ease; position: relative; margin: 0 12px;
        }
        .nav-menu a svg { flex-shrink: 0; margin-right: 12px; }
        .nav-menu a:hover { color: #8a5a36; background-color: #faf7f5; }
        
        .nav-menu .active { background-color: #EBE1D7; color: #8a5a36; font-weight: 600; padding-left: 30px; }
        .nav-menu .active::before {
            content: ""; position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            width: 4px; height: 24px; background-color: #8a5a36; border-radius: 10px;
        }

        .user-card {
            background: #ffffff; border: 1px solid #f1f5f9; border-radius: 12px;
            padding: 12px 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 16px;
        }
        .user-name { font-size: 13px; font-weight: 700; color: #2b2d42; margin-bottom: 2px;}
        .user-role { font-size: 11px; color: #94a3b8; }
        
        .btn-logout {
            display: flex; justify-content: left; align-items: center; gap: 12px;
            width: 100%; padding: 12px; border-radius: 12px; background: transparent; 
            border: 1px solid #E8DDD2; color: #8a5a36; font-weight: 600; font-size: 15px; 
            text-decoration: none; transition: 0.2s;
        }
        .btn-logout:hover { background: #faf7f5; border-color: #8a5a36; color: #8a5a36; }
        
        /* ================= MAIN CONTENT ================= */
        .main-content { margin-left: 240px; padding: 24px 32px; }
        
        .topbar { 
            display: flex; justify-content: space-between; align-items: center; 
            background-color: #ffffff; padding: 20px 32px; 
            margin: -24px -32px 32px -32px; border-bottom: 1px solid #EBE3DB;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 24px; font-weight: 700; color: #262626; margin: 0; }
        
        .clock-badge {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; background-color: #ffffff; 
            border: 1px solid #E8DDD2; border-radius: 12px;
            color: #262626; font-weight: 500; font-size: 14px;
        }
        
        .btn-brown { background-color: #8a5a36; color: white; font-weight: 500; border-radius: 10px; padding: 10px 20px; border: none; transition: 0.2s; }
        .btn-brown:hover { background-color: #734a2c; color: white; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #EBE3DB; font-size: 13px; padding: 10px 16px; box-shadow: none; }
        .form-control:focus, .form-select:focus { border-color: #8a5a36; box-shadow: none; }
        
        .stat-card { background: white; border-radius: 16px; padding: 20px; border: none; box-shadow: 0 4px 15px rgba(138,90,54,0.03); }
        .stat-title { font-size: 13px; color: #2b2d42; font-weight: 600; margin-bottom: 12px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #2b2d42; margin-bottom: 4px; }
        .stat-desc { font-size: 11px; color: #94a3b8; }
        .text-aman { color: #10b981; } .text-menipis { color: #f59e0b; } .text-habis { color: #ef4444; }
        
        .table-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 15px rgba(138,90,54,0.03); }
        .table-custom { width: 100%; font-size: 13px; }
        .table-custom th { color: #64748b; font-weight: 500; padding: 12px 16px; border-bottom: 1px solid #EBE3DB; background-color: #faf7f5; }
        .table-custom td { padding: 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        .badge-aman { background-color: #dcfce7; color: #10b981; padding: 6px 12px; border-radius: 20px; font-weight: 600; border: none;}
        .badge-menipis { background-color: #fef3c7; color: #d97706; padding: 6px 12px; border-radius: 20px; font-weight: 600; border: none;}
        .badge-habis { background-color: #fee2e2; color: #ef4444; padding: 6px 12px; border-radius: 20px; font-weight: 600; border: none;}
        
        .action-btn { width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; margin-right: 4px;}
        .btn-edit-icon { background-color: #F4EFEA; color: #8a5a36; }
        .btn-del-icon { background-color: #fee2e2; color: #ef4444; }
        
        .pagination .page-item .page-link { border: 1px solid #EBE3DB; color: #94a3b8; border-radius: 8px; margin: 0 4px; font-size: 13px; font-weight: 500; }
        .pagination .page-item.active .page-link { background-color: #8a5a36; border-color: #8a5a36; color: white; }
        .pagination .page-link:focus { box-shadow: 0 0 0 0.25rem rgba(138, 90, 54, 0.25); color: #8a5a36; }
        .pagination .page-link:hover { color: #8a5a36; background-color: #FCF9F6; border-color: #EBE3DB; }
        
        .modal-content { border-radius: 20px; border: none; padding: 16px; }
        .modal-header { border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; }
        .modal-title { font-size: 20px; font-weight: 600; }
        .kategori-list-item { background: #faf7f5; border: 1px solid #EBE3DB; border-radius: 10px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;}

        /* Form Custom */
        .form-label-custom { color: #4b5563; font-weight: 500; font-size: 13px; margin-bottom: 6px; display: block; }
        
        .input-stok-wrapper {
            display: flex; align-items: center;
            border: 1px solid #EBE3DB; border-radius: 8px;
            background-color: #ffffff; transition: all 0.2s ease;
        }
        .input-stok-wrapper:focus-within { border-color: #8a5a36; }
        .input-stok-wrapper input {
            border: none; background: transparent; box-shadow: none;
            font-size: 13px; padding: 10px 12px; width: 100%;
        }
        .input-stok-wrapper input:focus { outline: none; }
        .input-stok-wrapper .satuan-label {
            padding-right: 12px; font-weight: 600; color: #8a5a36;
            font-size: 13px; white-space: nowrap;
        }
        .input-stok-wrapper.is-disabled { background-color: #F4EFEA; border-color: #E8DDD2; }
        .input-stok-wrapper.is-disabled input::placeholder { color: #a8a29e; }

        .search-wrapper { display: flex; align-items: center; border: 1px solid #EBE3DB; border-radius: 8px; background-color: #ffffff; padding: 0 16px; transition: all 0.2s ease; width: 300px; }
        .search-wrapper:focus-within { border-color: #8a5a36; }
        .search-wrapper input { border: none; background: transparent; box-shadow: none; padding: 10px 0 10px 12px; width: 100%; font-size: 13px; }
        .search-wrapper input:focus { outline: none; box-shadow: none; }
        .search-wrapper svg { color: #94a3b8; transition: 0.2s; }
        .search-wrapper:focus-within svg { color: #8a5a36; }

        /* --- Custom Dropdown Filters --- */
        .filter-box {
            background: white; border-radius: 12px; padding: 10px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border: 1px solid #EBE3DB; color: #64748b; font-size: 13px; cursor: pointer; transition: 0.2s; height: 100%;
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
        .btn-close:focus { box-shadow: 0 0 0 0.25rem rgba(138, 90, 54, 0.25); }
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
        <a href="/bahan-baku" class="active"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 18.3334V10.0001M10 10.0001L2.74167 5.83341M10 10.0001L17.2583 5.83341M6.25 3.55841L13.75 7.85008M9.16667 18.1084C9.42003 18.2547 9.70744 18.3317 10 18.3317C10.2926 18.3317 10.58 18.2547 10.8333 18.1084L16.6667 14.7751C16.9198 14.6289 17.13 14.4188 17.2763 14.1658C17.4225 13.9127 17.4997 13.6257 17.5 13.3334V6.66675C17.4997 6.37448 17.4225 6.08742 17.2763 5.83438C17.13 5.58134 16.9198 5.37122 16.6667 5.22508L10.8333 1.89175C10.58 1.74547 10.2926 1.66846 10 1.66846C9.70744 1.66846 9.42003 1.74547 9.16667 1.89175L3.33333 5.22508C3.08022 5.37122 2.86998 5.58134 2.72372 5.83438C2.57745 6.08742 2.5003 6.37448 2.5 6.66675V13.3334C2.5003 13.6257 2.57745 13.9127 2.72372 14.1658C2.86998 14.4188 3.08022 14.6289 3.33333 14.7751L9.16667 18.1084Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Bahan Baku</a>
        <a href="/laporan"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 2.5V15.8333C2.5 16.2754 2.67559 16.6993 2.98816 17.0118C3.30072 17.3244 3.72464 17.5 4.16667 17.5H17.5M5.83333 13.3333H12.5M5.83333 9.16667H15.8333M5.83333 5H8.33333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Laporan</a>
        <a href="/akun"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Akun</a>
    </div>
    
    <div class="mt-auto px-4">
        <div class="user-card">
            <div class="user-name">{{ auth()->user()->name }}</div>
        </div>
        <div style="border-top: 1px solid #EBE3DB; margin: 0 8px 16px 8px;"></div>
        <a href="#" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 5.83333L17.5 10L13.3333 14.1667M17.5 10H7.5M7.5 17.5H4.16667C3.72464 17.5 3.30072 17.3244 2.98816 17.0118C2.67559 16.6993 2.5 16.2754 2.5 15.8333V4.16667C2.5 3.72464 2.67559 3.30072 2.98816 2.98816C3.30072 2.67559 3.72464 2.5 4.16667 2.5H7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="topbar">
        <h2 class="topbar-title">Bahan Baku</h2>
        <div class="clock-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 6V12L16 14" stroke="#8C5E3C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span id="realtime-clock">--:-- WIB</span>
        </div>
    </div>

    <!-- Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title">
            <h3 class="fw-bold mb-1" style="color: #2b2d42;">Bahan Baku</h3>
            <p class="text-muted mb-0" style="font-size: 14px;">Kelola seluruh stok bahan baku dan perlengkapan kedai</p>
        </div>
        <button class="btn-brown d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Item
        </button>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('bahan-baku.index') }}" class="d-flex align-items-stretch gap-3 mb-4" id="formFilterBahanBaku" style="height: 42px;">
        <div class="search-wrapper" style="height: 100%; margin: 0; padding: 0 16px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" placeholder="Cari Nama Item..." value="{{ $search }}" onchange="this.form.submit()" autocomplete="off" style="padding: 0; padding-left: 12px;">
        </div>

        <!-- Custom Dropdown Kategori -->
        <div class="position-relative filter-status-container" id="customDropdownKategori" style="min-width: 170px; height: 100%;">
            <input type="hidden" name="kategori" id="kategoriInput" value="{{ $kategori_filter }}">
            <button type="button" class="filter-box w-100 m-0" onclick="toggleDropdown('dropdownMenuKategori')">
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
        <div class="position-relative filter-status-container" id="customDropdownStatus" style="min-width: 150px; height: 100%;">
            <input type="hidden" name="status" id="statusInput" value="{{ $status_filter }}">
            <button type="button" class="filter-box w-100 m-0" onclick="toggleDropdown('dropdownMenuStatus')">
                <span class="fw-medium" id="labelStatus">
                    {{ $status_filter ?: 'Semua Status' }}
                </span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <ul class="dropdown-menu-custom position-absolute w-100 d-none" id="dropdownMenuStatus" style="top: 100%; left: 0; margin-top: 8px; margin-bottom: 0; z-index: 9999; background: white; list-style: none;">
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == '' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, '', 'Semua Status')">Semua Status</a></li>
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == 'Aman' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Aman', 'Aman')">Aman</a></li>
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == 'Menipis' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Menipis', 'Menipis')">Menipis</a></li>
                <li><a class="dropdown-item-custom d-block text-decoration-none {{ $status_filter == 'Habis' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Habis', 'Habis')">Habis</a></li>
            </ul>
        </div>
    </form>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Total Item</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-desc">Item Terdaftar</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Stok Aman</div>
                <div class="stat-value">{{ $stats['aman'] }}</div>
                <div class="stat-desc text-aman fw-bold">Item</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Stok Menipis</div>
                <div class="stat-value">{{ $stats['menipis'] }}</div>
                <div class="stat-desc text-menipis fw-bold">Perlu Restock</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-title">Stok Habis</div>
                <div class="stat-value">{{ $stats['habis'] }}</div>
                <div class="stat-desc text-habis fw-bold">Segera Restock</div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <h6 class="fw-bold mb-3">Daftar Bahan Baku</h6>
        
        @php
            $formatUnit = [
                'kg'     => 'kilogram (kg)', 'gr'     => 'gram (gr)',
                'liter'  => 'liter (L)',     'ml'     => 'mililiter (ml)',
                'pack'   => 'pack (pck)',    'pcs'    => 'pieces (pcs)',
                'botol'  => 'botol (btl)',   'kaleng' => 'kaleng (klg)',
                'karton' => 'karton (ktn)',  'cup'    => 'cup (c)'
            ];
        @endphp

        <table class="table-custom">
            <thead>
                <tr>
                    <th style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">Nama Item</th>
                    <th>Kategori</th>
                    <th>Stok Saat Ini</th>
                    <th>Unit Besar</th>
                    <th>Unit Kecil</th>
                    <th>Status</th>
                    <th style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bahanBakus as $item)
                <tr>
                    <td class="fw-bold">{{ $item->nama_item }}</td>
                    <td>{{ $item->kategori ? $item->kategori->nama_kategori : 'Tak Berkategori' }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark">{{ $item->stok_saat_ini_besar }} {{ $item->unit_besar }}</span>
                            @if($item->unit_kecil && $item->unit_kecil !== '-')
                            <span class="text-muted" style="font-size: 11px;">{{ $item->stok_saat_ini_kecil }} {{ $item->unit_kecil }}</span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $formatUnit[$item->unit_besar] ?? $item->unit_besar }}</td>
                    <td>{{ $item->unit_kecil ? ($formatUnit[$item->unit_kecil] ?? $item->unit_kecil) : '-' }}</td>
                    <td>
                        @if($item->status_stok == 'Aman') <span class="badge-aman">Aman</span>
                        @elseif($item->status_stok == 'Menipis') <span class="badge-menipis">Menipis</span>
                        @else <span class="badge-habis">Habis</span>
                        @endif
                    </td>
                    <td>
                        <button class="action-btn btn-edit-icon" onclick='openEditModal(@json($item))'>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <button class="action-btn btn-del-icon" onclick='openDeleteModal({{ $item->id }}, @json($item->nama_item))'>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <small class="text-muted">Menampilkan {{ $bahanBakus->firstItem() ?? 0 }} - {{ $bahanBakus->lastItem() ?? 0 }} dari {{ $bahanBakus->total() }} item</small>
            @if ($bahanBakus->hasPages())
            <ul class="pagination mb-0 gap-1">
                @foreach ($bahanBakus->linkCollection() as $link)
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
</div>

<!-- ================= MODALS ================= -->

<!-- 1. Modal Tambah Item -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bahan-baku.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label-custom">Nama Item</label>
                            <input type="text" name="nama_item" class="form-control" placeholder="Nama Bahan Baku" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Kategori</label>
                            <select name="kategori_bahan_id" id="tambah_kategori" class="form-select">
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
                        
                        <div class="col-12">
                            <h5 class="fw-bold mb-1" style="color: #2b2d42;">Unit & Konversi</h5>
                            <small class="text-dark" style="font-size: 12px;">Pilih satuan dan tentukan nilai konversinya.</small>
                        </div>
                        
                        <div class="col-12"><div style="border-top: 1px solid #f1f5f9; margin: 4px 0;"></div></div>
                        
                        <div class="col-6">
                            <label class="form-label-custom">Unit Besar</label>
                            <select name="unit_besar" id="tambah_unit_besar" class="form-select" required onchange="updateUnitLabels()">
                                <option value="" hidden selected>Pilih Satuan Besar</option>
                                <option value="kg">kilogram (kg)</option>
                                <option value="gr">gram (gr)</option>
                                <option value="liter">liter (L)</option>
                                <option value="ml">mililiter (ml)</option>
                                <option value="pack">pack (pck)</option>
                                <option value="pcs">pieces (pcs)</option>
                                <option value="botol">botol (btl)</option>
                                <option value="kaleng">kaleng (klg)</option>
                                <option value="karton">karton (ktn)</option>
                                <option value="cup">cup (c)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Unit Kecil <span class="text-muted fw-normal" style="font-size: 11px;">(Opsional)</span></label>
                            <select name="unit_kecil" id="tambah_unit_kecil" class="form-select" onchange="updateUnitLabels()">
                                <option value="" selected>Tidak ada (Opsional)</option>
                                <option value="kg">kilogram (kg)</option>
                                <option value="gr">gram (gr)</option>
                                <option value="liter">liter (L)</option>
                                <option value="ml">mililiter (ml)</option>
                                <option value="pack">pack (pck)</option>
                                <option value="pcs">pieces (pcs)</option>
                                <option value="botol">botol (btl)</option>
                                <option value="kaleng">kaleng (klg)</option>
                                <option value="karton">karton (ktn)</option>
                                <option value="cup">cup (c)</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Isi per Unit Besar (Konversi) <span class="text-muted fw-normal" style="font-size: 11px;">(Opsional)</span></label>
                            <div class="input-stok-wrapper is-disabled" id="wrapper_konversi_tambah">
                                <input type="number" name="konversi" id="input_konversi_tambah" placeholder="Misal: 12 (Jika 1 Karton = 12 Pcs)" disabled>
                            </div>
                            <small class="text-muted" style="font-size: 11px; margin-top: 4px; display: block;">Hanya diisi jika Anda memilih Unit Kecil (Misal: 1 karton isi 12 pcs).</small>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Minimal Stok</label>
                            <div class="input-stok-wrapper is-disabled" id="wrapper_minimal_stok">
                                <input type="number" name="minimal_stok" id="input_minimal_stok" placeholder="0" required disabled>
                                <span class="satuan-label d-none" id="label_minimal_stok"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end mt-4 pt-2">
                        <button type="button" class="btn btn-light border px-4 py-2 rounded-3 me-2" data-bs-dismiss="modal" style="font-weight: 500; font-size: 14px;">Batal</button>
                        <button type="submit" class="btn-brown px-4 py-2" style="font-size: 14px;">Simpan Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. Modal Edit Item -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Edit Item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <hr style="border-color: #EBE3DB; margin: 0 0 20px 0;">
            
            <div class="modal-body p-0">
                <form id="formEditItem" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label-custom">Nama Item</label>
                            <input type="text" name="nama_item" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Kategori</label>
                            <select name="kategori_bahan_id" id="edit_kategori" class="form-select">
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
                        
                        <div class="col-12">
                            <h5 class="fw-bold mb-1" style="color: #2b2d42;">Unit & Konversi</h5>
                            <small class="text-dark" style="font-size: 12px;">Pilih satuan dan tentukan nilai konversinya.</small>
                        </div>
                        
                        <div class="col-12"><div style="border-top: 1px solid #f1f5f9; margin: 4px 0;"></div></div>

                        <div class="col-6">
                            <label class="form-label-custom">Unit Besar</label>
                            <select name="unit_besar" id="edit_unit_b" class="form-select" required onchange="updateEditUnitLabels()">
                                <option value="kg">kilogram (kg)</option>
                                <option value="gr">gram (gr)</option>
                                <option value="liter">liter (L)</option>
                                <option value="ml">mililiter (ml)</option>
                                <option value="pack">pack (pck)</option>
                                <option value="pcs">pieces (pcs)</option>
                                <option value="botol">botol (btl)</option>
                                <option value="kaleng">kaleng (klg)</option>
                                <option value="karton">karton (ktn)</option>
                                <option value="cup">cup (c)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom">Unit Kecil <span class="text-muted fw-normal" style="font-size: 11px;">(Opsional)</span></label>
                            <select name="unit_kecil" id="edit_unit_k" class="form-select" onchange="updateEditUnitLabels()">
                                <option value="" selected>Tidak ada (Opsional)</option>
                                <option value="kg">kilogram (kg)</option>
                                <option value="gr">gram (gr)</option>
                                <option value="liter">liter (L)</option>
                                <option value="ml">mililiter (ml)</option>
                                <option value="pack">pack (pck)</option>
                                <option value="pcs">pieces (pcs)</option>
                                <option value="botol">botol (btl)</option>
                                <option value="kaleng">kaleng (klg)</option>
                                <option value="karton">karton (ktn)</option>
                                <option value="cup">cup (c)</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Isi per Unit Besar (Konversi) <span class="text-muted fw-normal" style="font-size: 11px;">(Opsional)</span></label>
                            <div class="input-stok-wrapper" id="edit_wrapper_konversi">
                                <input type="number" name="konversi" id="edit_konversi" placeholder="Misal: 12 (Jika 1 Karton = 12 Pcs)">
                            </div>
                            <small class="text-muted" style="font-size: 11px; margin-top: 4px; display: block;">Hanya diisi jika Anda memilih Unit Kecil (Misal: 1 karton isi 12 pcs).</small>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label-custom">Minimal Stok</label>
                            <div class="input-stok-wrapper" id="edit_wrapper_minimal">
                                <input type="number" name="minimal_stok" id="edit_minimal" required>
                                <span class="satuan-label" id="edit_label_minimal"></span>
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

<!-- 3. Modal Hapus Item -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 24px;">
            <div class="modal-header border-0 p-0 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-bold" style="font-size: 20px; color: #2b2d42;">Hapus Item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <hr style="border-color: #EBE3DB; margin: 0 0 24px 0;">
            <div class="modal-body p-0 text-center">
                <div class="mb-4">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#e75343" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h5 class="mb-3" style="color: #2b2d42; font-size: 18px; font-weight: 500;">
                    Hapus <span id="hapus_item_nama" class="fw-bold"></span>?
                </h5>
                <p class="text-muted mb-1" style="font-size: 14px;">Item yang dihapus tidak dapat dikembalikan</p>
                <p class="text-muted mb-4" style="font-size: 14px;">Pastikan item ini sudah tidak digunakan</p>
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
                <!-- Section 1: Tambah Kategori -->
                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #2b2d42;">Tambah Kategori</h6>
                <form action="{{ route('kategori.store') }}" method="POST" class="mb-4">
                    @csrf
                    <label class="form-label text-muted mb-1" style="font-size: 12px;">Nama Kategori</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan nama kategori..." required autocomplete="off">
                        <button type="submit" class="btn-brown px-4 d-flex align-items-center gap-1" style="white-space: nowrap;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Tambah
                        </button>
                    </div>
                </form>

                <hr style="border-color: #EBE3DB; margin: 24px 0 20px 0;">

                <!-- Section 2: Daftar Kategori -->
                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #2b2d42;">Daftar Kategori ({{ $kategoris->count() }})</h6>
                <div style="max-height: 250px; overflow-y: auto; padding-right: 4px;">
                    @foreach($kategoris as $k)
                    <div class="kategori-list-item" id="kat_row_{{ $k->id }}" style="background-color: #FCF9F6; border: 1px solid #EBE3DB; border-radius: 10px; padding: 12px 16px; margin-bottom: 12px;">
                        
                        <!-- View State -->
                        <div class="view-state w-100 d-flex justify-content-between align-items-center">
                            <span class="fw-medium" style="font-size: 14px; color: #2b2d42;">{{ $k->nama_kategori }} ({{ $k->bahan_bakus_count ?? 0 }})</span>
                            <div class="d-flex gap-2">
                                <button type="button" class="action-btn btn-edit-icon" onclick="editKategori({{ $k->id }}, '{{ $k->nama_kategori }}')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button type="button" class="action-btn btn-del-icon" onclick="hapusKategori({{ $k->id }}, '{{ $k->nama_kategori }}')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Edit State -->
                        <form action="{{ route('kategori.update', $k->id) }}" method="POST" class="edit-state w-100 d-none justify-content-between align-items-center">
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
          <!-- Footer Modal -->
            <div class="modal-footer border-0 p-0 mt-4 d-flex justify-content-end">
                <button type="button" class="btn-brown px-4 py-2" onclick="tutupKelolaKategori()" style="font-size: 14px;">Tutup</button>
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
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
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

<!-- Logika JavaScript Khusus Modal -->
<script>
    // ==========================================
    // JS MODAL BERTINGKAT (ANTI LAYAR GELAP)
    // ==========================================
    
    let originModal = sessionStorage.getItem('originModal') || 'modalTambah'; 
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
                
                sessionStorage.removeItem('originModal');
                sessionStorage.removeItem('editItemData'); 
                sessionStorage.removeItem('tambahItemData'); 
            }
        }
    });

    // 1. Fungsi Buka Kelola Kategori (Dari Tambah/Edit)
    function bukaKelolaKategori(asal) {
        originModal = asal; 
        sessionStorage.setItem('originModal', asal); 
        
        // 🌟 JURUS PENYELAMAT: Scrape data + field KONVERSI yang lagi diketik
        if (asal === 'modalEdit') {
            let currentEditData = {
                id: document.getElementById('formEditItem').action.split('/').pop(),
                nama_item: document.getElementById('edit_nama').value,
                kategori_bahan_id: document.getElementById('edit_kategori').value,
                unit_besar: document.getElementById('edit_unit_b').value,
                unit_kecil: document.getElementById('edit_unit_k').value,
                konversi: document.getElementById('edit_konversi').value,
                minimal_stok: document.getElementById('edit_minimal').value,
            };
            sessionStorage.setItem('editItemData', JSON.stringify(currentEditData));
        } else if (asal === 'modalTambah') {
            let currentTambahData = {
                nama_item: document.querySelector('input[name="nama_item"]').value,
                kategori_bahan_id: document.getElementById('tambah_kategori').value,
                unit_besar: document.getElementById('tambah_unit_besar').value,
                unit_kecil: document.getElementById('tambah_unit_kecil').value,
                konversi: document.getElementById('input_konversi_tambah').value,
                minimal_stok: document.getElementById('input_minimal_stok').value,
            };
            sessionStorage.setItem('tambahItemData', JSON.stringify(currentTambahData));
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
        document.getElementById('formHapusKategori').action = `/bahan-baku/kategori/${id}`;
        queuedModal = 'modalHapusKategori'; 
        let modKat = bootstrap.Modal.getInstance(document.getElementById('modalKategori'));
        if(modKat) modKat.hide();
    }

    function batalHapusKategori() {
        queuedModal = 'modalKategori'; 
        let modHapus = bootstrap.Modal.getInstance(document.getElementById('modalHapusKategori'));
        if(modHapus) modHapus.hide();
    }

    // ==========================================
    // JS SMART UNIT LABELS (Otomatis Nonaktifkan Konversi/Eceran)
    // ==========================================
    const unitLabels = {
        'kg': 'Kg', 'liter': 'L', 'pack': 'pck',
        'botol': 'btl', 'kaleng': 'klg', 'karton': 'ktn', 'cup': 'c',
        'gr': 'gr', 'ml': 'ml', 'pcs': 'pcs'
    };

    function updateUnitLabels() {
        let unitBesar = document.getElementById('tambah_unit_besar').value;
        let unitKecil = document.getElementById('tambah_unit_kecil').value;

        // Element Tambah


        const wrapMin = document.getElementById('wrapper_minimal_stok');
        const inMin = document.getElementById('input_minimal_stok');
        const lblMin = document.getElementById('label_minimal_stok');
        
        const wrapKonversi = document.getElementById('wrapper_konversi_tambah');
        const inKonversi = document.getElementById('input_konversi_tambah');

        if (unitBesar) {
            inMin.disabled = false; wrapMin.classList.remove('is-disabled');
            lblMin.classList.remove('d-none'); lblMin.textContent = unitLabels[unitBesar];
        } else {
            inMin.disabled = true; wrapMin.classList.add('is-disabled'); lblMin.classList.add('d-none');
        }

        // Kalau ada Unit Kecil, aktifin input KONVERSI
        if (unitKecil) {
            inKonversi.disabled = false; wrapKonversi.classList.remove('is-disabled');
        } else {
            inKonversi.disabled = true; wrapKonversi.classList.add('is-disabled');
            inKonversi.value = ''; // Konversi dikosongin karena ga punya unit kecil
        }
    }

    function updateEditUnitLabels() {
        let unitBesar = document.getElementById('edit_unit_b').value;
        let unitKecil = document.getElementById('edit_unit_k').value;

        // Element Edit
        const wrapKonversi = document.getElementById('edit_wrapper_konversi');
        const inKonversi = document.getElementById('edit_konversi');
        
        if(unitBesar) {
            document.getElementById('edit_label_minimal').textContent = unitLabels[unitBesar] || unitBesar;
        }

        if (unitKecil) {
            inKonversi.disabled = false; wrapKonversi.classList.remove('is-disabled');
        } else {
            inKonversi.disabled = true; wrapKonversi.classList.add('is-disabled');
            inKonversi.value = '';
        }
    }

    // ==========================================
    // JS PASSING DATA (Tembak Data ke Modal Edit)
    // ==========================================
    function openDeleteModal(id, nama) {
        document.getElementById('hapus_item_nama').innerText = nama;
        document.getElementById('formHapusItem').action = `/bahan-baku/${id}`;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }

    function openEditModal(item) {
        sessionStorage.setItem('editItemData', JSON.stringify(item));

        document.getElementById('formEditItem').action = `/bahan-baku/${item.id}`;
        document.getElementById('edit_nama').value = item.nama_item;
        document.getElementById('edit_kategori').value = item.kategori_bahan_id || "";
        document.getElementById('edit_unit_b').value = item.unit_besar;
        
        // Panggil unit kecil (bisa kosong) dan konversinya
        document.getElementById('edit_unit_k').value = item.unit_kecil || "";
        document.getElementById('edit_konversi').value = item.konversi || "";
        
        document.getElementById('edit_minimal').value = item.minimal_stok;
        
        updateEditUnitLabels();
        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    }

    // 🌟 JURUS RESTORE DATA (Balikin form gaib abis reload kategori)
    document.addEventListener("DOMContentLoaded", function() {
        let origin = sessionStorage.getItem('originModal');
        
        if (origin === 'modalEdit') {
            let savedData = sessionStorage.getItem('editItemData');
            if (savedData) {
                let item = JSON.parse(savedData);
                document.getElementById('formEditItem').action = `/bahan-baku/${item.id}`;
                document.getElementById('edit_nama').value = item.nama_item;
                document.getElementById('edit_kategori').value = item.kategori_bahan_id || "";
                document.getElementById('edit_unit_b').value = item.unit_besar;
                document.getElementById('edit_unit_k').value = item.unit_kecil || "";
                document.getElementById('edit_konversi').value = item.konversi || "";
                document.getElementById('edit_minimal').value = item.minimal_stok;
                updateEditUnitLabels();
            }
        } else if (origin === 'modalTambah') {
            let savedData = sessionStorage.getItem('tambahItemData');
            if (savedData) {
                let item = JSON.parse(savedData);
                document.querySelector('input[name="nama_item"]').value = item.nama_item;
                document.getElementById('tambah_kategori').value = item.kategori_bahan_id || "";
                document.getElementById('tambah_unit_besar').value = item.unit_besar || "";
                document.getElementById('tambah_unit_kecil').value = item.unit_kecil || "";
                document.getElementById('input_konversi_tambah').value = item.konversi || "";
                document.getElementById('input_minimal_stok').value = item.minimal_stok;
                updateUnitLabels();
            }
        }
    });

    // Fitur Edit Kategori Inline
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
</script>

<!-- Auto-open Kategori Modal -->
@if(session('open_kategori'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new bootstrap.Modal(document.getElementById('modalKategori')).show();
        });
    </script>
@endif
@if(session('error_kategori'))
    <script>alert("{{ session('error_kategori') }}");</script>
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
        document.getElementById('formFilterBahanBaku').submit();
    }

    function pilihStatus(event, val, label) {
        event.preventDefault();
        document.getElementById('statusInput').value = val;
        document.getElementById('formFilterBahanBaku').submit();
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.filter-status-container')) {
            document.querySelectorAll('.dropdown-menu-custom').forEach(el => el.classList.add('d-none'));
        }
    });
</script>

</body>
</html>
