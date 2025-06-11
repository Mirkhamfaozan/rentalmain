@extends('layouts.frontend')

@section('content')
    <!-- Motor Listing Section -->
    <section class="py-5 bg-white" id="daftar-motor">
        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center mb-5" data-aos="fade-up">
                <div class="col-lg-8 text-center">
                    <span class="badge bg-warning-subtle text-warning fs-6 px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-collection me-1"></i>Koleksi Motor
                    </span>
                    <h2 class="display-5 fw-bold mb-3">Pilihan Motor Terbaik</h2>
                    <p class="fs-5 text-muted">Temukan motor yang sesuai dengan kebutuhan perjalanan Anda</p>
                </div>
            </div>

            <!-- Motor Cards Grid -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-motors">
                    <div class="row g-4">
                        @forelse($products as $key => $product)
                            <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up"
                                data-aos-delay="{{ ($key % 4) * 100 }}">
                                <div
                                    class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-grow">
                                    <!-- Status Badge -->
                                    <div class="position-absolute top-0 end-0 m-3 z-3">
                                        <span
                                            class="badge {{ $product->is_available ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2 shadow-sm pulse-animation">
                                            <i
                                                class="bi {{ $product->is_available ? 'bi-check-circle' : 'bi-clock' }} me-1"></i>
                                            {{ $product->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </div>

                                    <!-- Motor Image -->
                                    <div class="ratio ratio-4x3 position-relative overflow-hidden">
                                        <img class="card-img-top object-fit-cover w-100 h-100 hover-zoom"
                                            src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                                            alt="{{ $product->nama_motor }}">

                                        <!-- Image Overlay -->
                                        <div
                                            class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 opacity-0 d-flex align-items-center justify-content-center hover-reveal">
                                            <a href="{{ route('frontend.detail', $product->id) }}"
                                                class="btn btn-light rounded-pill px-4 hover-scale-sm">
                                                <i class="bi bi-eye me-2"></i>Lihat Detail
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-4">
                                        <!-- Motor Name & Price -->
                                        <div class="text-center mb-3">
                                            <h5 class="card-title fw-bold mb-2 text-truncate">{{ $product->nama_motor }}
                                            </h5>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="h4 text-primary fw-bold mb-0">Rp
                                                    {{ number_format($product->harga_harian, 0, ',', '.') }}</span>
                                                <span class="text-muted ms-1">/hari</span>
                                            </div>
                                        </div>

                                        <!-- Motor Specs -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <div class="text-center p-2 bg-light rounded-3 border hover-scale-sm">
                                                    <i class="bi bi-speedometer2 text-primary d-block mb-1"></i>
                                                    <div class="fw-bold small">{{ $product->cc_motor }}</div>
                                                    <small class="text-muted">CC</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center p-2 bg-light rounded-3 border hover-scale-sm">
                                                    <i class="bi bi-gear text-primary d-block mb-1"></i>
                                                    <div class="fw-bold small">{{ $product->transmisi_motor }}</div>
                                                    <small class="text-muted">Transmisi</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center p-2 bg-light rounded-3 border hover-scale-sm">
                                                    <i class="bi bi-calendar text-primary d-block mb-1"></i>
                                                    <div class="fw-bold small">{{ $product->tahun_produksi }}</div>
                                                    <small class="text-muted">Tahun</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer bg-white border-0 p-4 pt-0">
                                        @if ($product->is_available)
                                            <div class="d-grid gap-2">
                                                <a class="btn btn-primary btn-lg rounded-pill shadow-sm hover-scale"
                                                    href="{{ route('frontend.order', $product->id) }}">
                                                    <i class="bi bi-motorcycle me-2"></i>Sewa Sekarang
                                                </a>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-outline-primary rounded-pill hover-scale-sm"
                                                        href="{{ route('frontend.detail', $product->id) }}">
                                                        <i class="bi bi-info-circle me-1"></i>Detail
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-secondary btn-lg rounded-pill hover-scale" disabled>
                                                    <i class="bi bi-clock me-2"></i>Tidak Tersedia
                                                </button>
                                                <a class="btn btn-outline-primary rounded-pill hover-scale-sm"
                                                    href="{{ route('frontend.detail', $product->id) }}">
                                                    <i class="bi bi-info-circle me-2"></i>Lihat Detail
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12" data-aos="fade-up">
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="bi bi-motorcycle text-muted" style="font-size: 5rem;"></i>
                                    </div>
                                    <h4 class="text-muted mb-3">Belum ada motor tersedia</h4>
                                    <p class="text-muted mb-4">Silakan kembali lagi nanti untuk melihat koleksi motor
                                        terbaru kami.</p>
                                    <a href="#" class="btn btn-primary rounded-pill px-4 hover-scale">
                                        <i class="bi bi-bell me-2"></i>Beritahu Saya
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('frontend.homepage') }}"
                    class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill hover-scale">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Lihat Semua Motor
                </a>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <button class="btn btn-primary btn-lg rounded-circle shadow-lg back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Styles -->
    <style>
        :root {
            --bs-primary-rgb: 13, 110, 253;
            --bs-warning-rgb: 255, 193, 7;
            --bs-success-rgb: 25, 135, 84;
            --animation-duration: 0.3s;
        }

        /* Hover Effects */
        .hover-scale {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
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

        .hover-reveal {
            transition: opacity var(--animation-duration) ease;
        }

        .card:hover .hover-reveal {
            opacity: 1 !important;
        }

        .hover-grow {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-grow:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }

        /* Animation Classes */
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(25, 135, 84, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0);
            }
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
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
                font-size: 2rem;
            }
        }

        /* Bootstrap Icon Enhancements */
        .bi {
            vertical-align: -.125em;
        }
    </style>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: false
            });

            // Back to Top Button
            const backToTopButton = document.getElementById('backToTop');
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
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
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
@endsection
