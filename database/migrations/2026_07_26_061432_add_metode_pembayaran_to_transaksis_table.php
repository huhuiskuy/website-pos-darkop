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
        // Nambahin kolom metode_pembayaran setelah kolom tipe_pesanan
        $table->string('metode_pembayaran')->default('Tunai')->after('tipe_pesanan');
    });
}

public function down()
{
    Schema::table('transaksis', function (Blueprint $table) {
        // Hapus kolom kalau migration di-rollback
        $table->dropColumn('metode_pembayaran');
    });
}
};
