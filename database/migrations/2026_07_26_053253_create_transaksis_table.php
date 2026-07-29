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
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi')->unique(); // Contoh: TRX-20260726-001
        $table->integer('total_harga'); // Total keseluruhan struk
        $table->integer('uang_bayar')->default(0); // Uang dari pelanggan (misal: 50000)
        $table->integer('kembalian')->default(0);
        $table->enum('tipe_pesanan', ['Dine In', 'Take Away'])->default('Dine In');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
