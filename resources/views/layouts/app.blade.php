<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rucas Hoodie - POS')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS Fallback & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Menampung <style> tambahan yang di-push oleh masing-masing halaman (mis. penjualan/pos.blade.php) --}}
    @stack('styles')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
        }

        body.login-page {
            background: linear-gradient(135deg, #4facfe, #00c6ff) !important;
            color: #212529;
        }

        .login-card {
            width: 400px;
            border-radius: 20px;
            background: #fff;
        }

        .form-control {
            border-radius: 10px;
        }

        .input-group-text {
            background: #fff;
            border-right: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .btn-primary {
            transition: .3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, .35);
        }

        .custom-navbar {
            background: rgba(15, 23, 42, 0.85) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text-primary-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-nav-link {
            color: #94a3b8 !important;
            font-weight: 500;
            padding: 0.5rem 0.85rem !important;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .custom-nav-link:hover {
            color: #f8fafc !important;
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-nav-link.active {
            color: #fff !important;
            background: rgba(99, 102, 241, 0.2) !important;
            border: 1px solid rgba(99, 102, 241, 0.3);
            font-weight: 600;
        }

        .navbar-time-badge {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout-solid {
            background-color: #ef4444 !important;
            border-color: #ef4444 !important;
            color: #ffffff !important;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-logout-solid:hover {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.4);
        }

        .dark-theme-popup {
            background: #1e293b !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
        }
        .dark-theme-popup .swal2-title {
            color: #ffffff !important;
        }
        .dark-theme-popup .swal2-html-container {
            color: #94a3b8 !important;
        }
        .swal2-confirm-btn {
            background: #ef4444 !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 8px 18px !important;
            margin-left: 8px !important;
            border: none !important;
        }
        .swal2-cancel-btn {
            background: #334155 !important;
            color: #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 8px 18px !important;
            border: none !important;
        }
    </style>
</head>
<body class="@yield('body-class')">

    @auth
    <nav class="navbar navbar-expand-lg sticky-top custom-navbar">
      <div class="container py-1">
        <!-- Brand Logo -> Diarahkan kembali ke route dashboard (Beranda) -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center gap-2" href="{{ route('tentang.toko') }}">
          <div class="brand-icon overflow-hidden p-1">
            <img src="{{ asset('images/rucas.png') }}" alt="Rucas Hoodie" class="w-100 h-100 object-fit-contain">
          </div>
          <span>Rucas <span class="text-primary-gradient">Hoodie</span></span>
        </a>

        <!-- Toggle Button Mobile -->
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="bi bi-list fs-2 text-white"></i>
        </button>

        <!-- Nav Items -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-lg-1">
            <li class="nav-item">
              <a class="nav-link custom-nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2 me-1"></i> Beranda
              </a>
            </li>

            @if(auth()->check() && strtolower(optional(auth()->user()->role)->name) === 'admin')
            <li class="nav-item">
              <a class="nav-link custom-nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                <i class="bi bi-people me-1"></i> Pengguna
              </a>
            </li>
            @endif

            <li class="nav-item">
              <a class="nav-link custom-nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                <i class="bi bi-box-seam me-1"></i> Produk
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link custom-nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                <i class="bi bi-cart-check me-1"></i> Penjualan
              </a>
            </li>


            <!-- Menu Tentang Saya -->
            <li class="nav-item">
              <a class="nav-link custom-nav-link {{ Request::is('tentang-saya*') ? 'active' : '' }}" href="{{ route('tentang.saya') }}">
                <i class="bi bi-person-badge me-1"></i> Tentang Saya
              </a>
            </li>
          </ul>

          <!-- Realtime Clock & Date Section -->
          <div class="d-none d-md-flex align-items-center gap-2 me-lg-3 px-3 py-1 rounded-3 navbar-time-badge">
            <i class="bi bi-clock text-primary"></i>
            <div class="text-start leading-tight">
              <div id="nav-clock" class="fw-bold text-white small" style="font-size: 0.85rem; line-height: 1;">--:--:-- WIB</div>
              <div id="nav-date" class="text-muted" style="font-size: 0.7rem; color: #94a3b8 !important;">-- --- ----</div>
            </div>
          </div>

          <!-- User Profile & Logout Section -->
          <div class="d-flex align-items-center gap-3 pt-3 pt-lg-0 border-top border-lg-0 border-secondary border-opacity-25">
            <div class="d-none d-xl-flex align-items-center gap-2 me-1 text-end">
                <div>
                    <div class="fw-semibold text-white small mb-0">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-muted" style="font-size: 0.75rem; color: #94a3b8;">
                        {{ ucfirst(optional(auth()->user()->role)->name ?? 'User') }}
                    </div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="btn btn-logout-solid btn-sm px-3 py-1.5 rounded-pill d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
              </button>
            </form>
          </div>

        </div>
      </div>
    </nav>
    @endauth

    <div class="container pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    @yield('content')

    {{-- Lightbox global untuk memperbesar foto (produk, QRIS, dll) tanpa pindah halaman --}}
    @include('partials.image-lightbox')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      function updateNavClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const clockElement = document.getElementById('nav-clock');
        if (clockElement) {
          clockElement.textContent = `${hours}:${minutes}:${seconds} WIB`;
        }

        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        const dateString = now.toLocaleDateString('id-ID', options);
        const dateElement = document.getElementById('nav-date');
        if (dateElement) {
          dateElement.textContent = dateString;
        }
      }

      document.addEventListener('DOMContentLoaded', function () {
        updateNavClock();
        setInterval(updateNavClock, 1000);
      });
    </script>

    @stack('scripts')

</body>
</html>