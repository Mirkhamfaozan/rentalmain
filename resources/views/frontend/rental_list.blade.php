@extends('layouts.frontend')

@section('content')
    <!-- Rental Listing Section -->
    <section class="py-5 bg-light" id="daftar-rental">
        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center mb-5" data-aos="fade-up">
                <div class="col-lg-8 text-center">
                    <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-shop me-1"></i>Daftar Rental
                    </span>
                    <h2 class="display-5 fw-bold mb-3">Rental Motor Terbaik di Tegal</h2>
                    <p class="fs-5 text-muted">Pilih rental motor yang sesuai untuk petualangan Anda</p>
                </div>
            </div>

            <!-- Rental Cards Grid -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-rentals">
                    <div class="row g-4">
                        @forelse($rentals as $key => $rental)
                            <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up"
                                data-aos-delay="{{ ($key % 4) * 100 }}">
                                <div
                                    class="card h-100 border-0 shadow rounded-4 overflow-hidden position-relative hover-lift">
                                    <!-- Status Badge -->
                                    <div class="position-absolute top-0 end-0 m-3 z-3">
                                        <span
                                            class="badge bg-success rounded-pill px-3 py-2 shadow-sm pulse-animation">
                                            <i class="bi bi-check-circle me-1"></i>Aktif
                                        </span>
                                    </div>

                                    <!-- Rental Image -->
                                    <div class="ratio ratio-4x3 position-relative overflow-hidden">
                                        <img class="card-img-top object-fit-cover w-100 h-100 hover-zoom"
                                            src="{{ $rental->gambar_rental ? Storage::url($rental->gambar_rental) : '/images/rental-placeholder.jpg' }}"
                                            alt="{{ $rental->nama_rental }}">

                                        <!-- Image Overlay -->
                                        <div
                                            class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 opacity-0 d-flex align-items-center justify-content-center hover-reveal">
                                            <span class="text-white fw-bold">Lihat Detail</span>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-4">
                                        <!-- Rental Name -->
                                        <div class="text-center mb-3">
                                            <h5 class="card-title fw-bold mb-2 text-truncate">{{ $rental->nama_rental }}</h5>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="bi bi-geo-alt text-primary me-1"></i>
                                                <span class="text-muted small">{{ $rental->kota }}, {{ $rental->provinsi }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer bg-white border-0 p-4 pt-0">
                                        <div class="d-grid gap-2">
                                            <a class="btn btn-primary rounded-pill shadow-sm hover-scale"
                                                href="/rental-profile/{{ $rental->id }}">
                                                <i class="bi bi-motorcycle me-2"></i>Lihat Motor
                                            </a>
                                            <a class="btn btn-outline-primary rounded-pill hover-scale-sm"
                                                href="https://wa.me/{{ $rental->no_wa }}" target="_blank">
                                                <i class="bi bi-whatsapp me-1"></i>Kontak
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12" data-aos="fade-up">
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="bi bi-shop text-muted" style="font-size: 5rem;"></i>
                                    </div>
                                    <h4 class="text-muted mb-3">Belum Ada Rental Tersedia</h4>
                                    <p class="text-muted mb-4">Cek kembali nanti untuk rental terbaru!</p>
                                    <a href="{{ route('frontend.homepage') }}"
                                        class="btn btn-primary rounded-pill px-4 hover-scale">
                                        <i class="bi bi-house me-2"></i>Kembali ke Beranda
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- Pagination -->
                    @if($rentals->hasPages())
                        <div class="text-center mt-5">
                            {{ $rentals->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('frontend.homepage') }}"
                    class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill hover-scale">
                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <button class="btn btn-primary rounded-circle shadow-lg back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Styles -->
    <style>
        :root {
            --bs-primary-rgb: 13, 110, 253;
            --bs-success-rgb: 25, 135, 84;
            --animation-duration: 0.3s;
        }

        /* Card Hover Effects */
        .hover-lift {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }

        .hover-scale {
            transition: transform var(--animation-duration) ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
        }

        .hover-scale-sm {
            transition: transform var(--animation-duration) ease;
        }

        .hover-scale-sm:hover {
            transform: scale(1.02);
        }

        .hover-zoom {
            transition: transform calc(var(--animation-duration) * 1.5) ease;
        }

        .hover-zoom:hover {
            transform: scale(1.08);
        }

        .hover-reveal {
            transition: opacity var(--animation-duration) ease;
        }

        .card:hover .hover-reveal {
            opacity: 1 !important;
        }

        /* Pulse Animation for Badge */
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(var(--bs-success-rgb), 0.4); }
            70% { box-shadow: 0 0 0 8px rgba(var(--bs-success-rgb), 0); }
            100% { box-shadow: 0 0 0 0 rgba(var(--bs-success-rgb), 0); }
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            display: none;
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .back-to-top.show {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .display-5 {
                font-size: 1.8rem;
            }

            .card-body {
                padding: 1.25rem !important;
            }

            .card-footer {
                padding: 1.25rem !important;
                padding-top: 0 !important;
            }
        }

        /* Bootstrap Icon Enhancements */
        .bi {
            vertical-align: -0.125em;
        }
    </style>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true
            });

            // Back to Top Button
            const backToTopButton = document.getElementById('backToTop');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 400) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });

            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 60,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
@endsection
