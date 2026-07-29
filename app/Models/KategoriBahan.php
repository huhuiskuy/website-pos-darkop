<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBahan extends Model
{
    protected $guarded = [];

    public function bahanBakus()
    {
        return $this->hasMany(BahanBaku::class);
    }
}
