@extends('layouts.backoffice')

@section('title', 'Laporan Opname - DariKopi')
@section('page_title', 'Laporan')

@push('styles')
    <!-- jQuery, Moment.js, & Daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        /* ================= LAPORAN COMPONENTS ================= */
        .top-tabs { border-bottom: 1px solid #EBE3DB; display: flex; gap: 32px; margin-bottom: 24px; padding-bottom: 0; margin-top: 32px; overflow-x: auto; white-space: nowrap;}
        .top-tabs a { color: #94a3b8; text-decoration: none; font-weight: 500; font-size: 14px; padding-bottom: 12px; position: relative; transition: 0.2s;}
        .top-tabs a:hover { color: #8a5a36; }
        .top-tabs a.active { color: #8a5a36; font-weight: 600; }
        .top-tabs a.active::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background-color: #8a5a36; }

        .laporan-card { background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB; overflow-x: auto;}

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

        .date-filter-group { display: inline-flex; align-items: center; background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); overflow: hidden; height: 42px; max-width: max-content;}
        .btn-date-custom { background: transparent; border: none; color: #2b2d42; display: flex; align-items: center; justify-content: center; transition: 0.2s; border-radius: 0; padding: 0 12px;}
        .btn-date-custom:hover { background: #faf7f5; color: #8a5a36; }
        .btn-date-center { font-weight: 600; font-size: 14px; padding: 0 16px;}

        .total-item-badge { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; font-size: 14px; font-weight: 600; color: #2b2d42; display: flex; align-items: center; padding: 0 16px; height: 42px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); white-space: nowrap;}
        
        .btn-export { background-color: #8a5a36; color: white; display: flex; align-items: center; gap: 8px; font-weight: 600; border-radius: 12px; padding: 0 24px; border: none; font-size: 14px; transition: 0.2s; height: 42px; white-space: nowrap;}
        .btn-export:hover { background-color: #734a2c; color: white; }

        .opname-info-badge { background: #ffffff; border: 1px solid #EBE3DB; border-radius: 20px; padding: 8px 16px; font-size: 13px; font-weight: 600; color: #2b2d42; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);}

        /* ================= PAGINATION ================= */
        .pagination-container { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 24px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 12px;}
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

        @media (max-width: 768px) {
            .laporan-card { padding: 16px; }
            .search-box { width: 100% !important; margin-bottom: 8px; }
            #formFilterOpname { flex-direction: column; align-items: stretch !important;}
            .date-filter-group { max-width: 100%; margin-bottom: 8px; justify-content: center; width: 100%;}
            .filter-status-container { min-width: auto !important; width: 100%; margin-bottom: 8px;}
            .btn-export { justify-content: center; width: 100%; margin-top: 8px;}
            .total-item-badge { width: 100%; justify-content: center;}
            .d-flex.gap-3.align-items-stretch { flex-direction: column; gap: 0 !important;}
            .d-flex.gap-3.align-items-center { flex-direction: column; gap: 0 !important;}
            
            .opname-info-badge { width: 100%; justify-content: center; }
            .d-flex.gap-3.mb-4 { flex-direction: column; gap: 8px !important;}
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div>
        <h1 class="fw-bold mb-1" style="color: #2b2d42; font-size: 32px;">Laporan</h1>
        <p class="text-muted" style="font-size: 15px;">Lihat dan ekspor seluruh laporan operasional kedai kopi</p>
    </div>

    <!-- Horizontal Tabs -->
    <div class="top-tabs">
        <a href="{{ route('laporan.index') }}">Penjualan</a>
        <a href="{{ route('laporan.transaksi') }}">Transaksi</a>
        <a href="{{ route('laporan.opname') }}" class="active">Opname</a>
    </div>

    <!-- Filter & Action Bar -->
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
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; min-width: 800px;">
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
@endsection

@push('scripts')
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
@endpush
