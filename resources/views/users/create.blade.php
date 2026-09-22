@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')


<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            
            <!-- Header Page -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus-fill text-primary"></i> Tambah User Baru
                    </h2>
                    <p class="text-secondary mb-0">
                        Isi formulir di bawah ini untuk menambahkan pengguna baru ke sistem.
                    </p>
                </div>
                <!-- Menggunakan URL langsung agar tidak mengandalkan nama route -->
                
            </div>

            <!-- Form Card -->
            <div class="card glass-card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ url('/admin/users') }}" method="POST">
                        @csrf
                        
                        <!-- Form Fields (Partials) -->
                        @include('users._form')

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary border-opacity-25">
                            <a href="{{ url('/admin/users') }}" class="btn btn-outline-secondary text-secondary border-secondary px-4 py-2 rounded-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-neon-primary px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-save"></i>
                                <span>Simpan User</span>
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
</style>

@endsection