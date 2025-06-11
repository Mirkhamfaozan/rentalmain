
@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-description', 'Lihat informasi lengkap pengguna di sistem.')

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
        </a>
        <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-1"></i>Edit Pengguna
        </a>
        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" title="Hapus"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                <i class="fas fa-trash me-1"></i>Hapus
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
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

                    <div class="d-flex align-items-center mb-4">
                        <div>
                            <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
                            <div class="text-muted small">ID: #{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama</label>
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Peran</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'rental' ? 'bg-primary' : 'bg-secondary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $user->email_verified_at ? 'Aktif' : 'Belum Terverifikasi' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bergabung</label>
                            <p class="form-control-plaintext">{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Terakhir Diperbarui</label>
                            <p class="form-control-plaintext">{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
