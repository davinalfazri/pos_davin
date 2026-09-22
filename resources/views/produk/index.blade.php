@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-grid-fill text-primary"></i> Katalog Produk
            </h2>
            <p class="text-secondary mb-0">
                Kelola katalog produk, stok, dan harga penjualan Anda dalam bentuk kartu.
            </p>
        </div>

        @can('create', App\Models\Produk::class)
        <a href="{{ route('produk.create') }}" class="btn btn-neon-primary px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg fs-5"></i>
            <span>Tambah Produk</span>
        </a>
        @endcan
    </div>

    <div class="card glass-card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('produk.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary border-end-0 text-secondary">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control bg-dark border-secondary border-start-0 text-white ps-0 custom-input"
                                placeholder="Cari nama produk..."
                            >
                            <button class="btn btn-primary px-4" type="submit">Cari</button>
                        </div>
                    </div>
                    @if(request('search'))
                    <div class="col-auto">
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary text-secondary border-secondary">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card glass-card h-100 border-0 rounded-4 overflow-hidden product-card transition-all">
                
                <div class="position-relative product-img-container">
                    @if($product->foto)
                        <img src="{{ asset('storage/'.$product->foto) }}" 
                             alt="{{ $product->nama }}"
                             class="card-img-top object-fit-cover product-img zoomable-img">
                    @else
                        <div class="product-img-placeholder d-flex align-items-center justify-content-center text-secondary">
                            <i class="bi bi-image fs-1 opacity-50"></i>
                        </div>
                    @endif

                    <div class="position-absolute top-0 end-0 m-3">
                        @if($product->stok <= 0)
                            <span class="badge badge-stock-danger px-3 py-1.5 rounded-pill shadow-sm">Habis</span>
                        @elseif($product->stok <= 5)
                            <span class="badge badge-stock-warning px-3 py-1.5 rounded-pill shadow-sm">Stok: {{ $product->stok }}</span>
                        @else
                            <span class="badge badge-stock-success px-3 py-1.5 rounded-pill shadow-sm">Stok: {{ $product->stok }}</span>
                        @endif
                    </div>

                    @if($product->punya_diskon)
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge badge-diskon px-3 py-1.5 rounded-pill shadow-sm">
                                <i class="bi bi-tag-fill me-1"></i>Diskon {{ rtrim(rtrim(number_format($product->diskon_persen, 1, ',', '.'), '0'), ',') }}%
                            </span>
                        </div>
                    @endif
                </div>

                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-2">
                            <span class="badge badge-pj px-2.5 py-1 rounded-pill">
                                <i class="bi bi-person me-1"></i>{{ $product->user->name ?? 'System' }}
                            </span>
                        </div>

                        <h5 class="fw-bold text-white mb-3 text-truncate" title="{{ $product->nama }}">
                            {{ $product->nama }}
                        </h5>

                        <!-- Price Box -->
                        <div class="price-box p-3 rounded-3 mb-3">
                            @if($product->punya_diskon)
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-secondary small">Harga Normal:</span>
                                    <span class="small text-secondary text-decoration-line-through">
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white small fw-medium">Harga Diskon:</span>
                                    <span class="fw-bold text-emerald fs-6">
                                        Rp {{ number_format($product->harga_setelah_diskon, 0, ',', '.') }}
                                    </span>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white small fw-medium">Harga Jual:</span>
                                    <span class="fw-bold text-emerald fs-6">
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-2 border-top border-secondary border-opacity-25 d-flex gap-2">
                        <a href="{{ route('produk.show', $product) }}" 
                           class="btn btn-action-view btn-sm w-100 rounded-3 py-2 d-flex align-items-center justify-content-center gap-1" 
                           title="Detail">
                            <i class="bi bi-eye"></i>
                            <span>Detail</span>
                        </a>

                        @can('update', $product)
                        <a href="{{ route('produk.edit', $product) }}" 
                           class="btn btn-action-edit btn-sm rounded-3 px-3 py-2" 
                           title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @endcan

                        @can('delete', $product)
                        <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-action-delete btn-sm rounded-3 px-3 py-2" 
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card glass-card border-0 rounded-4 p-5 text-center">
                <div class="text-secondary py-4">
                    <i class="bi bi-box2 fs-1 d-block mb-3 text-secondary"></i>
                    <h5 class="text-white fw-semibold">Data produk belum tersedia</h5>
                    <p class="small mb-0 text-secondary">Silakan tambahkan produk baru atau gunakan kata kunci pencarian lain.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($products->hasPages())
    <div class="card glass-card border-0 rounded-4 mt-4 p-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="small text-secondary">
                Menampilkan <strong class="text-white">{{ $products->firstItem() ?? 0 }}</strong> - <strong class="text-white">{{ $products->lastItem() ?? 0 }}</strong> dari <strong class="text-white">{{ $products->total() }}</strong> produk
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
    @endif

</div>

<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .product-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4) !important;
        border-color: rgba(99, 102, 241, 0.4) !important;
    }

    .product-img-container {
        height: 180px;
        background: rgba(15, 23, 42, 0.6);
        overflow: hidden;
    }

    .product-img {
        width: 100%;
        height: 180px;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .product-img-placeholder {
        width: 100%;
        height: 180px;
        background: rgba(15, 23, 42, 0.6);
    }

    .price-box {
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
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

    .text-emerald {
        color: #34d399 !important;
    }

    .badge-pj {
        background: rgba(148, 163, 184, 0.15) !important;
        color: #cbd5e1 !important;
        border: 1px solid rgba(148, 163, 184, 0.2);
        font-size: 0.75rem;
    }

    /* Status Stok Badges */
    .badge-stock-danger {
        background: rgba(239, 68, 68, 0.85) !important;
        color: #fff !important;
        backdrop-filter: blur(4px);
    }

    .badge-stock-warning {
        background: rgba(245, 158, 11, 0.85) !important;
        color: #fff !important;
        backdrop-filter: blur(4px);
    }

    .badge-stock-success {
        background: rgba(16, 185, 129, 0.85) !important;
        color: #fff !important;
        backdrop-filter: blur(4px);
    }

    .badge-diskon {
        background: rgba(239, 68, 68, 0.9) !important;
        color: #fff !important;
        backdrop-filter: blur(4px);
        font-weight: 700;
    }

    /* Action Buttons */
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

    .custom-input::placeholder {
        color: #64748b !important;
    }
    .custom-input:focus {
        box-shadow: none;
        border-color: #6366f1 !important;
    }

    /* Style Merah SweetAlert2 */
    .swal-red-popup {
        border: 1px solid rgba(220, 38, 38, 0.5) !important;
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.2) !important;
    }

    .swal-red-btn {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4) !important;
    }

    .swal-red-btn:hover {
        background-color: #b91c1c !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.form-delete');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus Produk?',
                    text: "Data produk yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    iconColor: '#ef4444',
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#4b5563',
                    background: '#1e293b',
                    color: '#ffffff',
                    customClass: {
                        popup: 'swal-red-popup rounded-4',
                        confirmButton: 'swal-red-btn btn px-4 py-2 rounded-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection