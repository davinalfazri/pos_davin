# Changelog — Fitur Diskon Produk

Ringkasan perubahan yang ditambahkan ke aplikasi kasir (POS) ini.

## 1. Fitur Baru: Diskon Produk

Sekarang setiap produk bisa diberi **diskon persentase** langsung dari halaman
**Tambah Produk** maupun **Edit Produk**.

### Aturan bisnis diskon

Diskon **tidak boleh melebihi persentase laba** produk. Supaya toko tetap
untung setelah diskon diberikan, rentang diskon yang diperbolehkan dibatasi:

- **Minimal diskon** = 1/3 × persentase laba
- **Maksimal diskon** = 2/3 × persentase laba

Contoh: harga beli Rp70.000, harga jual Rp100.000 → laba = 30%.
Maka diskon yang boleh diisi: **10% – 20%**.

> 0% (tidak ada diskon) selalu diperbolehkan, berapa pun labanya.
> Jika harga jual ≤ harga beli (tidak untung), diskon tidak bisa diisi sama
> sekali (dipaksa 0%).

Formula ini dipusatkan di satu tempat saja: `App\Models\Produk::hitungRangeDiskon()`,
supaya perhitungan di form tambah, form edit, dan validasi backend selalu
konsisten (tidak ada logika ganda yang bisa berbeda-beda).

### Dimana diskon berefek?

Diskon bukan cuma label di katalog — diskon **benar-benar mengubah harga yang
dibayar pelanggan**:

- Halaman **Katalog Produk** & **Detail Produk**: menampilkan harga normal
  dicoret + harga setelah diskon + badge persentase diskon.
- Halaman **Kasir (POS)**: daftar produk & keranjang menampilkan harga
  setelah diskon.
- Saat kasir menambahkan produk ke keranjang, sistem menyimpan
  **harga satuan setelah diskon** sebagai harga transaksi (bukan harga
  normal), sehingga total pembayaran & nota otomatis mengikuti diskon yang
  berlaku saat item ditambahkan ke keranjang.

## 2. Perbaikan Bug / Konsistensi

- **`resources/views/produk/edit.blade.php`** sebelumnya punya field form
  yang **terpisah & tidak sinkron** dari `create.blade.php` (tidak ada
  preview foto real-time, field berbeda). Sekarang kedua halaman memakai
  partial `produk/_form.blade.php` yang sama, sehingga perilaku form Tambah
  & Edit Produk selalu identik dan mudah dipelihara.
- Menghapus duplikasi tag `@csrf` yang sebelumnya muncul dua kali di form
  produk (tidak berbahaya, tapi tidak rapi).
- Tampilan "harga per item" di keranjang kasir sekarang mengacu ke
  `harga_satuan` yang benar-benar tersimpan pada item transaksi (bukan
  `harga_jual` produk saat ini), supaya tidak membingungkan bila harga/
  diskon produk berubah setelah item ada di keranjang.

## 3. File yang Ditambahkan

- `database/migrations/2026_09_22_000001_add_diskon_persen_to_produk_table.php`
  — kolom baru `diskon_persen` (decimal 5,2, default 0) di tabel `produk`.
- `app/Http/Requests/Produk/Concerns/ValidatesDiskon.php`
  — trait berisi rule validasi `diskon_persen`, dipakai bersama oleh
  `StoreRequest` & `UpdateRequest`.

## 4. File yang Diubah

- `app/Models/Produk.php` — tambah field `diskon_persen` + logika
  perhitungan laba/rentang diskon/harga setelah diskon.
- `app/Http/Requests/Produk/StoreRequest.php`
- `app/Http/Requests/Produk/UpdateRequest.php`
- `app/Http/Controllers/ProdukController.php`
- `app/Http/Controllers/ItemPenjualanController.php`
- `resources/views/produk/_form.blade.php`
- `resources/views/produk/edit.blade.php`
- `resources/views/produk/index.blade.php`
- `resources/views/produk/detail.blade.php`
- `resources/views/penjualan/pos.blade.php`

## 5. Cara Menerapkan (WAJIB dilakukan setelah extract ZIP)

```bash
composer install        # jika folder vendor tidak ikut / ingin fresh install
php artisan migrate     # menjalankan migration kolom diskon_persen yang baru
php artisan config:clear
php artisan view:clear
```

Setelah migrasi berhasil, buka menu **Produk > Tambah/Edit**, isi Harga Beli
& Harga Jual, lalu field **Diskon (%)** akan menampilkan estimasi laba dan
rentang diskon yang valid secara otomatis (live, tanpa reload halaman).

## 6. Yang Sudah Diverifikasi

Karena environment pengembangan ini tidak menyediakan runtime PHP untuk
menjalankan `php artisan serve` / test otomatis, verifikasi dilakukan secara
manual & menyeluruh terhadap:

- Kebenaran sintaks PHP (namespace, tipe data sesuai `php: ^8.2` di
  `composer.json`, closure, trait).
- Keseimbangan seluruh directive Blade (`@if/@endif`, `@forelse/@endforelse`,
  `@can/@endcan`, `@section/@endsection`, dll) di setiap file yang diubah.
- Konsistensi nama accessor Eloquent (`getXxxAttribute` ⇆ `$model->xxx`).
- Alur data diskon dari form → validasi → database → tampilan → transaksi
  kasir, memastikan tidak ada tempat yang masih memakai harga lama tanpa
  diskon secara tidak sengaja.

**Sangat disarankan** setelah deploy, Anda mencoba skenario berikut secara
manual sekali sebagai sanity check akhir:

1. Tambah produk baru dengan harga beli & jual yang membuat laba 30% → coba
   isi diskon 5% (harus ditolak, di bawah minimum 10%), 15% (harus diterima),
   25% (harus ditolak, di atas maksimum 20%).
2. Edit produk yang sudah punya diskon → pastikan field ter-isi ulang dengan
   nilai diskon sebelumnya.
3. Tambahkan produk berdiskon ke keranjang kasir → pastikan harga di
   keranjang & total pembayaran sudah harga setelah diskon.
4. Selesaikan transaksi → cek nota mencetak harga yang sudah didiskon.
