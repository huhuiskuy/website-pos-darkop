<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Detail ini milik satu transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Detail ini merujuk ke satu menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}