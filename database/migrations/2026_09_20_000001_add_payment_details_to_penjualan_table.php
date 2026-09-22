<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom untuk menyimpan detail pembayaran:
     * - cash_given  : nominal uang tunai yang diberikan pelanggan (khusus metode CASH)
     * - kembalian   : jumlah kembalian yang diterima pelanggan (khusus metode CASH)
     *
     * Kolom ini dibutuhkan agar nota/struk transaksi bisa menampilkan
     * rincian pembayaran tunai secara akurat saat dicetak.
     */
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->unsignedBigInteger('cash_given')->nullable()->after('metode_pembayaran');
            $table->unsignedBigInteger('kembalian')->nullable()->after('cash_given');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['cash_given', 'kembalian']);
        });
    }
};
