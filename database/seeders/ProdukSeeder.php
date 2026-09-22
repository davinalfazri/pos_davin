<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Katalog produk resmi Rucas Hoodie.
     *
     * Seeder ini sengaja HANYA berisi produk brand Rucas Hoodie (tidak ada
     * data dummy/acak lagi) supaya katalog di aplikasi murni fokus ke satu
     * brand. Harga & stok bisa diubah kapan saja lewat menu Produk, dan
     * perubahannya langsung real-time terbaca oleh halaman kasir (POS)
     * karena POS selalu mengambil data harga terbaru langsung dari database
     * setiap kali halaman dibuka / dicari, tidak ada cache.
     *
     * Foto sengaja dikosongkan (null) agar tidak memakai gambar placeholder
     * yang tidak relevan — silakan upload foto produk asli lewat menu
     * Produk > Edit setelah data ini di-seed.
     */
    protected array $produk = [
        // Oversized Hoodie
        ['nama' => 'Hoodie Oversized Rucas - Hitam (M)',  'harga_beli' => 120000, 'harga_jual' => 219000, 'stok' => 24],
        ['nama' => 'Hoodie Oversized Rucas - Hitam (L)',  'harga_beli' => 120000, 'harga_jual' => 219000, 'stok' => 30],
        ['nama' => 'Hoodie Oversized Rucas - Hitam (XL)', 'harga_beli' => 125000, 'harga_jual' => 225000, 'stok' => 18],
        ['nama' => 'Hoodie Oversized Rucas - Abu Misty (M)',  'harga_beli' => 120000, 'harga_jual' => 219000, 'stok' => 20],
        ['nama' => 'Hoodie Oversized Rucas - Abu Misty (L)',  'harga_beli' => 120000, 'harga_jual' => 219000, 'stok' => 22],
        ['nama' => 'Hoodie Oversized Rucas - Navy (L)',       'harga_beli' => 120000, 'harga_jual' => 219000, 'stok' => 15],

        // Zip-Up Hoodie
        ['nama' => 'Hoodie Zip-Up Rucas - Hitam (M)',   'harga_beli' => 145000, 'harga_jual' => 259000, 'stok' => 17],
        ['nama' => 'Hoodie Zip-Up Rucas - Hitam (L)',   'harga_beli' => 145000, 'harga_jual' => 259000, 'stok' => 19],
        ['nama' => 'Hoodie Zip-Up Rucas - Maroon (M)',  'harga_beli' => 145000, 'harga_jual' => 259000, 'stok' => 12],
        ['nama' => 'Hoodie Zip-Up Rucas - Krem (L)',    'harga_beli' => 145000, 'harga_jual' => 259000, 'stok' => 14],

        // Varsity Hoodie (edisi premium)
        ['nama' => 'Hoodie Varsity Rucas - Hitam/Krem (M)', 'harga_beli' => 165000, 'harga_jual' => 299000, 'stok' => 9],
        ['nama' => 'Hoodie Varsity Rucas - Hitam/Krem (L)', 'harga_beli' => 165000, 'harga_jual' => 299000, 'stok' => 11],
        ['nama' => 'Hoodie Varsity Rucas - Navy/Krem (XL)', 'harga_beli' => 170000, 'harga_jual' => 309000, 'stok' => 6],

        // Crewneck Sweater
        ['nama' => 'Crewneck Rucas Basic - Hitam (M)', 'harga_beli' => 95000,  'harga_jual' => 169000, 'stok' => 28],
        ['nama' => 'Crewneck Rucas Basic - Hitam (L)', 'harga_beli' => 95000,  'harga_jual' => 169000, 'stok' => 26],
        ['nama' => 'Crewneck Rucas Basic - Abu (M)',   'harga_beli' => 95000,  'harga_jual' => 169000, 'stok' => 20],

        // Merchandise pelengkap
        ['nama' => 'Topi Bucket Hat Rucas - Hitam',    'harga_beli' => 45000,  'harga_jual' => 89000,  'stok' => 40],
        ['nama' => 'Tote Bag Canvas Rucas',            'harga_beli' => 25000,  'harga_jual' => 59000,  'stok' => 50],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::where('role_id', 1)->value('id');

        foreach ($this->produk as $item) {
            Produk::firstOrCreate(
                ['nama' => $item['nama']],
                [
                    'user_id'    => $adminId,
                    'foto'       => null,
                    'harga_beli' => $item['harga_beli'],
                    'harga_jual' => $item['harga_jual'],
                    'stok'       => $item['stok'],
                ]
            );
        }
    }
}
