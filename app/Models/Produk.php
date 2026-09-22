<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
        'diskon_persen',
    ];

    protected $casts = [
        'diskon_persen' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'produk_id');
    }

    /*
    |--------------------------------------------------------------------
    | LOGIKA DISKON
    |--------------------------------------------------------------------
    | Aturan bisnis: persentase diskon TIDAK BOLEH melebihi persentase
    | laba produk. Sebagai pagar tambahan supaya toko tetap untung setelah
    | diskon diberikan, rentang diskon yang diperbolehkan dibatasi ke:
    |
    |   - Minimal diskon = 1/3  x persentase laba
    |   - Maksimal diskon = 2/3 x persentase laba
    |
    | Contoh: laba 30% -> minimal diskon 10%, maksimal diskon 20%.
    | (0% / tanpa diskon selalu diperbolehkan, terlepas dari besarnya laba.)
    |
    | Semua logika dipusatkan di sini (bukan diduplikasi di controller/
    | request/blade) supaya perhitungan di form tambah, form edit, dan
    | validasi backend selalu konsisten.
    */

    /**
     * Hitung persentase laba, serta rentang diskon minimum & maksimum yang
     * diperbolehkan, berdasarkan harga beli & harga jual mentah (belum
     * tentu tersimpan di database, misalnya saat validasi form).
     *
     * @param  int|float  $hargaBeli
     * @param  int|float  $hargaJual
     * @return array{laba_persen: float, min: float, max: float}
     */
    public static function hitungRangeDiskon($hargaBeli, $hargaJual): array
    {
        $hargaBeli = (float) $hargaBeli;
        $hargaJual = (float) $hargaJual;

        if ($hargaJual <= 0) {
            return ['laba_persen' => 0.0, 'min' => 0.0, 'max' => 0.0];
        }

        $labaPersen = (($hargaJual - $hargaBeli) / $hargaJual) * 100;

        // Jika rugi / balik modal, tidak ada ruang untuk diskon sama sekali.
        if ($labaPersen <= 0) {
            return ['laba_persen' => 0.0, 'min' => 0.0, 'max' => 0.0];
        }

        $labaPersen = round($labaPersen, 2);

        return [
            'laba_persen' => $labaPersen,
            'min'         => round($labaPersen / 3, 1),
            'max'         => round(($labaPersen * 2) / 3, 1),
        ];
    }

    /**
     * Validasi apakah suatu nilai diskon (%) valid untuk kombinasi harga
     * beli & harga jual tertentu. 0 (tanpa diskon) selalu valid.
     */
    public static function diskonValid($hargaBeli, $hargaJual, $diskonPersen): bool
    {
        $diskonPersen = (float) ($diskonPersen ?? 0);

        if ($diskonPersen <= 0) {
            return true;
        }

        $range = static::hitungRangeDiskon($hargaBeli, $hargaJual);

        if ($range['laba_persen'] <= 0) {
            return false;
        }

        return $diskonPersen >= $range['min'] && $diskonPersen <= $range['max'];
    }

    /**
     * Persentase laba produk ini saat ini (berdasarkan data tersimpan).
     */
    public function getLabaPersenAttribute(): float
    {
        return static::hitungRangeDiskon($this->harga_beli, $this->harga_jual)['laba_persen'];
    }

    /**
     * Batas minimum persentase diskon yang boleh diisi untuk produk ini.
     */
    public function getMinDiskonPersenAttribute(): float
    {
        return static::hitungRangeDiskon($this->harga_beli, $this->harga_jual)['min'];
    }

    /**
     * Batas maksimum persentase diskon yang boleh diisi untuk produk ini.
     */
    public function getMaxDiskonPersenAttribute(): float
    {
        return static::hitungRangeDiskon($this->harga_beli, $this->harga_jual)['max'];
    }

    /**
     * Harga jual final setelah dipotong diskon (dibulatkan ke rupiah
     * terdekat), inilah harga yang benar-benar dibayar pelanggan.
     */
    public function getHargaSetelahDiskonAttribute(): int
    {
        $diskon = (float) ($this->diskon_persen ?? 0);

        if ($diskon <= 0) {
            return (int) $this->harga_jual;
        }

        return (int) round($this->harga_jual - ($this->harga_jual * $diskon / 100));
    }

    /**
     * Apakah produk ini sedang punya diskon aktif (> 0%).
     */
    public function getPunyaDiskonAttribute(): bool
    {
        return (float) ($this->diskon_persen ?? 0) > 0;
    }
}