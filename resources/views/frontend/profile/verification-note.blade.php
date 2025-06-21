@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<header class="position-relative py-5 text-white overflow-hidden"
    style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="display-4 fw-bold text-warning mb-3">Verifikasi Ditolak</h1>
            <p class="lead fs-5 text-white-75">Silakan perbaiki data rental Anda sesuai catatan verifikasi</p>
        </div>
    </div>
</header>

<!-- Verification Note Content -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-5">
                            <i class="bi bi-x-circle-fill text-danger display-1"></i>
                            <h2 class="mt-3 text-danger fw-bold">Verifikasi Data Rental Ditolak</h2>
                            <p class="text-muted">Mohon perbaiki data berikut untuk melanjutkan proses verifikasi</p>
                        </div>

                        <!-- Rejection Note -->
                        <div class="alert alert-warning border-0 rounded-3 shadow-sm">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-warning"></i>
                                <div>
                                    <h5 class="alert-heading fw-bold mb-2">Catatan dari Admin</h5>
                                    <p class="mb-0">{{ $rentalBiodata->catatan_verifikasi ?? 'Tidak ada catatan spesifik' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Verification Checklist -->
                        <div class="card border-0 rounded-3 shadow-sm mt-4 verification-checklist">
                            <div class="card-header bg-transparent border-0 py-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-list-check me-2"></i>Dokumen yang Perlu Diperbaiki</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-person-badge me-2"></i>
                                            <span>Foto KTP Pemilik</span>
                                        </div>
                                        @if($rentalBiodata->foto_ktp)
                                            <span class="badge bg-success rounded-pill"><i class="bi bi-check-circle me-1"></i> Sudah Upload</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill"><i class="bi bi-x-circle me-1"></i> Belum Upload</span>
                                        @endif
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-file-earmark-text me-2"></i>
                                            <span>Surat Izin Usaha</span>
                                        </div>
                                        @if($rentalBiodata->foto_surat_izin_usaha)
                                            <span class="badge bg-success rounded-pill"><i class="bi bi-check-circle me-1"></i> Sudah Upload</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill"><i class="bi bi-x-circle me-1"></i> Belum Upload</span>
                                        @endif
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-shop me-2"></i>
                                            <span>Foto Tempat Usaha</span>
                                        </div>
                                        @if($rentalBiodata->foto_tempat)
                                            <span class="badge bg-success rounded-pill"><i class="bi bi-check-circle me-1"></i> Sudah Upload</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill"><i class="bi bi-x-circle me-1"></i> Belum Upload</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3 d-md-flex justify-content-md-center mt-5">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg px-4 rounded-pill">
                                <i class="bi bi-pencil-square me-2"></i> Perbaiki Data Sekarang
                            </a>
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .verification-checklist {
        border-left: 4px solid #ffc107;
        background-color: rgba(255, 193, 7, 0.05);
    }
    .verification-checklist .list-group-item {
        background-color: transparent;
        border-color: rgba(0, 0, 0, 0.05);
        padding: 1rem 1.25rem;
    }
    .verification-checklist .list-group-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endsection
