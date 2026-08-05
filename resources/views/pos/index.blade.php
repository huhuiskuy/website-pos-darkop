@extends('layouts.pos')

@section('title', 'Point of Sale - DariKopi')

@push('styles')
<style>
/* Pos index specific styles */
/* Hide scrollbar for aesthetics */
.menu-area::-webkit-scrollbar { display: none; }
.cart-items::-webkit-scrollbar { display: none; }

body { overflow: hidden; } /* Ensure it stays non-scrollable like the old design */

/* ================= MAIN CONTENT ================= */
.main-wrapper {
    height: calc(100vh - 70px);
}

/* --- KIRI: AREA MENU --- */
.menu-area {
    flex: 1;
    overflow-y: auto;
    padding-right: 8px;
}

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

/* Search & Filter */
.search-filter-row {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}
.search-box {
    flex: 1;
    display: flex;
    align-items: center;
    background: white;
    border-radius: 12px;
    padding: 0 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}
.search-box input {
    border: none;
    outline: none;
    width: 100%;
    padding: 12px;
    font-size: 13px;
    color: var(--text-dark);
}
.filter-box {
    background: white;
    border-radius: 12px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    border: 1px solid transparent;
}
.filter-box:focus { border-color: var(--primary-brown); }
.dropdown-menu-custom { padding: 8px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.dropdown-item-custom { border-radius: 8px; font-size: 13px; font-weight: 500; color: var(--text-gray); padding: 8px 12px; transition: 0.2s; }
.dropdown-item-custom:hover, .dropdown-item-custom.active { background-color: var(--active-bg); color: var(--primary-brown); }

/* Category Pills */
.category-pills {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    overflow-x: auto;
    padding-bottom: 4px;
}
.category-pills::-webkit-scrollbar { display: none; }

.pill {
    padding: 8px 24px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    background: white;
    color: var(--text-gray);
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    transition: 0.2s;
    white-space: nowrap;
}
.pill.active {
    background: var(--primary-brown);
    color: white;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}
.product-card {
    background: white;
    border-radius: 16px;
    padding: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    cursor: pointer;
    transition: 0.2s;
}
.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
}
.img-placeholder {
    background-color: var(--active-bg);
    border-radius: 12px;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #CDBAB0;
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 12px;
}
.prod-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
}
.prod-category {
    font-size: 11px;
    color: var(--text-gray);
    margin-bottom: 12px;
}
.prod-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.prod-price {
    font-size: 14px;
    font-weight: 700;
    color: var(--primary-brown);
}
.btn-add {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background-color: var(--primary-brown);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    line-height: 1;
    cursor: pointer;
}

/* --- KANAN: AREA KERANJANG --- */
.cart-sidebar {
    width: 360px;
    background: white;
    border-radius: 20px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    height: 100%;
}
.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.cart-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}
.cart-subtitle {
    font-size: 12px;
    color: var(--text-gray);
}
.btn-empty {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #FEF0F0;
    color: #D9534F;
    border: none;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

/* Cart Items */
.cart-items {
    flex: 1;
    overflow-y: auto;
}
.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    margin-bottom: 12px;
}
.item-info {
    flex: 1;
}
.item-title {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 4px;
}
.item-price {
    font-size: 12px;
    font-weight: 500;
    color: var(--text-gray);
}
.item-controls {
    display: flex;
    align-items: center;
    gap: 12px;
}
.qty-btn {
    background: none;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    padding: 0 4px;
}
.qty-num {
    font-size: 13px;
    font-weight: 600;
}
.btn-delete {
    background: #FEF0F0;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #D9534F;
    cursor: pointer;
    margin-left: 8px;
}

/* Tipe Penjualan Toggle */
.order-type-box {
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 16px;
    margin-top: 16px;
}
.order-type-title {
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
}
.order-type-toggle {
    display: flex;
    gap: 8px;
}
.type-btn {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    border: 1px solid var(--border-color);
    background: white;
    color: var(--text-dark);
}
.type-btn.active {
    background: var(--primary-brown);
    color: white;
    border-color: var(--primary-brown);
}

/* Total & Pay */
.summary-box {
    margin-top: 24px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 16px;
}
.summary-row.total {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 24px;
}
.btn-pay {
    width: 100%;
    padding: 16px;
    background: var(--primary-brown);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s;
}
.btn-pay:hover {
    background: #734F37;
}

/* ================= STYLING KHUSUS MODAL ================= */
.btn-pay-modal {
    background: var(--primary-brown);
    color: white;
    border: 1px solid var(--primary-brown);
    padding: 8px 24px;
    border-radius: 12px; /* Disesuaikan dengan lekukan mockup */
    font-weight: 600;
    font-size: 14px;
    transition: 0.2s;
}

/* Tampilan tombol saat belum bisa diklik (Disabled) */
.btn-pay-modal:disabled {
    background: white;
    color: #CDBAB0; /* Warna teks pudar */
    border-color: var(--border-color);
    cursor: not-allowed;
}

.payment-box {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 24px 20px; /* Jarak atas bawah dilonggarin */
    cursor: pointer;
    transition: 0.2s;
    background: white;
}

/* Opsi tombol di dalam modal (QRIS & Nominal) */
.btn-option {
    background: white;
    border: 1px solid var(--border-color);
    color: var(--primary-brown);
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
    text-align: center;
}

/* Saat opsi atau box luar terpilih (Hanya background, border tetap abu-abu) */
.payment-box.active {
    background-color: #FAFAFA;
    border-color: var(--border-color); /* Memaksa border luar tidak ikut jadi cokelat */
}

/* Border cokelat hanya untuk tombol opsi di dalamnya (QRIS & Nominal) */
.btn-option.active {
    border-color: var(--primary-brown);
    background-color: #FAFAFA;
}

.btn-option:hover {
    border-color: var(--primary-brown);
}

.cash-input {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 14px;
    color: var(--text-dark);
    font-weight: 500;
}

.cash-input:focus {
    border-color: var(--primary-brown);
    box-shadow: none;
    outline: none;
}

/* Responsiveness overrides */
@media (max-width: 991px) {
    /* Menu Area is full width on mobile */
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    }
}
</style>
@endpush

@section('navbar_actions')
    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" style="border-radius: 12px; border-color: var(--border-color); background: white;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary-brown)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <span class="badge bg-danger rounded-pill cart-badge-count" style="font-size: 10px; margin-left: 4px;" id="cart-badge">0</span>
    </button>
@endsection

@section('content')
<div class="main-wrapper">
    <!-- --- KIRI: AREA MENU --- -->
    <div class="menu-area">
<div class="page-header">
                <h1>Point of Sale</h1>
                <p>Pilih item untuk ditambahkan ke keranjang</p>
            </div>

            <!-- Search & Filter -->
            <div class="search-filter-row">
                <!-- Search Box -->
<div class="search-box">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary-brown)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
    <input type="text" id="searchInput" placeholder="Cari menu..." onkeyup="cariMenu()">
</div>
                <!-- Custom Dropdown Sort -->
                <div class="position-relative filter-status-container" id="customDropdownSort" style="min-width: 140px;">
                    <button type="button" class="filter-box w-100" onclick="toggleDropdown('dropdownMenuSort')">
                        <span class="fw-medium" id="labelSort">Semua</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <ul class="dropdown-menu-custom position-absolute w-100 d-none" id="dropdownMenuSort" style="top: 100%; right: 0; margin-top: 8px; margin-bottom: 0; z-index: 9999; background: white; list-style: none;">
                        <li><a class="dropdown-item-custom d-block text-decoration-none active" href="#" onclick="pilihSort(event, 'Semua')">Semua</a></li>
                        <li><a class="dropdown-item-custom d-block text-decoration-none" href="#" onclick="pilihSort(event, 'A-Z')">A-Z</a></li>
                        <li><a class="dropdown-item-custom d-block text-decoration-none" href="#" onclick="pilihSort(event, 'Termurah')">Termurah</a></li>
                        <li><a class="dropdown-item-custom d-block text-decoration-none" href="#" onclick="pilihSort(event, 'Termahal')">Termahal</a></li>
                    </ul>
                </div>
            </div>

            <!-- Category Pills -->
<div class="category-pills">
    <div class="pill active" onclick="filterKategori('Semua', this)">Semua</div>
    @foreach($kategoris as $kategori)
        <div class="pill" onclick="filterKategori('{{ $kategori->nama_kategori }}', this)">
            {{ $kategori->nama_kategori }}
        </div>
    @endforeach
</div>

            <!-- Product Grid -->
<div class="product-grid" id="productGrid">
    @foreach($menus as $menu)
    <!-- Tambahkan data-kategori di sini -->
    <div class="product-card" data-kategori="{{ $menu->kategori->nama_kategori ?? 'Umum' }}">
        @if($menu->foto_menu)
            <img src="{{ asset('storage/menus/' . $menu->foto_menu) }}" alt="{{ $menu->nama_menu }}" style="width: 100%; height: 140px; object-fit: cover; border-radius: 12px; margin-bottom: 12px;">
        @else
            <!-- Mengambil 2 huruf pertama dari nama menu sebagai placeholder gambar -->
            <div class="img-placeholder">{{ strtoupper(substr($menu->nama_menu, 0, 2)) }}</div>
        @endif

        
        <!-- Tambahkan class 'menu-name' untuk mempermudah pencarian nama -->
        <div class="prod-title menu-name">{{ $menu->nama_menu }}</div>
        
        <div class="prod-category">{{ $menu->kategori->nama_kategori ?? 'Umum' }}</div>
        
        <div class="prod-bottom">
            <div class="prod-price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</div>
            <button class="btn-add" 
                data-id="{{ $menu->id }}" 
                data-nama="{{ $menu->nama_menu }}" 
                data-harga="{{ $menu->harga }}">
                +
            </button>
        </div>
    </div>
    @endforeach
</div>
        </div>

    <!-- --- KANAN: AREA KERANJANG (Offcanvas di Mobile) --- -->
    <div class="offcanvas-lg offcanvas-end border-0 p-0 m-0" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" style="width: 360px; max-width: 100vw; background: transparent; box-shadow: none;">
        <div class="cart-sidebar w-100 mx-auto" style="border-radius: 20px;">
            <div class="cart-header">
                <div>
                    <h2 class="cart-title">Keranjang</h2>
                    <div class="cart-subtitle">3 Item</div>
                </div>
                <button class="btn-empty">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    Kosongkan
                </button>
            </div>

            <div class="cart-items">
                <!-- Item 1 -->
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-title">Kopi Susu Dari</div>
                        <div class="item-price">Rp46.000</div>
                    </div>
                    <div class="item-controls">
                        <button class="qty-btn">–</button>
                        <span class="qty-num">2</span>
                        <button class="qty-btn">+</button>
                        <button class="btn-delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-title">Long Black</div>
                        <div class="item-price">Rp23.000</div>
                    </div>
                    <div class="item-controls">
                        <button class="qty-btn">–</button>
                        <span class="qty-num">1</span>
                        <button class="qty-btn">+</button>
                        <button class="btn-delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-title">Sweet Matcha</div>
                        <div class="item-price">Rp48.000</div>
                    </div>
                    <div class="item-controls">
                        <button class="qty-btn">–</button>
                        <span class="qty-num">2</span>
                        <button class="qty-btn">+</button>
                        <button class="btn-delete">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tipe Penjualan -->
            <div class="order-type-box">
                <div class="order-type-title">Tipe Penjualan</div>
                <div class="order-type-toggle">
                    <div class="type-btn active">Dine In</div>
                    <div class="type-btn">Take Away</div>
                </div>
            </div>

            <!-- Summary -->
            <div class="summary-box">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp117.000</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp117.000</span>
                </div>
                <button class="btn-pay">Bayar Rp117.000</button>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL PEMBAYARAN ================= -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; padding: 24px;">
            
            <!-- Header Modal -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn border-0 p-0" data-bs-dismiss="modal" style="background: none;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </button>
                    <h4 class="mb-0 fw-bold" id="modal-total-amount">Rp0</h4>
                </div>
                <!-- Tombol Bayar default-nya kita kasih atribut disabled -->
                <button class="btn-pay-modal" id="btn-confirm-pay" disabled>Bayar</button>
            </div>
            
            <!-- Garis pembatas (Divider) tipis -->
            <div class="divider mb-4" style="margin: 0; background-color: #F0EBE6;"></div>

            <!-- Body Modal -->
            <div class="modal-body p-0">
                
                <!-- BOX TUNAI -->
                <div class="payment-box d-flex mb-3" id="box-tunai" onclick="selectPayment('Tunai')">
                    <!-- Kiri: Label -->
                    <div class="fw-bold" style="width: 30%; font-size: 14px;">Tunai</div>
                    <!-- Kanan: Kontrol (Tombol Cepat & Input) -->
                    <div style="width: 70%;">
                        <div class="d-flex gap-2 mb-2">
                            <button class="btn-option flex-grow-1" id="btn-cash-1" onclick="setCash(this.getAttribute('data-val')); event.stopPropagation();">Rp0</button>
                            <button class="btn-option flex-grow-1" id="btn-cash-2" onclick="setCash(this.getAttribute('data-val')); event.stopPropagation();">Rp0</button>
                        </div>
                        <input type="text" class="form-control cash-input w-100" id="input-cash-amount" placeholder="Rp0">
                    </div>
                </div>

                <!-- BOX QRIS -->
                <div class="payment-box d-flex align-items-center" id="box-qris" onclick="selectPayment('QRIS')">
                    <!-- Kiri: Label -->
                    <div class="fw-bold" style="width: 30%; font-size: 14px;">QRIS</div>
                    <!-- Kanan: Kontrol (Tombol QRIS) -->
                    <div class="d-flex gap-2" style="width: 70%;">
                        <button class="btn-option flex-grow-1" id="btn-qris-option" style="max-width: 50%;">QRIS</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL SUKSES PEMBAYARAN ================= -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center" style="border-radius: 20px; border: none; padding: 40px 24px;">
            <div class="modal-body p-0">
                
                <!-- Info Metode & Pembayaran -->
                <h5 class="fw-bold mb-2" id="success-method" style="color: var(--primary-brown);">Tunai</h5>
                <p class="mb-4" id="success-paid" style="font-size: 14px; font-weight: 600; color: var(--text-dark);">Bayar Rp0</p>

                <!-- Info Kembalian (Bakal disembunyikan otomatis kalau pakai QRIS) -->
                <div id="kembalian-area">
                    <h2 class="fw-bold mb-1" style="color: var(--primary-brown);">Kembalian</h2>
                    <h2 class="fw-bold mb-4" id="success-change" style="color: var(--primary-brown);">Rp0</h2>
                </div>

                <!-- Ikon Centang Hijau -->
                <div class="mb-4 d-flex justify-content-center">
                    <div style="width: 80px; height: 80px; background-color: #22C55E; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <!-- SVG Check -->
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <button class="btn w-100 mb-2" id="btn-print" onclick="window.print()" style="background-color: var(--primary-brown); color: white; border-radius: 12px; padding: 14px; font-weight: 600; font-size: 14px;">Cetak Struk</button>
                <button class="btn w-100" id="btn-new-trx" data-bs-dismiss="modal" style="background-color: white; color: var(--primary-brown); border: 1px solid var(--border-color); border-radius: 12px; padding: 14px; font-weight: 600; font-size: 14px;">Transaksi Baru</button>
                
            </div>
        </div>
</div>
</div>

<!-- ================= MODAL KOSONGKAN KERANJANG ================= -->
<div class="modal fade" id="emptyCartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content text-center" style="border-radius: 20px; border: none; padding: 32px 24px;">
            <div class="modal-body p-0">
                
                <!-- Ikon Peringatan -->
                <div class="mb-3 d-flex justify-content-center">
                    <div style="width: 72px; height: 72px; background-color: #FFF3F3; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #DC2626;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                </div>
                
                <!-- Teks Konfirmasi -->
                <h5 class="fw-bold mb-2" style="color: var(--text-dark);">Kosongkan Keranjang?</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">Semua menu yang sudah Anda pilih di dalam keranjang akan dihapus. Lanjutkan?</p>
                
                <!-- Tombol Aksi -->
                <div class="d-flex gap-2">
                    <button type="button" class="btn flex-grow-1" data-bs-dismiss="modal" style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 12px; font-weight: 600; color: var(--text-gray); font-size: 14px;">Batal</button>
                    <button type="button" class="btn flex-grow-1" id="confirmEmptyCart" style="background: #DC2626; color: white; border: none; border-radius: 12px; padding: 12px; font-weight: 600; font-size: 14px;">Ya, Kosongkan</button>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Script Keranjang Belanja -->
<script>
    // Inisialisasi array keranjang
    let cart = [];

    // Fungsi format Rupiah
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    // Tangkap click pada seluruh kotak product card
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            let btn = this.querySelector('.btn-add');
            let id = btn.getAttribute('data-id');
            let nama = btn.getAttribute('data-nama');
            let harga = parseInt(btn.getAttribute('data-harga'));

            addToCart(id, nama, harga);
        });
    });

    // Fungsi memasukkan item ke keranjang
    function addToCart(id, nama, harga) {
        // Cek apakah item sudah ada di keranjang sebelumnya
        let existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.qty += 1; // Jika ada, tambah quantity-nya
        } else {
            cart.push({ id: id, nama: nama, harga: harga, qty: 1 }); // Jika belum ada, masukkan sebagai item baru
        }

        renderCart(); // Perbarui tampilan keranjang
    }

    // Fungsi untuk menampilkan keranjang ke HTML
    function renderCart() {
        const cartContainer = document.querySelector('.cart-items');
        cartContainer.innerHTML = ''; // Kosongkan dulu isi keranjang sebelumnya

        let subtotal = 0;
        let totalItems = 0;

        cart.forEach((item, index) => {
            let itemTotal = item.harga * item.qty;
            subtotal += itemTotal;
            totalItems += item.qty;

            // Render HTML untuk setiap item di keranjang
            cartContainer.innerHTML += `
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-title">${item.nama}</div>
                        <div class="item-price">${formatRupiah(itemTotal)}</div>
                    </div>
                    <div class="item-controls">
                        <button class="qty-btn" onclick="updateQty('${item.id}', -1)">–</button>
                        <span class="qty-num">${item.qty}</span>
                        <button class="qty-btn" onclick="updateQty('${item.id}', 1)">+</button>
                        <button class="btn-delete" onclick="removeItem('${item.id}')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>
                </div>
            `;
        });

        // Update Subtotal, Total, dan Subtitle (Jumlah Item)
        document.querySelector('.summary-row:not(.total) span:last-child').innerText = formatRupiah(subtotal);
        document.querySelector('.summary-row.total span:last-child').innerText = formatRupiah(subtotal);
        
        let payBtn = document.querySelector('.btn-pay');
        payBtn.innerText = `Bayar ${formatRupiah(subtotal)}`;
        if (cart.length === 0) {
            payBtn.disabled = true;
            payBtn.style.opacity = '0.5';
            payBtn.style.cursor = 'not-allowed';
        } else {
            payBtn.disabled = false;
            payBtn.style.opacity = '1';
            payBtn.style.cursor = 'pointer';
        }
        
        document.querySelector('.cart-subtitle').innerText = `${totalItems} Item`;
    }

    // Fungsi mengubah jumlah qty (tombol + dan - di keranjang)
    function updateQty(id, change) {
        let item = cart.find(item => item.id === id);
        if (item) {
            item.qty += change;
            if (item.qty <= 0) {
                removeItem(id); // Jika qty 0, hapus dari keranjang
            } else {
                renderCart();
            }
        }
    }

    // Fungsi menghapus item dari keranjang
    function removeItem(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    // Fungsi Kosongkan Keranjang
    document.querySelector('.btn-empty').addEventListener('click', function() {
        if (cart.length === 0) return; // Jangan munculkan modal kalau keranjang sudah kosong
        let emptyModal = new bootstrap.Modal(document.getElementById('emptyCartModal'));
        emptyModal.show();
    });

    // Aksi tombol konfirmasi pada modal Kosongkan Keranjang
    document.getElementById('confirmEmptyCart').addEventListener('click', function() {
        cart = [];
        renderCart();
        bootstrap.Modal.getInstance(document.getElementById('emptyCartModal')).hide();
    });

    // Panggil renderCart pertama kali untuk memastikan keranjang kosong saat halaman dimuat
    renderCart();

    // --- FITUR FILTER KATEGORI ---
function filterKategori(kategoriDipilih, elemenPill) {
    // 1. Ubah tampilan tombol pill (active state)
    document.querySelectorAll('.category-pills .pill').forEach(pill => {
        pill.classList.remove('active');
    });
    elemenPill.classList.add('active');

    // 2. Filter kartu produk
    let cards = document.querySelectorAll('#productGrid .product-card');
    
    cards.forEach(card => {
        let kategoriProduk = card.getAttribute('data-kategori');
        
        // Tampilkan jika kategori 'Semua' atau kategori cocok dengan yang dipilih
        if (kategoriDipilih === 'Semua' || kategoriProduk === kategoriDipilih) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });

    // Reset kotak pencarian saat pindah kategori
    document.getElementById('searchInput').value = '';
}

// --- FITUR PENCARIAN MENU ---
function cariMenu() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let cards = document.querySelectorAll('#productGrid .product-card');

    cards.forEach(card => {
        let nama = card.querySelector('.menu-name').innerText.toLowerCase();
        let kategoriDipilih = document.querySelector('.category-pills .pill.active').innerText;
        let kategoriProduk = card.getAttribute('data-kategori');

        let matchKategori = (kategoriDipilih === 'Semua' || kategoriProduk === kategoriDipilih);
        let matchNama = nama.includes(input);

        if (matchKategori && matchNama) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// --- FITUR DROPDOWN SORT ---
function toggleDropdown(id) {
    document.querySelectorAll('.dropdown-menu-custom').forEach(el => {
        if(el.id !== id) el.classList.add('d-none');
    });
    document.getElementById(id).classList.toggle('d-none');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-status-container')) {
        document.querySelectorAll('.dropdown-menu-custom').forEach(el => el.classList.add('d-none'));
    }
});

function pilihSort(event, val) {
    event.preventDefault();
    document.getElementById('labelSort').innerText = val;
    document.getElementById('dropdownMenuSort').classList.add('d-none');
    
    document.querySelectorAll('#dropdownMenuSort .dropdown-item-custom').forEach(el => el.classList.remove('active'));
    event.target.classList.add('active');
    
    sortMenu(val);
}

function sortMenu(sortType) {
    const grid = document.getElementById('productGrid');
    const cards = Array.from(grid.querySelectorAll('.product-card'));
    
    if (!window.originalOrder) {
        window.originalOrder = [...cards];
    }

    if (sortType === 'Semua') {
        window.originalOrder.forEach(card => grid.appendChild(card));
        return;
    }

    cards.sort((a, b) => {
        if (sortType === 'A-Z') {
            let nameA = a.querySelector('.menu-name').innerText.toLowerCase();
            let nameB = b.querySelector('.menu-name').innerText.toLowerCase();
            return nameA.localeCompare(nameB);
        } else if (sortType === 'Termurah' || sortType === 'Termahal') {
            let priceA = parseInt(a.querySelector('.btn-add').getAttribute('data-harga'));
            let priceB = parseInt(b.querySelector('.btn-add').getAttribute('data-harga'));
            if (sortType === 'Termurah') return priceA - priceB;
            if (sortType === 'Termahal') return priceB - priceA;
        }
        return 0;
    });

    cards.forEach(card => grid.appendChild(card));
}

// --- LOGIKA MODAL PEMBAYARAN KUSTOM ---
let paymentModal;
let selectedPaymentMethod = null; // Awalnya kosong biar disabled
let finalTotalHarga = 0;

// Fungsi menghitung nominal cerdas (Kelipatan 10k & 50k ke atas)
function calculateQuickCash(total) {
    if (total === 0) return [0, 0];
    
    // Opsi 1: Pembulatan ke 10.000 terdekat ke atas
    let opt1 = Math.ceil(total / 10000) * 10000;
    if (opt1 === total) opt1 += 10000; // Kalau angkanya pas, kasih opsi +10k
    
    // Opsi 2: Pembulatan ke 50.000 terdekat ke atas
    let opt2 = Math.ceil(total / 50000) * 50000;
    if (opt2 <= opt1) opt2 = opt1 + 50000; // Pastikan opsi 2 selalu lebih besar dari opsi 1
    
    return [opt1, opt2];
}

// 1. Klik Tombol Bayar di Keranjang -> Buka Modal
document.querySelector('.btn-pay').addEventListener('click', function() {
    if (cart.length === 0) {
        return;
    }
    
    finalTotalHarga = cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
    document.getElementById('modal-total-amount').innerText = formatRupiah(finalTotalHarga);
    
    // Set placeholder dan generate tombol uang cepat
    let inputCash = document.getElementById('input-cash-amount');
    inputCash.placeholder = formatRupiah(finalTotalHarga);
    inputCash.value = ''; 
    
    let quickCash = calculateQuickCash(finalTotalHarga);
    
    let btnCash1 = document.getElementById('btn-cash-1');
    btnCash1.innerText = formatRupiah(quickCash[0]);
    btnCash1.setAttribute('data-val', quickCash[0]);
    
    let btnCash2 = document.getElementById('btn-cash-2');
    btnCash2.innerText = formatRupiah(quickCash[1]);
    btnCash2.setAttribute('data-val', quickCash[1]);

    // Reset state modal (semua mati)
    selectedPaymentMethod = null;
    document.querySelectorAll('.payment-box, .btn-option').forEach(el => el.classList.remove('active'));
    checkPaymentState(); // Kunci tombol konfirmasi
    
    if (!paymentModal) {
        paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    }
    paymentModal.show();
});

// 2. Fungsi Pilih Metode Pembayaran
function selectPayment(method) {
    selectedPaymentMethod = method;
    
    // Reset visual
    document.querySelectorAll('.payment-box').forEach(box => box.classList.remove('active'));
    document.getElementById('btn-qris-option').classList.remove('active');
    
    if (method === 'Tunai') {
        document.getElementById('box-tunai').classList.add('active');
        document.getElementById('input-cash-amount').focus();
    } else if (method === 'QRIS') {
        document.getElementById('box-qris').classList.add('active');
        document.getElementById('btn-qris-option').classList.add('active');
        
        // Bersihkan area tunai
        document.getElementById('input-cash-amount').value = ''; 
        document.querySelectorAll('#btn-cash-1, #btn-cash-2').forEach(btn => btn.classList.remove('active'));
    }
    
    checkPaymentState();
}

// 1. Fitur Auto Titik (Ribuan) saat ngetik manual di Input Tunai
document.getElementById('input-cash-amount').addEventListener('input', function(e) {
    // Hapus semua karakter selain angka
    let value = this.value.replace(/[^0-9]/g, '');
    
    // Format angka pakai titik ribuan
    if(value) {
        this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    } else {
        this.value = '';
    }

    // Kalau kasir ngetik manual, otomatis matikan status aktif di tombol Nominal Cepat
    document.querySelectorAll('#btn-cash-1, #btn-cash-2').forEach(btn => btn.classList.remove('active'));
    
    // Cek ulang state tombol Bayar
    checkPaymentState();
});

// 2. Fungsi Klik Nominal Cepat (Update: Field Input dibiarkan kosong)
function setCash(amount) {
    let input = document.getElementById('input-cash-amount');
    input.value = ''; // Mengosongkan field input manual
    
    // Visual state tombol tunai (aktifkan yang ditekan)
    document.querySelectorAll('#btn-cash-1, #btn-cash-2').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    selectPayment('Tunai'); // Pastikan box tunai luar jadi aktif
}

// 3. Update Fungsi Validasi Tombol "Bayar" Utama
function checkPaymentState() {
    let btnConfirm = document.getElementById('btn-confirm-pay');
    
    if (selectedPaymentMethod === 'QRIS') {
        btnConfirm.disabled = false;
    } else if (selectedPaymentMethod === 'Tunai') {
        // Cek mana yang dipakai: Input Manual atau Tombol Nominal Cepat?
        let manualInput = document.getElementById('input-cash-amount').value.replace(/[^0-9]/g, '');
        let activeQuickCash = document.querySelector('#btn-cash-1.active, #btn-cash-2.active');
        
        let currentCash = 0;
        if (manualInput) {
            currentCash = parseInt(manualInput); // Ambil dari input ketikan
        } else if (activeQuickCash) {
            currentCash = parseInt(activeQuickCash.getAttribute('data-val')); // Ambil dari tombol
        }

        // Kunci atau Buka gembok tombol Konfirmasi
        if (currentCash >= finalTotalHarga && finalTotalHarga > 0) {
            btnConfirm.disabled = false;
        } else {
            btnConfirm.disabled = true;
        }
    } else {
        btnConfirm.disabled = true;
    }
}

// 5. Eksekusi Pembayaran ke Database
document.getElementById('btn-confirm-pay').addEventListener('click', function() {
    let tipePesanan = document.querySelector('.type-btn.active').innerText;
    let manualInput = document.getElementById('input-cash-amount').value.replace(/[^0-9]/g, '');
    let activeQuickCash = document.querySelector('#btn-cash-1.active, #btn-cash-2.active');
    
    let cashAmount = 0;
    if (manualInput) {
        cashAmount = parseInt(manualInput);
    } else if (activeQuickCash) {
        cashAmount = parseInt(activeQuickCash.getAttribute('data-val'));
    }

    // --- TAMBAHAN LOGIC UANG BAYAR ---
    // Atur nominal uang bayar berdasarkan metode yang dipilih
    let uangBayarAkhir = 0;
    if (selectedPaymentMethod === 'Tunai') {
        uangBayarAkhir = cashAmount; // Ambil dari inputan kasir
    } else if (selectedPaymentMethod === 'QRIS') {
        uangBayarAkhir = finalTotalHarga; // Kalau QRIS, otomatis pas (uang bayar = total harga)
    }
    // ---------------------------------

    let btnConfirm = this;
    let originalText = btnConfirm.innerText;
    btnConfirm.innerText = 'Memproses...';
    btnConfirm.disabled = true;

    fetch('{{ route("pos.checkout") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            cart: cart,
            tipe_pesanan: tipePesanan,
            total_harga: finalTotalHarga,
            metode_pembayaran: selectedPaymentMethod,
            uang_bayar: uangBayarAkhir // <--- INI DIA PENYELAMATNYA, SEKARANG DIKIRIM KE BACKEND!
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            // 1. Sembunyikan Modal Pembayaran yang lama
            paymentModal.hide();

            // 1b. Update tombol cetak struk
            document.getElementById('btn-print').onclick = function() {
                window.open('/pos/print/' + data.transaksi_id, '_blank');
            };

            // 1c. AUTO-PRINT Struk Barista
            window.open('/pos/print-barista/' + data.transaksi_id, '_blank');

            // 2. Siapkan teks untuk Modal Sukses
            let kembalianArea = document.getElementById('kembalian-area');
            let textDibayar = '';

            if (selectedPaymentMethod === 'Tunai') {
                let kembalian = cashAmount - finalTotalHarga;
                textDibayar = 'Bayar ' + formatRupiah(cashAmount);
                document.getElementById('success-change').innerText = formatRupiah(kembalian);
                kembalianArea.style.display = 'block'; // Munculkan teks kembalian
            } else { // Jika metode QRIS
                textDibayar = 'Total ' + formatRupiah(finalTotalHarga);
                kembalianArea.style.display = 'none'; // Sembunyikan teks kembalian
            }

            // 3. Masukkan data ke HTML Modal Sukses
            document.getElementById('success-method').innerText = selectedPaymentMethod;
            document.getElementById('success-paid').innerText = textDibayar;

            // 4. Tampilkan Modal Sukses
            let successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // 5. Reset Keranjang untuk Transaksi Selanjutnya
            cart = []; 
            renderCart(); 

        } else {
            alert('Terjadi kesalahan: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menghubungi server.');
    })
    .finally(() => {
        btnConfirm.innerText = originalText;
        checkPaymentState(); // Reset state setelah selesai
    });
});

// Sedikit tambahan: Beri logika pada tombol toggle "Tipe Penjualan" agar bisa diklik
document.querySelectorAll('.type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endpush
@endsection
