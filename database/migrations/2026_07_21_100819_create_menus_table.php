<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel kategori_menus (kalau kategori dihapus, item jadi Tak Berkategori alias null)
            $table->foreignId('kategori_menu_id')->nullable()->constrained('kategori_menus')->nullOnDelete();
            
            $table->string('nama_menu');
            $table->integer('harga'); // Pake integer aja der biar aman ngitung Rupiah-nya
            $table->string('status')->default('Tersedia'); // Pilihan: Tersedia / Habis
            $table->string('foto_menu')->nullable(); // Nullable karena opsional (bisa pake inisial huruf kalau kosong)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
