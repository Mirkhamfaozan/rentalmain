@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 text-success"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2 text-danger"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Header Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar-lg rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user fs-2"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h3 class="mb-1 fw-bold">{{ $user->name ?? 'Nama Belum Diisi' }}</h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-envelope me-1"></i>{{ $user->email ?? 'Email Belum Diisi' }}
                            </p>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('dashboard.account.edit') }}" class="btn btn-light btn-lg shadow-sm">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="row">
        <!-- Informasi Akun -->
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <h6 class="card-title text-primary fw-bold mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Nama</label>
                                    <p class="text-muted mb-0">{{ $user->name ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-envelope text-success"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Email</label>
                                    <p class="text-muted mb-0">{{ $user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
                <a href="{{ route('dashboard.account.edit') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
        }

        .avatar-lg {
            width: 80px;
            height: 80px;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }

        .bg-opacity-20 {
            --bs-bg-opacity: 0.2;
        }
    </style>
@endsection
