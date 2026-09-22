<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi #{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }} - Rucas Hoodie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Consolas, monospace;
            background: #0f172a;
            color: #0f172a;
            margin: 0;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
        }

        .receipt-paper {
            width: 320px;
            max-width: 100%;
            background: #ffffff;
            padding: 22px 18px;
            border-radius: 6px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45);
        }

        .receipt-center {
            text-align: center;
        }

        .receipt-logo {
            width: 54px;
            height: 54px;
            object-fit: contain;
            margin: 0 auto 6px;
            display: block;
            filter: invert(1);
        }

        .receipt-brand {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.06em;
        }

        .receipt-sub {
            font-size: 0.72rem;
            color: #475569;
        }

        .receipt-divider {
            border-top: 1px dashed #94a3b8;
            margin: 12px 0;
        }

        .receipt-meta {
            font-size: 0.75rem;
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }

        .receipt-items table {
            width: 100%;
            font-size: 0.75rem;
            border-collapse: collapse;
        }

        .receipt-items td {
            padding: 3px 0;
            vertical-align: top;
        }

        .receipt-items .item-name {
            font-weight: 600;
        }

        .receipt-items .text-end {
            text-align: right;
            white-space: nowrap;
        }

        .receipt-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .receipt-total-row.grand {
            font-weight: 700;
            font-size: 1rem;
            margin-top: 8px;
        }

        .receipt-footer {
            font-size: 0.75rem;
            margin-top: 14px;
        }

        .receipt-actions {
            margin-top: 20px;
            display: flex;
            gap: 8px;
        }

        .receipt-actions button,
        .receipt-actions a {
            flex: 1;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #0f172a;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }

        .receipt-actions .btn-print {
            background: #10b981;
            border-color: #10b981;
            color: #fff;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .receipt-paper {
                box-shadow: none;
                width: 80mm;
                padding: 4mm;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-paper">

        <div class="receipt-center">
            <img src="{{ asset('images/rucas.png') }}" alt="Rucas Hoodie" class="receipt-logo">
            <div class="receipt-brand">RUCAS HOODIE</div>
            <div class="receipt-sub">Local Streetwear Brand</div>
            <div class="receipt-sub">Jl. Raya Toko No. 123, Tasikmalaya</div>
            <div class="receipt-sub">WA/IG: +62 812-3456-7890</div>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-meta">
            <span>No. Transaksi</span>
            <span>#{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="receipt-meta">
            <span>Tanggal</span>
            <span>{{ \Carbon\Carbon::parse($penjualan->created_at)->format('d-m-Y H:i') }}</span>
        </div>
        <div class="receipt-meta">
            <span>Kasir</span>
            <span>{{ $penjualan->user->name ?? '-' }}</span>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-items">
            <table>
                @forelse($penjualan->itemPenjualan as $item)
                <tr>
                    <td colspan="2" class="item-name">{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                </tr>
                <tr>
                    <td>{{ $item->kuantitas }} x {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="receipt-center">Tidak ada item.</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-total-row grand">
            <span>TOTAL</span>
            <span>Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</span>
        </div>

        <div class="receipt-total-row">
            <span>Metode Bayar</span>
            <span>{{ strtoupper($penjualan->metode_pembayaran) }}</span>
        </div>

        @if($penjualan->metode_pembayaran === 'CASH' && !is_null($penjualan->cash_given))
        <div class="receipt-total-row">
            <span>Tunai Diterima</span>
            <span>Rp {{ number_format($penjualan->cash_given, 0, ',', '.') }}</span>
        </div>
        <div class="receipt-total-row">
            <span>Kembalian</span>
            <span>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="receipt-divider"></div>

        <div class="receipt-center receipt-footer">
            Terima kasih telah berbelanja di<br>
            <strong>Rucas Hoodie</strong> 🧡<br>
            Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.
        </div>

        <div class="receipt-actions no-print">
            <button type="button" class="btn-print" onclick="window.print()">
                <i class="bi bi-printer-fill"></i> Cetak Nota
            </button>
            <a href="{{ route('penjualan.index') }}">Kembali</a>
        </div>

    </div>

    <script>
        @if(request('auto'))
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.print();
            }, 300);
        });
        @endif
    </script>

</body>
</html>
