@extends('layouts.app')

@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-description', 'Kelola dan pantau semua pengguna di sistem Anda.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Ekspor Pengguna
        </button>
        <button type="button" class="btn btn-outline-info" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
            <i class="fas fa-filter me-1"></i>Filter
        </button>
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>Tambah Pengguna
        </a>
    </div>
@endsection

@section('content')
    <!-- User Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $users->total() }}</div>
                            <div class="text-muted small">Total Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add more stat cards if needed (e.g., Active Users, New This Month) -->
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.users.index') }}">
                        @csrf
                        <div class="row g-3 collapse show" id="filterCollapse">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Cari pengguna..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="role" class="form-select">
                                    <option value="" {{ request('role') == '' ? 'selected' : '' }}>Semua Peran</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="rental" {{ request('role') == 'rental' ? 'selected' : '' }}>Rental</option>
                                    <option value="users" {{ request('role') == 'users' ? 'selected' : '' }}>Pengguna</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-filter me-1"></i>Terapkan
                                </button>
                                <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="fas fa-times me-1"></i>Hapus Filter
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Semua Pengguna</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active">
                                <i class="fas fa-list"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-th"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0 fw-semibold">Pengguna</th>
                                    <th class="border-0 fw-semibold">Email</th>
                                    <th class="border-0 fw-semibold">Peran</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Bergabung</th>
                                    <th class="border-0 fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input" name="selectedUsers[]" value="{{ $user->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    <div class="text-muted small">ID: #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'rental' ? 'bg-primary' : 'bg-secondary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $user->email_verified_at ? 'Aktif' : 'Belum Terverifikasi' }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('dashboard.users.show', $user->id) }}" class="btn btn-outline-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Tidak ada pengguna ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Selected Actions Bar -->
                    <div class="border-top p-3 bg-light d-none" id="selectedActions">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <span id="selectedCount">0</span> pengguna dipilih
                            </span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-check me-1"></i>Aktifkan
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                Menampilkan {{ $users->firstItem() }} hingga {{ $users->lastItem() }} dari {{ $users->total() }} entri
                            </span>
                            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle select all checkbox
    const selectAllCheckbox = document.querySelector('#selectAll');
    const rowCheckboxes = document.querySelectorAll('tbody input[name="selectedUsers[]"]');
    const selectedActions = document.getElementById('selectedActions');
    const selectedCount = document.getElementById('selectedCount');

    selectAllCheckbox.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedActions();
    });

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedActions);
    });

    function updateSelectedActions() {
        const checkedBoxes = document.querySelectorAll('tbody input[name="selectedUsers[]"]:checked');
        const count = checkedBoxes.length;

        if (count > 0) {
            selectedActions.classList.remove('d-none');
            selectedCount.textContent = count;
        } else {
            selectedActions.classList.add('d-none');
        }

        // Update select all checkbox state
        if (count === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (count === rowCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }
});
</script>
@endpush
