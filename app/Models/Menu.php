<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    // Kolom yang boleh diisi manual dari form lu
    protected $fillable = [
        'kategori_menu_id',
        'nama_menu',
        'harga',
        'status',
        'foto_menu'
    ];

    // Relasi: Satu Menu cuma milik Satu Kategori (belongsTo)
    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_menu_id');
    }
}