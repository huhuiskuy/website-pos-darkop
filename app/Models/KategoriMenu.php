<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    use HasFactory;

    // Kasih tau Laravel tabel yang dipake (opsional sih, tapi biar aman)
    protected $table = 'kategori_menus';

    // Kolom yang boleh diisi manual
    protected $fillable = ['nama_kategori'];

    // Relasi: Satu Kategori punya Banyak Menu (hasMany)
    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_menu_id');
    }
}