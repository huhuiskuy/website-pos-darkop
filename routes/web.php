<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\PosController;

/*
|--------------------------------------------------------------------------
| Web Routes (Single Domain Mode)
|--------------------------------------------------------------------------
*/

// Route pancingan bawaan auth Laravel
Route::get('/login', function () {
    $niatAwal = session()->get('url.intended', '');
    
    if (str_contains($niatAwal, '/admin') || request()->is('admin*')) {
        return redirect()->route('login.admin');
    }
    
    return redirect()->route('login.pos');
})->name('login');

// Logout bisa diakses dari mana saja
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| AREA KASIR / POS (Domain Utama)
| URL: darkopos.alwaysdata.net
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login.pos');
});

// Login Kasir
Route::get('/login-pos', function () {
    return view('auth.login-pos');
})->name('login.pos');
Route::post('/login-pos', [AuthController::class, 'loginPos'])->name('login.pos.post');

// Halaman Kasir (Wajib Login)
Route::middleware(['auth:barista'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    
    // Cetak
    Route::get('/pos/print/{id}', [PosController::class, 'printStruk'])->name('pos.print');
    Route::get('/pos/print-barista/{id}', [PosController::class, 'printBarista'])->name('pos.print_barista');
    
    // Aktivitas & Opname
    Route::get('/pos/aktivitas', [PosController::class, 'aktivitas'])->name('pos.aktivitas');
    Route::put('/pos/aktivitas/batal/{id}', [PosController::class, 'batalkanTransaksi'])->name('pos.batal');
    Route::get('/pos/opname', [PosController::class, 'opname'])->name('pos.opname');
    Route::post('/pos/opname/simpan', [PosController::class, 'simpanOpname'])->name('pos.simpanOpname');
});


/*
|--------------------------------------------------------------------------
| AREA BACK OFFICE ADMI N (Pakai Prefix /admin)
| URL: darkopos.alwaysdata.net/admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    // Login Admin
    Route::get('/login', function () {
        return view('auth.login-admin');
    })->name('login.admin');
    Route::post('/login', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

    // Halaman Back Office (Wajib Login)
    Route::middleware(['auth:owner'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Bahan Baku
        Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan-baku.index');
        Route::post('/bahan-baku', [BahanBakuController::class, 'store'])->name('bahan-baku.store');
        Route::put('/bahan-baku/{id}', [BahanBakuController::class, 'update'])->name('bahan-baku.update');
        Route::delete('/bahan-baku/{id}', [BahanBakuController::class, 'destroy'])->name('bahan-baku.destroy');
        Route::post('/bahan-baku/kategori', [BahanBakuController::class, 'storeKategori'])->name('kategori.store');
        Route::put('/bahan-baku/kategori/{id}', [BahanBakuController::class, 'updateKategori'])->name('kategori.update');
        Route::delete('/bahan-baku/kategori/{id}', [BahanBakuController::class, 'destroyKategori'])->name('kategori.destroy');

        // Menu
        Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
        Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::post('/menu/kategori', [MenuController::class, 'storeKategori'])->name('kategori_menu.store');
        Route::put('/menu/kategori/{id}', [MenuController::class, 'updateKategori'])->name('kategori_menu.update');
        Route::delete('/menu/kategori/{id}', [MenuController::class, 'destroyKategori'])->name('kategori_menu.destroy');

        // Laporan & Akun
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
        Route::get('/laporan/opname', [LaporanController::class, 'opname'])->name('laporan.opname');
        Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
        Route::put('/akun/profile', [AkunController::class, 'updateProfile'])->name('akun.profile.update');
        Route::put('/akun/password', [AkunController::class, 'updatePassword'])->name('akun.password.update');
        Route::put('/akun/barista', [AkunController::class, 'updateBarista'])->name('akun.barista.update');
    });

});