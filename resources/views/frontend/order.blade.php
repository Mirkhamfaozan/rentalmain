@extends('layouts.frontend')

@section('content')
    <!-- Hero Section with Parallax and Gradient Overlay -->
    <header class="position-relative py-5 text-white overflow-hidden bg-dark"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-3 fw-bold text-warning mb-3">Sewa {{ $product->nama_motor }}</h1>
                <p class="lead fs-4 text-white-75">Pesan motor impianmu untuk petualangan tak terlupakan!</p>
            </div>
        </div>
        <!-- Animated Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#rental-form" class="text-white text-decoration-none">
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
                            class="card-img-top img-fluid" alt="{{ $product->nama_motor }}" style="height: 300px; object-fit: cover;">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-primary mb-3">{{ $product->nama_motor }}</h4>
                            <!-- Pricing Information -->
                            <div class="bg-light rounded-3 p-3 mb-3 shadow-sm">
                                <h6 class="fw-semibold mb-3"><i class="bi bi-wallet2 me-2"></i>Tarif Sewa</h6>
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <strong>Harian:</strong><br>
                                        <span class="text-success fw-bold">Rp {{ number_format($product->harga_harian, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <strong>Mingguan:</strong><br>
                                        <span class="text-primary fw-bold">Rp {{ number_format($product->harga_mingguan, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <strong>Bulanan:</strong><br>
                                        <span class="text-warning fw-bold">Rp {{ number_format($product->harga_bulanan, 0, ',', '.') }}</span>
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
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Terjadi kesalahan:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('frontend.order.submit') }}" method="POST" id="orderForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <!-- Floating Label Inputs -->
                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}" placeholder="Nama Penyewa" required>
                                    <label for="name">Nama Penyewa <span class="text-danger">*</span></label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email') }}" placeholder="Email" required>
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $error }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                        name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="Nomor WhatsApp" required>
                                    <label for="phone_number">Nomor WhatsApp <span class="text-danger">*</span></label>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" min="{{ date('Y-m-d') }}" required>
                                    <label for="tanggal_mulai">Tanggal Mulai Sewa <span class="text-danger">*</span></label>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                    <label for="tanggal_selesai">Tanggal Selesai Sewa <span class="text-danger">*</span></label>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" rows="4" placeholder="Catatan Tambahan">{{ old('catatan') }}</textarea>
                                    <label for="catatan">Catatan Tambahan</label>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('lokasi_pengambilan') is-invalid @enderror"
                                        name="lokasi_pengambilan" id="lokasi_pengambilan" value="{{ old('lokasi_pengambilan') }}" placeholder="Lokasi Pengambilan">
                                    <label for="lokasi_pengambilan">Lokasi Pengambilan</label>
                                    @error('lokasi_pengambilan')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control @error('lokasi_pengembalian') is-invalid @enderror"
                                        name="lokasi_pengembalian" id="lokasi_pengembalian" value="{{ old('lokasi_pengembalian') }}" placeholder="Lokasi Pengembalian">
                                    <label for="lokasi_pengembalian">Lokasi Pengembalian</label>
                                    @error('lokasi_pengembalian')
                                        <div class="invalid-feedback">{{ $error }}</div>
                                    @enderror
                                </div>

                                <!-- Price Summary -->
                                <div class="card bg-light rounded-3 shadow-sm mb-4" id="priceInfo" style="display: none;"
                                    data-aos="fade-up" data-aos-delay="300">
                                    <div class="card-body p-4">
                                        <h6 class="fw-semibold mb-3"><i class="bi bi-calculator me-2"></i>Ringkasan Pesanan</h6>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <strong>Durasi:</strong> <span id="durasiHari">-</span> hari
                                            </div>
                                            <div class="col-6">
                                                <strong>Tipe Sewa:</strong> <span id="tipeSewaTerpilih">-</span>
                                            </div>
                                        </div>
                                        <div class="alert alert-info py-2 rounded-3" id="autoSelectionAlert" style="display: none;">
                                            <small><i class="bi bi-magic me-1"></i> <span id="autoSelectionText"></span></small>
                                        </div>
                                        <div class="border-top pt-3">
                                            <strong class="text-success fs-5">Total: Rp <span id="totalHarga">-</span></strong>
                                            <small class="d-block text-muted mt-1">*Harga final akan dikonfirmasi oleh vendor</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between gap-3">
                                    <button type="button" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold" id="submitBtn">
                                        <i class="bi bi-paper-plane me-2"></i>Submit Pesanan
                                    </button>
                                    <a href="{{ route('frontend.product') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
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

    <!-- Order Confirmation Modal -->
    <div class="modal fade" id="orderConfirmationModal" tabindex="-1" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white rounded-top-4 border-0">
                    <h5 class="modal-title fw-bold" id="orderConfirmationModalLabel">
                        <i class="bi bi-check-circle me-2"></i>Konfirmasi Pesanan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Pastikan data yang Anda masukkan sudah benar!</strong>
                    </div>

                    <!-- Order Summary -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 rounded-3 h-100">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="bi bi-person-circle me-2"></i>Data Penyewa
                                    </h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Nama:</small><br>
                                        <span class="fw-semibold" id="confirmName">-</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Email:</small><br>
                                        <span class="fw-semibold" id="confirmEmail">-</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">WhatsApp:</small><br>
                                        <span class="fw-semibold" id="confirmPhone">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0 rounded-3 h-100">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="bi bi-calendar-check me-2"></i>Detail Sewa
                                    </h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Motor:</small><br>
                                        <span class="fw-semibold">{{ $product->nama_motor }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Periode:</small><br>
                                        <span class="fw-semibold" id="confirmPeriod">-</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Durasi:</small><br>
                                        <span class="fw-semibold" id="confirmDuration">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Locations (if provided) -->
                    <div class="row g-4 mt-2" id="locationsSection" style="display: none;">
                        <div class="col-12">
                            <div class="card bg-light border-0 rounded-3">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-info mb-3">
                                        <i class="bi bi-geo-alt me-2"></i>Lokasi
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">Pengambilan:</small><br>
                                            <span class="fw-semibold" id="confirmPickup">-</span>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Pengembalian:</small><br>
                                            <span class="fw-semibold" id="confirmReturn">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes (if provided) -->
                    <div class="mt-3" id="notesSection" style="display: none;">
                        <div class="card bg-light border-0 rounded-3">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-secondary mb-2">
                                    <i class="bi bi-chat-text me-2"></i>Catatan Tambahan
                                </h6>
                                <p class="mb-0 text-muted" id="confirmNotes">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="mt-3">
                        <div class="card border-primary bg-primary bg-opacity-10 rounded-3">
                            <div class="card-body p-3 text-center">
                                <h6 class="fw-bold text-primary mb-2">
                                    <i class="bi bi-wallet2 me-2"></i>Estimasi Total
                                </h6>
                                <div class="fs-4 fw-bold text-success mb-1">
                                    Rp <span id="confirmTotal">-</span>
                                </div>
                                <small class="text-muted">*Harga final akan dikonfirmasi oleh vendor</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm" id="confirmOrderBtn">
                        <i class="bi bi-check-circle me-2"></i>Ya, Pesan Sekarang!
                    </button>
                </div>
            </div>
        </div>
    </div>

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
            const confirmOrderBtn = document.getElementById('confirmOrderBtn');
            const orderConfirmationModal = new bootstrap.Modal(document.getElementById('orderConfirmationModal'));

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

            // Submit button click handler - show confirmation modal
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Validate form first
                if (!orderForm.checkValidity()) {
                    orderForm.reportValidity();
                    return;
                }

                // Check if required fields are filled
                const requiredFields = ['name', 'email', 'phone_number', 'tanggal_mulai', 'tanggal_selesai'];
                let allValid = true;

                requiredFields.forEach(field => {
                    const element = document.getElementById(field);
                    if (!element.value.trim()) {
                        allValid = false;
                        element.classList.add('is-invalid');
                    } else {
                        element.classList.remove('is-invalid');
                    }
                });

                if (!allValid) {
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                    return;
                }

                // Populate confirmation modal
                populateConfirmationModal();

                // Show confirmation modal
                orderConfirmationModal.show();
            });

            // Confirm order button click handler
            confirmOrderBtn.addEventListener('click', function() {
                // Update submit button state
                confirmOrderBtn.innerHTML = '<i class="bi bi-arrow-clockwise fa-spin me-2"></i>Memproses...';
                confirmOrderBtn.disabled = true;

                // Close modal and submit form
                orderConfirmationModal.hide();

                // Update original submit button
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;

                // Submit the form
                orderForm.submit();
            });

            // Function to populate confirmation modal
            function populateConfirmationModal() {
                // Personal data
                document.getElementById('confirmName').textContent = document.getElementById('name').value;
                document.getElementById('confirmEmail').textContent = document.getElementById('email').value;
                document.getElementById('confirmPhone').textContent = document.getElementById('phone_number').value;

                // Rental details
                const startDate = new Date(document.getElementById('tanggal_mulai').value);
                const endDate = new Date(document.getElementById('tanggal_selesai').value);
                const formatDate = (date) => date.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                document.getElementById('confirmPeriod').textContent =
                    `${formatDate(startDate)} - ${formatDate(endDate)}`;
                document.getElementById('confirmDuration').textContent =
                    `${durasiHari.textContent} hari (${tipeSewaTerpilih.textContent})`;
                document.getElementById('confirmTotal').textContent = totalHarga.textContent;

                // Locations (optional)
                const pickupLocation = document.getElementById('lokasi_pengambilan').value;
                const returnLocation = document.getElementById('lokasi_pengembalian').value;

                if (pickupLocation || returnLocation) {
                    document.getElementById('confirmPickup').textContent = pickupLocation || 'Tidak disebutkan';
                    document.getElementById('confirmReturn').textContent = returnLocation || 'Tidak disebutkan';
                    document.getElementById('locationsSection').style.display = 'block';
                } else {
                    document.getElementById('locationsSection').style.display = 'none';
                }

                // Notes (optional)
                const notes = document.getElementById('catatan').value;
                if (notes.trim()) {
                    document.getElementById('confirmNotes').textContent = notes;
                    document.getElementById('notesSection').style.display = 'block';
                } else {
                    document.getElementById('notesSection').style.display = 'none';
                }
            }

            // Reset confirmation button when modal is hidden
            document.getElementById('orderConfirmationModal').addEventListener('hidden.bs.modal', function () {
                confirmOrderBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Ya, Pesan Sekarang!';
                confirmOrderBtn.disabled = false;
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
