<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    // Buka gerbang biar semua field bisa diisi langsung
    protected $guarded = [];

    // Relasi balik ke tabel Bahan Baku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}