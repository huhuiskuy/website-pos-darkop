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
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id();
            
            // Tanggal opname dilakukan
            $table->date('tanggal');
            
            // Relasi ke master data bahan baku (Cascade = kalau bahan dihapus, histori opname ikut kehapus)
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->onDelete('cascade');
            
            // --- DATA SESI PAGI ---
            $table->string('penginput_pagi')->nullable();
            $table->integer('stok_pagi_besar')->nullable();
            $table->integer('stok_pagi_kecil')->nullable();
            
            // --- DATA SESI SORE ---
            // Sengaja nullable (Boleh kosong) buat nanganin Edge Case (Sore belum diisi)
            $table->string('penginput_sore')->nullable();
            $table->integer('stok_sore_besar')->nullable();
            $table->integer('stok_sore_kecil')->nullable();
            
            $table->timestamps();

            // Cegah duplikat! 1 Bahan Baku cuma boleh punya 1 record per hari
            $table->unique(['tanggal', 'bahan_baku_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};
