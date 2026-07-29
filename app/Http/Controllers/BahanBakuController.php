<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\KategoriBahan;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $kategori_filter = $request->kategori;
        $status_filter = $request->status;

        $kategoris = KategoriBahan::withCount('bahanBakus')->get();

        // Query Dasar
        $query = BahanBaku::with(['kategori', 'riwayatOpname']);

        if ($search) {
            $query->where('nama_item', 'like', "%{$search}%");
        }
        
        // --- LOGIKA FILTER KATEGORI DIUBAH DI SINI ---
        if ($kategori_filter) {
            if ($kategori_filter == 'tak_berkategori') {
                // Filter khusus untuk item yang nggak punya kategori (kategori_bahan_id = null)
                $query->whereNull('kategori_bahan_id');
            } else {
                // Filter normal untuk kategori lainnya
                $query->whereHas('kategori', function($q) use ($kategori_filter) {
                    $q->where('nama_kategori', $kategori_filter);
                });
            }
        }

        // Get All untuk diproses di level Koleksi (karena status_stok sekarang dinamis)
        $bahanBakusQuery = $query->oldest()->get();

        // --- LOGIKA FILTER STATUS DI LEVEL KOLEKSI ---
        if ($status_filter) {
            $bahanBakusQuery = $bahanBakusQuery->filter(function($item) use ($status_filter) {
                return $item->status_stok == $status_filter;
            });
        }

        // Pagination 5 item per halaman secara manual
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 5;
        $bahanBakus = new \Illuminate\Pagination\LengthAwarePaginator(
            $bahanBakusQuery->forPage($page, $perPage)->values(),
            $bahanBakusQuery->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => request()->query()]
        );

        // Kalkulasi Statistik Cards
        $allBahan = BahanBaku::with('riwayatOpname')->get();
        $stats = [
            'total' => $allBahan->count(),
            'aman' => $allBahan->where('status_stok', 'Aman')->count(),
            'menipis' => $allBahan->where('status_stok', 'Menipis')->count(),
            'habis' => $allBahan->where('status_stok', 'Habis')->count(),
        ];

        return view('bahan_baku.index', compact('bahanBakus', 'kategoris', 'stats', 'search', 'kategori_filter', 'status_filter'));
    }

    // --- FUNGSI CRUD BAHAN BAKU ---
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_item'         => 'required|string|max:255',
            'kategori_bahan_id' => 'nullable|exists:kategori_bahans,id', 
            'unit_besar'        => 'required|string',
            'unit_kecil'        => 'nullable',
            'konversi'          => 'nullable|numeric',
            'minimal_stok'      => 'required|numeric',
        ]); 
        
        // 2. Simpan data pakai nilai default ('??') kalau kosong
        BahanBaku::create([
            'nama_item' => $request->nama_item,
            'kategori_bahan_id' => $request->kategori_bahan_id,
            'unit_besar' => $request->unit_besar,
            'unit_kecil' => $request->unit_kecil ?? '-',
            'konversi' => $request->konversi ?? 1000,   // Kalau kosong, otomatis jadi 1000
            'stok_besar' => 0,
            'stok_kecil' => 0,
            'minimal_stok' => $request->minimal_stok,
        ]);

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_item'         => 'required|string|max:255',
            'kategori_bahan_id' => 'nullable|exists:kategori_bahans,id', 
            'unit_besar'        => 'required|string',
            'unit_kecil'        => 'nullable',
            'konversi'          => 'nullable|numeric',
            'minimal_stok'      => 'required|numeric',
        ]);

        // --- JURUS PENGAMAN UPDATE ---
        // Kalau field ini dikosongin sama kasir, paksa isi pakai nilai default
        $validatedData['konversi']   = $request->konversi ?? 1000;
        
        // JURUS PENGAMAN: Kalau unit kecil kosong, paksa jadi strip '-'
        $validatedData['unit_kecil'] = $request->unit_kecil ?? '-'; 

        $bahan = BahanBaku::findOrFail($id);
        
        // Save pakai $validatedData, JANGAN pakai $request->all()
        $bahan->update($validatedData);
        
        return back()->with('success', 'Bahan baku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        BahanBaku::destroy($id);
        return back()->with('success', 'Bahan baku berhasil dihapus!');
    }

    // --- FUNGSI CRUD KATEGORI ---
    public function storeKategori(Request $request)
    {
        KategoriBahan::create(['nama_kategori' => $request->nama_kategori]);
        return back()->with('open_kategori', true);
    }

    public function updateKategori(Request $request, $id)
    {
        $kat = KategoriBahan::findOrFail($id);
        $kat->update(['nama_kategori' => $request->nama_kategori_baru]);
        return back()->with('open_kategori', true);
    }

    public function destroyKategori($id)
    {
        $kat = KategoriBahan::findOrFail($id);
        
        // 1. Cari semua Bahan Baku yang pakai kategori ini, ubah jadi Tak Berkategori (null)
        BahanBaku::where('kategori_bahan_id', $id)->update([
            'kategori_bahan_id' => null
        ]);

        // 2. Setelah item aman, baru hapus kategorinya
        $kat->delete();
        
        return back()->with('open_kategori', true);
    }
}