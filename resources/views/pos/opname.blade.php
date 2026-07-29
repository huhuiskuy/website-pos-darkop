<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opname - DariKopi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-brown: #7A4E33;
            --bg-body: #F5EFE9;
            --bg-sidebar: #FFFFFF;
            --text-dark: #382A22;
            --text-gray: #756D67;
            --border-color: #EAE3DB;
            --active-bg: #F4EBE1;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            margin: 0;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR & NAVBAR ================= */
        .sidebar {
            width: 250px; background-color: var(--bg-sidebar); height: 100vh;
            position: fixed; left: 0; top: 0; border-right: 1px solid var(--border-color);
            display: flex; flex-direction: column; padding: 24px; z-index: 100;
        }
        .brand-name { font-size: 24px; font-weight: 800; color: var(--primary-brown); line-height: 1; letter-spacing: -0.5px; }
        .brand-sub { font-size: 12px; color: var(--text-gray); margin-top: 6px; font-weight: 500; }
        .divider { height: 1px; background-color: var(--border-color); margin: 16px 0; width: 100%; }
        
        .nav-menu { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }
        .nav-item {
            display: flex; align-items: center; padding: 12px 16px; border-radius: 12px;
            color: var(--text-gray); text-decoration: none; font-weight: 600; font-size: 14px;
            transition: all 0.2s ease; gap: 16px; position: relative;
        }
        .nav-item.active { background-color: var(--active-bg); color: var(--primary-brown); padding-left: 24px; }
        .nav-item.active::before {
            content: ""; position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
            height: 18px; width: 3px; background-color: var(--primary-brown); border-radius: 4px;
        }
        .nav-item:hover:not(.active) { background-color: #FAFAFA; color: var(--primary-brown); }
        
        .sidebar-bottom { margin-top: auto; display: flex; flex-direction: column; gap: 12px; }
        .btn-logout {
            display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 12px;
            border: 1px solid var(--border-color); color: var(--primary-brown); text-decoration: none;
            font-weight: 600; font-size: 14px; background: white; transition: all 0.2s ease;
        }
        .btn-logout:hover { background: #FAFAFA; border-color: var(--primary-brown); }

        .navbar-top {
            position: fixed; top: 0; left: 250px; right: 0; height: 70px;
            background-color: var(--bg-sidebar); 
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; z-index: 99;
        }
        .navbar-title { font-size: 24px; font-weight: 800; color: var(--text-dark); margin: 0; }
        .time-badge {
            display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: white;
            border: 1px solid var(--border-color); border-radius: 20px; font-size: 13px; font-weight: 600; color: var(--text-dark);
        }

        /* ================= MAIN CONTENT ================= */
        .main-wrapper {
            margin-left: 250px;
            margin-top: 70px;
            height: calc(100vh - 70px);
            display: flex;
            padding: 32px;
            gap: 24px;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            padding-right: 8px;
            padding-bottom: 24px;
        }
        
        .content-area::-webkit-scrollbar { display: none; }

        .page-header p { font-size: 14px; color: var(--text-gray); margin-bottom: 24px; font-weight: 500;}

        /* --- Controls & Filters --- */
        .controls-row { display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
        .control-box {
            background: white; border-radius: 12px; padding: 10px 16px;
            display: flex; align-items: center; border: 1px solid white;
            color: var(--text-gray); font-size: 13px; font-weight: 500; height: 44px;
        }
        .control-search { flex: 1; min-width: 250px; max-width: 300px; gap: 10px; }
        .control-search input { border: none; outline: none; width: 100%; font-size: 13px; font-weight: 500;}
        .control-date { min-width: 200px; justify-content: space-between; color: var(--text-dark); cursor: pointer; }
        .control-total { margin-left: auto; color: var(--text-dark); font-weight: 600; }

        /* ================= CUSTOM DROPDOWN ================= */
        .custom-dropdown-container {
            min-width: 180px;
            user-select: none;
            padding: 0 !important;
        }
        .custom-dropdown-trigger {
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; height: 100%; padding: 0 16px; border-radius: 12px;
            color: var(--text-dark); cursor: pointer; font-weight: 500;
        }
        .dk-dropdown-menu {
            position: absolute; top: calc(100% + 8px); left: 0; width: 100%;
            background: white; border: 1px solid var(--border-color); border-radius: 12px;
            padding: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: none; flex-direction: column; gap: 4px; z-index: 1000;
        }
        .dk-dropdown-menu.show { display: flex; }
        .dk-dropdown-item {
            padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 500;
            color: var(--text-gray); cursor: pointer; transition: all 0.2s;
        }
        .dk-dropdown-item:hover, .dk-dropdown-item.active { 
            background-color: var(--active-bg); 
            color: var(--primary-brown); 
        }

        .pic-inputs { display: flex; gap: 24px; margin-bottom: 24px; }
        .pic-group { display: flex; flex-direction: column; gap: 8px; width: 250px; }
        .pic-group label { font-size: 13px; font-weight: 600; color: var(--text-dark); }
        .pic-group input {
            background: white; border: none; border-radius: 12px; height: 44px;
            padding: 0 16px; font-size: 13px; outline: none; font-weight: 500;
        }

        /* --- Table Card --- */
        .table-card {
            background: white; border-radius: 20px; padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        
        .opname-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .opname-table thead th {
            background-color: var(--active-bg); padding: 12px 16px;
            font-size: 13px; font-weight: 600; color: var(--primary-brown); text-align: left;
        }
        .opname-table thead th:first-child { border-radius: 12px 0 0 12px; }
        .opname-table thead th:last-child { border-radius: 0 12px 12px 0; }
        
        .opname-table tbody td {
            padding: 16px; font-size: 13px; color: var(--text-dark); font-weight: 600;
            border-bottom: 1px solid var(--border-color); vertical-align: middle;
        }
        .opname-table tbody tr:last-child td { border-bottom: none; }

        .unit-badges { display: flex; gap: 6px; }
        .unit-badge { background-color: #F1F5F9; color: #475569; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; }

        .stok-inputs { display: flex; gap: 8px; align-items: center; }
        .stok-input {
            width: 54px; height: 36px; border: 1px solid #E2E8F0; border-radius: 8px;
            text-align: center; font-size: 12px; font-weight: 500; outline: none; transition: 0.2s;
        }
        .stok-input:focus { border-color: var(--primary-brown); }
        .stok-input::placeholder { color: #CBD5E1; }

        .locked-input {
            background-color: #F1F5F9 !important; color: #94A3B8 !important;
            cursor: not-allowed; pointer-events: none; border-color: #E2E8F0 !important;
        }

        /* ================= TAMPILAN STOK DISIMPAN ================= */
        .saved-stok-container {
            display: flex; flex-direction: column; align-items: flex-start; justify-content: center;
        }
        .saved-stok-besar { font-size: 13px; font-weight: 800; color: var(--text-dark); }
        .saved-stok-kecil { font-size: 12px; font-weight: 500; color: #756D67; margin-top: 2px; }

        /* --- Footer & Pagination (Grid 3 Kolom) --- */
        .table-footer {
            display: grid; grid-template-columns: 1fr auto 1fr; align-items: center;
            margin-top: 24px; border-top: 1px solid #F5F5F5; padding-top: 24px;
        }
        .footer-info {
            grid-column: 1; justify-self: start; font-size: 13px; color: var(--text-gray); font-weight: 500;
        }
        .pagination-wrapper { grid-column: 2; justify-self: center; }
        .btn-simpan {
            grid-column: 3; justify-self: end; background-color: #8C593B; color: white; font-weight: 600; 
            font-size: 14px; padding: 10px 32px; border-radius: 10px; border: none; cursor: pointer; transition: 0.2s;
        }
        .btn-simpan:hover { background-color: #7A4E33; }

        /* ================= PAGINATION OVERRIDE ================= */
        .pagination-wrapper nav > div.d-sm-flex > div:first-child,
        .pagination-wrapper nav p,
        .pagination-wrapper nav .d-sm-none {
            display: none !important;
        }
        .pagination-wrapper nav > .d-sm-flex { justify-content: center !important; width: 100%; }
        .pagination-wrapper .pagination { display: flex; gap: 8px; margin: 0; padding: 0; }
        .pagination-wrapper .page-item .page-link {
            width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
            border-radius: 10px !important; border: 1px solid var(--border-color) !important; 
            color: #64748B !important; font-weight: 600; font-size: 14px; padding: 0;
            background-color: white !important; transition: all 0.2s; box-shadow: none !important;
        }
        .pagination-wrapper .page-item.active .page-link { background-color: var(--primary-brown) !important; border-color: var(--primary-brown) !important; color: white !important; }
        .pagination-wrapper .page-item.disabled .page-link { background-color: #F1F5F9 !important; border-color: #EAE3DB !important; color: #94A3B8 !important; }
        .pagination-wrapper .page-item:not(.active):not(.disabled) .page-link:hover { border-color: var(--primary-brown) !important; color: var(--primary-brown) !important; }
        .pagination-wrapper .page-item:last-child:not(.disabled) .page-link { color: var(--primary-brown) !important; }
        .pagination-wrapper .page-link svg { width: 16px; height: 16px; }
    </style>
</head>
<body>

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <div class="brand">
            <div class="brand-name">DariKopi</div>
            <div class="brand-sub">Point of Sales</div>
        </div>
        
        <div class="divider"></div>
        
        <ul class="nav-menu">
            <a href="{{ url('/pos') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                Point of Sale
            </a>
            <a href="{{ route('pos.aktivitas') }}" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Aktivitas
            </a>
            <a href="{{ route('pos.opname') ?? '#' }}" class="nav-item active">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                Opname
            </a>
        </ul>

        <div class="sidebar-bottom">
            <div class="divider"></div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            <a href="#" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Keluar
            </a>
        </div>
    </div>

    <!-- ================= NAVBAR TOP ================= -->
    <div class="navbar-top">
        <h1 class="navbar-title">Opname</h1>
        <div class="time-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span id="realtime-clock">00:00 WIB</span>
        </div>
    </div>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="main-wrapper">
        <div class="content-area">
            <div class="page-header">
            <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">Opname</h1>
            <p>Input item bahan baku yang ada di kedai</p>
        </div>

        <!-- ================= 1. AREA FILTER ================= -->
        <form action="{{ route('pos.opname') }}" method="GET" id="formFilterOpname" class="controls-row mb-4">
            
            <!-- Search -->
            <div class="control-box control-search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari nama item" autocomplete="off">
            </div>
            
            <!-- Kategori (Custom Dropdown) -->
            <div class="control-box custom-dropdown-container position-relative">
                <input type="hidden" name="kategori" id="kategoriInput" value="{{ request('kategori') }}">

                @php
                    $selectedKatName = 'Semua Kategori';
                    if (request('kategori') == 'tak_berkategori') {
                        $selectedKatName = 'Tak Berkategori';
                    }
                    foreach($kategoris as $kat) {
                        if(request('kategori') == $kat->id) {
                            $selectedKatName = $kat->nama_kategori;
                            break;
                        }
                    }
                @endphp

                <div class="custom-dropdown-trigger" onclick="toggleDropdown(event)">
                    <span id="dropdownSelectedText">{{ $selectedKatName }}</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>

                <div class="dk-dropdown-menu" id="kategoriMenu">
                    <div class="dk-dropdown-item {{ request('kategori') == '' ? 'active' : '' }}" onclick="selectKategori('', 'Semua Kategori')">
                        Semua Kategori
                    </div>
                    <div class="dk-dropdown-item {{ request('kategori') == 'tak_berkategori' ? 'active' : '' }}" onclick="selectKategori('tak_berkategori', 'Tak Berkategori')">
                        Tak Berkategori
                    </div>
                    @foreach($kategoris as $kat)
                        <div class="dk-dropdown-item {{ request('kategori') == $kat->id ? 'active' : '' }}" onclick="selectKategori('{{ $kat->id }}', '{{ $kat->nama_kategori }}')">
                            {{ $kat->nama_kategori }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tanggal (Sistem Chevron) -->
            <div class="control-box control-date px-3">
                <input type="hidden" name="date" id="dateInput" value="{{ $date }}">
                <div class="filter-date-btn" style="cursor: pointer;" onclick="ubahTanggal(-1)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#756D67" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </div>
                <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
                <div class="filter-date-btn" style="cursor: pointer;" onclick="ubahTanggal(1)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#756D67" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </div>

            <!-- Total Item -->
            <div class="control-box control-total ms-auto">
                Total Item: {{ $items->total() }}
            </div>
        </form>

        <!-- ================= 2. AREA FORM SIMPAN OPNAME ================= -->
        <form action="{{ route('pos.simpanOpname') }}" method="POST" id="formSimpanOpname">
            @csrf
            <input type="hidden" name="tanggal_opname" value="{{ $date }}">
            <input type="hidden" name="redirect_url" id="redirectUrl" value="">

            <!-- Row 2: PIC Inputs & Edit Button -->
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div class="pic-inputs position-relative mb-0" style="margin-bottom: 0;">
                    <div class="pic-group">
                        <label>Opname Pagi</label>
                        <input type="text" name="pic_pagi" placeholder="Masukkan Nama" value="{{ $picPagi }}" 
                               {{ $lockPagi ? 'readonly' : 'required' }} 
                               class="{{ $lockPagi ? 'locked-input' : '' }}">
                    </div>
                    
                    <div class="pic-group">
                        <label>Opname Sore</label>
                        <input type="text" name="pic_sore" placeholder="Masukkan Nama" value="{{ $picSore }}" 
                               {{ $lockSore ? 'readonly' : '' }} 
                               {{ ($lockPagi && !$lockSore) ? 'required' : '' }} 
                               class="{{ $lockSore ? 'locked-input' : '' }}">
                    </div>
                </div>

                <!-- Tombol Edit Dropdown -->
                <div class="dropdown">
                    <button class="control-box dropdown-toggle d-flex align-items-center justify-content-between" type="button" data-bs-toggle="dropdown" style="border: 1px solid white; color: var(--text-dark); cursor: pointer; min-width: 190px; padding: 0 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div class="d-flex align-items-center gap-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            Edit Data Opname
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 12px; border: 1px solid var(--border-color); padding: 8px; min-width: 190px; margin-top: 8px;">
                        @if($lockPagi && $picPagi !== '')
                        <li><a class="dk-dropdown-item d-block text-decoration-none auto-save-link {{ $editMode === 'pagi' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['edit' => 'pagi']) }}">Edit Sesi Pagi</a></li>
                        @endif
                        
                        @if($lockSore && $picSore !== '')
                        <li><a class="dk-dropdown-item d-block text-decoration-none auto-save-link {{ $editMode === 'sore' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['edit' => 'sore']) }}">Edit Sesi Sore</a></li>
                        @endif

                        @if($editMode)
                        <li><hr class="dropdown-divider" style="margin: 4px 0; border-color: #f1f5f9;"></li>
                        <li><a class="dk-dropdown-item d-block text-decoration-none auto-save-link text-danger" href="{{ request()->url() }}?date={{ $date }}" style="color: #dc2626 !important; font-weight: 600;">Batalkan Edit</a></li>
                        @endif
                        

                    </ul>
                </div>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <table class="opname-table">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th>Kategori</th>
                            <th>Unit</th>
                            <th>Stok Pagi</th>
                            <th>Stok Sore</th>
                            <th>Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        @php
                            // Kamus singkatan dinamis
                            $kamusSingkatan = [
                                'pack' => 'pck',
                                'karton' => 'ktn',
                                'botol' => 'btl',
                                'bungkus' => 'bks',
                                'liter' => 'ltr',
                                'gram' => 'gr',
                                'mililiter' => 'ml'
                            ];
                            
                            $uBesarAsli = strtolower($item->unit_besar ?? 'kg');
                            $uKecilAsli = strtolower($item->unit_kecil ?? '-');
                            
                            $uBesar = $kamusSingkatan[$uBesarAsli] ?? $uBesarAsli;
                            $uKecil = $kamusSingkatan[$uKecilAsli] ?? $uKecilAsli;
                            
                            $hasUnitKecil = $item->unit_kecil && $item->unit_kecil !== '-';
                        @endphp

                        <tr data-unit-besar="{{ $uBesar }}" 
                            data-unit-kecil="{{ $uKecil }}"
                            data-rasio="{{ $item->konversi ?? 1000 }}">
                            
                            <td>{{ $item->nama_item }}</td>
                            <td>{{ $item->kategori ? $item->kategori->nama_kategori : 'Tak Berkategori' }}</td>
                            
                            <!-- UNIT DINAMIS -->
                            <td>
                                <div class="unit-badges">
                                    <span class="unit-badge">{{ $uBesar }}</span>
                                    @if($hasUnitKecil)
                                        <span class="unit-badge">{{ $uKecil }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- STOK PAGI -->
                            <td>
                                @php
                                    $valPagiBesar = $item->riwayatOpname->first()->stok_pagi_besar ?? '';
                                    $valPagiKecil = $item->riwayatOpname->first()->stok_pagi_kecil ?? '';
                                @endphp

                                <!-- Kalau dilock, paksa jadi teks. Kalau kosong, tampilin 0 -->
                                @if($lockPagi)
                                    <div class="saved-stok-container">
                                        <div class="saved-stok-besar">{{ $valPagiBesar !== '' ? $valPagiBesar : '0' }} {{ $uBesar }}</div>
                                        @if($hasUnitKecil)
                                            <div class="saved-stok-kecil">{{ $valPagiKecil !== '' ? $valPagiKecil : '0' }} {{ $uKecil }}</div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="opname[{{ $item->id }}][pagi_besar]" class="pagi-besar" value="{{ $valPagiBesar }}">
                                    <input type="hidden" name="opname[{{ $item->id }}][pagi_kecil]" class="pagi-kecil" value="{{ $valPagiKecil }}">
                                @else
                                    <div class="stok-inputs">
                                        <input type="number" name="opname[{{ $item->id }}][pagi_besar]" 
                                            class="stok-input pagi-besar" 
                                            placeholder="{{ $uBesar }}" min="0" onkeyup="hitungSelisih(this)" 
                                            value="{{ $valPagiBesar }}"
                                            @if(!$hasUnitKecil) style="width: 116px;" @endif>
                                        
                                        @if($hasUnitKecil)
                                            <input type="number" name="opname[{{ $item->id }}][pagi_kecil]" 
                                                class="stok-input pagi-kecil" 
                                                placeholder="{{ $uKecil }}" min="0" onkeyup="hitungSelisih(this)" 
                                                value="{{ $valPagiKecil }}">
                                        @else
                                            <!-- Jangan lupa panggil name biar nggak error pas page 2 -->
                                            <input type="hidden" name="opname[{{ $item->id }}][pagi_kecil]" class="pagi-kecil" value="">
                                        @endif
                                    </div>
                                @endif
                            </td>
                            
                            <!-- STOK SORE -->
                            <td>
                                @php
                                    $valSoreBesar = $item->riwayatOpname->first()->stok_sore_besar ?? '';
                                    $valSoreKecil = $item->riwayatOpname->first()->stok_sore_kecil ?? '';
                                @endphp

                                <!-- Kalau dilock, paksa jadi teks. Kalau kosong, tampilin 0 -->
                                @if($lockSore)
                                    <div class="saved-stok-container">
                                        <div class="saved-stok-besar">{{ $valSoreBesar !== '' ? $valSoreBesar : '0' }} {{ $uBesar }}</div>
                                        @if($hasUnitKecil)
                                            <div class="saved-stok-kecil">{{ $valSoreKecil !== '' ? $valSoreKecil : '0' }} {{ $uKecil }}</div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="opname[{{ $item->id }}][sore_besar]" class="sore-besar" value="{{ $valSoreBesar }}">
                                    <input type="hidden" name="opname[{{ $item->id }}][sore_kecil]" class="sore-kecil" value="{{ $valSoreKecil }}">
                                @else
                                    <div class="stok-inputs">
                                        <input type="number" name="opname[{{ $item->id }}][sore_besar]" 
                                            class="stok-input sore-besar" 
                                            placeholder="{{ $uBesar }}" min="0" onkeyup="hitungSelisih(this)" 
                                            value="{{ $valSoreBesar }}"
                                            @if(!$hasUnitKecil) style="width: 116px;" @endif>
                                        
                                        @if($hasUnitKecil)
                                            <input type="number" name="opname[{{ $item->id }}][sore_kecil]" 
                                                class="stok-input sore-kecil" 
                                                placeholder="{{ $uKecil }}" min="0" onkeyup="hitungSelisih(this)" 
                                                value="{{ $valSoreKecil }}">
                                        @else
                                            <!-- Jangan lupa panggil name biar nggak error pas page 2 -->
                                            <input type="hidden" name="opname[{{ $item->id }}][sore_kecil]" class="sore-kecil" value="">
                                        @endif
                                    </div>
                                @endif
                            </td>
                            
                            <!-- SELISIH -->
                            <td style="padding-left: 24px; min-width: 120px;" class="selisih-text">-</td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data bahan baku ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Footer & Pagination -->
                <div class="table-footer">
                    <div class="footer-info">
                        Menampilkan <strong>{{ $items->firstItem() ?? 0 }}</strong> sampai <strong>{{ $items->lastItem() ?? 0 }}</strong> dari <strong>{{ $items->total() }}</strong> data
                    </div>
                    
                    <div class="pagination-wrapper">
                        {{ $items->links('vendor.pagination.bootstrap-5') }}
                    </div>

                    <button type="submit" class="btn-simpan" 
                        {{ ($lockPagi && $lockSore && !$editMode) ? 'disabled' : '' }} 
                        style="{{ ($lockPagi && $lockSore && !$editMode) ? 'background-color: #cbd5e1; cursor: not-allowed;' : '' }}">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <!-- ================= SCRIPT ================= -->
    <script>
        // 1. Jam Real-Time
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('realtime-clock').textContent = `${hours}:${minutes} WIB`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Custom Dropdown Kategori
        function toggleDropdown(event) {
            event.stopPropagation();
            document.getElementById('kategoriMenu').classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            const container = document.querySelector('.custom-dropdown-container');
            const menu = document.getElementById('kategoriMenu');
            if (container && !container.contains(event.target)) {
                menu.classList.remove('show');
            }
        });

        // 3. Live Search Super Instan (Client-Side)
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const rows = document.querySelectorAll('.opname-table tbody tr');

            rows.forEach(row => {
                const tdNama = row.querySelector('td:first-child');
                if (tdNama && !tdNama.classList.contains('text-center')) { // Skip baris empty teks kosong
                    const namaItem = tdNama.textContent || tdNama.innerText;
                    row.style.display = namaItem.toLowerCase().includes(keyword) ? '' : 'none';
                }
            });
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') e.preventDefault();
        });

        // 4. Hitung Selisih Otomatis
        function hitungSelisih(element) {
            let row = element.closest('tr');
            let unitBesar = row.getAttribute('data-unit-besar') || 'kg';
            let unitKecil = row.getAttribute('data-unit-kecil') || 'gr';
            let rasio = parseFloat(row.getAttribute('data-rasio')) || 1000;
            
            let pagiBesarEl = row.querySelector('.pagi-besar');
            let pagiKecilEl = row.querySelector('.pagi-kecil');
            let soreBesarEl = row.querySelector('.sore-besar');
            let soreKecilEl = row.querySelector('.sore-kecil');

            let pagiBesar = pagiBesarEl ? (parseFloat(pagiBesarEl.value) || 0) : 0;
            let pagiKecil = pagiKecilEl ? (parseFloat(pagiKecilEl.value) || 0) : 0;
            let soreBesar = soreBesarEl ? (parseFloat(soreBesarEl.value) || 0) : 0;
            let soreKecil = soreKecilEl ? (parseFloat(soreKecilEl.value) || 0) : 0;

            let selisihCell = row.querySelector('.selisih-text');

            let hasSoreBesar = soreBesarEl && soreBesarEl.value !== '';
            let hasSoreKecil = soreKecilEl && soreKecilEl.type !== 'hidden' && soreKecilEl.value !== '';
            
            if (!hasSoreBesar && !hasSoreKecil) {
                selisihCell.innerText = '-';
                selisihCell.style.color = 'var(--text-dark)';
                return;
            }

            let totalPagiKecil = (pagiBesar * rasio) + pagiKecil;
            let totalSoreKecil = (soreBesar * rasio) + soreKecil;

            let selisihKecil = totalSoreKecil - totalPagiKecil;
            let isMinus = selisihKecil < 0;
            let absKecil = Math.abs(selisihKecil);

            let outBesar = Math.floor(absKecil / rasio);
            let outKecil = absKecil % rasio;

            let text = isMinus ? '- ' : '+ ';
            if(outBesar > 0) text += outBesar + ' ' + unitBesar + ' ';
            if(outKecil > 0 || outBesar === 0) text += outKecil + ' ' + unitKecil;

            if (unitKecil === '-' || unitKecil === '') {
                text = (isMinus ? '- ' : '+ ') + outBesar + ' ' + unitBesar;
                if (absKecil === 0) text = '0 ' + unitBesar;
            }

            selisihCell.innerText = text;
            selisihCell.style.color = isMinus ? '#DC2626' : '#16A34A';
            selisihCell.style.fontWeight = '700';
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.pagi-besar').forEach(el => hitungSelisih(el));
            
            if (searchInput.value.length > 0) {
                let val = searchInput.value;
                searchInput.focus();
                searchInput.value = '';
                searchInput.value = val;
            }
        });

        // 5. Sistem Auto-Save (Ganti Tanggal, Dropdown Kategori, Pagination, Edit)
        function ubahTanggal(hari) {
            let dateInput = document.getElementById('dateInput');
            let currentDate = new Date(dateInput.value);
            currentDate.setDate(currentDate.getDate() + hari);
            
            let year = currentDate.getFullYear();
            let month = String(currentDate.getMonth() + 1).padStart(2, '0');
            let day = String(currentDate.getDate()).padStart(2, '0');
            
            let url = new URL(window.location.href);
            url.searchParams.set('date', `${year}-${month}-${day}`);
            
            document.getElementById('redirectUrl').value = url.toString();
            document.getElementById('formSimpanOpname').submit();
        }

        function selectKategori(value, text) {
            document.getElementById('kategoriInput').value = value;
            document.getElementById('dropdownSelectedText').innerText = text;
            document.getElementById('kategoriMenu').classList.remove('show');
            
            let url = new URL(window.location.href);
            if(value === '') url.searchParams.delete('kategori');
            else url.searchParams.set('kategori', value);
            
            url.searchParams.delete('page');
            
            // Cek status input PIC Pagi
            let picPagiInput = document.querySelector('input[name="pic_pagi"]');
            let isPagiLocked = picPagiInput.hasAttribute('readonly');
            let isPagiFilled = picPagiInput.value.trim() !== '';
            
            // Kalau lagi aktif input Pagi
            if (url.searchParams.get('edit') === 'pagi' || (!isPagiLocked && isPagiFilled)) {
                url.searchParams.set('edit', 'pagi');
            }
            
            // Cek status input PIC Sore
            let picSoreInput = document.querySelector('input[name="pic_sore"]');
            let isSoreLocked = picSoreInput.hasAttribute('readonly');
            let isSoreFilled = picSoreInput.value.trim() !== '';
            
            // Kalau lagi aktif input Sore
            if (url.searchParams.get('edit') === 'sore' || (!isSoreLocked && isSoreFilled)) {
                url.searchParams.set('edit', 'sore');
            }
            
            document.getElementById('redirectUrl').value = url.toString();
            document.getElementById('formSimpanOpname').submit();
        }

        document.addEventListener('click', function(e) {
            let pageLink = e.target.closest('.pagination a');
            let editLink = e.target.closest('.auto-save-link');
            let targetLink = pageLink || editLink;

            if (targetLink) {
                e.preventDefault();
                
                let targetUrl = new URL(targetLink.href, window.location.origin);
                
                // JIKA ini adalah link pagination (bukan link edit manual)
                if (pageLink) {
                    let picPagiInput = document.querySelector('input[name="pic_pagi"]');
                    let isPagiLocked = picPagiInput.hasAttribute('readonly');
                    let isPagiFilled = picPagiInput.value.trim() !== '';
                    
                    let currentUrl = new URL(window.location.href);
                    
                    // Kalau lagi aktif input Pagi (belum kekunci) atau ada edit=pagi di URL
                    if (currentUrl.searchParams.get('edit') === 'pagi' || (!isPagiLocked && isPagiFilled)) {
                        targetUrl.searchParams.set('edit', 'pagi');
                    }
                    
                    let picSoreInput = document.querySelector('input[name="pic_sore"]');
                    let isSoreLocked = picSoreInput.hasAttribute('readonly');
                    let isSoreFilled = picSoreInput.value.trim() !== '';
                    
                    // Kalau lagi aktif input Sore
                    if (currentUrl.searchParams.get('edit') === 'sore' || (!isSoreLocked && isSoreFilled)) {
                        targetUrl.searchParams.set('edit', 'sore');
                    }
                }
                
                document.getElementById('redirectUrl').value = targetUrl.toString();
                document.getElementById('formSimpanOpname').submit();
            }
        });
    </script>
</body>
</html>
