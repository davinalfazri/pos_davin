@extends('layouts.app')

@section('title', 'Tentang Perusahaan - Rucas Hoodie')

@section('content')
<div class="py-4">
    <div class="container">

        <!-- Header Judul Halaman -->
        <div class="mb-4">
            <h3 class="fw-bold text-white d-flex align-items-center gap-2">
                <i class="bi bi-building text-primary"></i> Tentang Perusahaan
            </h3>
            <p class="text-muted small">Sistem manajemen penjualan resmi untuk Rucas Hoodie</p>
        </div>

        <!-- HERO: Brand Rucas -->
        <div class="card border-0 shadow-lg rounded-4 text-white p-4 p-md-5 mb-4" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08) !important;">
            <div class="row align-items-center g-4">
                <div class="col-lg-3 text-center">
                    <div class="rounded-4 overflow-hidden border border-3 border-primary shadow d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px; background: rgba(99, 102, 241, 0.1);">
                        {{-- Ganti dengan logo Rucas --}}
                        <img src="{{ asset('images/rucas.png') }}" alt="Logo Rucas" class="w-100 h-100 object-fit-contain p-3 zoomable-img">
                    </div>
                </div>
                <div class="col-lg-9 text-center text-lg-start">
                    <h2 class="fw-bold text-white mb-1">Rucas <span class="text-primary">Hoodie</span></h2>
                    <p class="text-primary fw-medium mb-3">Local Streetwear Brand</p>
                    <div class="p-3 rounded-3" style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.05);">
                        <p class="text-white small mb-0">
                            {{-- ISI DI SINI: tagline/cerita singkat brand Rucas --}}
                            "Rucas hadir untuk menghadirkan hoodie berkualitas dengan desain khas, dibuat untuk mereka yang ingin tampil nyaman dan percaya diri."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tentang Brand & Sistem -->
        <div class="row g-4 mb-4">
            <!-- Tentang Brand -->
            <div class="col-md-6">
                <div class="card border-0 rounded-4 p-4 h-100 text-white" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.06) !important;">
                    <h5 class="fw-semibold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="p-2 rounded-2" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">🧥</span>
                        Tentang Rucas
                    </h5>
                    <p class="text-white small lh-base mb-0">
                        {{-- ISI DI SINI: tahun berdiri, jenis produk (hoodie, jaket, dll), target pasar, keunggulan bahan/desain --}}
                        Rucas berdiri sejak tahun ..., berfokus memproduksi hoodie premium dengan bahan berkualitas dan desain
                        original. Produk kami dibuat untuk memenuhi kebutuhan fashion streetwear yang nyaman digunakan sehari-hari.
                    </p>
                </div>
            </div>

            <!-- Tentang Sistem -->
            <div class="col-md-6">
                <div class="card border-0 rounded-4 p-4 h-100 text-white" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.06) !important;">
                    <h5 class="fw-semibold text-white mb-3 d-flex align-items-center gap-2">
                        <span class="p-2 rounded-2" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">🚀</span>
                        Tentang Sistem
                    </h5>
                    <p class="text-white small lh-base mb-0">
                        Sistem Point of Sales (POS) ini dirancang khusus untuk mendukung operasional penjualan Rucas Hoodie —
                        mulai dari pencatatan transaksi harian, pemantauan stok per varian ukuran & warna secara real-time,
                        hingga laporan penjualan yang rapi dan mudah dipantau.
                    </p>
                </div>
            </div>
        </div>

        <!-- Stack Teknologi -->
        <div class="card border-0 rounded-4 p-4 mb-4 text-white" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.06) !important;">
            <h5 class="fw-semibold text-white mb-3 d-flex align-items-center gap-2">
                <span class="p-2 rounded-2" style="background: rgba(99, 102, 241, 0.15); color: #818cf8;">⚙️</span>
                Stack Teknologi & Bahasa
            </h5>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5);">
                        <span class="text-muted small d-block mb-1">Bahasa Pemrograman</span>
                        <strong class="text-primary">PHP & JavaScript</strong>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5);">
                        <span class="text-muted small d-block mb-1">Framework Backend</span>
                        <strong class="text-primary">Laravel (Blade Engine)</strong>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5);">
                        <span class="text-muted small d-block mb-1">Frontend Style</span>
                        <strong class="text-primary">Bootstrap 5 & Custom CSS</strong>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5);">
                        <span class="text-muted small d-block mb-1">Database</span>
                        <strong class="text-primary">MySQL / MariaDB</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Credit Developer (kecil, di bawah) -->
        <div class="card border-0 rounded-4 p-3 text-white" style="background: rgba(30, 41, 59, 0.3); border: 1px solid rgba(255, 255, 255, 0.05) !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle overflow-hidden border border-2 border-primary" style="width: 56px; height: 56px;">
                    <img src="{{ asset('images/images.jpg') }}" alt="Foto Profil Davin Alfazri" class="w-100 h-100 object-fit-cover zoomable-img">
                </div>
                <div>
                    <p class="mb-0 small text-muted">Dikembangkan & dipelihara oleh</p>
                    <p class="mb-0 fw-semibold text-white">Davin Alfazri <span class="text-primary fw-normal">— Full Stack Developer</span></p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection