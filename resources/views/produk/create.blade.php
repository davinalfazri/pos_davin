@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')


<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            
            <!-- Header Page -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-box-seam-fill text-primary"></i> Tambah Produk Baru
                    </h2>
                    <p class="text-secondary mb-0">
                        Isi data produk baru ke dalam sistem katalog inventaris.
                    </p>
                </div>
                
            </div>

            <!-- Form Card -->
            <div class="card glass-card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <!-- FIX 1: Action diarahkan ke produk.store dan tanpa @method('PUT') -->
                    <form action="{{ route('produk.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Form Fields (Partials) -->
                        @include('produk._form')

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary border-opacity-25">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary text-secondary border-secondary px-4 py-2 rounded-3">
                                Batal
                            </a>
                            <!-- FIX 2: Tombol disesuaikan untuk Simpan Produk Baru -->
                            <button type="submit" class="btn btn-neon-primary px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-plus-circle"></i>
                                <span>Simpan Produk</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Custom Dark Styling (Glassmorphism Tema Utama) -->
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

    /* Input, Select, Textarea & Label styling untuk elemen dalam partials _form */
    .form-control, .form-select {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #f8fafc !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.3) !important;
    }
    .form-label {
        color: #cbd5e1 !important;
        font-weight: 500;
    }
    
    /* Styling khusus input file (Upload Gambar Produk) */
    .form-control[type="file"]::file-selector-button {
        background-color: #1e293b;
        color: #cbd5e1;
        border: 0;
        border-right: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.375rem 0.75rem;
        margin-right: 0.75rem;
        transition: background-color 0.2s ease;
    }
    .form-control[type="file"]::file-selector-button:hover {
        background-color: #334155;
        color: #fff;
    }
</style>

@endsection