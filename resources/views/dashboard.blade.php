@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Dashboard - Ringkasan Hari Ini')

<!-- batas awal isi konten -->
@section('content')

<!-- Style Khusus Dashboard -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background: #0f172a !important;
        min-height: 100vh;
        position: relative;
        color: #f8fafc;
    }

    .dashboard-bg-wrapper {
        position: relative;
        padding-top: 2rem;
        padding-bottom: 4rem;
        z-index: 1;
        background: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(168, 85, 247, 0.15) 0%, transparent 40%),
            linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    }

    .glass-card {
        background: rgba(30, 41, 59, 0.7) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
    }

    .hero-banner-pro {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(168, 85, 247, 0.1) 100%);
        border: 1px solid rgba(168, 85, 247, 0.2);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
    }

    .stat-card-pro {
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card-pro:hover {
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.2);
    }

    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .icon-indigo {
        background: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .icon-emerald {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .icon-cyan {
        background: rgba(6, 182, 212, 0.15);
        color: #22d3ee;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }

    .icon-purple {
        background: rgba(168, 85, 247, 0.15);
        color: #c084fc;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    .section-title-glow {
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #f8fafc;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title-glow::before {
        content: '';
        width: 4px;
        height: 22px;
        background: linear-gradient(180deg, #6366f1, #a855f7);
        border-radius: 10px;
        box-shadow: 0 0 10px #6366f1;
    }

    .table-pro {
        color: #cbd5e1 !important;
        margin-bottom: 0;
    }

    .table-pro thead th {
        background: rgba(15, 23, 42, 0.6) !important;
        color: #94a3b8 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 16px 20px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .table-pro tbody td {
        padding: 16px 20px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        background: transparent !important;
        color: #e2e8f0 !important;
    }

    .table-pro tbody tr {
        transition: background 0.2s ease;
    }

    .table-pro tbody tr:hover {
        background: rgba(255, 255, 255, 0.03) !important;
    }

    .badge-neon-warning {
        background: rgba(245, 158, 11, 0.15) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(245, 158, 11, 0.3) !important;
    }

    .badge-neon-danger {
        background: rgba(239, 68, 68, 0.15) !important;
        color: #f87171 !important;
        border: 1px solid rgba(239, 68, 68, 0.3) !important;
    }

    .badge-neon-success {
        background: rgba(16, 185, 129, 0.15) !important;
        color: #34d399 !important;
        border: 1px solid rgba(16, 185, 129, 0.3) !important;
    }

    .rank-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
    }

    .rank-1 {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        box-shadow: 0 0 12px rgba(245, 158, 11, 0.4);
    }

    .rank-2 {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        color: #fff;
    }

    .rank-3 {
        background: linear-gradient(135deg, #b45309, #78350f);
        color: #fff;
    }

    .rank-normal {
        background: rgba(255, 255, 255, 0.05);
        color: #94a3b8;
    }
</style>

<div class="dashboard-bg-wrapper">

    <div class="container">

        <!-- Hero Dashboard Header -->
        <div class="p-4 mb-4 hero-banner-pro glass-card d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="ps-2">
                <h2 class="fw-extrabold mb-1 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2" style="color: #818cf8;"></i> Ringkasan Hari Ini
                </h2>
                <p class="mb-0 fs-6" style="color: #94a3b8;">
                    <i class="bi bi-calendar3 me-1" style="color: #818cf8;"></i> {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div>
                <span class="badge badge-neon-success px-3 py-2 rounded-pill fw-semibold shadow-sm">
                    <span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>
                    Live Data Update
                </span>
            </div>
        </div>

        @can('__viewAny', App\Models\User::class)
        <!-- Section 1: Sales Summary -->
        <div class="mb-5">
            <h5 class="section-title-glow mb-4">Today's Sales Summary</h5>

            <div class="row g-3">
                <!-- Total Penjualan -->
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card-pro">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase fs-7 fw-bold" style="color: #94a3b8; font-size: 0.75rem;">Total Penjualan</span>
                                <h3 class="fw-bold mb-0 mt-1 text-white">Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="stat-icon-wrapper icon-indigo">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jumlah Transaksi -->
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card-pro">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase fs-7 fw-bold" style="color: #94a3b8; font-size: 0.75rem;">Jumlah Transaksi</span>
                                <h3 class="fw-bold mb-0 mt-1 text-white">{{ number_format($ringkasan['total_transaksi']) }} <small class="fs-6" style="color: #94a3b8;">x</small></h3>
                            </div>
                            <div class="stat-icon-wrapper icon-emerald">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Tunai -->
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card-pro">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase fs-7 fw-bold" style="color: #94a3b8; font-size: 0.75rem;">Pembayaran Tunai</span>
                                <h3 class="fw-bold mb-0 mt-1 text-white">Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="stat-icon-wrapper icon-cyan">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Non-Tunai -->
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card-pro">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-uppercase fs-7 fw-bold" style="color: #94a3b8; font-size: 0.75rem;">Non-Tunai</span>
                                <h3 class="fw-bold mb-0 mt-1 text-white">Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}</h3>
                            </div>
                            <div class="stat-icon-wrapper icon-purple">
                                <i class="bi bi-qr-code-scan"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Section 2: Critical Inventory Status -->
        <div class="mb-5">
            <h5 class="section-title-glow mb-4">Critical Inventory Status</h5>

            <div class="row g-4">
                <!-- Stok Rendah -->
                <div class="col-lg-6">
                    <div class="glass-card overflow-hidden h-100">
                        <div class="p-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                            <h6 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill text-warning"></i> Produk Stok Rendah
                            </h6>
                            <span class="badge badge-neon-warning px-3 py-1.5 rounded-pill fs-7 fw-bold">Peringatan</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-pro align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-4" width="60">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-end pe-4">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokRendah as $index => $produk)
                                    <tr>
                                        <td class="ps-4 font-monospace" style="color: #94a3b8;">{{ $produkStokRendah->firstItem() + $index }}</td>
                                        <td class="fw-semibold text-white">{{ $produk->nama }}</td>
                                        <td class="text-end pe-4">
                                            <span class="badge badge-neon-warning px-3 py-1.5 rounded-pill fw-bold">
                                                {{ $produk->stok }} Unit
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5" style="color: #94a3b8;">
                                            <i class="bi bi-shield-check fs-1 d-block mb-2" style="color: #34d399;"></i>
                                            Seluruh produk dalam kondisi stok aman.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($produkStokRendah->hasPages())
                        <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-end">
                            {{ $produkStokRendah->links() }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Stok Habis -->
                <div class="col-lg-6">
                    <div class="glass-card overflow-hidden h-100">
                        <div class="p-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                            <h6 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-x-circle-fill text-danger"></i> Produk Habis Stok
                            </h6>
                            <span class="badge badge-neon-danger px-3 py-1.5 rounded-pill fs-7 fw-bold">Kritis</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-pro align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-4" width="60">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-end pe-4">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokHabis as $index => $produk)
                                    <tr>
                                        <td class="ps-4 font-monospace" style="color: #94a3b8;">{{ $produkStokHabis->firstItem() + $index }}</td>
                                        <td class="fw-semibold text-white">{{ $produk->nama }}</td>
                                        <td class="text-end pe-4">
                                            <span class="badge badge-neon-danger px-3 py-1.5 rounded-pill fw-bold">
                                                Habis
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5" style="color: #94a3b8;">
                                            <i class="bi bi-check-circle fs-1 d-block mb-2" style="color: #34d399;"></i>
                                            Tidak ada produk yang habis stok.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($produkStokHabis->hasPages())
                        <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-end">
                            {{ $produkStokHabis->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Best Seller Products -->
        <div>
            <h5 class="section-title-glow mb-4">Best Seller Products</h5>

            <div class="glass-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-pro align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 80px;">Rank</th>
                                <th>Nama Produk</th>
                                <th>Sisa Stok</th>
                                <th class="text-end pe-4">Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkTerlaris as $index => $produk)
                            <tr>
                                <td class="ps-4">
                                    @if($loop->first)
                                    <div class="rank-circle rank-1" title="Peringkat 1">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    @elseif($loop->iteration == 2)
                                    <div class="rank-circle rank-2" title="Peringkat 2">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    @elseif($loop->iteration == 3)
                                    <div class="rank-circle rank-3" title="Peringkat 3">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    @else
                                    <div class="rank-circle rank-normal">#{{ $loop->iteration }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-white fs-6 d-block">{{ $produk->nama }}</span>
                                </td>
                                <td>
                                    <span class="badge border border-secondary border-opacity-50 px-3 py-1.5 rounded-2" style="color: #cbd5e1;">
                                        {{ $produk->stok }} Unit
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="fw-bold fs-6" style="color: #34d399;">
                                        <i class="bi bi-bag-check me-1"></i>{{ $produk->total_terjual }} Unit
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5" style="color: #94a3b8;">
                                    <i class="bi bi-box2 fs-1 d-block mb-2"></i>
                                    Belum ada data penjualan produk terlaris.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- batas Akhir isi konten -->
@endsection