@extends('layouts.frontend')

@section('content')
    <!-- Hero Section with Parallax and Gradient Overlay -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-3 fw-bold text-warning mb-3">{{ $rentalProfile->name_rental ?? 'Rental aProfile' }}</h1>
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
                        <img src="{{ $rentalProfile->profile_image ? Storage::url($rentalProfile->profile_image) : '/images/placeholder.jpg' }}"
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
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($products as $key => $product)
                            <div class="col" data-aos="fade-up" data-aos-delay="{{ ($key % 3) * 100 }}">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-grow">
                                    <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                                        class="card-img-top hover-zoom" alt="{{ $product->nama_motor }}"
                                        style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold mb-2 text-truncate">{{ $product->nama_motor }}</h5>
                                        <p class="text-primary fw-bold mb-2">Rp.
                                            {{ number_format($product->harga_harian, 0, ',', '.') }} / Hari</p>
                                        <p class="text-muted small mb-0">{{ $product->brand }}</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 text-center p-4">
                                        <a href="{{ route('frontend.detail', $product->id) }}"
                                            class="btn btn-outline-primary rounded-pill px-4 py-2 hover-scale-sm">
                                            <i class="bi bi-eye me-2"></i>Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-5 text-center" data-aos="fade-up" data-aos-delay="300">
                    <h4 class="text-muted">Belum ada motor tersedia dari penyedia ini.</h4>
                </div>
            @endif
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        /* Root Variables for Consistent Styling */
        :root {
            --primary: #0d6efd;
            --warning: #ffc107;
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

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .display-3 {
                font-size: 2.5rem;
            }

            .card-img-top {
                height: 150px;
            }
        }

        /* Bootstrap Icon Enhancements */
        .bi {
            vertical-align: -.125em;
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
        });
    </script>
@endsection
