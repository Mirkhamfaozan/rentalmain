@extends('layouts.frontend')

@section('content')
    <!-- Hero Section with Parallax and Gradient Overlay -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-3 fw-bold text-warning mb-3">{{ $rentalProfile->name_rental ?? 'Rental Profile' }}</h1>
                <p class="lead fs-4 text-white-75">Explore top-quality motorbike rentals for your next adventure!</p>
            </div>
        </div>
        <!-- Animated Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#profile" class="text-white text-decoration-none scroll-down">
                <i class="bi bi-chevron-double-down fs-3 animate__animated animate__bounce animate__infinite"></i>
            </a>
        </div>
    </header>

    <!-- Rental Profile Section -->
    <section class="py-5 bg-light" id="profile">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-5">
                <!-- Profile Image -->
                <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="card shadow-lg rounded-4 overflow-hidden">
                        <img src="{{ Storage::url($rentalProfile->foto_tempat) }}"
                            class="d-block w-100 rounded-top hover-zoom" alt="{{ $rentalProfile->business_name }}"
                            style="object-fit: cover; height: 300px;">
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <h2 class="card-title fw-bold mb-3 text-primary">
                                {{ $rentalProfile->nama_rental ?? 'Unknown Business' }}</h2>
                            <p class="mb-2"><strong>Pemilik:</strong> {{ $rentalProfile->user->name ?? 'Unknown' }}</p>
                            <p class="mb-2"><strong>Alamat:</strong> {{ $rentalProfile->alamat ?? 'Tidak tersedia' }}</p>
                            <p class="mb-2"><strong>Kontak:</strong> {{ $rentalProfile->no_wa ?? 'Tidak tersedia' }}</p>
                            <p class="mb-4"><strong>Email:</strong>
                                {{ $rentalProfile->email_perusahan ?? 'Tidak tersedia' }}</p>

                            <!-- Deskripsi -->
                            <hr>
                            <h5 class="fw-semibold mb-3 text-dark">Deskripsi Bisnis</h5>
                            <p class="text-muted lh-lg">{{ $rentalProfile->description ?? 'Tidak ada deskripsi tersedia.' }}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center p-4">
                            <a href="{{ route('frontend.contact', $rentalProfile->id) }}"
                                class="btn btn-gradient btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale fw-bold">
                                <i class="bi bi-envelope me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Products -->
            @if ($products->isNotEmpty())
                <div class="mt-5" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="fw-bold mb-4 text-center text-dark">Motor Tersedia</h3>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach ($products as $key => $product)
                            <div class="col" data-aos="fade-up" data-aos-delay="{{ ($key % 3) * 100 }}">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-grow">
                                    <!-- Motor Image -->
                                    <div class="position-relative">
                                        <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                                            class="card-img-top hover-zoom" alt="{{ $product->nama_motor }}"
                                            style="height: 220px; object-fit: cover;">
                                        <!-- Availability Badge -->
                                        <div class="position-absolute top-0 end-0 m-3">
                                            @if ($product->is_available)
                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    <i class="bi bi-check-circle me-1"></i>Tersedia
                                                </span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                                    <i class="bi bi-x-circle me-1"></i>Tidak Tersedia
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Motor Name & Brand -->
                                        <h5 class="card-title fw-bold mb-2 text-truncate">{{ $product->nama_motor }}</h5>
                                        <p class="text-muted small mb-3">
                                            <i class="bi bi-building me-1"></i>{{ $product->brand }} •
                                            <i class="bi bi-calendar me-1"></i>{{ $product->tahun_produksi }}
                                        </p>

                                        <!-- Pricing -->
                                        <div class="pricing-section mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-primary fw-bold fs-5">
                                                    Rp. {{ number_format($product->harga_harian, 0, ',', '.') }}
                                                </span>
                                                <small class="text-muted">/ Hari</small>
                                            </div>
                                        </div>

                                        <!-- Motor Specifications -->
                                        <div class="specifications mb-3">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="spec-item">
                                                        <i class="bi bi-gear text-primary me-1"></i>
                                                        <small
                                                            class="text-muted">{{ $product->transmisi_motor ?? 'Manual' }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="spec-item">
                                                        <i class="bi bi-speedometer text-warning me-1"></i>
                                                        <small
                                                            class="text-muted">{{ $product->cc_motor ?? '150' }}cc</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="spec-item">
                                                        <i class="bi bi-palette text-info me-1"></i>
                                                        <small class="text-muted">{{ $product->warna ?? 'Hitam' }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="spec-item">
                                                        <i class="bi bi-123 text-primary me-1"></i>
                                                        <small class="text-muted">No. Kend:
                                                            {{ $product->nomor_kendaraan ?? '-' }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="spec-item">
                                                        <i class="bi bi-tag text-success me-1"></i>
                                                        <small
                                                            class="text-muted">{{ $product->tipe_motor ?? 'Sport' }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Short Description -->
                                        @if ($product->deskripsi)
                                            <p class="text-muted small mb-3"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $product->deskripsi }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="card-footer bg-white border-top-0 text-center p-3">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('frontend.detail', $product->id) }}"
                                                class="btn btn-outline-primary rounded-pill px-4 py-2 hover-scale-sm">
                                                <i class="bi bi-eye me-2"></i>Detail
                                            </a>
                                            @if ($product->is_available)
                                                <button
                                                    class="btn btn-success rounded-pill px-4 py-2 hover-scale-sm fw-bold rent-btn"
                                                    data-product-id="{{ $product->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#locationVerificationModal">
                                                    <i class="bi bi-cart-plus me-2"></i>Sewa Sekarang
                                                </button>
                                            @else
                                                <button class="btn btn-secondary rounded-pill px-4 py-2" disabled>
                                                    <i class="bi bi-x-circle me-2"></i>Tidak Tersedia
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-5 text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="empty-state py-5">
                        <i class="bi bi-motorcycle display-1 text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada motor tersedia dari penyedia ini.</h4>
                        <p class="text-muted">Silakan cek kembali nanti atau hubungi penyedia untuk informasi lebih lanjut.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Location Verification Modal -->
    <div class="modal fade" id="locationVerificationModal" tabindex="-1"
        aria-labelledby="locationVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold text-primary" id="locationVerificationModalLabel">🎉 Selamat Datang di
                        Tegal!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="bi bi-scooter text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Nikmati perjalanan Anda dengan motor kami</h4>
                        <p class="text-muted mb-4">
                            Kami menyambut semua tamu yang ingin menjelajahi Tegal.<br>
                            Apakah Anda sedang berkunjung ke kota ini?
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-lg btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">
                        Tidak
                    </button>
                    <button type="button" id="confirmLocationBtn" class="btn btn-lg btn-primary rounded-pill px-4">
                        <i class="bi bi-scooter me-1"></i>Ya, Saya Ingin Sewa
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Root Variables for Consistent Styling */
        :root {
            --primary: #0d6efd;
            --warning: #ffc107;
            --success: #198754;
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
        }

        /* Success Button Enhancement */
        .btn-success {
            background: linear-gradient(135deg, var(--success), #20c997);
            border: none;
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #157347, #1a9d80);
            transform: scale(1.05);
            box-shadow: 0 0.25rem 0.75rem rgba(25, 135, 84, 0.3);
        }

        /* Hover Effects */
        .hover-scale {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .hover-scale-sm {
            transition: transform var(--animation-duration) ease;
        }

        .hover-scale-sm:hover {
            transform: scale(1.03);
        }

        .hover-zoom {
            transition: transform calc(var(--animation-duration) * 2) ease;
        }

        .hover-zoom:hover {
            transform: scale(1.1);
        }

        .hover-grow {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-grow:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        /* Pricing Section */
        .pricing-section {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
        }

        /* Specifications */
        .specifications {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .spec-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .spec-item:last-child {
            margin-bottom: 0;
        }

        /* Vehicle Info */
        .vehicle-info {
            padding: 10px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }

        /* Badge Enhancements */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            padding: 3rem 1rem;
        }

        /* Button Gap Enhancement */
        .d-flex.gap-2 {
            gap: 0.5rem !important;
        }

        /* Scroll Down Animation */
        .scroll-down {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }

        /* Modal Enhancements */
        .modal-content {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            border: none;
        }

        .modal-header.bg-light {
            background-color: #f8f9fa !important;
        }

        .modal-footer.bg-light {
            background-color: #f8f9fa !important;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .display-3 {
                font-size: 2.5rem;
            }

            .card-img-top {
                height: 180px;
            }

            /* Stack buttons vertically on mobile */
            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.25rem !important;
            }

            .btn {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
            }

            .pricing-section {
                padding: 10px;
            }

            .specifications {
                padding: 8px;
            }

            .spec-item {
                font-size: 0.8rem;
            }

            .modal-dialog {
                margin: 1rem;
            }
        }

        /* Bootstrap Icon Enhancements */
        .bi {
            vertical-align: -.125em;
        }

        /* Card improvements */
        .card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, .125);
        }

        .card:hover {
            border-color: rgba(13, 110, 253, 0.25);
        }

        /* Position relative for badges */
        .position-relative {
            position: relative;
        }
    </style>

    <!-- Custom Scripts -->
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: false
            });

            // Store selected product ID
            let selectedProductId = null;

            // Handle rent button clicks
            document.querySelectorAll('.rent-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Cek apakah tombol disabled
                    if (this.classList.contains('disabled') || this.hasAttribute('disabled')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                    selectedProductId = this.getAttribute('data-product-id');
                });
            });

            // Handle location confirmation
            document.getElementById('confirmLocationBtn').addEventListener('click', function() {
                if (selectedProductId) {
                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'locationVerificationModal'));
                    modal.hide();

                    // Redirect to order page
                    window.location.href = `/order/${selectedProductId}`;
                }
            });

            // Smooth Scroll for Anchor Links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add hover effects for specification items
            document.querySelectorAll('.spec-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                    this.style.transition = 'transform 0.2s ease';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
@endsection
