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
                                @if ($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle shadow-lg"
                                        alt="Avatar" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow-lg mx-auto"
                                        style="width: 150px; height: 150px;">
                                        <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <span
                                    class="position-absolute bottom-0 end-0 translate-middle badge rounded-pill
                                    @if ($user->role === 'admin') bg-danger
                                    @elseif($user->role === 'rental') bg-warning
                                    @else bg-success @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <h4 class="fw-bold text-primary mb-2">{{ $user->name }}</h4>
                            <p class="text-muted mb-3">{{ $user->email }}</p>

                            @if ($user->phone)
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

                    @if ($user->role === 'rental' && $rentalBiodata)
                        <!-- Rental Info Card -->
                        <div class="card shadow-sm border-0 rounded-4 mt-4" data-aos="fade-right" data-aos-delay="200">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-shop me-2"></i>Info Rental
                                </h5>

                                <!-- Verification Status Alert -->
                                @if ($rentalBiodata->isRejected())
                                    <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">Verifikasi Ditolak</h6>
                                                <p class="mb-0">Data rental Anda tidak memenuhi persyaratan verifikasi.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('profile.verification-note') }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-info-circle me-1"></i> Lihat Detail Penolakan
                                            </a>
                                        </div>
                                    </div>
                                @elseif($rentalBiodata->isPending())
                                    <div class="alert alert-warning border-0 rounded-3 shadow-sm mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hourglass-split me-3 fs-4"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">Menunggu Verifikasi</h6>
                                                <p class="mb-0">Data rental Anda sedang dalam proses verifikasi oleh
                                                    admin.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <strong>Status Verifikasi:</strong>
                                    <span class="badge bg-{{ $rentalBiodata->getStatusBadgeClass() }} ms-2">
                                        {{ $rentalBiodata->getStatusLabel() }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <strong>Nama Bisnis:</strong>
                                    <p class="text-muted mb-0">{{ $rentalBiodata->nama_rental }}</p>
                                </div>

                                <div class="mb-3">
                                    <strong>Alamat Bisnis:</strong>
                                    <p class="text-muted mb-0">{{ $rentalBiodata->alamat }}</p>
                                </div>

                                @if ($rentalBiodata->no_wa)
                                    <div class="mb-3">
                                        <strong>WhatsApp:</strong>
                                        <p class="text-muted mb-0">{{ $rentalBiodata->no_wa }}</p>
                                    </div>
                                @endif

                                @if ($rentalBiodata->isVerified())
                                    <div class="alert alert-success border-0 rounded-3 shadow-sm mt-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">Terverifikasi</h6>
                                                <p class="mb-0">Data rental Anda telah diverifikasi pada
                                                    {{ $rentalBiodata->tanggal_verifikasi->format('d F Y') }}
                                                </p>
                                            </div>
                                        </div>
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
                                    @if ($user->role === 'rental')
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

                                    @if ($orders->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered rounded-3 overflow-hidden">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th scope="col">ID Pesanan</th>
                                                        <th scope="col">Produk</th>
                                                        <th scope="col">Tanggal Mulai</th>
                                                        <th scope="col">Tanggal Selesai</th>
                                                        <th scope="col">Total Harga</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr class="hover-scale">
                                                            <td>{{ $order->id }}</td>
                                                            <td>{{ $order->product->nama_motor ?? 'N/A' }}</td>
                                                            <td>{{ $order->tanggal_mulai->format('d/m/Y') }}</td>
                                                            <td>{{ $order->tanggal_selesai->format('d/m/Y') }}</td>
                                                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : ($order->status === 'cancelled' ? 'danger' : 'info')) }}">
                                                                    {{ $order->getStatusLabelAttribute() }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-5">
                                            <i class="bi bi-bag-x display-1 text-muted mb-3"></i>
                                            <p>Belum ada pesanan. <a href="{{ route('frontend.product') }}"
                                                    class="text-primary">Mulai berbelanja</a></p>
                                        </div>
                                    @endif
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

                                    @if ($payments->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered rounded-3 overflow-hidden">
                                                <thead class="bg-primary text-white">
                                                    <tr>
                                                        <th scope="col">ID Pembayaran</th>
                                                        <th scope="col">Pesanan</th>
                                                        <th scope="col">Jumlah</th>
                                                        <th scope="col">Metode</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Waktu Transaksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payments as $payment)
                                                        <tr class="hover-scale">
                                                            <td>{{ $payment->id }}</td>
                                                            <td>{{ $payment->order->product->nama_motor ?? 'N/A' }}</td>
                                                            <td>Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</td>
                                                            <td>{{ $payment->payment_type ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'pending' ? 'warning' : ($payment->status === 'expired' || $payment->status === 'failed' ? 'danger' : 'info')) }}">
                                                                    {{ $payment->getStatusLabelAttribute() }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $payment->transaction_time ? $payment->transaction_time->format('d/m/Y H:i') : 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-5">
                                            <i class="bi bi-credit-card-2-front display-1 text-muted mb-3"></i>
                                            <p>Belum ada pembayaran</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Products Tab (Rental Only) -->
                        @if ($user->role === 'rental')
                            <div class="tab-pane fade" id="nav-products" role="tabpanel">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="fw-bold text-primary mb-0">
                                                <i class="bi bi-grid me-2"></i>Produk Saya
                                            </h5>
                                            <a href="{{ route('products.create') }}"
                                                class="btn btn-sm btn-gradient rounded-pill">
                                                <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                                            </a>
                                        </div>

                                        @if ($userProducts->isNotEmpty())
                                            <div class="row g-4">
                                                @foreach ($userProducts->take(6) as $product)
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="card border-0 shadow-sm rounded-3 hover-scale">
                                                            <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                                                                class="card-img-top"
                                                                style="height: 150px; object-fit: cover;"
                                                                alt="{{ $product->nama_motor }}">
                                                            <div class="card-body p-3">
                                                                <h6 class="fw-bold text-truncate mb-2">
                                                                    {{ $product->nama_motor }}</h6>
                                                                <p class="text-success fw-bold mb-2">
                                                                    Rp {{ number_format($product->harga_harian, 0, ',', '.') }}/hari
                                                                </p>
                                                                <div class="d-flex gap-2">
                                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                                        class="btn btn-sm btn-outline-primary rounded-pill">
                                                                        <i class="bi bi-pencil me-1"></i>Edit
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('products.destroy', $product->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Hapus produk ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger rounded-pill">
                                                                            <i class="bi bi-trash me-1"></i>Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if ($userProducts->count() > 6)
                                                <div class="text-center mt-4">
                                                    <a href="{{ route('profile.products') }}"
                                                        class="btn btn-outline-primary rounded-pill">
                                                        Lihat Semua Produk
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center text-muted py-5">
                                                <i class="bi bi-plus-circle display-1 text-muted mb-3"></i>
                                                <p>Belum ada produk. <a href="{{ route('products.create') }}"
                                                        class="text-primary">Tambah produk sekarang</a></p>
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
        :root {
            --primary: #0d6efd;
            --warning: #ffc107;
            --success: #28a745;
            --danger: #dc3545;
            --info: #17a2b8;
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
            box-shadow: 0 0.5rem 1rem rgba(0, 0,0,0.2);
            color: white;
        }

        /* Hover Effects */
        .hover-scale {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Alerts */
        .alert {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 4px solid var(--success);
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeeba);
            border-left: 4px solid var(--warning);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6);
            border-left: 4px solid var(--danger);
        }

        /* Card Animation */
        .card {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 2rem rgba(0,0, 0, 0.1);
        }

        /* Table Styles */
        .table {
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .table th, .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
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

        .nav-pills .nav-link:hover:not(.active):hover {
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

            .table th, .table td {
                font-size: 0.9rem;
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
                once: true
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);
        });
    </script>
@endsection
