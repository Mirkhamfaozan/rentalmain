@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-4 fw-bold text-warning mb-3">Profil Saya</h1>
                <p class="lead fs-5 text-white-75">Kelola informasi akun dan preferensi Anda</p>
            </div>
        </div>
    </header>

    <!-- Profile Content -->
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

            <div class="row gx-5">
                <!-- Profile Card -->
                <div class="col-lg-4 mb-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="card-body text-center p-4">
                            <!-- Avatar -->
                            <div class="position-relative mb-4">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}"
                                         class="rounded-circle shadow-lg"
                                         alt="Avatar"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow-lg mx-auto"
                                         style="width: 150px; height: 150px;">
                                        <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <span class="position-absolute bottom-0 end-0 translate-middle badge rounded-pill
                                    @if($user->role === 'admin') bg-danger
                                    @elseif($user->role === 'rental') bg-warning
                                    @else bg-success @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <h4 class="fw-bold text-primary mb-2">{{ $user->name }}</h4>
                            <p class="text-muted mb-3">{{ $user->email }}</p>

                            @if($user->phone)
                                <p class="text-muted mb-3">
                                    <i class="bi bi-telephone-fill me-2"></i>{{ $user->phone }}
                                </p>
                            @endif

                            <!-- Quick Actions -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('profile.edit') }}" class="btn btn-gradient rounded-pill">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                                </a>
                                <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-shield-lock me-2"></i>Ganti Password
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'rental' && $rentalBiodata)
                        <!-- Rental Info Card -->
                        <div class="card shadow-sm border-0 rounded-4 mt-4" data-aos="fade-right" data-aos-delay="200">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-shop me-2"></i>Info Rental
                                </h5>
                                <div class="mb-3">
                                    <strong>Nama Bisnis:</strong>
                                    <p class="text-muted mb-0">{{ $rentalBiodata->nama_rental }}</p>
                                </div>
                                <div class="mb-3">
                                    <strong>Alamat Bisnis:</strong>
                                    <p class="text-muted mb-0">{{ $rentalBiodata->alamat }}</p>
                                </div>
                                @if($rentalBiodata->no_wa)
                                    <div class="mb-3">
                                        <strong>WhatsApp:</strong>
                                        <p class="text-muted mb-0">{{ $rentalBiodata->no_wa }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Profile Details & Navigation -->
                <div class="col-lg-8" data-aos="fade-left" data-aos-delay="100">
                    <!-- Navigation Tabs -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <nav>
                                <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                                    <button class="nav-link active rounded-pill" id="nav-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-info" type="button" role="tab">
                                        <i class="bi bi-person-lines-fill me-2"></i>Info Personal
                                    </button>
                                    <button class="nav-link rounded-pill" id="nav-orders-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-orders" type="button" role="tab">
                                        <i class="bi bi-bag-check me-2"></i>Pesanan
                                    </button>
                                    <button class="nav-link rounded-pill" id="nav-payments-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-payments" type="button" role="tab">
                                        <i class="bi bi-credit-card me-2"></i>Pembayaran
                                    </button>
                                    @if($user->role === 'rental')
                                        <button class="nav-link rounded-pill" id="nav-products-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-products" type="button" role="tab">
                                            <i class="bi bi-grid me-2"></i>Produk
                                        </button>
                                    @endif
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="nav-info" role="tabpanel">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold text-primary mb-4">
                                        <i class="bi bi-person-lines-fill me-2"></i>Informasi Personal
                                    </h5>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="bg-light rounded-3 p-3">
                                                <strong class="text-muted d-block mb-1">Nama Lengkap</strong>
                                                <span class="fw-semibold">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light rounded-3 p-3">
                                                <strong class="text-muted d-block mb-1">Email</strong>
                                                <span class="fw-semibold">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="bg-light rounded-3 p-3">
                                                <strong class="text-muted d-block mb-1">Bergabung Sejak</strong>
                                                <span class="fw-semibold">{{ $user->created_at->format('d F Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="nav-orders" role="tabpanel">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="fw-bold text-primary mb-0">
                                            <i class="bi bi-bag-check me-2"></i>Pesanan Saya
                                        </h5>

                                    </div>
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-bag-x display-1 text-muted mb-3"></i>
                                        <p>Belum ada pesanan. <a href="{{ route('frontend.product') }}" class="text-primary">Mulai berbelanja</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payments Tab -->
                        <div class="tab-pane fade" id="nav-payments" role="tabpanel">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="fw-bold text-primary mb-0">
                                            <i class="bi bi-credit-card me-2"></i>Riwayat Pembayaran
                                        </h5>

                                    </div>
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-credit-card-2-front display-1 text-muted mb-3"></i>
                                        <p>Belum ada pembayaran</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Tab (Rental Only) -->
                        @if($user->role === 'rental')
                            <div class="tab-pane fade" id="nav-products" role="tabpanel">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="fw-bold text-primary mb-0">
                                                <i class="bi bi-grid me-2"></i>Produk Saya
                                            </h5>
                                        </div>

                                        @if($userProducts->count() > 0)
                                            <div class="row g-3">
                                                @foreach($userProducts->take(3) as $product)
                                                    <div class="col-md-4">
                                                        <div class="card border-0 shadow-sm rounded-3 hover-scale">
                                                            <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                                                                 class="card-img-top"
                                                                 style="height: 150px; object-fit: cover;"
                                                                 alt="{{ $product->nama_motor }}">
                                                            <div class="card-body p-3">
                                                                <h6 class="fw-bold text-truncate mb-2">{{ $product->nama_motor }}</h6>
                                                                <p class="text-success fw-bold mb-0">
                                                                    Rp {{ number_format($product->harga_harian, 0, ',', '.') }}/hari
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center text-muted py-5">
                                                <i class="bi bi-plus-circle display-1 text-muted mb-3"></i>
                                                <p>Belum ada produk. Mulai tambahkan produk Anda</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        /* Root Variables */
        :root {
            --primary: #0d6efd;
            --warning: #ffc107;
            --success: #28a745;
            --animation-duration: 0.3s;
        }

        /* Gradient Button */
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

        /* Hover Effects */
        .hover-scale {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Alerts */
        .alert {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid var(--success);
        }

        /* Card Animation */
        .card {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.1);
        }

        /* Nav Pills Custom */
        .nav-pills .nav-link {
            color: #6c757d;
            font-weight: 500;
            transition: all var(--animation-duration) ease;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--primary), #4dabf7);
            color: white;
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--primary);
        }

        /* Tab Content Animation */
        .tab-pane {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }

            .nav-pills .nav-link {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
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
        });
    </script>
@endsection
