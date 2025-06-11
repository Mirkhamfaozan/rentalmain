@extends('layouts.app')
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
                            <h3 class="mb-1 fw-bold">Edit Profil Rental</h3>
                            <p class="mb-0 opacity-75">
                                <i class="fas fa-info-circle me-1"></i>Perbarui informasi biodata rental Anda dengan lengkap dan akurat
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <form action="{{ route('dashboard.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Informasi Dasar -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                        <h6 class="card-title text-primary fw-bold mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </h6>
                        <small class="text-muted">Lengkapi informasi dasar rental Anda</small>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-3">
                            <label for="nama_rental" class="form-label fw-semibold">
                                <i class="fas fa-store me-1 text-primary"></i>Nama Rental <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_rental" id="nama_rental"
                                   class="form-control form-control-lg @error('nama_rental') is-invalid @enderror"
                                   value="{{ old('nama_rental', $biodata->nama_rental) }}"
                                   placeholder="Masukkan nama rental"
                                   required>
                            @error('nama_rental')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_pemilik" class="form-label fw-semibold">
                                <i class="fas fa-user me-1 text-success"></i>Nama Pemilik <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_pemilik" id="nama_pemilik"
                                   class="form-control form-control-lg @error('nama_pemilik') is-invalid @enderror"
                                   value="{{ old('nama_pemilik', $biodata->nama_pemilik) }}"
                                   placeholder="Masukkan nama pemilik"
                                   required>
                            @error('nama_pemilik')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="email_perusahaan" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-info"></i>Email Perusahaan <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email_perusahaan" id="email_perusahaan"
                                   class="form-control form-control-lg @error('email_perusahaan') is-invalid @enderror"
                                   value="{{ old('email_perusahaan', $biodata->email_perusahaan) }}"
                                   placeholder="contoh@rental.com"
                                   required>
                            @error('email_perusahaan')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
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
                        <small class="text-muted">Tentukan lokasi rental Anda dengan jelas</small>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">
                                <i class="fas fa-home me-1 text-warning"></i>Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap rental"
                                      required>{{ old('alamat', $biodata->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="kota" class="form-label fw-semibold">
                                        <i class="fas fa-city me-1 text-secondary"></i>Kota <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="kota" id="kota"
                                           class="form-control @error('kota') is-invalid @enderror"
                                           value="{{ old('kota', $biodata->kota) }}"
                                           placeholder="Nama kota"
                                           required>
                                    @error('kota')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label fw-semibold">
                                        <i class="fas fa-map me-1 text-dark"></i>Provinsi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="provinsi" id="provinsi"
                                           class="form-control @error('provinsi') is-invalid @enderror"
                                           value="{{ old('provinsi', $biodata->provinsi) }}"
                                           placeholder="Nama provinsi"
                                           required>
                                    @error('provinsi')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="kode_pos" class="form-label fw-semibold">
                                <i class="fas fa-mail-bulk me-1 text-danger"></i>Kode Pos <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="kode_pos" id="kode_pos"
                                   class="form-control @error('kode_pos') is-invalid @enderror"
                                   value="{{ old('kode_pos', $biodata->kode_pos) }}"
                                   placeholder="12345"
                                   required>
                            @error('kode_pos')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0">
                        <h6 class="card-title text-success fw-bold mb-0">
                            <i class="fas fa-phone me-2"></i>Informasi Kontak
                        </h6>
                        <small class="text-muted">Nomor kontak yang bisa dihubungi pelanggan</small>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-1 text-primary"></i>Nomor Telepon <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="number" name="no_telepon" id="no_telepon"
                                               class="form-control @error('no_telepon') is-invalid @enderror"
                                               value="{{ old('no_telepon', $biodata->no_telepon) }}"
                                               placeholder="08xxxxxxxxxx"
                                               required>
                                        @error('no_telepon')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_wa" class="form-label fw-semibold">
                                        <i class="fab fa-whatsapp me-1 text-success"></i>Nomor WhatsApp <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white">
                                            <i class="fab fa-whatsapp"></i>
                                        </span>
                                        <input type="number" name="no_wa" id="no_wa"
                                               class="form-control @error('no_wa') is-invalid @enderror"
                                               value="{{ old('no_wa', $biodata->no_wa) }}"
                                               placeholder="08xxxxxxxxxx"
                                               required>
                                        @error('no_wa')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
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
                                <a href="{{ route('dashboard.profile.show') }}" class="btn btn-outline-secondary btn-lg">
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

        .input-group-text {
            border-right: 0;
        }

        .input-group .form-control {
            border-left: 0;
        }

        .input-group .form-control:focus {
            border-left: 0;
            box-shadow: none;
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
