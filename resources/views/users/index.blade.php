@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')

<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-white mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-people-fill text-primary"></i> Kelola Users
            </h2>
            <p class="text-secondary mb-0">
                Manajemen data pengguna dan hak akses aplikasi POS
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg fs-5"></i>
            <span>Tambah User</span>
        </a>
    </div>

    <div class="card glass-card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
                <div class="row g-2 justify-content-end">
                    <div class="col-12 col-md-5 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary border-end-0 text-secondary">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                class="form-control bg-dark border-secondary border-start-0 text-white ps-0 custom-input" 
                                placeholder="Cari nama atau email...">
                            <button type="submit" class="btn btn-primary px-3">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-dark-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th>Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-end pe-3" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-3 text-secondary fw-medium">
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold text-white">{{ $user->name }}</span>
                                </div>
                            </td>

                            <td class="text-secondary">{{ $user->email }}</td>

                            <td>
                                @if(optional($user->role)->name === 'admin')
                                    <span class="badge badge-admin px-3 py-2 rounded-pill">
                                        <i class="bi bi-shield-check me-1"></i> Admin
                                    </span>
                                @elseif(optional($user->role)->name === 'kasir')
                                    <span class="badge badge-kasir px-3 py-2 rounded-pill">
                                        <i class="bi bi-person-badge me-1"></i> Kasir
                                    </span>
                                @else
                                    <span class="badge badge-other px-3 py-2 rounded-pill">
                                        {{ optional($user->role)->name ?? 'Tanpa Role' }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-end pe-3">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-action-edit btn-sm rounded-2" 
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button type="button" 
                                            class="btn btn-action-delete btn-sm rounded-2" 
                                            onclick="confirmDeleteUser('delete-user-form-{{ $user->id }}')" 
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <form id="delete-user-form-{{ $user->id }}" 
                                          action="{{ route('admin.users.destroy', $user) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data user yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top border-secondary border-opacity-25 gap-2">
                <div class="small text-secondary">
                    Menampilkan <strong class="text-white">{{ $users->firstItem() ?? 0 }}</strong> - <strong class="text-white">{{ $users->lastItem() ?? 0 }}</strong> dari <strong class="text-white">{{ $users->total() }}</strong> users
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    .glass-card {
        background: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
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

    .avatar-circle {
        width: 38px;
        height: 38px;
        background: rgba(99, 102, 241, 0.2);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .badge-admin {
        background: rgba(99, 102, 241, 0.2) !important;
        color: #818cf8 !important;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .badge-kasir {
        background: rgba(16, 185, 129, 0.2) !important;
        color: #34d399 !important;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .badge-other {
        background: rgba(148, 163, 184, 0.2) !important;
        color: #94a3b8 !important;
        border: 1px solid rgba(148, 163, 184, 0.3);
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
</style>

@push('scripts')
<script>
    function confirmDeleteUser(formId) {
        Swal.fire({
            title: 'Hapus User ini?',
            text: 'Apakah kamu yakin ingin menghapus user ini dari sistem? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            iconColor: '#ef4444',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus User',
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
    }
</script>
@endpush

@endsection