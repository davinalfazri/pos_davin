<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualan,id',
            'product_id'   => 'required|exists:produk,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {

                // Penting: pakai penjualan_id yang dikirim form (sesuai keranjang yang
                // sedang tampil di layar), BUKAN "cari transaksi OPEN milik user" yang
                // ambigu -- karena satu user sekarang bisa punya lebih dari satu
                // transaksi berstatus OPEN sekaligus (transaksi lama yang belum
                // di-checkout + transaksi baru).
                $sale = Penjualan::where('id', $request->penjualan_id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'OPEN')
                    ->lockForUpdate()
                    ->first();

                if (!$sale) {
                    throw new \RuntimeException('Transaksi tidak ditemukan atau sudah tidak berstatus OPEN.');
                }

                $product = Produk::lockForUpdate()->findOrFail($request->product_id);

                // Cek stok
                if ($product->stok < $request->quantity) {
                    throw new \RuntimeException(
                        'Stok produk "' . $product->nama . '" tidak mencukupi (sisa ' . $product->stok . ').'
                    );
                }

                // Kurangi stok
                $product->decrement('stok', $request->quantity);

                // Harga satuan yang dipakai untuk transaksi ini adalah harga
                // JUAL SETELAH DISKON (jika produk sedang punya diskon aktif),
                // sehingga fitur diskon benar-benar berdampak pada nominal
                // yang dibayar pelanggan, bukan sekadar label di katalog.
                $hargaSatuan = $product->harga_setelah_diskon;

                // Update / insert item penjualan
                $item = ItemPenjualan::where('penjualan_id', $sale->id)
                    ->where('produk_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if ($item) {
                    // UPDATE
                    $item->kuantitas += $request->quantity;
                } else {
                    // CREATE
                    $item = new ItemPenjualan([
                        'penjualan_id' => $sale->id,
                        'produk_id'    => $product->id,
                        'kuantitas'    => $request->quantity,
                        'harga_satuan' => $hargaSatuan,
                    ]);
                }

                // hitung subtotal SETELAH kuantitas fix
                $item->subtotal = $item->kuantitas * $item->harga_satuan;
                $item->save();

                // TOTAL PEMBAYARAN
                $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
                $sale->save();
            });
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('penjualan.edit', $request->penjualan_id)
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('penjualan.edit', $request->penjualan_id)
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $saleId = $itempenjualan->penjualan_id;

        try {
            DB::transaction(function () use ($request, $itempenjualan) {

                $produk = $itempenjualan->produk()->lockForUpdate()->first();

                $selisih = $request->quantity - $itempenjualan->kuantitas;

                // Jika qty bertambah → kurangi stok
                if ($selisih > 0) {
                    if ($produk->stok < $selisih) {
                        throw new \RuntimeException(
                            'Stok produk "' . $produk->nama . '" tidak mencukupi (sisa ' . $produk->stok . ').'
                        );
                    }
                    $produk->decrement('stok', $selisih);
                }

                // Jika qty berkurang → kembalikan stok
                if ($selisih < 0) {
                    $produk->increment('stok', abs($selisih));
                }

                // Update item
                $itempenjualan->update([
                    'kuantitas' => $request->quantity,
                    'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
                ]);

                // Update total penjualan
                $itempenjualan->penjualan->update([
                    'total_pembayaran' =>
                        $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
                ]);
            });
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('penjualan.edit', $saleId)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('penjualan.edit', $saleId);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);

        $saleId = $itempenjualan->penjualan_id;

        DB::transaction(function () use ($itempenjualan) {

            $produk = $itempenjualan->produk;
            $sale   = $itempenjualan->penjualan;

            // Kembalikan stok
            if ($produk) {
                $produk->increment('stok', $itempenjualan->kuantitas);
            }

            // Hapus item
            $itempenjualan->delete();

            // Update total penjualan
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        });

        return redirect()
            ->route('penjualan.edit', $saleId)
            ->with('success', 'Produk berhasil dihapus dari keranjang.');

    }
}