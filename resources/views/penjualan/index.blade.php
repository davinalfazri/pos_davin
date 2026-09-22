@extends('layouts.app')

@section('title', 'Rekap Penjualan')

@section('content')

<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-white"></i> Rekap Penjualan
            </h2>
            <p class="text-secondary mb-0">
                Kelola data log transaksi, riwayat penjualan, dan status pembayaran.
            </p>
        </div>

        <a href="{{ route('penjualan.create') }}" class="btn btn-neon-primary px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg fs-5"></i>
            <span>Transaksi Baru</span>
        </a>
    </div>

    <div class="card glass-card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('penjualan.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary border-end-0 text-secondary">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control bg-dark border-secondary border-start-0 text-white ps-0 custom-input"
                                placeholder="Ketik kata kunci / ID Transaksi..."
                            >
                            <button class="btn btn-primary px-4" type="submit">Cari</button>
                        </div>
                    </div>
                    @if(request('search'))
                    <div class="col-auto">
                        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary text-secondary border-secondary">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card glass-card border-0 shadow-lg rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 5%;">#</th>
                            <th>Waktu Transaksi</th>
                            <th>Kasir / Operator</th>
                            <th>Total Bayar</th>
                            <th>Metode</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-4 font-mono fw-medium text-secondary">
                                #{{ str_pad($sales->firstItem() + $loop->index, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <span class="fw-semibold text-white d-block">
                                    {{ $sale->created_at ? $sale->created_at->translatedFormat('d M Y') : '-' }}
                                </span>
                                <span class="font-mono text-secondary small">
                                    <i class="bi bi-clock me-1 text-primary"></i>{{ $sale->created_at ? $sale->created_at->format('H:i:s') : '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-pj px-3 py-1.5 rounded-pill">
                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ strtoupper($sale->user->name ?? $sale->kasir_name ?? $sale->user_id ?? 'KASIR') }}
                                </span>
                            </td>

                            <td>
                                <span class="fw-bold text-emerald fs-6">
                                    Rp {{ number_format($sale->total_pembayaran ?? $sale->total_harga ?? 0, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-method px-2.5 py-1 rounded-3">
                                    <i class="bi bi-credit-card me-1 text-primary"></i>{{ strtoupper($sale->metode_pembayaran ?? $sale->metode ?? 'CASH') }}
                                </span>
                            </td>

                            <td class="text-center">
                                @php 
                                    $st = strtoupper($sale->status ?? ''); 
                                @endphp

                                @if(in_array($st, ['COMPLETED', 'SELESAI', 'LUNAS', 'SUCCESS']))
                                    <span class="badge badge-stock-success px-3 py-1.5 rounded-pill">
                                        <i class="bi bi-check2-circle me-1"></i>COMPLETED
                                    </span>
                                @elseif(in_array($st, ['OPEN', 'PENDING', 'PROSES']))
                                    <span class="badge badge-stock-warning px-3 py-1.5 rounded-pill">
                                        <i class="bi bi-hourglass-split me-1"></i>OPEN
                                    </span>
                                @else
                                    <span class="badge badge-pj px-3 py-1.5 rounded-pill">
                                        {{ $st ?: 'SELESAI' }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2 position-relative" style="z-index: 10;">
                                    <a href="{{ route('penjualan.show', $sale) }}" 
                                       class="btn btn-action-view btn-sm rounded-2" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(strtoupper($sale->status ?? '') === 'COMPLETED')
                                        <a href="{{ route('penjualan.receipt', $sale) }}"
                                           target="_blank"
                                           class="btn btn-action-print btn-sm rounded-2"
                                           title="Cetak Nota">
                                            <i class="bi bi-printer-fill"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('penjualan.edit', $sale) }}" 
                                           class="btn btn-action-edit btn-sm rounded-2" 
                                           title="Ubah Log">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @can('delete', $sale)
                                        <button type="button" 
                                                class="btn btn-action-delete btn-sm rounded-2" 
                                                onclick="confirmDelete('delete-form-{{ $sale->id }}')" 
                                                title="Hapus Log">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $sale->id }}" action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-secondary py-3">
                                    <i class="bi bi-database-slash fs-1 d-block mb-2 text-secondary"></i>
                                    <h5 class="text-white fw-semibold">Tidak ada data transaksi</h5>
                                    <p class="small mb-0 text-secondary">Silakan buat transaksi baru atau cari dengan kata kunci lain.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($sales->hasPages())
        <div class="card-footer bg-transparent border-top border-secondary border-opacity-25 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="small text-secondary">
                    Menampilkan <strong class="text-white">{{ $sales->firstItem() ?? 0 }}</strong> - <strong class="text-white">{{ $sales->lastItem() ?? 0 }}</strong> dari <strong class="text-white">{{ $sales->total() }}</strong> transaksi
                </div>
                <div>
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .btn-neon-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border: none;
        color: #fff;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        transition: all 0.2s ease;
    }
    .btn-neon-primary:hover {
        opacity: 0.9;
        color: #fff;
        transform: translateY(-1px);
    }

    .table-dark-custom {
        color: #cbd5e1;
    }

    .table-dark-custom thead th {
        background: rgba(15, 23, 42, 0.6) !important;
        color: #94a3b8 !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1rem !important;
    }

    .table-dark-custom tbody td {
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 1rem !important;
        color: #e2e8f0;
    }

    .table-dark-custom tbody tr:hover td {
        background: rgba(255, 255, 255, 0.03) !important;
    }

    .text-emerald {
        color: #34d399 !important;
    }

    .badge-pj {
        background: rgba(148, 163, 184, 0.15) !important;
        color: #cbd5e1 !important;
        border: 1px solid rgba(148, 163, 184, 0.2);
    }

    .badge-method {
        background: rgba(15, 23, 42, 0.6) !important;
        color: #cbd5e1 !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .badge-stock-warning {
        background: rgba(245, 158, 11, 0.2) !important;
        color: #fbbf24 !important;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .badge-stock-success {
        background: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .btn-action-view, .btn-action-edit, .btn-action-delete {
        position: relative;
        z-index: 15;
        cursor: pointer !important;
    }

    .btn-action-view {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    .btn-action-view:hover {
        background: #38bdf8;
        color: #fff;
    }

    .btn-action-edit {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .btn-action-edit:hover {
        background: #f59e0b;
        color: #fff;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .btn-action-delete:hover {
        background: #ef4444;
        color: #fff;
    }

    .btn-action-print {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .btn-action-print:hover {
        background: #10b981;
        color: #fff;
    }

    .custom-input::placeholder {
        color: #64748b !important;
    }
    .custom-input:focus {
        box-shadow: none;
        border-color: #6366f1 !important;
    }

    .font-mono {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>

@push('scripts')
<script>
    function confirmDelete(formId) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Log Transaksi?',
                text: 'Apakah kamu yakin ingin menghapus permanen log transaksi ini?',
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Log',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'dark-theme-popup',
                    confirmButton: 'swal2-confirm-btn',
                    cancelButton: 'swal2-cancel-btn'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        } else {
            if (confirm('Apakah kamu yakin ingin menghapus log transaksi ini?')) {
                document.getElementById(formId).submit();
            }
        }
    }
</script>
@endpush

@endsection