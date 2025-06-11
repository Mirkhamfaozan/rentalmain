@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-4 fw-bold text-warning mb-3">Ganti Password</h1>
                <p class="lead fs-5 text-white-75">Perbarui kata sandi akun Anda untuk keamanan</p>
            </div>
        </div>
    </header>

    <!-- Change Password Content -->
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
                <!-- Change Password Form -->
                <div class="col-lg-6 offset-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="bi bi-shield-lock me-2"></i>Ubah Kata Sandi
                            </h5>

                            <form action="{{ route('profile.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="current_password" class="form-label fw-semibold text-muted">Kata Sandi Saat Ini</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" id="current_password" class="form-control rounded-3 rounded-end-0"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary rounded-start-0 toggle-password"
                                                data-target="current_password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold text-muted">Kata Sandi Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control rounded-3 rounded-end-0"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary rounded-start-0 toggle-password"
                                                data-target="password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold text-muted">Konfirmasi Kata Sandi Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-3 rounded-end-0"
                                               required>
                                        <button type="button" class="btn btn-outline-secondary rounded-start-0 toggle-password"
                                                data-target="password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex gap-3">
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

        .toggle-password {
            cursor: pointer;
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

            // Toggle password visibility
            const toggleButtons = document.querySelectorAll('.toggle-password');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });
        });
    </script>
@endsection
