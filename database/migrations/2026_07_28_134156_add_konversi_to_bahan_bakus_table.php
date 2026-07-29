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
    Schema::table('bahan_bakus', function (Blueprint $table) {
        // Tambah kolom 'konversi' tipe integer. Default 1000 biar aman buat L->ml atau kg->gr
        $table->integer('konversi')->default(1000)->after('nama_item'); 
    });
}

public function down()
{
    Schema::table('bahan_bakus', function (Blueprint $table) {
        $table->dropColumn('konversi');
    });
}
};
