@extends('layouts.app')

@section('title', 'Login - Rucas Hoodie POS')

@section('content')

<div class="login-wrapper d-flex justify-content-center align-items-center min-vh-100 py-4">

    <div class="card-entrance-wrapper d-flex flex-column align-items-center">

        <!-- Logo -->
        <div class="brand-logo mb-3 d-flex align-items-center justify-content-center overflow-hidden p-2 @if($errors->any()) border-danger animate-shake @endif">
            <img src="{{ asset('images/rucas.png') }}" alt="Rucas Hoodie" class="w-100 h-100 object-fit-contain">
        </div>
        
        <!-- Login Card -->
        <div class="card dark-card border-0 p-4 p-md-5 login-card">

            <div class="text-center mb-4">
                <h3 class="fw-bold text-white mb-1">Selamat Datang</h3>
                <p class="text-secondary small mb-0">Login untuk mengakses sistem kasir Rucas Hoodie</p>
            </div>

            <form action="{{ route('auth') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text form-dark-input border-end-0">
                            <i class="bi bi-envelope @error('email') text-danger @else text-secondary @enderror"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control form-dark-input border-start-0 ps-0 @error('email') is-invalid @enderror"
                            placeholder="nama@email.com"
                            required 
                            autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text form-dark-input border-end-0">
                            <i class="bi bi-lock @error('password') text-danger @else text-secondary @enderror"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            class="form-control form-dark-input border-start-0 ps-0 @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn btn-neon-primary w-100 rounded-3 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <span>Login ke Sistem</span>
                        <i class="bi bi-arrow-right-short fs-5 btn-icon"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<style>
    /* Background Gelap Flat */
    html, body, .login-wrapper {
        background-color: #0f172a !important;
    }

    .login-wrapper {
        position: relative;
        z-index: 1;
    }

    .card-entrance-wrapper {
        width: 100%;
        max-width: 420px;
    }

    .login-card {
        width: 100%;
    }

    /* Card Gelap Modern (Tanpa Efek 3D/Tilt) */
    .dark-card {
        background: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 20px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
    }

    /* Logo Style */
    .brand-logo {
        width: 64px;
        height: 64px;
        background: #1e293b;
        border: 1px solid rgba(99, 102, 241, 0.4);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .border-danger {
        border-color: #ef4444 !important;
    }

    /* Form Dark Inputs */
    .form-dark-input {
        background: rgba(15, 23, 42, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    }

    .form-dark-input::placeholder {
        color: #64748b !important;
    }

    .input-group:focus-within .form-dark-input {
        border-color: #6366f1 !important;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.3) !important;
    }

    .input-group-text.form-dark-input {
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
    }

    .form-control.form-dark-input {
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
    }

    /* Button Neon Gradient */
    .btn-neon-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border: none;
        color: #fff;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
        transition: all 0.2s ease;
    }

    .btn-neon-primary:hover {
        opacity: 0.95;
        color: #fff;
        box-shadow: 0 6px 20px rgba(168, 85, 247, 0.4);
    }

    .btn-neon-primary .btn-icon {
        transition: transform 0.2s ease;
    }

    .btn-neon-primary:hover .btn-icon {
        transform: translateX(4px);
    }

    /* Shake Error Animation */
    .animate-shake {
        animation: shake 0.4s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
</style>

@endsection