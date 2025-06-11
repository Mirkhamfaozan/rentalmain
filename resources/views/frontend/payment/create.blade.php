@extends('layouts.frontend')

@section('content')
<div class=" py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Alerts Section -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                                <!-- Payment Method Selection -->
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-header bg-white border-bottom py-4 text-center">
                            <h4 class="mb-0 fw-bold">
                                <i class="bi bi-credit-card-2-front me-2 text-primary"></i>
                                Pilih Metode Pembayaran
                            </h4>
                            <p class="text-muted mb-0 mt-2">Pilih metode pembayaran yang paling nyaman untuk Anda</p>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('payment.store', $order->id) }}" method="POST" id="paymentForm">
                                @csrf
                                <div class="payment-methods">
                                    @php
                                    $paymentOptions = [
                                        'bank_transfer' => [
                                            'label' => 'Transfer Bank',
                                            'icon' => 'bi-bank',
                                            'description' => 'Transfer melalui ATM, Internet Banking, atau Mobile Banking (BCA, Mandiri, BNI, BRI)',
                                            'popular' => false,
                                            'expiry' => '24 jam'
                                        ],
                                        'credit_card' => [
                                            'label' => 'Kartu Kredit/Debit',
                                            'icon' => 'bi-credit-card',
                                            'description' => 'Visa, MasterCard, JCB - Pembayaran langsung dan aman',
                                            'popular' => true,
                                            'expiry' => '15 menit'
                                        ],
                                        'gopay' => [
                                            'label' => 'GoPay',
                                            'icon' => 'bi-wallet2',
                                            'description' => 'Bayar dengan saldo GoPay atau GoPay Later',
                                            'popular' => true,
                                            'expiry' => '30 menit'
                                        ],
                                        'qris' => [
                                            'label' => 'QRIS',
                                            'icon' => 'bi-qr-code-scan',
                                            'description' => 'Scan QR Code dengan aplikasi perbankan atau e-wallet apapun',
                                            'popular' => false,
                                            'expiry' => '15 menit'
                                        ],
                                    ];

                                    $bankOptions = [
                                        'bca' => 'BCA',
                                        'bni' => 'BNI',
                                        'bri' => 'BRI',
                                        'mandiri' => 'Mandiri',
                                        'permata' => 'Permata',
                                        'cimb' => 'CIMB Niaga'
                                    ];
                                    @endphp

                                    @foreach($paymentOptions as $key => $option)
                                    <div class="form-check payment-option mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Berlaku selama {{ $option['expiry'] }}">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               id="{{ $key }}" value="{{ $key }}" required>
                                        <label class="form-check-label d-flex align-items-center p-3 border rounded-3 shadow-sm"
                                               for="{{ $key }}">
                                            <div class="payment-icon me-3 p-2 rounded-circle">
                                                <i class="bi {{ $option['icon'] }} fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold">{{ $option['label'] }}</h6>
                                                    @if($option['popular'])
                                                    <span class="badge bg-warning text-dark ms-2 rounded-pill">
                                                        <i class="bi bi-star-fill me-1"></i>Populer
                                                    </span>
                                                    @endif
                                                </div>
                                                <p class="text-muted mb-0 small">{{ $option['description'] }}</p>
                                            </div>
                                            <div class="payment-check ms-3">
                                                <i class="bi bi-check-circle-fill text-success d-none"></i>
                                            </div>
                                        </label>

                                        @if($key === 'bank_transfer')
                                        <div class="bank-selection mt-3 ms-4" style="display: none;">
                                            <label for="bank_type" class="form-label fw-bold">Pilih Bank:</label>
                                            <select class="form-select rounded-3" name="bank_type" id="bank_type">
                                                <option value="">-- Pilih Bank --</option>
                                                @foreach($bankOptions as $bankKey => $bankName)
                                                <option value="{{ $bankKey }}">{{ $bankName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Payment Information -->
                                <div class="alert alert-info d-flex align-items-start shadow-sm rounded-3" role="alert">
                                    <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                                    <div>
                                        <strong>Informasi Penting:</strong>
                                        <ul class="mb-0 mt-2 small">
                                            <li>Setiap metode pembayaran memiliki batas waktu yang berbeda</li>
                                            <li>Pembayaran yang melewati batas waktu akan otomatis dibatalkan</li>
                                            <li>Untuk transfer bank, gunakan nomor virtual account yang akan diberikan</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3 mt-4">
                                    <a href="{{ route('frontend.product') }}"
                                       class="btn btn-outline-secondary w-50 rounded-pill shadow-sm">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary w-50 rounded-pill shadow-sm" id="paymentBtn">
                                        <span class="btn-text">
                                            <i class="bi bi-lock me-2"></i>Proses Pembayaran
                                        </span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            Memproses...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Order Summary Card -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="card-header bg-gradient-primary text-white text-center py-4">
                            <h5 class="mb-0">
                                <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="flex mb-4">
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $order->product->image) }}"
                                         alt="{{ $order->product->name }}"
                                         class="img-fluid rounded shadow-sm hover-scale-img">
                                </div>
                                <div class="col-10 ps-3">
                                    <h6 class="mb-2 fw-bold">{{ $order->product->name }}</h6>
                                    <div class="d-flex  mb-2">
                                        <i class="bi bi-calendar-check text-primary me-2"></i>
                                        <span class="text-muted me-2">Mulai:</span>
                                        <strong>{{ $order->tanggal_mulai->format('d M Y') }}</strong>
                                    </div>
                                    <div class="flex  mb-2">
                                        <i class="bi bi-calendar-x text-danger me-2"></i>
                                        <span class="text-muted me-2">Selesai:</span>
                                        <strong>{{ $order->tanggal_selesai->format('d M Y') }}</strong>
                                    </div>
                                    <div class="flex ">
                                        <i class="bi bi-clock text-info me-2"></i>
                                        <span class="text-muted me-2">Durasi:</span>
                                        <strong>{{ $order->durasi_hari }} hari</strong>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Price Breakdown -->
                            <div class="price-breakdown">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga per hari:</span>
                                    <span>Rp {{ number_format($order->product->harga_harian, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Durasi:</span>
                                    <span>{{ $order->durasi_hari }} hari</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal:</span>
                                    <span>Rp {{ number_format($order->product->harga_harian * $order->durasi_hari, 0, ',', '.') }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between bg-light p-3 rounded-3 shadow-sm">
                                    <strong>Total Pembayaran:</strong>
                                    <strong class="text-primary fs-4">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                                </div>
                            </div>

                            <!-- Security Badge -->
                            <div class="text-center mt-4">
                                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-shield-check me-1"></i>Pembayaran Aman & Terpercaya
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<style>
/* Modern and Sleek Styling */
:root {
    --primary: #0d6efd;
    --primary-dark: #0a58ca;
    --success: #198754;
    --warning: #ffc107;
    --animation-duration: 0.3s;
}

body {
    background: linear-gradient(180deg, #f8f9fa, #e9ecef);
}

/* Card Styling */
.card {
    transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
    border-radius: 1rem !important;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, var(--primary), #6610f2);
}

/* Payment Option Styling */
.payment-option .form-check-label {
    transition: all var(--animation-duration) ease;
    cursor: pointer;
    border: 2px solid #e9ecef !important;
    border-radius: 0.75rem !important;
    background: white;
}

.payment-option .form-check-input:checked + .form-check-label {
    border-color: var(--primary) !important;
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.05), rgba(102, 16, 242, 0.05));
    box-shadow: 0 0 20px rgba(13, 110, 253, 0.2);
    transform: translateY(-3px);
}

.payment-option .form-check-input:checked + .form-check-label .payment-check i {
    display: inline-block !important;
}

.payment-option:hover .form-check-label {
    border-color: var(--primary) !important;
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
}

.payment-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ffffff, #f1f3f5);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all var(--animation-duration) ease;
}

.payment-option .form-check-input:checked + .form-check-label .payment-icon {
    background: linear-gradient(135deg, var(--primary), #6610f2);
    color: white;
    transform: scale(1.1);
}

/* Button Styling */
.btn-primary {
    background: linear-gradient(45deg, var(--primary), #6610f2);
    border: none;
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 50px !important;
    transition: all var(--animation-duration) ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, var(--primary-dark), #5c0bc6);
    transform: translateY(-2px);
    box-shadow: 0 0.25rem 0.75rem rgba(13, 110, 253, 0.3);
}

.btn-primary:disabled {
    background: #6c757d;
    transform: none;
    box-shadow: none;
}

.btn-outline-secondary {
    border-radius: 50px !important;
    transition: all var(--animation-duration) ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

/* Progress Steps */
.nav-pills .nav-link {
    border-radius: 50px;
    font-weight: 600;
    transition: all var(--animation-duration) ease;
}

.nav-pills .nav-link.completed {
    background: var(--success);
    color: white;
    border-color: var(--success);
}

.nav-pills .nav-link.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.nav-pills .nav-link.disabled {
    background: #dee2e6;
    color: #6c757d;
    border-color: #dee2e6;
}


/* Alert Animations */
.alert-dismissible {
    animation: slideInDown 0.5s ease-out;
    border-radius: 0.75rem;
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Image Hover */
.hover-scale-img {
    transition: transform var(--animation-duration) ease;
}

.hover-scale-img:hover {
    transform: scale(1.05);
}

/* Badge Styling */
.bg-success-subtle {
    background-color: rgba(25, 135, 84, 0.1) !important;
    transition: transform var(--animation-duration) ease;
}

.bg-success-subtle:hover {
    transform: scale(1.05);
}

/* Bank Selection */
.bank-selection select {
    max-width: 300px;
    border-radius: 0.5rem;
    transition: all var(--animation-duration) ease;
}

.bank-selection select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Trust Indicators */
.d-flex.justify-content-center.gap-4 {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
    border-radius: 1rem;
}

.d-flex.justify-content-center.gap-4 i {
    transition: transform var(--animation-duration) ease;
}

.d-flex.justify-content-center.gap-4 i:hover {
    transform: scale(1.2);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .payment-icon {
        width: 40px;
        height: 40px;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .d-flex.gap-3 {
        flex-direction: column;
    }

    .d-flex.gap-3 .btn {
        width: 100% !important;
    }

    .nav-pills .nav-link {
        font-size: 0.9rem;
        padding: 0.5rem;
    }
}

/* Accessibility */
.payment-option .form-check-input:focus + .form-check-label {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

.btn:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const paymentBtn = document.getElementById('paymentBtn');
    const paymentOptions = document.querySelectorAll('.payment-option');
    const bankSelection = document.querySelector('.bank-selection');
    const bankTypeSelect = document.querySelector('#bank_type');

    // Initialize Bootstrap Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Toggle bank selection visibility with animation
    function toggleBankSelection(show) {
        if (bankSelection) {
            bankSelection.style.transition = 'opacity 0.3s ease, height 0.3s ease';
            bankSelection.style.opacity = show ? '1' : '0';
            bankSelection.style.height = show ? 'auto' : '0';
            bankSelection.style.display = show ? 'block' : 'none';
            bankTypeSelect.required = show;
        }
    }

    // Form submission with loading state and validation
    form.addEventListener('submit', function(e) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');

        if (!selectedPayment) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return false;
        }

        if (selectedPayment.value === 'bank_transfer' && (!bankTypeSelect.value || bankTypeSelect.value === '')) {
            e.preventDefault();
            alert('Silakan pilih bank untuk transfer.');
            bankTypeSelect.classList.add('is-invalid');
            return false;
        }

        const btnText = paymentBtn.querySelector('.btn-text');
        const btnLoading = paymentBtn.querySelector('.btn-loading');

        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        paymentBtn.disabled = true;

        form.classList.add('was-validated');
    });

    // Enhanced payment option interactions
    paymentOptions.forEach(option => {
        const radio = option.querySelector('.form-check-input');
        const label = option.querySelector('.form-check-label');
        const icon = option.querySelector('.payment-icon');

        // Hover effects
        option.addEventListener('mouseenter', function() {
            if (!radio.checked) {
                label.style.borderColor = '#0d6efd';
                label.style.transform = 'translateY(-3px)';
                icon.style.transform = 'scale(1.1)';
            }
        });

        option.addEventListener('mouseleave', function() {
            if (!radio.checked) {
                label.style.borderColor = '#e9ecef';
                label.style.transform = 'translateY(0)';
                icon.style.transform = 'scale(1)';
            }
        });

        // Selection change
        radio.addEventListener('change', function() {
            paymentOptions.forEach(opt => {
                const optLabel = opt.querySelector('.form-check-label');
                const optCheck = opt.querySelector('.payment-check i');
                const optIcon = opt.querySelector('.payment-icon');

                optCheck.classList.add('d-none');
                opt.classList.remove('selected');
                optLabel.style.borderColor = '#e9ecef';
                optLabel.style.transform = 'translateY(0)';
                optIcon.style.background = 'linear-gradient(135deg, #ffffff, #f1f3f5)';
                optIcon.style.color = '';
                optIcon.style.transform = 'scale(1)';
            });

            if (this.checked) {
                const thisOption = this.closest('.payment-option');
                const thisLabel = thisOption.querySelector('.form-check-label');
                const thisCheck = thisOption.querySelector('.payment-check i');
                const thisIcon = thisOption.querySelector('.payment-icon');

                thisOption.classList.add('selected');
                thisCheck.classList.remove('d-none');
                thisLabel.style.borderColor = '#0d6efd';
                thisLabel.style.transform = 'translateY(-3px)';
                thisIcon.style.background = 'linear-gradient(135deg, #0d6efd, #6610f2)';
                thisIcon.style.color = 'white';
                thisIcon.style.transform = 'scale(1.1)';

                const methodName = this.nextElementSibling.querySelector('h6').textContent;
                const btnText = paymentBtn.querySelector('.btn-text');
                btnText.innerHTML = `<i class="bi bi-lock me-2"></i>Bayar dengan ${methodName}`;

                toggleBankSelection(this.value === 'bank_transfer');
            }
        });

        label.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    // Handle bank type validation
    if (bankTypeSelect) {
        bankTypeSelect.addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });
    }

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Form validation feedback
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('invalid', function() {
            this.classList.add('is-invalid');
        });

        input.addEventListener('input', function() {
            if (this.validity.valid) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    // Prevent double submission
    let isSubmitting = false;
    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
    });

    // Reset form state if user navigates back
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            isSubmitting = false;
            paymentBtn.disabled = false;
            const btnText = paymentBtn.querySelector('.btn-text');
            const btnLoading = paymentBtn.querySelector('.btn-loading');
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
            toggleBankSelection(false);
        }
    });
});
</script>
@endsection
