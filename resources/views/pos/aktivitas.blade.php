@extends('layouts.pos')

@section('title', 'Aktivitas - DariKopi')

@push('styles')
<style>
/* ================= MAIN CONTENT (Aktivitas) ================= */
.main-wrapper {
    height: calc(100vh - 70px);
}

.content-area {
    flex: 1;
    overflow-y: auto;
    padding-right: 8px;
}
.content-area::-webkit-scrollbar { display: none; }

.page-header h1 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 4px;
}
.page-header p {
    font-size: 13px;
    color: var(--text-gray);
    margin-bottom: 24px;
}

/* --- FIlter Controls --- */
.filter-controls {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}
.filter-box {
    background: white;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    color: var(--text-gray);
    font-size: 13px;
}
.filter-search {
    flex: 1;
    max-width: 350px;
}
.filter-search input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 13px;
    color: var(--text-dark);
}
.filter-date, .filter-status {
    cursor: pointer;
    font-weight: 500;
    color: var(--text-dark);
    justify-content: space-between;
}
.filter-date svg, .filter-status svg {
    color: var(--text-dark);
}

/* --- List Transaksi --- */
.trx-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding-bottom: 40px;
}
.trx-card {
    background: white;
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    cursor: pointer;
    transition: 0.2s;
    border: 1px solid transparent;
}
.trx-card:hover {
    border-color: var(--primary-brown);
    transform: translateY(-2px);
}

.trx-left {
    width: 25%;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.trx-id {
    font-weight: 700;
    font-size: 14px;
    color: var(--text-dark);
}
.trx-price {
    font-weight: 700;
    font-size: 14px;
    color: var(--primary-brown);
}

.trx-center {
    flex: 1;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
}

.trx-right {
    width: 25%;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 20px;
}
.trx-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}
.trx-time {
    font-size: 11px;
    color: var(--text-gray);
}
.badge-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}
.status-selesai {
    background-color: #ECFDF3;
    color: #12B76A;
}
.status-batal {
    background-color: #FEF3F2;
    color: #F04438;
}
.trx-arrow {
    color: #D0D5DD;
}

/* ================= PAGINATION ================= */
.pagination .page-link:focus { 
    box-shadow: 0 0 0 0.25rem rgba(138, 90, 54, 0.25); 
    color: var(--primary-brown); 
}
.pagination .page-link:hover { 
    color: var(--primary-brown); 
    background-color: #FCF9F6; 
    border-color: #EBE3DB; 
}
.pagination .page-item .page-link { 
    border: 1px solid #EBE3DB; 
    color: #94a3b8; 
    border-radius: 8px; 
    margin: 0 4px; 
    font-size: 13px; 
    font-weight: 500; 
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 10px;
    background-color: white;
}
.pagination .page-item.active .page-link { 
    background-color: var(--primary-brown); 
    border-color: var(--primary-brown); 
    color: white; 
}
.pagination .page-item.disabled .page-link {
    background-color: #F1F5F9;
    border-color: #EBE3DB;
    color: #94a3b8;
    cursor: not-allowed;
    opacity: 0.8;
}
.pagination .page-link svg {
    width: 14px; 
    height: 14px;
}
.pagination .page-item:last-child:not(.disabled) .page-link {
    color: var(--primary-brown);
}

/* ================= HILANGKAN SCROLLBAR MODAL ================= */
.modal::-webkit-scrollbar {
    display: none;
}
.modal {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* CSS Tambahan Khusus Filter */
.input-aesthetic-filter {
    border: none; outline: none; background: transparent;
    font-family: 'Poppins', sans-serif; font-size: 13px;
    font-weight: 500; color: var(--text-dark); width: 100%;
}
.filter-date-btn {
    cursor: pointer; color: var(--text-dark); transition: 0.2s;
    display: flex; align-items: center; justify-content: center;
}
.filter-date-btn:hover { color: var(--primary-brown); }

/* Custom Dropdown Status */
.dropdown-menu-custom {
    border-radius: 12px; border: 1px solid var(--border-color);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 8px;
}
.dropdown-item-custom {
    border-radius: 8px; font-size: 13px; font-weight: 500;
    color: var(--text-gray); padding: 8px 12px; transition: 0.2s;
}
.dropdown-item-custom:hover, .dropdown-item-custom.active {
    background-color: var(--active-bg); color: var(--primary-brown);
}

@media (max-width: 768px) {
    .filter-controls {
        flex-direction: column;
    }
    .filter-search, .filter-date, .filter-status-container {
        max-width: 100%;
        width: 100%;
    }
    .trx-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .trx-left, .trx-center, .trx-right {
        width: 100%;
        text-align: left;
    }
    .trx-right {
        justify-content: space-between;
    }
}
</style>
@endpush

@section('content')
<div class="main-wrapper">
    <div class="content-area">
<div class="page-header">
                <h1>Aktivitas Pesanan</h1>
                <p>Lihat seluruh histori transaksi</p>
            </div>

           <!-- Area Filter -->
<form action="{{ route('pos.aktivitas') }}" method="GET" id="formFilterAktivitas" class="filter-controls d-flex w-100 mb-4">
    
    <!-- CSS Tambahan Khusus Filter -->
    <style>
        .input-aesthetic-filter {
            border: none; outline: none; background: transparent;
            font-family: 'Poppins', sans-serif; font-size: 13px;
            font-weight: 500; color: var(--text-dark); width: 100%;
        }
        .filter-date-btn {
            cursor: pointer; color: var(--text-dark); transition: 0.2s;
            display: flex; align-items: center; justify-content: center;
        }
        .filter-date-btn:hover { color: var(--primary-brown); }
        
        /* Custom Dropdown Status */
        .dropdown-menu-custom {
            border-radius: 12px; border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 8px;
        }
        .dropdown-item-custom {
            border-radius: 8px; font-size: 13px; font-weight: 500;
            color: var(--text-gray); padding: 8px 12px; transition: 0.2s;
        }
        .dropdown-item-custom:hover, .dropdown-item-custom.active {
            background-color: var(--active-bg); color: var(--primary-brown);
        }
    </style>

    <!-- 1. Pencarian (Live Search Instan Tanpa Loading) -->
    <div class="filter-box filter-search flex-grow-1">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <!-- Hapus name dan value backend, murni pakai ID buat JS -->
        <input type="text" id="searchInput" placeholder="Cari Nomor Struk..." class="input-aesthetic-filter" autocomplete="off">
    </div>
    
    <!-- 2. Filter Tanggal (Mockup Style: Chevron Kiri Kanan) -->
    @php
        // Ambil tanggal dari request, kalau kosong pakai hari ini
        $currentDate = request('date', now()->format('Y-m-d'));
        // Format untuk ditampilin di layar (contoh: 13/01/2026)
        $displayDate = \Carbon\Carbon::parse($currentDate)->format('d/m/Y');
    @endphp
    <div class="filter-box filter-date d-flex align-items-center justify-content-between px-3" style="min-width: 170px;">
        <input type="hidden" name="date" id="dateInput" value="{{ $currentDate }}">
        
        <!-- Chevron Kiri (Minus 1 Hari) -->
        <div class="filter-date-btn" onclick="ubahTanggal(-1)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </div>
        
        <!-- Text Tanggal -->
        <span class="fw-semibold" style="font-size: 13px; color: var(--text-dark);">{{ $displayDate }}</span>
        
        <!-- Chevron Kanan (Plus 1 Hari) -->
        <div class="filter-date-btn" onclick="ubahTanggal(1)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </div>

    <!-- 3. Filter Status (Custom Dropdown Anti-Bug) -->
    <div class="position-relative filter-status-container" id="customDropdownStatus" style="min-width: 150px;">
        <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
        
        <!-- Tombol Pemicu -->
        <button type="button" class="filter-box filter-status d-flex align-items-center justify-content-between w-100" onclick="toggleDropdown()" style="background: white; outline: none; border: 1px solid transparent; text-align: left;">
            <span class="fw-medium" style="font-size: 13px;">
                {{ request('status') ?: 'Semua Status' }}
            </span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        
        <!-- Menu Dropdown (Murni CSS & JS kita) -->
        <ul class="dropdown-menu-custom position-absolute w-100 d-none" id="dropdownMenuStatus" style="top: 100%; left: 0; margin-top: 8px; margin-bottom: 0; z-index: 9999; background: white; list-style: none; padding: 8px;">
            <li style="margin-bottom: 4px;">
                <a class="dropdown-item-custom d-block text-decoration-none {{ request('status') == '' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, '')">Semua Status</a>
            </li>
            <li style="margin-bottom: 4px;">
                <a class="dropdown-item-custom d-block text-decoration-none {{ request('status') == 'Selesai' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Selesai')">Selesai</a>
            </li>
            <li>
                <a class="dropdown-item-custom d-block text-decoration-none {{ request('status') == 'Batal' ? 'active' : '' }}" href="#" onclick="pilihStatus(event, 'Batal')">Batal</a>
            </li>
        </ul>
    </div>
</form>

            <!-- List Transaksi -->
            <div class="trx-list">
                @forelse($transaksis as $trx)
                
                <!-- 1. KOTAK TRANSAKSI -->
                <div class="trx-card" data-bs-toggle="modal" data-bs-target="#detailTransaksiModal-{{ $trx->id }}">
                    <div class="trx-left">
                        <span class="trx-id">{{ $trx->kode_transaksi }}</span>
                        <span class="trx-price">Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="trx-center">
                        @php
                            $items = [];
                            foreach($trx->detail_transaksis as $detail) {
                                $namaMenu = $detail->menu ? $detail->menu->nama_menu : 'Menu Dihapus';
                                $items[] = $namaMenu . ($detail->qty > 1 ? ' x' . $detail->qty : '');
                            }
                            echo implode(', ', $items);
                        @endphp
                    </div>

                    <div class="trx-right">
                        <div class="trx-info">
                            <span class="trx-time">{{ $trx->created_at->format('H:i') }} WIB</span>
                            @if($trx->status == 'Batal')
    <span class="badge-status status-batal">Batal</span>
@else
    <span class="badge-status status-selesai">Selesai</span>
@endif
                        </div>
                        <svg class="trx-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </div>

                <!-- 2. MODAL DETAIL TRANSAKSI -->
                <div class="modal fade" id="detailTransaksiModal-{{ $trx->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; padding: 12px 16px;">
                            
                            <!-- Modal Header -->
<div class="modal-header border-0 pb-4 align-items-center"> <!-- pb-2 diganti jadi pb-4 biar jarak bawahnya lega -->
    <h5 class="modal-title fw-bold mb-0" style="color: #000; font-size: 1.15rem;">
        Detail Transaksi
    </h5>
    
    <div class="d-flex align-items-center gap-3">
        @if($trx->status == 'Batal')
            <span class="badge-status status-batal">Batal</span>
        @else
            <span class="badge-status status-selesai">Selesai</span>
        @endif
        
        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.8rem;"></button>
    </div>
</div>

<!-- Modal Body -->
<div class="modal-body pt-1 pb-2" style="font-size: 0.95rem; color: #111;"> <!-- pt-0 dinaikin dikit jadi pt-1 -->
    
    <!-- Info Meta -->
    <div class="d-flex justify-content-between mb-4"> <!-- mb-3 diganti mb-4 biar jarak antar barisnya juga lebih enak dilihat -->
        <span>Metode Pembayaran</span>
        <span class="text-end">{{ $trx->metode_pembayaran ?? 'Tunai' }}</span>
    </div>
    <div class="d-flex justify-content-between mb-4">
        <span>Nomor Struk</span>
        <span class="text-end">{{ $trx->kode_transaksi }}</span>
    </div>
    <div class="d-flex justify-content-between mb-4">
        <span>Waktu Pembelian</span>
        <span class="text-end">{{ $trx->created_at->translatedFormat('d F Y \p\a\d\a H:i') }}</span>
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

                                <!-- Rincian Harga (Udah Dirapihin) -->
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
        <!-- mt-4 diubah jadi mt-2 biar naik, ditambah mb-3 biar bawahnya nggak mepet -->
        <div class="mt-2 mb-3 d-flex flex-column gap-2">
            <!-- Kotak Alasan Pembatalan -->
            <div class="text-start" style="background-color: #FEF2F2; border: 1px solid #FEE2E2; border-radius: 12px; padding: 16px;">
                <div class="fw-medium mb-1" style="font-size: 12px; color: #EF4444;">Alasan pembatalan</div>
                <div class="fw-semibold" style="font-size: 14px; color: #991B1B; line-height: 1.4;">
                    {{ $trx->alasan_batal ?? '-' }}
                </div>
            </div>
            
            <!-- Tombol Tutup Outline -->
            <button type="button" class="btn w-100 fw-semibold mt-1" data-bs-dismiss="modal" style="background-color: white; border: 1px solid var(--border-color); color: var(--text-dark); border-radius: 12px; padding: 12px 0; font-size: 14px;">
                Tutup
            </button>
        </div>
    @else
        <!-- FOOTER VERSI SELESAI (Normal) -->
    <div class="d-flex gap-3 mt-2 mb-3" style="background-color: #F9F9F9; padding: 12px; border-radius: 12px;">
        <a href="{{ route('pos.print', $trx->id) }}" target="_blank" class="btn flex-fill fw-bold d-flex align-items-center justify-content-center" style="background-color: #8C593B; color: white; border-radius: 8px; padding: 12px 0; text-decoration: none; font-size: 14px;">
            Cetak Struk
        </a>
        
        <!-- Tombol Batalkan (Murni JS Antrean, hapus data-bs-toggle!) -->
        <button type="button" class="btn flex-fill fw-bold" 
            onclick="bukaModalBatal('{{ $trx->id }}', '{{ $trx->kode_transaksi }}', 'Rp{{ number_format($trx->total_harga, 0, ',', '.') }}', 'detailTransaksiModal-{{ $trx->id }}')" 
            style="background-color: #FF4141; color: white; border-radius: 8px; padding: 12px 0; font-size: 14px;">
            Batalkan
        </button>
    </div>
    @endif
                            
                        </div>
                    </div>
                </div>
                <!-- AKHIR KOTAK TRANSAKSI & MODAL -->

                @empty
                <!-- Tampilan kosong -->
                <div class="text-center py-5" style="color: var(--text-gray);">
                    <svg class="mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                    <h5>Belum ada aktivitas pesanan</h5>
                    <p>Transaksi yang diselesaikan akan muncul di sini.</p>
                </div>
                @endforelse
            </div>

            <!-- Tombol Pagination -->
            <div class="mt-4 mb-5 w-100">
                {{ $transaksis->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- ================= MODAL KONFIRMASI BATALKAN TRANSAKSI (PREMIUM UI) ================= -->
<div class="modal fade" id="modalBatalkanTransaksi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Background putih bersih, shadow lembut, border radius besar khas tema lu -->
        <div class="modal-content shadow-lg" style="border-radius: 20px; border: none; padding: 24px;">
            <div class="modal-body p-0 text-start">
                
                <!-- Judul & Info -->
                <h4 class="fw-bold mb-1" style="color: var(--text-dark);">Batalkan transaksi</h4>
                <p class="mb-4" style="color: var(--text-gray); font-size: 14px;">
                    Kode: <span id="text-kode-batal" class="fw-medium">TRX-XXX</span> &bull; 
                    <span id="text-harga-batal" class="fw-medium">Rp0</span>
                </p>

                <!-- Input Alasan -->
                <div class="mb-4">
                    <label for="input-alasan-batal" class="form-label fw-semibold" style="font-size: 14px; color: var(--text-dark);">
                        Alasan pembatalan <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control input-aesthetic" id="input-alasan-batal" rows="3" placeholder="Contoh: Salah input menu" style="border-radius: 12px; border: 1px solid var(--border-color); font-size: 14px; resize: none; background-color: #FAFAFA; color: var(--text-dark); padding: 12px 16px;"></textarea>
                    
                    <!-- Styling khusus biar pas diklik (focus) warnanya jadi cokelat -->
                    <style>
                        .input-aesthetic:focus {
                            border-color: var(--primary-brown) !important;
                            box-shadow: 0 0 0 0.25rem rgba(122, 78, 51, 0.15) !important;
                            background-color: #FFFFFF !important;
                        }
                    </style>
                </div>

                <!-- Tombol Aksi (Kiri-Kanan) -->
                <div class="d-flex gap-3">
                   <!-- Tombol Kembali (Murni JS Antrean) -->
<button type="button" class="btn w-50" id="btn-kembali-modal" onclick="kembaliKeDetail()" style="background-color: #F3F4F6; color: #374151; border-radius: 10px; font-weight: 600;">
    Kembali
</button>
                    <!-- Warna tombol merah disesuaikan biar tetep elegan -->
                    <button type="button" class="btn w-50" id="btn-konfirmasi-batal" style="background-color: #DC2626; color: white; border: none; border-radius: 12px; font-weight: 600; padding: 12px 0; font-size: 15px;">Ya, batalkan</button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Script Bootstrap 5 (Wajib Paling Atas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
</div>
</div>

@push('scripts')
<script>
        let activeDetailModalId = null; // Menyimpan ID modal rincian yang lagi aktif
        let queuedModalPOS = null;      // Menyimpan antrean modal yang mau dibuka

        // =====================================================================
        // 1. SISTEM PENGATUR LALU LINTAS MODAL (ANTI TABRAKAN / LAYAR GELAP)
        // =====================================================================
        document.addEventListener('hidden.bs.modal', function () {
            if (queuedModalPOS) {
                // Kalau ada antrean modal, buka sekarang
                bootstrap.Modal.getOrCreateInstance(document.getElementById(queuedModalPOS)).show();
                queuedModalPOS = null; // Kosongkan antrean
            } else {
                // Kalau beneran mau tutup semua, bersihin layar sampai tuntas
                if (document.querySelectorAll('.modal.show').length === 0) {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.paddingRight = '';
                    document.body.style.overflow = '';
                }
            }
        });

        // =====================================================================
        // 2. MAJU KE MODAL KONFIRMASI BATAL
        // =====================================================================
        function bukaModalBatal(idTransaksi, kodeTransaksi, hargaTransaksi, modalDetailId) {
            // Isi data
            document.getElementById('text-kode-batal').innerText = kodeTransaksi;
            document.getElementById('text-harga-batal').innerText = hargaTransaksi;
            document.getElementById('input-alasan-batal').value = '';
            document.getElementById('btn-konfirmasi-batal').setAttribute('data-id', idTransaksi);

            // Simpan jejak biar tau jalan pulang
            activeDetailModalId = modalDetailId;
            
            // Masukin modal batal ke antrean
            queuedModalPOS = 'modalBatalkanTransaksi';

            // Tutup modal detail (Sistem lalu lintas otomatis ngebuka modal batal setelah ini ketutup)
            let detailModal = bootstrap.Modal.getInstance(document.getElementById(modalDetailId));
            if (detailModal) detailModal.hide();
        }

        // =====================================================================
        // 3. MUNDUR KE MODAL DETAIL (TOMBOL KEMBALI)
        // =====================================================================
        function kembaliKeDetail() {
            if (!activeDetailModalId) return;

            // Masukin modal detail ke antrean
            queuedModalPOS = activeDetailModalId;

            // Tutup modal batal (Sistem lalu lintas otomatis ngebuka modal detail lagi)
            let batalModal = bootstrap.Modal.getInstance(document.getElementById('modalBatalkanTransaksi'));
            if (batalModal) batalModal.hide();
        }

        // =====================================================================
        // 4. FUNGSI FETCH KIRIM DATA KE DATABASE
        // =====================================================================
        document.getElementById('btn-konfirmasi-batal').addEventListener('click', function() {
            let idTrx = this.getAttribute('data-id');
            let alasan = document.getElementById('input-alasan-batal').value;

            if (alasan.trim() === '') {
                alert('Alasan pembatalan wajib diisi ya, der!');
                return;
            }

            let btn = this;
            let originalText = btn.innerText;
            btn.innerText = 'Memproses...';
            btn.disabled = true;

            fetch(`/pos/aktivitas/batal/${idTrx}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ alasan: alasan })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal: ' + data.message);
                    btn.innerText = originalText;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada sistem, coba lagi nanti.');
                btn.innerText = originalText;
                btn.disabled = false;
            });
        });
    </script>

    <!-- Script Logika Filter & Pencarian -->
    <script>
        const formFilter = document.getElementById('formFilterAktivitas');

        // ==========================================
        // 1. LIVE SEARCH INSTAN (MURNI FRONTEND)
        // ==========================================
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function () {
            // Ambil kata yang lu ketik dan ubah ke huruf kecil semua
            let keyword = this.value.toLowerCase();
            
            // Ambil semua elemen kotak transaksi di layar
            let listTransaksi = document.querySelectorAll('.trx-card');

            listTransaksi.forEach(function(kartu) {
                // Cari teks nomor struk di dalam kotak transaksi itu
                let noStruk = kartu.querySelector('.trx-id').innerText.toLowerCase();
                
                // Kalau nomor struk mengandung kata yang diketik, tampilkan! Kalau nggak, sembunyikan!
                if (noStruk.includes(keyword)) {
                    kartu.style.setProperty('display', 'flex', 'important');
                } else {
                    kartu.style.setProperty('display', 'none', 'important');
                }
            });
        });

        // ==========================================
        // 2. NAVIGASI TANGGAL (Chevron Kiri/Kanan)
        // ==========================================
        function ubahTanggal(hari) {
            let dateInput = document.getElementById('dateInput');
            // Ambil value tanggal sekarang, ubah jadi objek Date JavaScript
            let currentDate = new Date(dateInput.value);
            
            // Tambah/Kurang hari
            currentDate.setDate(currentDate.getDate() + hari);
            
            // Format balik ke YYYY-MM-DD
            let year = currentDate.getFullYear();
            let month = String(currentDate.getMonth() + 1).padStart(2, '0');
            let day = String(currentDate.getDate()).padStart(2, '0');
            
            // Masukin ke input hidden, lalu submit form
            dateInput.value = `${year}-${month}-${day}`;
            formFilter.submit();
        }

        // ==========================================
        // 3. DROPDOWN STATUS (VANILLA JS)
        // ==========================================
        // Fungsi Buka/Tutup Menu
        function toggleDropdown() {
            document.getElementById('dropdownMenuStatus').classList.toggle('d-none');
        }

        // Fungsi Auto-tutup kalau user ngeklik sembarang tempat (di luar dropdown)
        document.addEventListener('click', function(event) {
            const container = document.getElementById('customDropdownStatus');
            const menu = document.getElementById('dropdownMenuStatus');
            if (container && !container.contains(event.target)) {
                menu.classList.add('d-none'); // Sembunyikan kalau klik di luar
            }
        });

        // Fungsi Memilih Status & Submit
        function pilihStatus(event, status) {
            event.preventDefault(); // Mencegah halaman loncat ke atas
            document.getElementById('statusInput').value = status;
            document.getElementById('dropdownMenuStatus').classList.add('d-none'); // Tutup menu
            formFilter.submit(); // Kirim data ke backend
        }
    </script>

    <!-- Script Jam Realtime -->
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
</body>
</html>
@endpush
@endsection
