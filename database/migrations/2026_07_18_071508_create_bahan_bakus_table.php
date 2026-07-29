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
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            // Ganti 'kategoris' jadi 'kategori_bahans' 👇
            $table->foreignId('kategori_bahan_id')->nullable()->constrained('kategori_bahans')->nullOnDelete();
            $table->string('nama_item');
            $table->string('unit_besar');
            $table->string('unit_kecil');
            $table->integer('stok_besar')->default(0);
            $table->integer('stok_kecil')->default(0);
            $table->integer('minimal_stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
