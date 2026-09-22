@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')


<div class="container py-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-primary"></i> Detail Penjualan
            </h2>
            <p class="text-secondary mb-0">Informasi ringkasan dan rincian barang transaksi penjualan.</p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-light border-secondary text-secondary-hover px-4 py-2 rounded-3 d-flex align-items-center gap-2 transition-all">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    @if($penjualan->status === 'COMPLETED')
    <div class="mb-4">
        <a href="{{ route('penjualan.receipt', $penjualan) }}" target="_blank" class="btn btn-success px-4 py-2 rounded-3 d-flex align-items-center gap-2 shadow-sm" style="width: fit-content;">
            <i class="bi bi-printer-fill"></i>
            <span>Cetak Nota</span>
        </a>
    </div>
    @endif

    <!-- Informasi Ringkasan Transaksi -->
    <div class="card glass-card border-0 shadow-lg rounded-4 mb-4 p-3 p-md-4">
        <div class="row g-4 text-center text-md-start">
            <div class="col-6 col-md-3">
                <span class="text-secondary small d-block mb-1">Kasir</span>
                <span class="fw-bold text-white fs-5">{{ $penjualan->user->name ?? '-' }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-secondary small d-block mb-1">Tanggal Transaksi</span>
                <span class="fw-bold text-white fs-6">{{ \Carbon\Carbon::parse($penjualan->created_at)->format('d-m-Y H:i:s') }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-secondary small d-block mb-1">Metode Pembayaran</span>
                <span class="badge badge-payment px-3 py-2 rounded-pill fs-6">{{ strtoupper($penjualan->metode_pembayaran ?? 'CASH') }}</span>
            </div>
            <div class="col-6 col-md-3">
                <span class="text-secondary small d-block mb-1">Total Pembayaran</span>
                <span class="fw-bold text-emerald fs-4">Rp {{ number_format($penjualan->total_pembayaran ?? $penjualan->total_harga ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian Barang Dibeli -->
    <div class="card glass-card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 p-4">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-basket2-fill text-primary"></i> Daftar Barang Dibeli
            </h5>
        </div>
        <div class="table-responsive">
            <table class="table table-dark-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4 text-secondary text-uppercase small fw-semibold">NO</th>
                        <th class="text-secondary text-uppercase small fw-semibold">FOTO</th>
                        <th class="text-secondary text-uppercase small fw-semibold">NAMA PRODUK</th>
                        <th class="text-center text-secondary text-uppercase small fw-semibold">JUMLAH</th>
                        <th class="text-end text-secondary text-uppercase small fw-semibold">HARGA SATUAN</th>
                        <th class="pe-4 text-end text-secondary text-uppercase small fw-semibold">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Mendukung relasi itemPenjualan atau detailPenjualan --}}
                    @php
                        $items = $penjualan->detailPenjualan ?? $penjualan->itemPenjualan ?? [];
                    @endphp

                    @forelse($items as $index => $detail)
                    <tr class="border-bottom border-secondary border-opacity-10">
                        <td class="ps-4 text-secondary fw-medium">{{ $index + 1 }}</td>
                        <td>
                            @if(isset($detail->produk) && $detail->produk->foto)
                                <img src="{{ asset('storage/' . $detail->produk->foto) }}" alt="{{ $detail->produk->nama }}" class="product-thumb rounded-3 object-fit-cover zoomable-img">
                            @else
                                <div class="product-thumb-placeholder rounded-3 d-flex align-items-center justify-content-center text-secondary">
                                    <i class="bi bi-image fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold text-white">{{ $detail->produk->nama ?? 'Produk Dihapus' }}</td>
                        <td class="text-center">
                            <span class="badge badge-qty px-3 py-1.5 rounded-pill">{{ $detail->kuantitas ?? $detail->jumlah ?? 0 }}</span>
                        </td>
                        <td class="text-end text-white">Rp {{ number_format($detail->harga_satuan ?? ($detail->subtotal / ($detail->kuantitas ?: 1)), 0, ',', '.') }}</td>
                        <td class="pe-4 text-end fw-bold text-emerald">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">Tidak ada rincian barang untuk transaksi ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    /* Card Glassmorphism Tema Gelap */
    .glass-card {
        background: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Tabel Custom Gelap */
    .table-dark-custom {
        --bs-table-bg: transparent;
        color: #f8fafc;
    }

    .table-dark-custom thead {
        background: rgba(15, 23, 42, 0.7) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-dark-custom th {
        padding-top: 1rem;
        padding-bottom: 1rem;
        letter-spacing: 0.05em;
    }

    .table-dark-custom td {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Thumbnail Gambar */
    .product-thumb {
        width: 48px;
        height: 48px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .product-thumb-placeholder {
        width: 48px;
        height: 48px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Color Accents */
    .text-emerald {
        color: #34d399 !important;
    }

    /* Badges */
    .badge-payment {
        background: rgba(56, 189, 248, 0.15) !important;
        color: #38bdf8 !important;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }

    .badge-qty {
        background: rgba(99, 102, 241, 0.2) !important;
        color: #818cf8 !important;
        border: 1px solid rgba(99, 102, 241, 0.3);
        font-weight: 600;
    }

    /* Button Styling */
    .text-secondary-hover:hover {
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
        background: rgba(255, 255, 255, 0.05);
    }
</style>

@endsection