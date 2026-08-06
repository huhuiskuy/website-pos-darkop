@extends('layouts.backoffice')

@section('title', 'Laporan - DariKopi')
@section('page_title', 'Laporan')

@push('styles')
    <!-- jQuery, Moment.js, & Daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        /* ================= LAPORAN COMPONENTS ================= */
        .top-tabs {  border-bottom: 1px solid #EBE3DB; display: flex; gap: 32px; margin-bottom: 32px; padding-bottom: 0; margin-top: 32px; overflow-x: auto; white-space: nowrap; overflow-y: hidden; scrollbar-width: none; }
        .top-tabs::-webkit-scrollbar { display: none; }
        .top-tabs a { color: #94a3b8; text-decoration: none; font-weight: 500; font-size: 14px; padding-bottom: 12px; position: relative; transition: 0.2s;}
        .top-tabs a:hover { color: #8a5a36; }
        .top-tabs a.active { color: #8a5a36; font-weight: 600; }
        .top-tabs a.active::after { content: ''; position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background-color: #8a5a36; }

        .btn-export { background-color: #8a5a36; color: white; display: flex; align-items: center; gap: 8px; font-weight: 600; border-radius: 8px; padding: 10px 24px; border: none; font-size: 14px; transition: 0.2s; white-space: nowrap;}
        .btn-export:hover { background-color: #734a2c; color: white; }

        /* Kiri: Sub Menu Laporan */
        .laporan-sidebar { background: #ffffff; border-radius: 16px; padding: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB;}
        .laporan-sidebar a { display: block; padding: 12px 20px; color: #64748b; font-weight: 500; font-size: 14px; text-decoration: none; border-radius: 8px; margin-bottom: 8px; transition: 0.2s;}
        .laporan-sidebar a.active { background: #8a5a36; color: #ffffff; }
        .laporan-sidebar a:hover:not(.active) { background: #faf7f5; color: #8a5a36; }

        /* Kanan: Konten Utama */
        .laporan-card { background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #EBE3DB; }
        .laporan-card-title { font-size: 18px; font-weight: 700; color: #2b2d42; margin-bottom: 24px; }
        
        .laporan-table-header { background: #F4EFEA; color: #64748b; border-radius: 8px; padding: 14px 20px; display: flex; justify-content: space-between; font-weight: 600; font-size: 13px; margin-bottom: 8px;}
        .laporan-table-row { display: flex; justify-content: space-between; padding: 20px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #2b2d42;}
        .laporan-table-row:last-child { border-bottom: none; }
        .row-bold { font-weight: 700; color: #1e1e1e; }

        /* ================= DATE PICKER CUSTOM (Dari Dashboard) ================= */
        .date-filter-group { display: inline-flex; align-items: center; background: #ffffff; border: 1px solid #EBE3DB; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); overflow: hidden; max-width: max-content; }
        .btn-date-custom { background: transparent; border: none; color: #2b2d42; display: flex; align-items: center; justify-content: center; transition: 0.2s; border-radius: 0; flex-shrink: 0;}
        .btn-date-custom:hover { background: #faf7f5; color: #8a5a36; }
        .btn-date-custom:focus { outline: none; box-shadow: none; }
        .btn-date-center { font-weight: 600; font-size: 14px; padding: 0 16px; justify-content: center;}
        
        #date-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 250px;}

        /* DATERANGEPICKER PREMIUM CUSTOM CSS */
        .daterangepicker { font-family: 'Poppins', sans-serif !important; border: 1px solid #EBE3DB !important; border-radius: 16px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; padding: 20px !important; margin-top: 8px !important; color: #2b2d42 !important; display: none; }
        .daterangepicker .ranges { float: left !important; padding-right: 20px; border-right: 1px solid #f1f5f9 !important; margin-top: 0 !important; }
        .daterangepicker .ranges ul { width: 140px !important; }
        .daterangepicker .ranges li { font-size: 13px !important; font-weight: 500 !important; color: #64748b !important; background-color: #ffffff !important; border: 1px solid #EBE3DB !important; border-radius: 8px !important; padding: 10px 12px !important; margin-bottom: 8px !important; text-align: center !important; transition: all 0.2s ease; }
        .daterangepicker .ranges li:hover { background-color: #faf7f5 !important; color: #8a5a36 !important; border-color: #8a5a36 !important; }
        .daterangepicker .ranges li.active { background-color: #8a5a36 !important; color: #ffffff !important; border-color: #8a5a36 !important; }
        .daterangepicker .drp-calendar { padding: 0 16px !important; }
        .daterangepicker .calendar-table { border: none !important; background-color: transparent !important; }
        .daterangepicker th.month { font-size: 15px !important; font-weight: 700 !important; color: #2b2d42 !important; padding-bottom: 12px !important; }
        .daterangepicker th.prev span, .daterangepicker th.next span { border-color: #94a3b8 !important; }
        .daterangepicker th.prev:hover, .daterangepicker th.next:hover { background-color: transparent !important; }
        .daterangepicker th.prev:hover span, .daterangepicker th.next:hover span { border-color: #8a5a36 !important; }
        .daterangepicker th { color: #94a3b8 !important; font-weight: 500 !important; font-size: 12px !important; }
        .daterangepicker td { width: 32px !important; height: 32px !important; font-size: 13px !important; font-weight: 500 !important; border-radius: 6px !important; transition: 0.2s; }
        .daterangepicker td.in-range { background-color: #F4EFEA !important; color: #8a5a36 !important; border-radius: 0 !important; }
        .daterangepicker td.active, .daterangepicker td.active:hover { background-color: #8a5a36 !important; color: #ffffff !important; border-radius: 6px !important; box-shadow: 0 2px 6px rgba(138, 90, 54, 0.3) !important; }
        .daterangepicker td.available:hover { background-color: #EBE1D7 !important; color: #8a5a36 !important; }
        .daterangepicker td.off, .daterangepicker td.off.in-range, .daterangepicker td.off.start-date, .daterangepicker td.off.end-date { color: #cbd5e1 !important; background-color: transparent !important; font-weight: 400 !important; }
        .daterangepicker .drp-buttons { border-top: 1px solid #EBE3DB !important; padding: 16px 0 0 0 !important; margin-top: 8px !important; display: flex !important; align-items: center !important; justify-content: flex-end !important; gap: 12px; }
        .daterangepicker .drp-selected { font-size: 13px !important; font-weight: 500 !important; color: #64748b !important; margin-right: auto !important; padding-left: 160px !important; }
        .daterangepicker .cancelBtn { background: transparent !important; border: 1px solid #EBE3DB !important; color: #64748b !important; font-weight: 600 !important; border-radius: 8px !important; padding: 8px 20px !important; }
        .daterangepicker .cancelBtn:hover { background: #f1f5f9 !important; }
        .daterangepicker .applyBtn { background: #8a5a36 !important; border: none !important; color: white !important; font-weight: 600 !important; border-radius: 8px !important; padding: 8px 24px !important; }
        .daterangepicker .applyBtn:hover { background: #734a2c !important; }

        @media (max-width: 768px) {
            .laporan-card { padding: 16px; }
            .date-filter-group { max-width: 100%; margin-bottom: 10px;}
            #formFilterIndex { flex-direction: column; align-items: stretch !important;}
            .btn-export { justify-content: center; }
            .laporan-table-header { flex-direction: column; gap: 8px; }
            .laporan-table-header > div { flex: 0 0 auto !important; width: 100%; }
            .laporan-table-row { flex-direction: column; gap: 8px; }
            .laporan-table-row > div { flex: 0 0 auto !important; width: 100%; }
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
        <a href="#" class="active">Penjualan</a>
        <a href="{{ route('laporan.transaksi') }}">Transaksi</a>
        <a href="{{ route('laporan.opname') }}">Opname</a>
    </div>

    <!-- Filter & Export Action Bar -->
    <form action="{{ route('laporan.index') }}" method="GET" id="formFilterIndex" class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <!-- Date Picker Custom -->
        <div class="date-filter-group">
            <input type="hidden" name="start_date" id="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" id="end_date" value="{{ $endDate }}">

            <button type="button" class="btn btn-date-custom px-3 py-2" onclick="ubahPeriode(-1)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button type="button" class="btn btn-date-custom btn-date-center py-2 gap-2" id="daterange-btn">
                <span id="date-text">{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}{{ $startDate != $endDate ? ' - ' . \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '' }}</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <button type="button" class="btn btn-date-custom px-3 py-2" onclick="ubahPeriode(1)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
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
            <div class="laporan-sidebar nav flex-row flex-md-column flex-nowrap flex-md-wrap overflow-auto" role="tablist" style="gap: 4px;">
                <a href="#tab-ringkasan" class="active text-nowrap" data-bs-toggle="tab" role="tab">Ringkasan Penjualan</a>
                <a href="#tab-metode" class="text-nowrap" data-bs-toggle="tab" role="tab">Metode Pembayaran</a>
                <a href="#tab-jenis" class="text-nowrap" data-bs-toggle="tab" role="tab">Jenis Penjualan</a>
                <a href="#tab-menu" class="text-nowrap" data-bs-toggle="tab" role="tab">Penjualan Menu</a>
                <a href="#tab-kategori" class="text-nowrap" data-bs-toggle="tab" role="tab">Penjualan Kategori</a>
            </div>
        </div>

        <!-- Kolom Kanan (Card Tabel) -->
        <div class="col-md-9">
            <div class="tab-content">
                
                <!-- ================= TAB 1: RINGKASAN PENJUALAN ================= -->
                <div class="tab-pane fade show active" id="tab-ringkasan" role="tabpanel">
                    <div class="laporan-card">
                        <h4 class="laporan-card-title">Ringkasan Penjualan</h4>
                        <div class="laporan-table-header">
                            <span>Keterangan</span>
                            <span>Nilai</span>
                        </div>
                        <div class="laporan-table-row">
                            <span>Penjualan Kotor</span>
                            <span class="row-bold">Rp{{ number_format($totalPenjualanKotor, 0, ',', '.') }}</span>
                        </div>
                        <div class="laporan-table-row">
                            <span>Pesanan Batal</span>
                            <span class="row-bold">Rp{{ number_format($totalPesananBatal, 0, ',', '.') }}</span>
                        </div>
                        <div class="laporan-table-row">
                            <span class="row-bold">Penjualan Bersih</span>
                            <span class="row-bold">Rp{{ number_format($totalPenjualanBersih, 0, ',', '.') }}</span>
                        </div>
                        <div class="laporan-table-row">
                            <span class="row-bold">Total Pendapatan</span>
                            <span class="row-bold">Rp{{ number_format($totalPenjualanBersih, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 2: METODE PEMBAYARAN ================= -->
                <div class="tab-pane fade" id="tab-metode" role="tabpanel">
                    <div class="laporan-card">
                        <h4 class="laporan-card-title">Metode Pembayaran</h4>
                        <div class="laporan-table-header d-none d-md-flex">
                            <div style="flex: 0 0 40%;">Metode Pembayaran</div>
                            <div style="flex: 0 0 30%;">Jumlah Transaksi</div>
                            <div style="flex: 0 0 30%;">Total Pendapatan</div>
                        </div>
                        @foreach($metodePembayaran as $metode)
                        <div class="laporan-table-row d-flex align-items-md-center">
                            <div style="flex: 0 0 40%; font-weight: 600;"><span class="d-md-none text-muted small d-block">Metode: </span>{{ $metode['metode'] }}</div>
                            <div style="flex: 0 0 30%; font-weight: 600;"><span class="d-md-none text-muted small d-block">Jumlah: </span>{{ $metode['jumlah_transaksi'] }}</div>
                            <div style="flex: 0 0 30%; font-weight: 600;"><span class="d-md-none text-muted small d-block">Total: </span>Rp{{ number_format($metode['total_pendapatan'], 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                        @if($metodePembayaran->isEmpty())
                        <div class="laporan-table-row text-center d-block text-muted">Tidak ada data</div>
                        @endif
                        <div class="laporan-table-row d-flex align-items-md-center mt-3 pt-3" style="border-top: 2px solid #EBE3DB;">
                            <div style="flex: 0 0 40%; font-weight: 700; color: #1e1e1e;">Total</div>
                            <div style="flex: 0 0 30%; font-weight: 700; color: #1e1e1e;"><span class="d-md-none text-muted small d-block">Jumlah: </span>{{ $totalTransaksi }}</div>
                            <div style="flex: 0 0 30%; font-weight: 700; color: #1e1e1e;"><span class="d-md-none text-muted small d-block">Total: </span>Rp{{ number_format($totalPenjualanBersih, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 3: JENIS PENJUALAN ================= -->
                <div class="tab-pane fade" id="tab-jenis" role="tabpanel">
                    <div class="laporan-card">
                        <h4 class="laporan-card-title">Jenis Penjualan</h4>
                        <div class="laporan-table-header d-none d-md-flex">
                            <div style="flex: 0 0 40%;">Jenis Penjualan</div>
                            <div style="flex: 0 0 30%;">Jumlah Transaksi</div>
                            <div style="flex: 0 0 30%;">Total Pendapatan</div>
                        </div>
                        @foreach($jenisPenjualan as $jenis)
                        <div class="laporan-table-row d-flex align-items-md-center">
                            <div style="flex: 0 0 40%; font-weight: 600;"><span class="d-md-none text-muted small d-block">Jenis: </span>{{ $jenis['jenis'] }}</div>
                            <div style="flex: 0 0 30%; font-weight: 600;"><span class="d-md-none text-muted small d-block">Jumlah: </span>{{ $jenis['jumlah_transaksi'] }}</div>
                            <div style="flex: 0 0 30%; font-weight: 600;"><span class="d-md-none text-muted small d-block">Total: </span>Rp{{ number_format($jenis['total_pendapatan'], 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                        @if($jenisPenjualan->isEmpty())
                        <div class="laporan-table-row text-center d-block text-muted">Tidak ada data</div>
                        @endif
                        <div class="laporan-table-row d-flex align-items-md-center mt-3 pt-3" style="border-top: 2px solid #EBE3DB;">
                            <div style="flex: 0 0 40%; font-weight: 700; color: #1e1e1e;">Total</div>
                            <div style="flex: 0 0 30%; font-weight: 700; color: #1e1e1e;"><span class="d-md-none text-muted small d-block">Jumlah: </span>{{ $totalTransaksi }}</div>
                            <div style="flex: 0 0 30%; font-weight: 700; color: #1e1e1e;"><span class="d-md-none text-muted small d-block">Total: </span>Rp{{ number_format($totalPenjualanBersih, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 4: PENJUALAN MENU ================= -->
                <div class="tab-pane fade" id="tab-menu" role="tabpanel">
                    <div class="laporan-card">
                        <h4 class="laporan-card-title">Penjualan Menu</h4>
                        
                        <div style="overflow-x: auto; padding-bottom: 8px;">
                            <table style="width: 100%; border-collapse: separate; border-spacing: 0; white-space: nowrap; font-size: 14px; color: #2b2d42; min-width: 800px;">
                                
                                <thead>
                                    <tr style="background-color: #F4EFEA; color: #64748b; font-size: 13px; font-weight: 600;">
                                        <th style="padding: 14px 20px; border-radius: 8px 0 0 8px; position: sticky; left: 0; background-color: #F4EFEA; z-index: 2; box-shadow: 4px 0 8px -4px rgba(0,0,0,0.05);">Menu</th>
                                        <th style="padding: 14px 20px;">Kategori</th>
                                        <th style="padding: 14px 20px; text-align: center;">Menu Terjual</th>
                                        <th style="padding: 14px 20px; text-align: center;">Menu Batal</th>
                                        <th style="padding: 14px 20px;">Penjualan Kotor</th>
                                        <th style="padding: 14px 20px;">Nominal Batal</th>
                                        <th style="padding: 14px 20px; border-radius: 0 8px 8px 0;">Penjualan Bersih</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @php
                                        $totalMenuTerjual = 0;
                                        $totalMenuBatal = 0;
                                        $totalMenuKotor = 0;
                                        $totalMenuNominalBatal = 0;
                                    @endphp
                                    @forelse($menuSales as $m)
                                    @php
                                        $totalMenuTerjual += $m['terjual'];
                                        $totalMenuBatal += $m['terjual_batal'];
                                        $kotor = $m['pendapatan'] + $m['pendapatan_batal'];
                                        $totalMenuKotor += $kotor;
                                        $totalMenuNominalBatal += $m['pendapatan_batal'];
                                    @endphp
                                    <tr>
                                        <td style="padding: 20px; font-weight: 600; border-bottom: 1px solid #f1f5f9; position: sticky; left: 0; background-color: #ffffff; z-index: 1; box-shadow: 4px 0 8px -4px rgba(0,0,0,0.05);">{{ $m['menu'] }}</td>
                                        <td style="padding: 20px; font-weight: 600; color: #1e1e1e; border-bottom: 1px solid #f1f5f9;">{{ $m['kategori'] }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">{{ $m['terjual'] }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">{{ $m['terjual_batal'] }}</td>
                                        <td style="padding: 20px; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($kotor, 0, ',', '.') }}</td>
                                        <td style="padding: 20px; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($m['pendapatan_batal'], 0, ',', '.') }}</td>
                                        <td style="padding: 20px; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($m['pendapatan'], 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada data</td></tr>
                                    @endforelse
                                    
                                    <!-- Baris Total -->
                                    <tr style="border-top: 2px solid #EBE3DB;">
                                        <td style="padding: 20px; font-weight: 700; color: #1e1e1e; position: sticky; left: 0; background-color: #ffffff; z-index: 1; box-shadow: 4px 0 8px -4px rgba(0,0,0,0.05);">Total</td>
                                        <td style="padding: 20px; border-bottom: none;"></td> 
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">{{ $totalMenuTerjual }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">{{ $totalMenuBatal }}</td>
                                        <td style="padding: 20px; font-weight: 700; color: #1e1e1e; border-bottom: none;">Rp{{ number_format($totalMenuKotor, 0, ',', '.') }}</td>
                                        <td style="padding: 20px; font-weight: 700; color: #1e1e1e; border-bottom: none;">Rp{{ number_format($totalMenuNominalBatal, 0, ',', '.') }}</td>
                                        <td style="padding: 20px; font-weight: 700; color: #1e1e1e; border-bottom: none;">Rp{{ number_format($totalMenuKotor - $totalMenuNominalBatal, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

                <!-- ================= TAB 5: PENJUALAN KATEGORI ================= -->
                <div class="tab-pane fade" id="tab-kategori" role="tabpanel">
                    <div class="laporan-card">
                        <h4 class="laporan-card-title">Penjualan Kategori</h4>
                        
                        <div style="overflow-x: auto; padding-bottom: 8px;">
                            <table style="width: 100%; border-collapse: separate; border-spacing: 0; white-space: nowrap; font-size: 14px; color: #2b2d42; min-width: 800px;">
                                
                                <thead>
                                    <tr style="background-color: #F4EFEA; color: #64748b; font-size: 13px; font-weight: 600;">
                                        <th style="padding: 14px 20px; border-radius: 8px 0 0 8px; position: sticky; left: 0; background-color: #F4EFEA; z-index: 2; box-shadow: 4px 0 8px -4px rgba(0,0,0,0.05);">Kategori</th>
                                        <th style="padding: 14px 20px; text-align: center;">Menu Terjual</th>
                                        <th style="padding: 14px 20px; text-align: center;">Menu Batal</th>
                                        <th style="padding: 14px 20px; text-align: center;">Penjualan Kotor</th>
                                        <th style="padding: 14px 20px; text-align: center;">Nominal Batal</th>
                                        <th style="padding: 14px 20px; border-radius: 0 8px 8px 0; text-align: center;">Penjualan Bersih</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @php
                                        $totalKatTerjual = 0;
                                        $totalKatBatal = 0;
                                        $totalKatKotor = 0;
                                        $totalKatNominalBatal = 0;
                                    @endphp
                                    @forelse($kategoriSales as $k)
                                    @php
                                        $totalKatTerjual += $k['terjual'];
                                        $totalKatBatal += $k['terjual_batal'];
                                        $kotor = $k['pendapatan'] + $k['pendapatan_batal'];
                                        $totalKatKotor += $kotor;
                                        $totalKatNominalBatal += $k['pendapatan_batal'];
                                    @endphp
                                    <tr>
                                        <td style="padding: 20px; font-weight: 600; color: #1e1e1e; border-bottom: 1px solid #f1f5f9; position: sticky; left: 0; background-color: #ffffff; z-index: 1; box-shadow: 4px 0 8px -4px rgba(0,0,0,0.05);">{{ $k['kategori'] }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">{{ $k['terjual'] }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">{{ $k['terjual_batal'] }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($kotor, 0, ',', '.') }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($k['pendapatan_batal'], 0, ',', '.') }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Rp{{ number_format($k['pendapatan'], 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data</td></tr>
                                    @endforelse
                                    
                                    <!-- Baris Total -->
                                    <tr style="border-top: 2px solid #EBE3DB;">
                                        <td style="padding: 20px; font-weight: 700; color: #1e1e1e; position: sticky; left: 0; background-color: #ffffff; z-index: 1; box-shadow: 4px 0 8px -4px rgba(0,0,0,0.05);">Total</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">{{ $totalKatTerjual }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">{{ $totalKatBatal }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">Rp{{ number_format($totalKatKotor, 0, ',', '.') }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">Rp{{ number_format($totalKatNominalBatal, 0, ',', '.') }}</td>
                                        <td style="padding: 20px; text-align: center; font-weight: 700; color: #1e1e1e; border-bottom: none;">Rp{{ number_format($totalKatKotor - $totalKatNominalBatal, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

            </div> <!-- Tutup Tab Content -->
        </div> <!-- Tutup Kolom Kanan -->

    </div> <!-- Tutup Row -->
@endsection

@push('scripts')
<!-- ================= KONFIGURASI DATERANGEPICKER ================= -->
<script>
    function ubahPeriode(offset) {
        var start = moment($('#start_date').val());
        var end = moment($('#end_date').val());
        
        start.add(offset, 'days');
        end.add(offset, 'days');
        
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        document.getElementById('formFilterIndex').submit();
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
        }, function(start, end) {
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            document.getElementById('formFilterIndex').submit();
        });

        updateDateText(start, end);
    });
</script>
@endpush
