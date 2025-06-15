@extends('layouts.frontend')

@section('content')
    <!-- Hero Section with Parallax Effect -->
    <header class="position-relative vh-100 overflow-hidden">
        <div class="hero-parallax" style="background: url('/images/bg.jpg') center/cover no-repeat fixed;"></div>
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>

        <div class="container h-100 d-flex align-items-center">
            <div class="row w-100 justify-content-center text-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="animate__animated animate__fadeInUp" data-aos="fade-up" data-aos-duration="1000">
                        <h1 class="display-2 fw-bold text-white mb-4">
                            <span class="text-warning typed-text"></span>
                        </h1>
                        <p class="lead fs-4 text-white mb-5 animate__animated animate__fadeIn animate__delay-1-5s">
                            Pengalaman berkendara terbaik hanya dengan satu sentuhan
                        </p>
                        <div
                            class="d-flex flex-column flex-sm-row gap-3 justify-content-center animate__animated animate__fadeIn animate__delay-2s">
                            <a href="#daftar-motor"
                                class="btn btn-warning btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale">
                                <i class="bi bi-motorcycle me-2"></i>Lihat Motor
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill hover-scale">
                                <i class="bi bi-telephone me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animated Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#about" class="text-white text-decoration-none scroll-down">
                <i class="bi bi-chevron-double-down fs-2 animate__animated animate__bounce animate__infinite"></i>
            </a>
        </div>
    </header>

    <!-- About Section with Advanced Animations -->
    <section class="py-5 bg-light" id="about">
        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center mb-5" data-aos="fade-up">
                <div class="col-lg-8 text-center">
                    <span
                        class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 rounded-pill mb-3 animate__animated animate__pulse animate__infinite animate__slow">
                        <i class="bi bi-award me-1"></i>Tentang Kami
                    </span>
                    <h2 class="display-5 fw-bold text-dark mb-4">
                        Pelayanan Terbaik untuk
                        <span class="text-primary">Pengalaman Berkendara</span> Anda
                    </h2>
                    <p class="fs-5 text-muted">
                        Kami berkomitmen memberikan pengalaman sewa motor yang tak terlupakan
                    </p>
                </div>
            </div>

            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="position-relative">
                        <!-- Image with hover effect -->
                        <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-lg hover-tilt">
                            <img class="object-fit-cover w-100 h-100" src="images/pcx23.jpeg" alt="Pelayanan Terbaik">
                        </div>

                        <!-- Floating Stats Cards with animations -->
                        <div class="position-absolute top-0 end-0 m-3 floating-animation">
                            <div class="card border-0 shadow-sm hover-scale-sm">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-star-fill text-warning fs-4"></i>
                                    <div class="fw-bold">4.9</div>
                                    <small class="text-muted">Rating</small>
                                </div>
                            </div>
                        </div>

                        <div class="position-absolute bottom-0 start-0 m-3 floating-animation-delay">
                            <div class="card border-0 shadow-sm bg-primary text-white hover-scale-sm">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-people-fill fs-4"></i>
                                    <div class="fw-bold">1000+</div>
                                    <small>Pelanggan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="ps-lg-4">
                        <p class="fs-5 text-muted mb-4 lh-lg">
                            Dengan memastikan setiap pelanggan mendapatkan pengalaman sewa motor yang nyaman,
                            aman, dan memuaskan. Kepuasan Anda adalah prioritas kami.
                        </p>

                        <!-- Feature List with staggered animations -->
                        <div class="list-group list-group-flush mb-4">
                            <div class="list-group-item border-0 px-0 py-3" data-aos="fade-up" data-aos-delay="100">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-transparent rounded-circle p-3 hover-rotate">
                                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 fw-bold">Motor Terawat & Berkualitas</h6>
                                        <p class="mb-0 text-muted small">Semua motor dalam kondisi prima dan rutin diservice
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="list-group-item border-0 px-0 py-3 mt-1" data-aos="fade-up" data-aos-delay="200">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-transparent rounded-circle p-3 hover-rotate">
                                            <i class="bi bi-clock-fill text-primary fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 fw-bold">Proses Booking Cepat</h6>
                                        <p class="mb-0 text-muted small">Reservasi dalam hitungan menit, siap pakai</p>
                                    </div>
                                </div>
                            </div>

                            <div class="list-group-item border-0 px-0 py-3 mt-1" data-aos="fade-up" data-aos-delay="300">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-transparent rounded-circle p-3 hover-rotate">
                                            <i class="bi bi-shield-check text-warning fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 fw-bold">Asuransi & Keamanan</h6>
                                        <p class="mb-0 text-muted small">Perlindungan menyeluruh untuk ketenangan pikiran
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-3" data-aos="fade-up" data-aos-delay="400">
                            <a href="#" class="btn btn-primary btn-lg px-4 py-3 rounded-pill hover-scale">
                                <i class="bi bi-chat-dots me-2"></i>Hubungi Kami
                            </a>
                            <a href="#daftar-motor"
                                class="btn btn-outline-primary btn-lg px-4 py-3 rounded-pill hover-scale">
                                <i class="bi bi-arrow-down me-2"></i>Lihat Motor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Motor Listing Section with Advanced Filtering -->
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

            <!-- Motor Cards Grid with Staggered Animations -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-motors">
                    <div class="row g-4">
                        @forelse($products as $key => $product)
                            <div class="col-12 col-sm-6 col-lg-3 col-xl-4" data-aos="fade-up"
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

                                    <!-- Favorite Button -->
                                    <div class="position-absolute top-0 start-0 m-3 z-3">
                                        <button
                                            class="btn btn-light btn-sm rounded-circle p-2 shadow-sm border-0 hover-scale-sm">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>

                                    <!-- Motor Image with Hover Effect -->
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
                                                <a class="btn btn-primary btn-lg rounded-pill shadow-sm hover-scale rent-button"
                                                    href="{{ route('frontend.order', $product->id) }}"
                                                    data-product-id="{{ $product->id }}">
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

            <!-- View All Button with Animation -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('frontend.homepage') }}"
                    class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill hover-scale">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Lihat Semua Motor
                </a>
            </div>
        </div>
    </section>

    <!-- Rental Profiles Section -->
    <section class="py-5 bg-light" id="rental-profiles">
        <div class="container">
            <!-- Section Header -->
            <div class="row justify-content-center mb-5" data-aos="fade-up">
                <div class="col-lg-8 text-center">
                    <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-shop me-1"></i>Rental Terpercaya
                    </span>
                    <h2 class="display-5 fw-bold mb-3">Temui Mitra Rental Kami</h2>
                    <p class="fs-5 text-muted">Jelajahi penyedia rental terpercaya untuk pengalaman sewa yang aman dan nyaman</p>
                </div>
            </div>

            <!-- Rental Profiles Grid with Staggered Animations -->
            <div class="row g-4">
                @forelse($rentalProfiles as $key => $profile)
                    <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($key % 3) * 100 }}">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-grow">
                            <!-- Rental Image (Placeholder or logo if available) -->
                            <div class="ratio ratio-4x3 position-relative overflow-hidden">
                                <img class="card-img-top object-fit-cover w-100 h-100 hover-zoom"
                                    src="{{ $profile->logo ? Storage::url($profile->logo) : '/images/rental-placeholder.jpg' }}"
                                    alt="{{ $profile->nama_rental }}">

                                <!-- Image Overlay -->
                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 opacity-0 d-flex align-items-center justify-content-center hover-reveal">
                                    <a href="{{ route('rental.profiles', $profile->id) }}"
                                        class="btn btn-light rounded-pill px-4 hover-scale-sm">
                                        <i class="bi bi-eye me-2"></i>Lihat Profil
                                    </a>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-2 text-truncate">{{ $profile->nama_rental }}</h5>
                                <p class="text-muted small mb-2"><i class="bi bi-person me-2"></i>{{ $profile->nama_pemilik }}</p>
                                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-2"></i>{{ $profile->kota }}, {{ $profile->provinsi }}</p>
                                <p class="text-muted small mb-0"><i class="bi bi-envelope me-2"></i>{{ $profile->email_perusahaan }}</p>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-white border-0 p-4 pt-0">
                                <div class="d-grid gap-2">
                                    <a class="btn btn-primary btn-lg rounded-pill shadow-sm hover-scale"
                                        href="{{ route('rental.profiles', $profile->id) }}">
                                        <i class="bi bi-shop me-2"></i>Lihat Profil
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
                            <h4 class="text-muted mb-3">Belum ada profil rental tersedia</h4>
                            <p class="text-muted mb-4">Silakan kembali lagi nanti untuk melihat mitra rental kami.</p>
                            <a href="#" class="btn btn-primary rounded-pill px-4 hover-scale">
                                <i class="bi bi-bell me-2"></i>Beritahu Saya
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- View All Button with Animation -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="100">
                <a href=""
                    class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill hover-scale">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Lihat Semua Rental
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section with Particle Animation -->
    <section class="py-5 bg-primary text-white position-relative overflow-hidden" id="cta">
        <div id="particles-js"></div>

        <div class="container position-relative">
            <div class="row align-items-center g-4">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-rocket-takeoff fs-1 me-3"></i>
                        <div>
                            <h3 class="fw-bold mb-2">Siap untuk Petualangan Anda?</h3>
                            <p class="mb-0 fs-5 opacity-75">
                                Booking motor sekarang dan nikmati pengalaman berkendara yang tak terlupakan!
                            </p>
                        </div>
                    </div>

                    <!-- Stats with Animation -->
                    <div class="row g-3 mt-3">
                        <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="text-center counter-up">
                                <div class="fw-bold fs-4" data-count="1000">0</div>
                                <small class="opacity-75">Pelanggan Puas</small>
                            </div>
                        </div>
                        <div class="col-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-center counter-up">
                                <div class="fw-bold fs-4" data-count="50">0</div>
                                <small class="opacity-75">Motor Tersedia</small>
                            </div>
                        </div>
                        <div class="col-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="text-center counter-up">
                                <div class="fw-bold fs-4">24/7</div>
                                <small class="opacity-75">Layanan</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                    <div class="d-grid gap-3">
                        <a href="#"
                            class="btn btn-warning btn-lg px-5 py-3 rounded-pill shadow text-dark fw-bold hover-scale">
                            <i class="bi bi-telephone-fill me-2"></i>Hubungi Sekarang
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill hover-scale">
                            <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Verifikasi Lokasi -->
<!-- Modal Verifikasi Lokasi -->
<div class="modal fade" id="locationVerificationModal" tabindex="-1" aria-labelledby="locationVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-primary" id="locationVerificationModalLabel">🎉 Selamat Datang di Tegal!</h5>
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
                <button type="button" class="btn btn-lg btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Tidak
                </button>
                <button type="button" id="confirmLocationBtn" class="btn btn-lg btn-primary rounded-pill px-4">
                    <i class="bi bi-scooter me-1"></i>Ya, Saya Ingin Sewa
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Back to Top Button -->
    <button class="btn btn-primary btn-lg rounded-circle shadow-lg back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Required Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/css/homepage.css') }}"></script>
    <script>
        // Initialize AOS (Animate On Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: false
            });

            // Typed.js for Hero Text
            var typed = new Typed('.typed-text', {
                strings: ["Sewa Motor", "Rental Motor", "Tour Motor"],
                typeSpeed: 100,
                backSpeed: 50,
                loop: true,
                showCursor: true,
                cursorChar: '|',
                autoInsertCss: true
            });

            // Counter Animation
            const counters = document.querySelectorAll('.counter-up div[data-count]');
            const speed = 200;

            function animateCounters() {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-count');
                    const count = +counter.innerText;
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(animateCounters, 1);
                    } else {
                        counter.innerText = target;
                    }
                });
            }

            // Start counter when CTA section is in view
            const ctaObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        ctaObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            const ctaSection = document.getElementById('cta');
            if (ctaSection) {
                ctaObserver.observe(ctaSection);
            }

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

            // Location Verification Modal
            document.querySelectorAll('.rent-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');
                    const modal = new bootstrap.Modal(document.getElementById('locationVerificationModal'));

                    // Set the confirm button to redirect to the order page
                    document.getElementById('confirmLocationBtn').onclick = function() {
                        window.location.href = `/order/${productId}`;
                    };

                    modal.show();
                });
            });

            // If user clicks "No" in modal, redirect to homepage
            document.getElementById('locationVerificationModal').addEventListener('hidden.bs.modal', function () {
                window.location.href = "{{ route('frontend.product') }}";
            });
        });
    </script>
@endsection
