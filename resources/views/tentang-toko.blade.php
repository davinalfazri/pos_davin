@extends('layouts.app')

@section('title', 'Tentang Toko - Rucas Hoodie')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white border-0 shadow-lg p-4 rounded-4" style="background: rgba(30, 41, 59, 0.85) !important; border: 1px solid rgba(255, 255, 255, 0.08) !important;">
                <div class="card-body text-center py-4">
                    
                    <div class="d-inline-flex align-items-center justify-content-center mb-3">
                        <div class="rounded-4 overflow-hidden d-inline-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3);">
                            <img src="{{ asset('images/rucas.png') }}" alt="Logo Rucas Hoodie" class="w-100 h-100 object-fit-contain p-2 zoomable-img">
                        </div>
                    </div>
                    <h2 class="fw-bold mb-2">Rucas <span class="text-primary-gradient">Hoodie</span></h2>
                    <p class="text-muted mb-4">Local Streetwear Brand &mdash; Solusi Kasir Digital Modern & Terpercaya</p>

                    <hr class="border-secondary opacity-25 my-4">

                    <div class="row text-start g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Alamat</small>
                                <span class="fw-semibold">Jl. Raya Toko No. 123, Tasikmalaya</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-whatsapp text-success me-1"></i> Kontak / WhatsApp</small>
                                <span class="fw-semibold">+62 812-3456-7890</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-instagram text-warning me-1"></i> Instagram</small>
                                <span class="fw-semibold">@rucashoodie</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <small class="text-muted d-block mb-1"><i class="bi bi-clock-fill text-info me-1"></i> Jam Operasional</small>
                                <span class="fw-semibold">Senin - Sabtu (08.00 - 21.00)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-3 text-start" style="background: rgba(15, 23, 42, 0.3); border: 1px solid rgba(99, 102, 241, 0.2);">
    <small class="text-primary fw-bold d-block mb-1"><i class="bi bi-info-circle me-1"></i> Deskripsi Toko</small>
    <p class="text-white small mb-0">
        Rucas Hoodie adalah brand streetwear lokal yang berfokus memproduksi hoodie premium dengan bahan berkualitas dan desain original, dibuat untuk mereka yang ingin tampil nyaman dan percaya diri.

Sistem Point of Sales (POS) ini dikembangkan khusus untuk mendukung operasional penjualan Rucas Hoodie, mulai dari pencatatan transaksi harian, pemantauan stok per varian ukuran & warna secara akurat, hingga laporan penjualan yang rapi dan mudah dipantau secara real-time.
    </p>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
