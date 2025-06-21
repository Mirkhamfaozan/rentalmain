@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-4 fw-bold text-warning mb-3">Edit Profil</h1>
                <p class="lead fs-5 text-white-75">Perbarui informasi akun dan preferensi Anda</p>
            </div>
        </div>
    </header>

    <!-- Edit Profile Content -->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5">
            <!-- Success/Error Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert"
                    data-aos="fade-down">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert"
                    data-aos="fade-down">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row gx-5">
                <!-- Profile Edit Form -->
                <div class="col-lg-8 offset-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="bi bi-pencil-square me-2"></i>Edit Informasi Profil
                            </h5>

                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Personal Information -->
                                <div class="row g-4">
                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold text-muted">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" class="form-control rounded-3"
                                               value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold text-muted">Email</label>
                                        <input type="email" name="email" id="email" class="form-control rounded-3"
                                               value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    <!-- Avatar -->
                                    <div class="col-12">
                                        <label for="avatar" class="form-label fw-semibold text-muted">Foto Profil</label>
                                        <input type="file" name="avatar" id="avatar" class="form-control rounded-3">
                                        @if($user->avatar)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar" class="rounded-circle" width="100" height="100">
                                                <a href="{{ route('profile.delete-avatar') }}" class="btn btn-sm btn-outline-danger ms-2" onclick="return confirm('Yakin ingin menghapus foto profil?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Rental Information (if applicable) -->
                                @if($user->role === 'rental')
                                    <hr class="my-4">
                                    <h5 class="fw-bold text-primary mb-4">
                                        <i class="bi bi-shop me-2"></i>Informasi Rental
                                    </h5>
                                    <div class="row g-4">
                                        <!-- Business Name -->
                                        <div class="col-md-6">
                                            <label for="nama_rental" class="form-label fw-semibold text-muted">Nama Bisnis Rental</label>
                                            <input type="text" name="nama_rental" id="nama_rental" class="form-control rounded-3"
                                                   value="{{ old('nama_rental', $rentalBiodata->nama_rental ?? '') }}" required>
                                        </div>
                                        <!-- Owner Name -->
                                        <div class="col-md-6">
                                            <label for="nama_pemilik" class="form-label fw-semibold text-muted">Nama Pemilik</label>
                                            <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control rounded-3"
                                                   value="{{ old('nama_pemilik', $rentalBiodata->nama_pemilik ?? '') }}" required>
                                        </div>
                                        <!-- Business Address -->
                                        <div class="col-12">
                                            <label for="alamat" class="form-label fw-semibold text-muted">Alamat Lengkap</label>
                                            <textarea name="alamat" id="alamat" class="form-control rounded-3" rows="3" required>{{ old('alamat', $rentalBiodata->alamat ?? '') }}</textarea>
                                        </div>
                                        <!-- City -->
                                        <div class="col-md-4">
                                            <label for="kota" class="form-label fw-semibold text-muted">Kota</label>
                                            <input type="text" name="kota" id="kota" class="form-control rounded-3"
                                                   value="{{ old('kota', $rentalBiodata->kota ?? '') }}" required>
                                        </div>
                                        <!-- Province -->
                                        <div class="col-md-4">
                                            <label for="provinsi" class="form-label fw-semibold text-muted">Provinsi</label>
                                            <input type="text" name="provinsi" id="provinsi" class="form-control rounded-3"
                                                   value="{{ old('provinsi', $rentalBiodata->provinsi ?? '') }}" required>
                                        </div>
                                        <!-- Postal Code -->
                                        <div class="col-md-4">
                                            <label for="kode_pos" class="form-label fw-semibold text-muted">Kode Pos</label>
                                            <input type="text" name="kode_pos" id="kode_pos" class="form-control rounded-3"
                                                   value="{{ old('kode_pos', $rentalBiodata->kode_pos ?? '') }}">
                                        </div>
                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <label for="no_telepon" class="form-label fw-semibold text-muted">Nomor Telepon</label>
                                            <input type="text" name="no_telepon" id="no_telepon" class="form-control rounded-3"
                                                   value="{{ old('no_telepon', $rentalBiodata->no_telepon ?? '') }}" required>
                                        </div>
                                        <!-- WhatsApp -->
                                        <div class="col-md-6">
                                            <label for="no_wa" class="form-label fw-semibold text-muted">WhatsApp</label>
                                            <input type="text" name="no_wa" id="no_wa" class="form-control rounded-3"
                                                   value="{{ old('no_wa', $rentalBiodata->no_wa ?? '') }}" required>
                                        </div>
                                        <!-- Company Email -->
                                        <div class="col-md-6">
                                            <label for="email_perusahaan" class="form-label fw-semibold text-muted">Email Perusahaan</label>
                                            <input type="email" name="email_perusahaan" id="email_perusahaan" class="form-control rounded-3"
                                                   value="{{ old('email_perusahaan', $rentalBiodata->email_perusahaan ?? '') }}">
                                        </div>
                                        <!-- KTP Photo -->
                                        <div class="col-md-6">
                                            <label for="foto_ktp" class="form-label fw-semibold text-muted">Foto KTP</label>
                                            <input type="file" name="foto_ktp" id="foto_ktp" class="form-control rounded-3">
                                            @if($rentalBiodata && $rentalBiodata->foto_ktp)
                                                <div class="mt-2">
                                                    <a href="{{ $rentalBiodata->getKtpPhotoUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Lihat KTP
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Business License -->
                                        <div class="col-md-6">
                                            <label for="foto_surat_izin_usaha" class="form-label fw-semibold text-muted">Surat Izin Usaha</label>
                                            <input type="file" name="foto_surat_izin_usaha" id="foto_surat_izin_usaha" class="form-control rounded-3">
                                            @if($rentalBiodata && $rentalBiodata->foto_surat_izin_usaha)
                                                <div class="mt-2">
                                                    <a href="{{ $rentalBiodata->getBusinessLicenseUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Lihat Izin Usaha
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Business Place Photo -->
                                        <div class="col-md-6">
                                            <label for="foto_tempat" class="form-label fw-semibold text-muted">Foto Tempat Usaha</label>
                                            <input type="file" name="foto_tempat" id="foto_tempat" class="form-control rounded-3">
                                            @if($rentalBiodata && $rentalBiodata->foto_tempat)
                                                <div class="mt-2">
                                                    <a href="{{ $rentalBiodata->getBusinessPlaceUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Lihat Tempat Usaha
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Form Actions -->
                                <div class="d-flex gap-3 mt-4">
                                    <button type="submit" class="btn btn-gradient rounded-pill px-4">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                    </button>
                                    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                        <i class="bi bi-x-circle me-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #0d6efd;
            --warning: #ffc107;
            --success: #28a745;
            --animation-duration: 0.3s;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), #4dabf7);
            color: white;
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .btn-gradient:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            color: white;
        }

        .card {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 5px solid #dc3545;
        }

        .form-control {
            transition: border-color var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: false
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Preview avatar image
            const avatarInput = document.getElementById('avatar');
            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.classList.add('rounded-circle', 'shadow-sm', 'mt-2');
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            const currentImg = avatarInput.nextElementSibling?.querySelector('img');
                            if (currentImg) {
                                currentImg.replaceWith(img);
                            } else {
                                avatarInput.nextElementSibling?.prepend(img);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection
