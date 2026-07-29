<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function (\Illuminate\Http\Request $request) {
    if ($request->getHost() === 'darkopos.com') {
        return redirect()->route('pos.index');
    }
    return redirect()->route('dashboard.index');
});

use App\Http\Controllers\BahanBakuController;

// Route Login Back Office
Route::get('/login-admin', function () {
    return view('auth.login-admin');
})->name('login.admin');
// Jalur buat nge-proses data dari form login
Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

// Jalur buat tombol keluar (logout)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Bahan Baku
Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan-baku.index');
Route::post('/bahan-baku', [BahanBakuController::class, 'store'])->name('bahan-baku.store');
Route::put('/bahan-baku/{id}', [BahanBakuController::class, 'update'])->name('bahan-baku.update');
Route::delete('/bahan-baku/{id}', [BahanBakuController::class, 'destroy'])->name('bahan-baku.destroy');

// Route Kategori Bahan Baku
Route::post('/bahan-baku/kategori', [BahanBakuController::class, 'storeKategori'])->name('kategori.store');
Route::put('/bahan-baku/kategori/{id}', [BahanBakuController::class, 'updateKategori'])->name('kategori.update');
Route::delete('/bahan-baku/kategori/{id}', [BahanBakuController::class, 'destroyKategori'])->name('kategori.destroy');

use App\Http\Controllers\MenuController;

// --- ROUTE UNTUK HALAMAN MENU ---
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

// --- ROUTE UNTUK KELOLA KATEGORI MENU ---
Route::post('/menu/kategori', [MenuController::class, 'storeKategori'])->name('kategori_menu.store');
Route::put('/menu/kategori/{id}', [MenuController::class, 'updateKategori'])->name('kategori_menu.update');
Route::delete('/menu/kategori/{id}', [MenuController::class, 'destroyKategori'])->name('kategori_menu.destroy');

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
// (Gua taruh di '/' biar pas buka web langsung masuk ke Dashboard)

use App\Http\Controllers\LaporanController;

// Route Laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
Route::get('/laporan/opname', [LaporanController::class, 'opname'])->name('laporan.opname'); // INI JALUR OPNAME

// Route Akun / Pengaturan
Route::get('/akun', [App\Http\Controllers\AkunController::class, 'index'])->name('akun.index');
Route::put('/akun/profile', [App\Http\Controllers\AkunController::class, 'updateProfile'])->name('akun.profile.update');
Route::put('/akun/password', [App\Http\Controllers\AkunController::class, 'updatePassword'])->name('akun.password.update');

// Route Login buat Mesin Kasir / POS
Route::get('/login-pos', function () {
    return view('auth.login-pos');
})->name('login.pos');

use App\Http\Controllers\PosController;

Route::middleware(['auth'])->group(function () {
    // Route POS / Kasir
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    // Pastikan baris ini ada di area route POS kamu
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    // Jalur Cetak Struk
    Route::get('/pos/print/{id}', [PosController::class, 'printStruk'])->name('pos.print');
    // Jalur Cetak Struk Barista
    Route::get('/pos/print-barista/{id}', [PosController::class, 'printBarista'])->name('pos.print_barista');
});

Route::get('/pos/aktivitas', [App\Http\Controllers\PosController::class, 'aktivitas'])->name('pos.aktivitas');

// Route pancingan bawaan auth Laravel biar ga error Route [login] not defined
Route::get('/login', function (\Illuminate\Http\Request $request) {
    if ($request->getHost() === 'darkopos.com') {
        return redirect()->route('login.pos');
    }
    return redirect()->route('login.admin'); 
})->name('login');

Route::put('/pos/aktivitas/batal/{id}', [PosController::class, 'batalkanTransaksi'])->name('pos.batal');

Route::get('/pos/opname', [PosController::class, 'opname'])->name('pos.opname');

Route::post('/pos/opname/simpan', [PosController::class, 'simpanOpname'])->name('pos.simpanOpname');