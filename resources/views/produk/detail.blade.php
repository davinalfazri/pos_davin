@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')


<div class="container py-4">
    <h2 class="fw-bold mb-4 text-white">Halaman Detail Produk</h2>

    <div class="card bg-dark text-white border-secondary shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row g-4 align-items-center">
                
                <div class="col-12 col-md-5 text-center">
                    <div class="p-4 bg-secondary bg-opacity-10 rounded-4 border border-secondary border-opacity-25 d-flex align-items-center justify-content-center" style="min-height: 350px;">
                        @if($produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" 
                                 class="img-fluid rounded zoomable-img" 
                                 style="max-height: 320px; object-fit: contain;" 
                                 alt="{{ $produk->nama }}"
                                 onerror="this.closest('.p-4').innerHTML='<i class=\'bi bi-image fs-1 text-secondary opacity-50\'></i>'">
                        @else
                            <i class="bi bi-image fs-1 text-secondary opacity-50"></i>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-7 d-flex flex-column justify-content-between">
                    <div>
                        <h2 class="fw-bold text-white mb-4 text-capitalize display-6">{{ $produk->nama }}</h2>
                        
                        <hr class="border-secondary opacity-50 mb-4">

                        <div class="row gy-3 mb-4">
                            <div class="col-sm-4 text-white-50 fs-5">Harga Dasar</div>
                            <div class="col-sm-8 text-light fw-semibold fs-5">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</div>

                            <div class="col-sm-4 text-white-50 fs-5">Harga Jual</div>
                            <div class="col-sm-8 fs-4 {{ $produk->punya_diskon ? 'text-secondary text-decoration-line-through fw-semibold' : 'text-success fw-bold' }}">
                                Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                            </div>

                            @if($produk->punya_diskon)
                                <div class="col-sm-4 text-white-50 fs-5">Diskon</div>
                                <div class="col-sm-8">
                                    <span class="badge bg-danger px-3 py-2 fs-6 rounded-pill">
                                        {{ rtrim(rtrim(number_format($produk->diskon_persen, 1, ',', '.'), '0'), ',') }}%
                                    </span>
                                </div>

                                <div class="col-sm-4 text-white-50 fs-5">Harga Setelah Diskon</div>
                                <div class="col-sm-8 text-success fw-bold fs-4">
                                    Rp {{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                                </div>
                            @endif

                            <div class="col-sm-4 text-white-50 fs-5">Estimasi Laba</div>
                            <div class="col-sm-8 text-light fw-semibold fs-6">
                                {{ rtrim(rtrim(number_format($produk->laba_persen, 1, ',', '.'), '0'), ',') }}%
                                <span class="text-secondary fs-7">(Rp {{ number_format($produk->harga_jual - $produk->harga_beli, 0, ',', '.') }} / item sebelum diskon)</span>
                            </div>

                            <div class="col-sm-4 text-white-50 fs-5 d-flex align-items-center">Stok</div>
                            <div class="col-sm-8">
                                <span class="badge bg-info text-dark px-3 py-2 fs-6 rounded-pill">{{ $produk->stok }} unit</span>
                            </div>

                            <div class="col-sm-4 text-white-50 fs-5 d-flex align-items-center">Penginput</div>
                            <div class="col-sm-8">
                                <span class="badge bg-secondary bg-opacity-50 text-light border border-secondary px-3 py-2 fs-6">{{ $produk->user->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top border-secondary opacity-75">
                        <a href="{{ route('produk.index') }}" class="btn btn-primary btn-lg fw-semibold rounded-3 px-4">
                            &larr; Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection