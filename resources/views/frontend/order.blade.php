@extends('layouts.frontend')

@section('content')
    <!-- Hero Section with Parallax and Gradient Overlay -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-3 fw-bold text-warning mb-3 animate__animated animate__fadeIn">Sewa
                    {{ $product->nama_motor }}</h1>
                <p class="lead fs-4 text-white-75">Pesan motor impianmu untuk petualangan tak terlupakan!</p>
            </div>
        </div>
        <!-- Animated Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#rental-form" class="text-white text-decoration-none scroll-down">
                <i class="bi bi-chevron-double-down fs-3 animate__animated animate__bounce animate__infinite"></i>
            </a>
        </div>
    </header>

    <!-- Rental Form Section -->
    <section class="py-5 bg-light" id="rental-form">
        <div class="container px-4 px-lg-5">
            <!-- Success/Error Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert"
                    data-aos="fade-down">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert"
                    data-aos="fade-down">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row gx-5">
                <!-- Product Details -->
                <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                        <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                            class="card-img-top hover-zoom" alt="{{ $product->nama_motor }}"
                            style="height: 300px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-3">{{ $product->nama_motor }}</h4>
                            <!-- Pricing Information -->
                            <div class="bg-light rounded-3 p-3 mb-3 shadow-sm">
                                <h6 class="fw-semibold mb-3"><i class="bi bi-wallet2 me-2"></i>Tarif Sewa</h6>
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <strong>Harian:</strong><br>
                                        <span class="text-success fw-bold">Rp
                                            {{ number_format($product->harga_harian, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <strong>Mingguan:</strong><br>
                                        <span class="text-primary fw-bold">Rp
                                            {{ number_format($product->harga_mingguan, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <strong>Bulanan:</strong><br>
                                        <span class="text-warning fw-bold">Rp
                                            {{ number_format($product->harga_bulanan, 0, ',', '.') }}</span>

                                    </div>
                                </div>
                            </div>
                            <p class="text-muted lh-lg">{{ $product->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rental Form -->
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm"
                                    role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Terjadi kesalahan:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('frontend.order.submit') }}" method="POST" id="orderForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- Floating Label Inputs -->
                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}"
                                        placeholder="Nama Penyewa" required>
                                    <label for="name">Nama Penyewa <span class="text-danger">*</span></label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email') }}" placeholder="Email"
                                        required>
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $error }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                        name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                        placeholder="Nomor WhatsApp" required>
                                    <label for="phone_number">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="date"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                        min="{{ date('Y-m-d') }}" required>
                                    <label for="tanggal_mulai">Tanggal Mulai Sewa <span
                                            class="text-danger">*</span></label>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="date"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                        required>
                                    <label for="tanggal_selesai">Tanggal Selesai Sewa <span
                                            class="text-danger">*</span></label>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" rows="4"
                                        placeholder="Catatan Tambahan">{{ old('catatan') }}</textarea>
                                    <label for="catatan">Catatan Tambahan</label>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text"
                                        class="form-control @error('lokasi_pengambilan') is-invalid @enderror"
                                        name="lokasi_pengambilan" id="lokasi_pengambilan"
                                        value="{{ old('lokasi_pengambilan') }}" placeholder="Lokasi Pengambilan">
                                    <label for="lokasi_pengambilan">Lokasi Pengambilan</label>
                                    @error('lokasi_pengambilan')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text"
                                        class="form-control @error('lokasi_pengembalian') is-invalid @enderror"
                                        name="lokasi_pengembalian" id="lokasi_pengembalian"
                                        value="{{ old('lokasi_pengembalian') }}" placeholder="Lokasi Pengembalian">
                                    <label for="lokasi_pengembalian">Lokasi Pengembalian</label>
                                    @error('lokasi_pengembalian')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <!-- Price Summary -->
                                <div class="card bg-light rounded-3 shadow-sm mb-4" id="priceInfo" style="display: none;"
                                    data-aos="fade-up" data-aos-delay="300">
                                    <div class="card-body p-4">
                                        <h6 class="fw-semibold mb-3"><i class="bi bi-calculator me-2"></i>Ringkasan
                                            Pesanan</h6>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <strong>Durasi:</strong> <span id="durasiHari">-</span> hari
                                            </div>
                                            <div class="col-6">
                                                <strong>Tipe Sewa:</strong> <span id="tipeSewaTerpilih">-</span>
                                            </div>
                                        </div>
                                        <div class="alert alert-info py-2 rounded-3" id="autoSelectionAlert"
                                            style="display: none;">
                                            <small><i class="bi bi-magic me-1"></i> <span
                                                    id="autoSelectionText"></span></small>
                                        </div>
                                        <div class="border-top pt-3">
                                            <strong class="text-success fs-5">Total: Rp <span
                                                    id="totalHarga">-</span></strong>
                                            <small class="d-block text-muted mt-1">*Harga final akan dikonfirmasi oleh
                                                vendor</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between gap-3">
                                    <button type="submit"
                                        class="btn btn-gradient btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale fw-bold"
                                        id="submitBtn">
                                        <i class="bi bi-paper-plane me-2"></i>Submit Pesanan
                                    </button>
                                    <a href="{{ route('frontend.product') }}"
                                        class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill hover-scale">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
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
        }

        /* Hover Effects */
        .hover-scale {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .hover-zoom {
            transition: transform calc(var(--animation-duration) * 2) ease;
        }

        .hover-zoom:hover {
            transform: scale(1.1);
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

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 5px solid #dc3545;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-left: 5px solid #17a2b8;
        }

        /* Card Animation */
        .card {
            transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
        }

        .card:hover {
            transform: translateY(-5px);
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

        /* Fade In Animation */
        #priceInfo {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Control Focus */
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .display-3 {
                font-size: 2.5rem;
            }

            .card-img-top {
                height: 200px;
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

            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            const priceInfo = document.getElementById('priceInfo');
            const durasiHari = document.getElementById('durasiHari');
            const totalHarga = document.getElementById('totalHarga');
            const tipeSewaTerpilih = document.getElementById('tipeSewaTerpilih');
            const autoSelectionAlert = document.getElementById('autoSelectionAlert');
            const autoSelectionText = document.getElementById('autoSelectionText');
            const submitBtn = document.getElementById('submitBtn');
            const orderForm = document.getElementById('orderForm');

            // Pricing data
            const pricing = {
                harian: {{ $product->harga_harian }},
                mingguan: {{ $product->harga_mingguan }},
                bulanan: {{ $product->harga_bulanan }}
            };

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert:not(#autoSelectionAlert)');
                alerts.forEach(function(alert) {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Form submission loading state
            orderForm.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            });

// Hybrid rental calculation system
function determineRentalType(days) {
    if (days > 29) return 'bulanan';  // Lebih dari 29 hari
    if (days > 7) return 'mingguan';  // Lebih dari 7 hari
    return 'harian';                  // 7 hari atau kurang
}

function calculateHybridPrice(days, pricing) {
    let totalPrice = 0;
    let breakdown = [];

    if (days > 29) {
        // Bulanan + sisa hari
        const months = Math.floor(days / 30);
        const remainingDays = days % 30;

        if (months > 0) {
            totalPrice += months * pricing.bulanan;
            breakdown.push(`${months} bulan`);
        }

        if (remainingDays > 0) {
            if (remainingDays > 7) {
                // Sisa hari lebih dari 7, gunakan mingguan + harian
                const weeks = Math.floor(remainingDays / 7);
                const extraDays = remainingDays % 7;

                if (weeks > 0) {
                    totalPrice += weeks * pricing.mingguan;
                    breakdown.push(`${weeks} minggu`);
                }

                if (extraDays > 0) {
                    totalPrice += extraDays * pricing.harian;
                    breakdown.push(`${extraDays} hari`);
                }
            } else {
                // Sisa hari 7 atau kurang, gunakan harian
                totalPrice += remainingDays * pricing.harian;
                breakdown.push(`${remainingDays} hari`);
            }
        }
    } else if (days > 7) {
        // Mingguan + sisa hari
        const weeks = Math.floor(days / 7);
        const remainingDays = days % 7;

        if (weeks > 0) {
            totalPrice += weeks * pricing.mingguan;
            breakdown.push(`${weeks} minggu`);
        }

        if (remainingDays > 0) {
            totalPrice += remainingDays * pricing.harian;
            breakdown.push(`${remainingDays} hari`);
        }
    } else {
        // Harian saja
        totalPrice = days * pricing.harian;
        breakdown.push(`${days} hari`);
    }

    return {
        totalPrice: totalPrice,
        breakdown: breakdown,
        mainType: determineRentalType(days)
    };
}

function calculatePrice() {
    const startDate = new Date(tanggalMulai.value);
    const endDate = new Date(tanggalSelesai.value);

    if (startDate && endDate && endDate >= startDate) {
        const timeDiff = endDate.getTime() - startDate.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

        // Hitung dengan sistem hybrid
        const calculation = calculateHybridPrice(daysDiff, pricing);

        durasiHari.textContent = daysDiff;
        tipeSewaTerpilih.textContent = calculation.breakdown.join(' + ');
        totalHarga.textContent = calculation.totalPrice.toLocaleString('id-ID');

        showAutoSelectionInfo(daysDiff, calculation);
        priceInfo.style.display = 'block';
    } else {
        priceInfo.style.display = 'none';
    }
}

function showAutoSelectionInfo(days, calculation) {
    const explanationText = `Durasi ${days} hari = ${calculation.breakdown.join(' + ')} - Sistem perhitungan hybrid`;
    autoSelectionText.textContent = explanationText;
    autoSelectionAlert.style.display = 'block';
}


       // Event listeners
            tanggalMulai.addEventListener('change', function() {
                tanggalSelesai.min = this.value;
                if (tanggalSelesai.value && tanggalSelesai.value < this.value) {
                    tanggalSelesai.value = '';
                }
                calculatePrice();
            });

            tanggalSelesai.addEventListener('change', calculatePrice);

            // Initial calculation
            if (tanggalMulai.value && tanggalSelesai.value) {
                calculatePrice();
            }
        });
    </script>
@endsection
