<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('transaksis', function (Blueprint $table) {
        // Tambah kolom status (kita set default 'Selesai' biar transaksi yang lama nggak error)
        $table->string('status')->default('Selesai')->after('total_harga'); 

        // Tambah kolom alasan_batal (nullable karena cuma diisi kalau transaksinya dibatalkan)
        $table->text('alasan_batal')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('transaksis', function (Blueprint $table) {
        // Menghapus kolom jika lu melakukan rollback
        $table->dropColumn(['status', 'alasan_batal']);
    });
}
};
