<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom diskon_persen pada tabel produk untuk menyimpan
     * persentase diskon yang bisa diatur langsung dari halaman produk.
     * Nilai disimpan sebagai decimal(5,2) agar mendukung persentase desimal
     * (contoh: 12.5%), dengan default 0 (tidak ada diskon).
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->decimal('diskon_persen', 5, 2)->default(0)->after('harga_jual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('diskon_persen');
        });
    }
};
