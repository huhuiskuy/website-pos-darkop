<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\KategoriMenu;
use Illuminate\Support\Facades\Storage; // Wajib dipanggil buat ngatur hapus/upload file foto

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $kategori_filter = $request->kategori;
        $status_filter = $request->status;

        $kategoris = KategoriMenu::withCount('menus')->get();

        // Query Dasar (Sambil bawa relasi kategorinya)
        $query = Menu::with('kategori');

        // Fitur Search Nama Menu
        if ($search) {
            $query->where('nama_menu', 'like', "%{$search}%");
        }

        // Fitur Filter Kategori
        if ($kategori_filter) {
            if ($kategori_filter == 'tak_berkategori') {
                $query->whereNull('kategori_menu_id');
            } else {
                $query->whereHas('kategori', function($q) use ($kategori_filter) {
                    $q->where('nama_kategori', $kategori_filter);
                });
            }
        }

        // Fitur Filter Status (Tersedia / Habis)
        if ($status_filter) {
            $query->where('status', $status_filter);
        }

        // Ambil data (Ngurut dari terlama ke terbaru kayak request lu kemaren) dan Pagination 8 item
        $menus = $query->oldest()->paginate(8)->withQueryString();
        $totalMenu = Menu::count();

        return view('menu.index', compact('menus', 'kategoris', 'search', 'kategori_filter', 'status_filter', 'totalMenu'));
    }

    // ==========================================
    // FUNGSI TAMBAH MENU
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_menu_id' => 'nullable|exists:kategori_menus,id',
            'harga' => 'required|numeric',
            'status' => 'required|in:Tersedia,Habis',
            'foto_menu' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil semua data kecuali foto (biar nggak error keracunan objek)
        $data = $request->except(['foto_menu']); 

        if ($request->hasFile('foto_menu')) {
            $foto = $request->file('foto_menu');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            
            // JURUS BARU: Pakai parameter 'public' biar fix masuk ke storage/app/public
            $foto->storeAs('menus', $namaFoto, 'public'); 
            
            $data['foto_menu'] = $namaFoto;
        }

        Menu::create($data);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    // ==========================================
    // FUNGSI EDIT MENU
    // ==========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_menu_id' => 'nullable|exists:kategori_menus,id',
            'harga' => 'required|numeric',
            'status' => 'required|in:Tersedia,Habis',
            'foto_menu' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        
        // Buang foto_menu dan hapus_foto_lama dari tangkapan array
        $data = $request->except(['hapus_foto_lama', 'foto_menu']);

        // 1. Kalau user upload foto BARU
        if ($request->hasFile('foto_menu')) {
            // Hapus foto lama pakai disk('public')
            if ($menu->foto_menu) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('menus/' . $menu->foto_menu);
            }
            
            // Simpan foto baru
            $foto = $request->file('foto_menu');
            $namaFoto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('menus', $namaFoto, 'public'); // JURUS BARU
            
            $data['foto_menu'] = $namaFoto;
        } 
        // 2. Kalau user MENGHAPUS foto lama
        elseif ($request->hapus_foto_lama == '1') {
            if ($menu->foto_menu) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('menus/' . $menu->foto_menu);
            }
            $data['foto_menu'] = null; 
        }

        $menu->update($data);
        return back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Sebelum hapus dari database, sapu bersih dulu foto aslinya dari folder PC!
        if ($menu->foto_menu) {
            Storage::delete('public/menus/' . $menu->foto_menu);
        }
        
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }


    // --- FUNGSI CRUD KATEGORI MENU ---
    // (Biar modal kelola kategori lu bisa jalan mulus!)
    public function storeKategori(Request $request)
    {
        KategoriMenu::create(['nama_kategori' => $request->nama_kategori]);
        return back()->with('open_kategori', true);
    }

    public function updateKategori(Request $request, $id)
    {
        $kat = KategoriMenu::findOrFail($id);
        $kat->update(['nama_kategori' => $request->nama_kategori_baru]);
        return back()->with('open_kategori', true);
    }

    public function destroyKategori($id)
    {
        $kat = KategoriMenu::findOrFail($id);
        
        // Kalau kategori dihapus, menu yang ada di dalemnya dilempar ke "Tak Berkategori"
        Menu::where('kategori_menu_id', $id)->update([
            'kategori_menu_id' => null
        ]);

        $kat->delete();
        return back()->with('open_kategori', true);
    }
}