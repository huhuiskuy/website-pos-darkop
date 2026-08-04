<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\BahanBaku; 
use App\Models\KategoriBahan;
use App\Models\StokOpname;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        // Ambil semua data kategori untuk filter
        $kategoris = KategoriMenu::all();
        
        // Ambil semua menu beserta relasi kategorinya yang statusnya Tersedia
        $menus = Menu::with('kategori')->where('status', 'Tersedia')->get();

        return view('pos.index', compact('kategoris', 'menus'));
    }

   public function checkout(Request $request)
    {
        // 1. Tambahin validasi uang_bayar di sini
        $request->validate([
            'cart' => 'required|array',
            'tipe_pesanan' => 'required|string',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required|string',
            // Pastikan uang bayar diisi dan nominalnya ga kurang dari total harga
            'uang_bayar' => 'required|numeric|gte:total_harga' 
        ]);

        // 2. Hitung kembalian di backend biar aman
        $kembalian = $request->uang_bayar - $request->total_harga;

        DB::beginTransaction();
        
        try {
            // 3. Simpan uang_bayar dan kembalian ke tabel transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . date('YmdHis'),
                'total_harga' => $request->total_harga,
                'tipe_pesanan' => $request->tipe_pesanan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'uang_bayar' => $request->uang_bayar, // Masuk ke database
                'kembalian' => $kembalian           // Masuk ke database
            ]);

            foreach ($request->cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['id'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['harga'] * $item['qty']
                ]);
            }

            DB::commit(); 
            
            return response()->json([
                'status' => 'success', 
                'message' => 'Pembayaran berhasil dicatat!',
                'transaksi_id' => $transaksi->id
            ]);

        } catch (\Exception $e) {
            DB::rollback(); // Batalkan jika ada yang gagal
            return response()->json([
                'status' => 'error', 
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function printStruk($id)
    {
        $transaksi = Transaksi::with('detail_transaksis.menu')->findOrFail($id);
        return view('pos.print', compact('transaksi'));
    }

    public function printBarista($id)
    {
        $transaksi = Transaksi::with('detail_transaksis.menu')->findOrFail($id);
        return view('pos.print_barista', compact('transaksi'));
    }

public function aktivitas(Request $request)
{
    // 1. Siapkan query dasar (urut dari yang terbaru)
    $query = Transaksi::with(['detail_transaksis.menu'])->latest();

    // 2. Filter Pencarian (Nomor Struk)
    if ($request->filled('search')) {
        $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
    }

    // 3. Filter Tanggal (Datepicker, default ke hari ini)
    $date = $request->input('date', now()->format('Y-m-d'));
    $query->whereDate('created_at', $date);

    // 4. Filter Status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 5. Eksekusi Pagination (appends query biar pas ganti halaman, filternya nggak ilang)
    $transaksis = $query->paginate(10)->appends($request->query());

    return view('pos.aktivitas', compact('transaksis'));
}


public function batalkanTransaksi(Request $request, $id)
{
    // Validasi form agar alasan tidak boleh kosong saat dikirim ke backend
    $request->validate([
        'alasan' => 'required|string'
    ]);

    $trx = Transaksi::find($id);

    if (!$trx) {
        return response()->json([
            'success' => false, 
            'message' => 'Transaksi tidak ditemukan.'
        ], 404);
    }

    // Update status dan simpan alasan pembatalan. 
    // Sesuaikan nama kolom 'status' dan 'alasan_batal' dengan migration/database lu.
    $trx->status = 'Batal'; 
    $trx->alasan_batal = $request->alasan;
    $trx->save();

    return response()->json([
        'success' => true,
        'message' => 'Transaksi berhasil dibatalkan.'
    ]);
}

// --- 1. UBAH FUNGSI opname (GET) ---
    public function opname(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');

        $query = BahanBaku::with(['kategori', 'riwayatOpname' => function($q) use ($date) {
            $q->where('tanggal', $date);
        }]); 

        if ($request->filled('search')) {
            $query->where('nama_item', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            if ($request->kategori === 'tak_berkategori') {
                $query->whereNull('kategori_bahan_id');
            } else {
                $query->where('kategori_bahan_id', $request->kategori);
            }
        }

        $items = $query->paginate(7)->appends($request->query());
        $kategoris = KategoriBahan::all(); 

        // --- TAMBAHAN LOGIKA LOCK & EDIT ---
        $opnamePagi = \App\Models\StokOpname::where('tanggal', $date)->whereNotNull('penginput_pagi')->first();
        $opnameSore = \App\Models\StokOpname::where('tanggal', $date)->whereNotNull('penginput_sore')->first();
        
        $picPagi = $opnamePagi ? $opnamePagi->penginput_pagi : '';
        $picSore = $opnameSore ? $opnameSore->penginput_sore : '';

        // Cek apakah kasir lagi mencet tombol "Edit Pagi"
        $editMode = $request->query('edit'); 

        // RULE 1: Kunci Pagi JIKA udah ada nama penginput DAN kasir lagi nggak di mode edit
        $lockPagi = ($picPagi !== '' && $editMode !== 'pagi') ? true : false;

        // RULE 2: Kunci Sore JIKA Pagi belum kelar, ATAU kasir lagi ngedit Pagi, 
        // ATAU Sore udah kelar diisi (dan nggak lagi diedit)
        $lockSore = ($picPagi === '' || $editMode === 'pagi' || ($picSore !== '' && $editMode !== 'sore')) ? true : false;
        // ------------------------------------

        return view('pos.opname', compact('items', 'kategoris', 'date', 'picPagi', 'picSore', 'lockPagi', 'lockSore', 'editMode'));
    }

    // --- 2. TAMBAHIN FUNGSI BARU BUAT SIMPAN (POST) ---
    public function simpanOpname(Request $request)
    {
        $tanggal = $request->tanggal_opname;
        $opnameData = $request->opname ?? []; 

        foreach ($opnameData as $bahan_baku_id => $data) {
            $updateData = [];

            // Pengecekan Aman: Pastikan datanya diisi angka (Bukan string kosong)
            // (Note: Angka 0 tetap terbaca valid di sini)
            $isiPagi = (isset($data['pagi_besar']) && $data['pagi_besar'] !== '') || 
                       (isset($data['pagi_kecil']) && $data['pagi_kecil'] !== '');
            
            if ($isiPagi) {
                if ($request->filled('pic_pagi')) $updateData['penginput_pagi'] = $request->pic_pagi;
                $updateData['stok_pagi_besar'] = $data['pagi_besar'] ?? null;
                $updateData['stok_pagi_kecil'] = $data['pagi_kecil'] ?? null;
            }

            $isiSore = (isset($data['sore_besar']) && $data['sore_besar'] !== '') || 
                       (isset($data['sore_kecil']) && $data['sore_kecil'] !== '');
            
            if ($isiSore) {
                if ($request->filled('pic_sore')) $updateData['penginput_sore'] = $request->pic_sore;
                $updateData['stok_sore_besar'] = ($data['sore_besar'] ?? '') !== '' ? $data['sore_besar'] : null;
$updateData['stok_sore_kecil'] = ($data['sore_kecil'] ?? '') !== '' ? $data['sore_kecil'] : null;
            }

            if (!empty($updateData)) {
                StokOpname::updateOrCreate(
                    [
                        'tanggal' => $tanggal,
                        'bahan_baku_id' => $bahan_baku_id
                    ],
                    $updateData
                );
            }
        }

        // --- JURUS REDIRECT OTOMATIS KE HALAMAN SELANJUTNYA ---
        if ($request->filled('redirect_url')) {
            return redirect($request->redirect_url)->with('success', 'Data halaman sebelumnya otomatis disimpan!');
        }

        return redirect()->back()->with('success', 'Data Opname berhasil disimpan!');
    }
}