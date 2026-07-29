<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Supaya semua kolom bisa diisi masal
    protected $guarded = [];

    // Satu transaksi bisa punya banyak detail pesanan
    public function detail_transaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}