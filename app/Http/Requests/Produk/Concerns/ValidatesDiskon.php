<?php

namespace App\Http\Requests\Produk\Concerns;

use App\Models\Produk;
use Closure;

trait ValidatesDiskon
{
    /**
     * Rule validasi untuk field diskon_persen.
     *
     * Diskon 0% / dikosongkan selalu valid (artinya produk tidak sedang
     * didiskon). Jika diisi > 0%, nilainya wajib berada di rentang
     * [min, max] yang dihitung dari persentase laba produk
     * (lihat App\Models\Produk::hitungRangeDiskon()).
     *
     * @return array<int, mixed>
     */
    protected function diskonRules(): array
    {
        return [
            'nullable',
            'numeric',
            'min:0',
            'max:100',
            function (string $attribute, mixed $value, Closure $fail) {
                $hargaBeli = $this->input('purchase_price', 0);
                $hargaJual = $this->input('selling_price', 0);

                if (Produk::diskonValid($hargaBeli, $hargaJual, $value)) {
                    return;
                }

                $range = Produk::hitungRangeDiskon($hargaBeli, $hargaJual);

                if ($range['laba_persen'] <= 0) {
                    $fail('Diskon tidak bisa diberikan karena produk ini tidak memiliki margin laba (harga jual harus lebih besar dari harga beli).');
                    return;
                }

                $fail("Diskon tidak boleh melebihi persentase laba. Untuk margin laba {$range['laba_persen']}%, diskon harus antara {$range['min']}% - {$range['max']}% (atau kosongkan / isi 0 jika tidak ingin memberi diskon).");
            },
        ];
    }
}
