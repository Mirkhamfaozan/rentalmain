@extends('layouts.app')

@section('title', 'Edit Profil Akun')

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

    <!-- Edit Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar-lg rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center">
                                <i class="fas fa-edit fs-2"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h3 class="mb-1 fw-bold">Edit Profil Akun</h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-info-circle me-1"></i>Perbarui informasi akun Anda dengan lengkap dan akurat
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <form action="{{ route('dashboard.account.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Informasi Akun -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                        <h6 class="card-title text-primary fw-bold mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informasi Akun
                        </h6>
                        <small class="text-muted">Lengkapi informasi akun Anda</small>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-1 text-primary"></i>Nama <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Masukkan nama Anda"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-success"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="contoh@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pastikan semua informasi yang Anda masukkan sudah benar sebelum menyimpan.
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dashboard.account.show') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .avatar-lg {
            width: 80px;
            height: 80px;
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
        }

        .card {
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.15) !important;
        }

        .bg-opacity-20 {
            --bs-bg-opacity: 0.2;
        }

        .invalid-feedback {
            display: block;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }
    </style>
@endsection
