<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Kumpulkan semua use Controller di atas agar rapi
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\PosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Jalur utama fallback (hanya untuk berjaga-jaga jika IP diakses langsung)
Route::get('/', function (Request $request) {
    if ($request->getHost() === 'darkopos.alwaysdata.net') {
        return redirect()->route('pos.index');
    }
    return redirect()->route('dashboard.index');
});

// Route pancingan bawaan auth Laravel (redirect otomatis saat belum login)
Route::get('/login', function (Request $request) {
    if ($request->getHost() === 'darkopos.alwaysdata.net') {
        return redirect()->route('login.pos');
    }
    return redirect()->route('login.admin'); 
})->name('login');

// Jalur buat tombol keluar (logout) - bisa diakses dari domain mana saja
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DOMAIN: KASIR / POS (darkopos.alwaysdata.net)
|--------------------------------------------------------------------------
*/
Route::domain('darkopos.alwaysdata.net')->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('pos.index');
    });

    // Login Kasir
    Route::get('/login-pos', function () {
        return view('auth.login-pos');
    })->name('login.pos');

    // Proses data dari form login POS (Ini yang ditambahin biar bisa masuk)
    Route::post('/login-pos', [AuthController::class, 'loginPos'])->name('login.pos.post');

    // Halaman Kasir (Wajib Login)
    Route::middleware(['auth'])->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        
        // Cetak Struk
        Route::get('/pos/print/{id}', [PosController::class, 'printStruk'])->name('pos.print');
        Route::get('/pos/print-barista/{id}', [PosController::class, 'printBarista'])->name('pos.print_barista');
        
        // Aktivitas
        Route::get('/pos/aktivitas', [PosController::class, 'aktivitas'])->name('pos.aktivitas');
        Route::put('/pos/aktivitas/batal/{id}', [PosController::class, 'batalkanTransaksi'])->name('pos.batal');
        
        // Opname
        Route::get('/pos/opname', [PosController::class, 'opname'])->name('pos.opname');
        Route::post('/pos/opname/simpan', [PosController::class, 'simpanOpname'])->name('pos.simpanOpname');
    });

});


/*
|--------------------------------------------------------------------------
| DOMAIN: BACK OFFICE (darkopos-bo.alwaysdata.net)
|--------------------------------------------------------------------------
*/
Route::domain('darkopos-bo.alwaysdata.net')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    // Login Admin
    Route::get('/login-admin', function () {
        return view('auth.login-admin');
    })->name('login.admin');
    
    // Proses data dari form login Admin
    Route::post('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

    // Halaman Back Office (Wajib Login)
    Route::middleware(['auth'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Bahan Baku
        Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan-baku.index');
        Route::post('/bahan-baku', [BahanBakuController::class, 'store'])->name('bahan-baku.store');
        Route::put('/bahan-baku/{id}', [BahanBakuController::class, 'update'])->name('bahan-baku.update');
        Route::delete('/bahan-baku/{id}', [BahanBakuController::class, 'destroy'])->name('bahan-baku.destroy');

        // Kategori Bahan Baku
        Route::post('/bahan-baku/kategori', [BahanBakuController::class, 'storeKategori'])->name('kategori.store');
        Route::put('/bahan-baku/kategori/{id}', [BahanBakuController::class, 'updateKategori'])->name('kategori.update');
        Route::delete('/bahan-baku/kategori/{id}', [BahanBakuController::class, 'destroyKategori'])->name('kategori.destroy');

        // Menu
        Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
        Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

        // Kategori Menu
        Route::post('/menu/kategori', [MenuController::class, 'storeKategori'])->name('kategori_menu.store');
        Route::put('/menu/kategori/{id}', [MenuController::class, 'updateKategori'])->name('kategori_menu.update');
        Route::delete('/menu/kategori/{id}', [MenuController::class, 'destroyKategori'])->name('kategori_menu.destroy');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/laporan/opname', [LaporanController::class, 'opname'])->name('laporan.opname');

        // Akun / Pengaturan
        Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
        Route::put('/akun/profile', [AkunController::class, 'updateProfile'])->name('akun.profile.update');
        Route::put('/akun/password', [AkunController::class, 'updatePassword'])->name('akun.password.update');
        
    });

});