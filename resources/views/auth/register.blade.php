@extends('layouts.frontend')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="card-title fw-bold text-dark mb-2">Buat Akun Anda</h2>
                            <p class="text-muted">Bergabunglah dengan komunitas rental kami hari ini</p>
                        </div>

                        <!-- Display validation errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Role Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="bi bi-person-badge me-2"></i>Daftar Sebagai
                                </label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="roleUser" value="users"
                                               {{ old('role', 'users') == 'users' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="roleUser">
                                            <i class="bi bi-person me-1"></i>Pengguna Biasa
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="roleRental" value="rental"
                                               {{ old('role') == 'rental' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="roleRental">
                                            <i class="bi bi-shop me-1"></i>Pemilik Rental
                                        </label>
                                    </div>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Basic Information Section -->
                            <div class="mb-4">
                                <h5 class="fw-semibold text-dark mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Dasar
                                </h5>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person me-2"></i>Nama Lengkap
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input type="text"
                                               class="form-control border-start-0 @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Masukkan nama lengkap Anda"
                                               required
                                               autofocus>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-envelope me-2"></i>Alamat Email
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email"
                                               class="form-control border-start-0 @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="Masukkan email Anda"
                                               required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="mb-4">
                                <h5 class="fw-semibold text-dark mb-3">
                                    <i class="bi bi-shield-lock me-2"></i>Keamanan Akun
                                </h5>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock me-2"></i>Kata Sandi
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Buat kata sandi yang kuat"
                                               required>
                                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock-fill me-2"></i>Konfirmasi Kata Sandi
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Konfirmasi kata sandi Anda"
                                               required>
                                        <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleConfirmPassword">
                                            <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Rental Information Section (Conditional) -->
                            <div id="rentalFields" style="display: {{ old('role') == 'rental' ? 'block' : 'none' }};">
                                <div class="mb-4">
                                    <h5 class="fw-semibold text-dark mb-3">
                                        <i class="bi bi-building me-2"></i>Informasi Bisnis Rental
                                    </h5>

                                    <!-- Rental Name -->
                                    <div class="mb-3">
                                        <label for="nama_rental" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-shop me-2"></i>Nama Bisnis Rental
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-shop text-muted"></i>
                                            </span>
                                            <input type="text"
                                                   class="form-control border-start-0 @error('nama_rental') is-invalid @enderror"
                                                   id="nama_rental"
                                                   name="nama_rental"
                                                   value="{{ old('nama_rental') }}"
                                                   placeholder="Nama bisnis rental Anda">
                                        </div>
                                        @error('nama_rental')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Owner Name -->
                                    <div class="mb-3">
                                        <label for="nama_pemilik" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-person-vcard me-2"></i>Nama Pemilik
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person-vcard text-muted"></i>
                                            </span>
                                            <input type="text"
                                                   class="form-control border-start-0 @error('nama_pemilik') is-invalid @enderror"
                                                   id="nama_pemilik"
                                                   name="nama_pemilik"
                                                   value="{{ old('nama_pemilik') }}"
                                                   placeholder="Nama lengkap pemilik">
                                        </div>
                                        @error('nama_pemilik')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-geo-alt me-2"></i>Alamat Bisnis
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-geo-alt text-muted"></i>
                                            </span>
                                            <input type="text"
                                                   class="form-control border-start-0 @error('alamat') is-invalid @enderror"
                                                   id="alamat"
                                                   name="alamat"
                                                   value="{{ old('alamat') }}"
                                                   placeholder="Alamat jalan">
                                        </div>
                                        @error('alamat')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- City -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kota" class="form-label fw-semibold text-dark">
                                                Kota
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('kota') is-invalid @enderror"
                                                   id="kota"
                                                   name="kota"
                                                   value="{{ old('kota') }}"
                                                   placeholder="Kota">
                                            @error('kota')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Province -->
                                        <div class="col-md-6 mb-3">
                                            <label for="provinsi" class="form-label fw-semibold text-dark">
                                                Provinsi
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('provinsi') is-invalid @enderror"
                                                   id="provinsi"
                                                   name="provinsi"
                                                   value="{{ old('provinsi') }}"
                                                   placeholder="Provinsi">
                                            @error('provinsi')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Postal Code -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kode_pos" class="form-label fw-semibold text-dark">
                                                Kode Pos
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('kode_pos') is-invalid @enderror"
                                                   id="kode_pos"
                                                   name="kode_pos"
                                                   value="{{ old('kode_pos') }}"
                                                   placeholder="Kode pos">
                                            @error('kode_pos')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="col-md-6 mb-3">
                                            <label for="no_telepon" class="form-label fw-semibold text-dark">
                                                <i class="bi bi-telephone me-2"></i>Nomor Telepon
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="bi bi-telephone text-muted"></i>
                                                </span>
                                                <input type="tel"
                                                       class="form-control border-start-0 @error('no_telepon') is-invalid @enderror"
                                                       id="no_telepon"
                                                       name="no_telepon"
                                                       value="{{ old('no_telepon') }}"
                                                       placeholder="Telepon bisnis">
                                            </div>
                                            @error('no_telepon')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- WhatsApp Number -->
                                    <div class="mb-3">
                                        <label for="no_wa" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-whatsapp me-2"></i>Nomor WhatsApp (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-whatsapp text-muted"></i>
                                            </span>
                                            <input type="tel"
                                                   class="form-control border-start-0 @error('no_wa') is-invalid @enderror"
                                                   id="no_wa"
                                                   name="no_wa"
                                                   value="{{ old('no_wa') }}"
                                                   placeholder="Nomor WhatsApp (jika berbeda)">
                                        </div>
                                        @error('no_wa')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Business Email -->
                                    <div class="mb-3">
                                        <label for="email_perusahaan" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-envelope-at me-2"></i>Email Bisnis (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope-at text-muted"></i>
                                            </span>
                                            <input type="email"
                                                   class="form-control border-start-0 @error('email_perusahaan') is-invalid @enderror"
                                                   id="email_perusahaan"
                                                   name="email_perusahaan"
                                                   value="{{ old('email_perusahaan') }}"
                                                   placeholder="Email bisnis (jika berbeda)">
                                        </div>
                                        @error('email_perusahaan')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label small text-muted" for="terms">
                                        Saya setuju dengan <a href="#" class="text-decoration-none">Syarat dan Ketentuan</a> dan <a href="#" class="text-decoration-none">Kebijakan Privasi</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="border-radius: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border: none; transition: all 0.3s ease;">
                                    <i class="bi bi-person-plus me-2"></i>Buat Akun
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">Sudah memiliki akun?
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Masuk di sini</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle role fields
    const roleRadios = document.querySelectorAll('input[name="role"]');
    const rentalFields = document.getElementById('rentalFields');

    roleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'rental') {
                rentalFields.style.display = 'block';
            } else {
                rentalFields.style.display = 'none';
            }
        });
    });

    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });

    // Toggle confirm password visibility
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('password_confirmation');
    const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        toggleConfirmIcon.classList.toggle('bi-eye');
        toggleConfirmIcon.classList.toggle('bi-eye-slash');
    });
});
</script>
