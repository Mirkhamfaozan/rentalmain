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
                            <h2 class="card-title fw-bold text-dark mb-2">Create Your Account</h2>
                            <p class="text-muted">Join our rental community today</p>
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
                                    <i class="bi bi-person-badge me-2"></i>Register As
                                </label>
                                <div class="d-flex gap-4 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="roleUser" value="users"
                                               {{ old('role', 'users') == 'users' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="roleUser">
                                            <i class="bi bi-person me-1"></i>Regular User
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="roleRental" value="rental"
                                               {{ old('role') == 'rental' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-medium" for="roleRental">
                                            <i class="bi bi-shop me-1"></i>Rental Owner
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
                                    <i class="bi bi-info-circle me-2"></i>Basic Information
                                </h5>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person me-2"></i>Full Name
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
                                               placeholder="Enter your full name"
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
                                        <i class="bi bi-envelope me-2"></i>Email Address
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
                                               placeholder="Enter your email"
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
                                    <i class="bi bi-shield-lock me-2"></i>Account Security
                                </h5>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Create a strong password"
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
                                        <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Confirm your password"
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
                                        <i class="bi bi-building me-2"></i>Rental Business Information
                                    </h5>

                                    <!-- Rental Name -->
                                    <div class="mb-3">
                                        <label for="nama_rental" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-shop me-2"></i>Rental Business Name
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
                                                   placeholder="Your rental business name">
                                        </div>
                                        @error('nama_rental')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Owner Name -->
                                    <div class="mb-3">
                                        <label for="nama_pemilik" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-person-vcard me-2"></i>Owner's Name
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
                                                   placeholder="Owner's full name">
                                        </div>
                                        @error('nama_pemilik')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-geo-alt me-2"></i>Business Address
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
                                                   placeholder="Street address">
                                        </div>
                                        @error('alamat')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- City -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kota" class="form-label fw-semibold text-dark">
                                                City
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('kota') is-invalid @enderror"
                                                   id="kota"
                                                   name="kota"
                                                   value="{{ old('kota') }}"
                                                   placeholder="City">
                                            @error('kota')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Province -->
                                        <div class="col-md-6 mb-3">
                                            <label for="provinsi" class="form-label fw-semibold text-dark">
                                                Province
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('provinsi') is-invalid @enderror"
                                                   id="provinsi"
                                                   name="provinsi"
                                                   value="{{ old('provinsi') }}"
                                                   placeholder="Province">
                                            @error('provinsi')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Postal Code -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kode_pos" class="form-label fw-semibold text-dark">
                                                Postal Code
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('kode_pos') is-invalid @enderror"
                                                   id="kode_pos"
                                                   name="kode_pos"
                                                   value="{{ old('kode_pos') }}"
                                                   placeholder="Postal code">
                                            @error('kode_pos')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="col-md-6 mb-3">
                                            <label for="no_telepon" class="form-label fw-semibold text-dark">
                                                <i class="bi bi-telephone me-2"></i>Phone Number
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
                                                       placeholder="Business phone">
                                            </div>
                                            @error('no_telepon')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- WhatsApp Number -->
                                    <div class="mb-3">
                                        <label for="no_wa" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-whatsapp me-2"></i>WhatsApp Number (Optional)
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
                                                   placeholder="WhatsApp number (if different)">
                                        </div>
                                        @error('no_wa')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Business Email -->
                                    <div class="mb-3">
                                        <label for="email_perusahaan" class="form-label fw-semibold text-dark">
                                            <i class="bi bi-envelope-at me-2"></i>Business Email (Optional)
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
                                                   placeholder="Business email (if different)">
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
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="border-radius: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border: none; transition: all 0.3s ease;">
                                    <i class="bi bi-person-plus me-2"></i>Create Account
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">Already have an account?
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign in here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPassword = document.getElementById('password_confirmation');
    const icon = document.getElementById('toggleConfirmIcon');

    if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        confirmPassword.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

// Toggle rental fields based on role selection
const roleUser = document.getElementById('roleUser');
const roleRental = document.getElementById('roleRental');
const rentalFields = document.getElementById('rentalFields');

function toggleRentalFields() {
    if (roleRental.checked) {
        rentalFields.style.display = 'block';
        // Make rental fields required
        document.querySelectorAll('#rentalFields input').forEach(input => {
            if (input.name !== 'no_wa' && input.name !== 'email_perusahaan') {
                input.required = true;
            }
        });
    } else {
        rentalFields.style.display = 'none';
        // Remove required from rental fields
        document.querySelectorAll('#rentalFields input').forEach(input => {
            input.required = false;
        });
    }
}

roleUser.addEventListener('change', toggleRentalFields);
roleRental.addEventListener('change', toggleRentalFields);

// Add hover effects to submit button
document.querySelector('.btn-primary').addEventListener('mouseover', function() {
    this.style.transform = 'translateY(-2px)';
    this.style.boxShadow = '0 8px 25px rgba(102, 126, 234, 0.4)';
});

document.querySelector('.btn-primary').addEventListener('mouseout', function() {
    this.style.transform = 'translateY(0)';
    this.style.boxShadow = 'none';
});

// Initialize fields based on old input (if form was submitted with errors)
document.addEventListener('DOMContentLoaded', function() {
    toggleRentalFields();
});
</script>
@endsection
