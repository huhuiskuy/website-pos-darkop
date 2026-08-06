@extends('layouts.backoffice')

@section('title', 'Dashboard - DariKopi')
@section('page_title', 'Dashboard')

@push('styles')
    <!-- ApexCharts JS (We need this early for rendering if needed, though usually at bottom is fine, but keeping logic same) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- jQuery, Moment.js, & Daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
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
            border: 1px solid #EBE3DB; 
            border-radius: 12px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            overflow: hidden; 
        }
        .btn-date-custom { 
            background: transparent; 
            border: none; 
            color: #2b2d42; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            transition: 0.2s;
            border-radius: 0; 
        }
        .btn-date-custom:hover { background: #faf7f5; color: #8a5a36; }
        .btn-date-custom:focus { outline: none; box-shadow: none; }
        .btn-date-center { font-weight: 600; font-size: 14px; padding: 0 16px;}

        /* Tabel Menu Terlaris */
        .table-menu-terlaris { width: 100%; margin-bottom: 0; }
        .table-menu-terlaris th { background-color: #F4EFEA; color: #64748b; font-weight: 600; font-size: 13px; padding: 12px 16px; border: none; white-space: nowrap; }
        .table-menu-terlaris th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .table-menu-terlaris th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
        .table-menu-terlaris td { font-size: 14px; font-weight: 600; color: #2b2d42; padding: 16px; border-bottom: 1px solid #f1f5f9; white-space: nowrap; }
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
        
        /* Responsive adjustments for Daterangepicker */
        @media (max-width: 768px) {
            .daterangepicker { padding: 10px !important; }
            .daterangepicker .ranges { float: none !important; border-right: none !important; padding-right: 0; margin-bottom: 12px !important; }
            .daterangepicker .ranges ul { width: 100% !important; display: flex; flex-wrap: wrap; gap: 4px; }
            .daterangepicker .ranges li { margin-bottom: 4px !important; flex: 1 1 calc(50% - 4px); font-size: 11px !important;}
            .daterangepicker .drp-calendar { padding: 0 !important; }
        }

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
            border-radius: 0 !important;
        }
        .daterangepicker td.active, .daterangepicker td.active:hover {
            background-color: #8a5a36 !important;
            color: #ffffff !important;
            border-radius: 6px !important;
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

        .daterangepicker .drp-buttons {
            border-top: 1px solid #EBE3DB !important;
            padding: 16px 0 0 0 !important;
            margin-top: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            flex-wrap: wrap;
            gap: 12px;
        }
        @media (max-width: 768px) {
            .daterangepicker .drp-selected { padding-left: 0 !important; width: 100%; text-align: center; margin-bottom: 8px; }
            .daterangepicker .drp-buttons { justify-content: center !important; }
        }
        .daterangepicker .drp-selected {
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-right: auto !important;
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
@endpush

@section('content')
    <!-- Header & Welcome -->
    <div>
        <h1 class="fw-bold mb-1" style="color: #2b2d42; font-size: 32px;">Selamat Datang, {{ auth('owner')->user()->name ?? 'Admin' }}</h1>
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
        <div class="col-sm-6 col-xl-3">
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
        <div class="col-sm-6 col-xl-3">
            <div class="dash-card">
                <span class="dash-title-sm">Transaksi</span>
                <div class="dash-value">{{ $jumlahTransaksi }}</div>
                <span class="dash-subtext">Transaksi Selesai</span>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dash-card">
                <span class="dash-title-sm">Menu Terjual</span>
                <div class="dash-value">{{ $menuTerjual }}</div>
                <span class="dash-subtext">Menu Periode Ini</span>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dash-card">
                <span class="dash-title-sm">Menu Terlaris</span>
                <div class="dash-value" style="font-size: 20px;">{{ $menuTerlaris }}</div>
                <span class="dash-subtext">{{ $menuTerlarisJml }} Terjual</span>
            </div>
        </div>
    </div>

    <!-- 2. GRAFIK UTAMA (Bar & Area) -->
    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="dash-card">
                <span class="dash-title-sm">Jumlah Penjualan Harian Dalam Seminggu</span>
                <div id="chart-mingguan"></div>
            </div>
        </div>
        <div class="col-xl-6">
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
        <div class="col-xl-6">
            <div class="dash-card text-center relative">
                <span class="dash-title-sm text-start">Kategori Berdasarkan Volume</span>
                <div class="d-flex justify-content-center">
                    <div id="chart-donut-volume"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
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
        <div class="row mt-4 g-4">
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

@endsection

@push('scripts')
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
            categories: labelMingguan, 
            axisBorder: {show: false}, axisTicks: {show: false}, crosshairs: {show: false} 
        },
        yaxis: { labels: { formatter: function (val) { return val + "k" } } },
        grid: { show: false },
        tooltip: {
            custom: function({series, seriesIndex, dataPointIndex}) {
                let val = series[seriesIndex][dataPointIndex];
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
            categories: labelPerJam, 
            axisBorder: {show: false}, axisTicks: {show: false}, crosshairs: {show: false},
            labels: { style: { fontSize: '10px' } }
        },
        yaxis: { labels: { formatter: function (val) { return val + "k" }, style: { fontSize: '10px' } } },
        grid: { show: false },
        tooltip: {
            custom: function({series, seriesIndex, dataPointIndex}) {
                let val = series[seriesIndex][dataPointIndex];
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
        legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '11px', markers: { radius: 12 } },
        stroke: { width: 4, colors: ['#fff'] },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    let vol = volumeAsli[opts.seriesIndex];
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
        legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '11px', markers: { radius: 12 } },
        stroke: { width: 4, colors: ['#fff'] },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    let rp = pendapatanAsli[opts.seriesIndex];
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
        var start = moment($('#start_date').val(), 'YYYY-MM-DD'); 
        var end = moment($('#end_date').val(), 'YYYY-MM-DD');

        window.ubahHari = function(hari) {
            let s = moment($('#start_date').val(), 'YYYY-MM-DD').add(hari, 'days').format('YYYY-MM-DD');
            let e = moment($('#end_date').val(), 'YYYY-MM-DD').add(hari, 'days').format('YYYY-MM-DD');
            $('#start_date').val(s);
            $('#end_date').val(e);
            $('#filterForm').submit();
        };

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
            opens: 'left', // Changed from right to left to not overflow on mobile
            drops: 'down',
            alwaysShowCalendars: true,
            applyButtonClasses: 'btn-brown',
            ranges: {
               'Hari Ini': [moment(), moment()],
               'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Minggu Ini': [moment().startOf('week'), moment().endOf('week')],
               'Bulan Ini': [moment().startOf('month'), moment().endOf('month')]
            },
            locale: {
                customRangeLabel: 'Kustom',
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

        updateDateText(start, end);
    });
</script>
@endpush
