@extends('layouts.app')

@section('title', 'Profil Rental')

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
                                <i class="fas fa-store fs-2"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h3 class="mb-1 fw-bold">{{ $biodata->nama_rental ?? 'Nama Rental Belum Diisi' }}</h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-user me-1"></i>{{ $biodata->nama_pemilik ?? 'Nama Pemilik Belum Diisi' }}
                            </p>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $biodata->kota ?? 'Kota Belum Diisi' }}, {{ $biodata->provinsi ?? 'Provinsi Belum Diisi' }}
                            </p>
                        </div>
                        <div class="col-auto">
                            @if($biodata->canUpdate(auth()->user()))
                                <a href="{{ route('dashboard.profile.edit') }}" class="btn btn-light btn-lg shadow-sm">
                                    <i class="fas fa-edit me-2"></i>Edit Profil
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="row">
        <!-- Informasi Dasar -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <h6 class="card-title text-primary fw-bold mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-store text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Nama Rental</label>
                                    <p class="text-muted mb-0">{{ $biodata->nama_rental ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user text-success"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Nama Pemilik</label>
                                    <p class="text-muted mb-0">{{ $biodata->nama_pemilik ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-envelope text-info"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Email Perusahaan</label>
                                    <p class="text-muted mb-0">{{ $biodata->email_perusahaan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Lokasi -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <h6 class="card-title text-warning fw-bold mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Informasi Lokasi
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-warning bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-home text-warning"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Alamat</label>
                                    <p class="text-muted mb-0">{{ $biodata->alamat ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-city text-secondary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Kota</label>
                                    <p class="text-muted mb-0">{{ $biodata->kota ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-dark bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-map text-dark"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Provinsi</label>
                                    <p class="text-muted mb-0">{{ $biodata->provinsi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm rounded bg-danger bg-opacity-10 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-mail-bulk text-danger"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Kode Pos</label>
                                    <p class="text-muted mb-0">{{ $biodata->kode_pos ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Kontak -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                    <h6 class="card-title text-success fw-bold mb-0">
                        <i class="fas fa-phone me-2"></i>Informasi Kontak
                    </h6>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 rounded bg-light">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md rounded-circle bg-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-phone text-white fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Nomor Telepon</label>
                                    <p class="text-muted mb-0 fs-6">
                                        @if($biodata->no_telepon)
                                            <a href="tel:{{ $biodata->no_telepon }}" class="text-decoration-none">
                                                {{ $biodata->no_telepon }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 rounded bg-light">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md rounded-circle bg-success d-flex align-items-center justify-content-center">
                                        <i class="fab fa-whatsapp text-white fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <label class="form-label fw-semibold text-dark mb-1">Nomor WhatsApp</label>
                                    <p class="text-muted mb-0 fs-6">
                                        @if($biodata->no_wa)
                                            <a href="https://wa.me/{{ $biodata->no_wa }}" class="text-decoration-none" target="_blank">
                                                {{ $biodata->no_wa }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </p>
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
                @if($biodata->canUpdate(auth()->user()))
                    <a href="{{ route('dashboard.profile.edit') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </a>
                @endif
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

        .avatar-md {
            width: 48px;
            height: 48px;
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
