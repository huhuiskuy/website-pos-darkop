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
    Schema::create('detail_transaksis', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel transaksis
        $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
        // Relasi ke tabel menus (asumsi tabel menu kamu namanya 'menus')
        $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
        
        $table->integer('qty'); // Jumlah porsi/gelas
        $table->integer('subtotal'); // harga menu * qty
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
