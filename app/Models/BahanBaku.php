<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $guarded = [];

    // Relasi ke tabel kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBahan::class, 'kategori_bahan_id');
    }

    public function riwayatOpname()
    {
        return $this->hasMany(StokOpname::class, 'bahan_baku_id');
    }

    // Fungsi sakti buat nentuin badge status otomatis (UDAH DI-UPGRADE)
    public function getStatusStokAttribute()
    {
        // 1. Tarik rasio konversi (kalau misal ada data lama yang konversinya 0, kita anggep 1 biar aman)
        $rasio = $this->konversi > 0 ? $this->konversi : 1;

        // 2. Totalin stok saat ini ke dalam pecahan unit terkecil
        // Misal: 3 Karton 2 Pcs (Rasio 12) -> (3 * 12) + 2 = 38 Pcs
        $totalStokTerkecil = ($this->stok_saat_ini_besar * $rasio) + $this->stok_saat_ini_kecil;

        // 3. Totalin juga minimal stok ke pecahan unit terkecil
        // Karena di form lu "Minimal Stok" pakai label Unit Besar
        // Misal: Minimal 5 Karton -> 5 * 12 = 60 Pcs
        $batasMinimalTerkecil = $this->minimal_stok * $rasio;

        // 4. Bandingin dengan adil!
        if ($totalStokTerkecil <= 0) {
            return 'Habis';
        } elseif ($totalStokTerkecil <= $batasMinimalTerkecil) {
            return 'Menipis';
        } else {
            return 'Aman';
        }
    }

    // Accessor Stok Saat Ini (Besar)
    public function getStokSaatIniBesarAttribute()
    {
        $opname = $this->riwayatOpname->sortByDesc('tanggal')->first();
        if (!$opname) return 0;
        return $opname->stok_sore_besar !== null ? $opname->stok_sore_besar : ($opname->stok_pagi_besar ?? 0);
    }

    // Accessor Stok Saat Ini (Kecil)
    public function getStokSaatIniKecilAttribute()
    {
        $opname = $this->riwayatOpname->sortByDesc('tanggal')->first();
        if (!$opname) return 0;
        return $opname->stok_sore_kecil !== null ? $opname->stok_sore_kecil : ($opname->stok_pagi_kecil ?? 0);
    }
}
