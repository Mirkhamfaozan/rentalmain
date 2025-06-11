@extends('layouts.frontend')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('frontend.homepage') }}" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <h2 class="mb-1">Detail Pembayaran</h2>
                        <p class="text-muted mb-0">ID Transaksi: {{ $payment->transaction_id }}</p>
                    </div>
                </div>

                <div class="row">
                    <!-- Payment Status Card -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <!-- Status Badge -->
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h5 class="card-title mb-2">Status Pembayaran</h5>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'warning',
                                                'success' => 'success',
                                                'failed' => 'danger',
                                                'expired' => 'secondary',
                                                'cancelled' => 'dark',
                                                'refunded' => 'info',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Menunggu Pembayaran',
                                                'success' => 'Pembayaran Berhasil',
                                                'failed' => 'Pembayaran Gagal',
                                                'expired' => 'Kadaluarsa',
                                                'cancelled' => 'Dibatalkan',
                                                'refunded' => 'Dikembalikan',
                                            ];
                                        @endphp
                                        <span
                                            class="badge bg-{{ $statusClasses[$payment->status] ?? 'secondary' }} fs-6 px-3 py-2">
                                            {{ $statusLabels[$payment->status] ?? ucfirst($payment->status) }}
                                        </span>
                                    </div>
                                    @if ($payment->status === 'pending' && $payment->expiry_time > now())
                                        <div class="text-end">
                                            <small class="text-muted d-block">Batas Waktu:</small>
                                            <strong class="text-danger" id="countdown-timer">
                                                {{ $payment->expiry_time->format('d/m/Y H:i') }}
                                            </strong>
                                        </div>
                                    @endif
                                </div>

                                <!-- Payment Method Specific Information -->
                                @if ($payment->payment_type === 'bank_transfer')
                                    <div class="payment-method-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-box p-3 bg-light rounded mb-3">
                                                    <h6 class="fw-bold mb-2">
                                                        <i class="fas fa-university text-primary"></i>
                                                        Transfer Bank {{ strtoupper($payment->bank) }}
                                                    </h6>
                                                    <div class="va-number-display p-3 bg-white border rounded text-center">
                                                        <small class="text-muted d-block">Nomor Virtual Account</small>
                                                        <h4 class="fw-bold text-primary mb-2">{{ $payment->va_number }}</h4>
                                                        <button class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $payment->va_number }}')">
                                                            <i class="fas fa-copy"></i> Salin
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-box p-3 bg-light rounded mb-3">
                                                    <h6 class="fw-bold mb-2">
                                                        <i class="fas fa-money-bill-wave text-success"></i>
                                                        Jumlah Transfer
                                                    </h6>
                                                    <div class="amount-display p-3 bg-white border rounded text-center">
                                                        <h4 class="fw-bold text-success mb-2">
                                                            Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}
                                                        </h4>
                                                        <button class="btn btn-sm btn-outline-success"
                                                            onclick="copyToClipboard('{{ $payment->gross_amount }}')">
                                                            <i class="fas fa-copy"></i> Salin Nominal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Transfer Instructions -->
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Cara Transfer:</h6>
                                            <ol class="mb-0">
                                                <li>Buka aplikasi mobile banking atau kunjungi ATM
                                                    {{ strtoupper($payment->bank) }}</li>
                                                <li>Pilih menu Transfer > Virtual Account</li>
                                                <li>Masukkan nomor Virtual Account:
                                                    <strong>{{ $payment->va_number }}</strong></li>
                                                <li>Masukkan nominal: <strong>Rp
                                                        {{ number_format($payment->gross_amount, 0, ',', '.') }}</strong>
                                                </li>
                                                <li>Konfirmasi dan selesaikan pembayaran</li>
                                            </ol>
                                        </div>
                                    </div>
                                @elseif(in_array($payment->payment_type, ['gopay', 'shopeepay', 'dana', 'ovo']))
                                    <div class="payment-method-info">
                                        <div class="text-center mb-4">
                                            <h6 class="fw-bold mb-3">
                                                <i class="fas fa-mobile-alt text-primary"></i>
                                                Pembayaran {{ strtoupper($payment->payment_type) }}
                                            </h6>

                                            @if ($payment->qr_string)
                                                <div class="qr-code-container mb-3">
                                                    <div id="qrcode" class="d-inline-block"></div>
                                                    <p class="text-muted mt-2">Scan QR Code dengan aplikasi
                                                        {{ strtoupper($payment->payment_type) }}</p>
                                                </div>
                                            @endif

                                            @if ($payment->deeplink_redirect)
                                                <div class="d-grid gap-2 col-md-6 mx-auto">
                                                    <a href="{{ $payment->deeplink_redirect }}"
                                                        class="btn btn-primary btn-lg">
                                                        <i class="fas fa-external-link-alt"></i>
                                                        Buka {{ strtoupper($payment->payment_type) }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="alert alert-info">
                                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Cara Pembayaran:
                                            </h6>
                                            <ol class="mb-0">
                                                <li>Buka aplikasi {{ strtoupper($payment->payment_type) }} di smartphone
                                                    Anda</li>
                                                <li>{{ $payment->qr_string ? 'Scan QR Code di atas atau klik tombol "Buka ' . strtoupper($payment->payment_type) . '"' : 'Klik tombol "Buka ' . strtoupper($payment->payment_type) . '"' }}
                                                </li>
                                                <li>Konfirmasi pembayaran sebesar <strong>Rp
                                                        {{ number_format($payment->gross_amount, 0, ',', '.') }}</strong>
                                                </li>
                                                <li>Selesaikan pembayaran</li>
                                            </ol>
                                        </div>
                                    </div>
                                @elseif($payment->payment_type === 'qris')
                                    <div class="payment-method-info text-center">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-qrcode text-primary"></i>
                                            Pembayaran QRIS
                                        </h6>

                                        @if ($payment->qr_string)
                                            <div class="qr-code-container mb-3">
                                                <div id="qrcode" class="d-inline-block"></div>
                                                <p class="text-muted mt-2">Scan dengan aplikasi e-wallet atau mobile banking
                                                    yang mendukung QRIS</p>
                                            </div>
                                        @endif

                                        <div class="alert alert-info text-start">
                                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Cara Pembayaran:
                                            </h6>
                                            <ol class="mb-0">
                                                <li>Buka aplikasi e-wallet atau mobile banking Anda</li>
                                                <li>Pilih fitur Scan QR atau QRIS</li>
                                                <li>Scan QR Code di atas</li>
                                                <li>Konfirmasi pembayaran sebesar <strong>Rp
                                                        {{ number_format($payment->gross_amount, 0, ',', '.') }}</strong>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                @elseif($payment->payment_type === 'credit_card')
                                    <div class="payment-method-info text-center">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-credit-card text-primary"></i>
                                            Pembayaran Kartu Kredit/Debit
                                        </h6>

                                        @if ($payment->redirect_url && $payment->status === 'pending')
                                            <div class="d-grid gap-2 col-md-6 mx-auto mb-3">
                                                <a href="{{ $payment->redirect_url }}" class="btn btn-primary btn-lg"
                                                    target="_blank">
                                                    <i class="fas fa-external-link-alt"></i>
                                                    Lanjutkan Pembayaran
                                                </a>
                                            </div>
                                        @endif

                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <strong>Penting:</strong> Jangan tutup halaman ini sampai pembayaran selesai.
                                        </div>
                                    </div>
                                @elseif(in_array($payment->payment_type, ['cstore']) && in_array($payment->payment_code, ['indomaret', 'alfamart']))
                                    <div class="payment-method-info">
                                        <div class="text-center mb-4">
                                            <h6 class="fw-bold mb-3">
                                                <i class="fas fa-store text-primary"></i>
                                                Pembayaran di
                                                {{ $payment->payment_code === 'indomaret' ? 'Indomaret' : 'Alfamart' }}
                                            </h6>

                                            <div class="payment-code-display p-3 bg-light rounded">
                                                <small class="text-muted d-block">Kode Pembayaran</small>
                                                <h4 class="fw-bold text-primary mb-2">{{ $payment->payment_code }}</h4>
                                                <button class="btn btn-sm btn-outline-primary"
                                                    onclick="copyToClipboard('{{ $payment->payment_code }}')">
                                                    <i class="fas fa-copy"></i> Salin Kode
                                                </button>
                                            </div>
                                        </div>

                                        <div class="alert alert-info">
                                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Cara Pembayaran:
                                            </h6>
                                            <ol class="mb-0">
                                                <li>Kunjungi
                                                    {{ $payment->payment_code === 'indomaret' ? 'Indomaret' : 'Alfamart' }}
                                                    terdekat</li>
                                                <li>Berikan kode pembayaran: <strong>{{ $payment->payment_code }}</strong>
                                                    kepada kasir</li>
                                                <li>Bayar sebesar <strong>Rp
                                                        {{ number_format($payment->gross_amount, 0, ',', '.') }}</strong>
                                                </li>
                                                <li>Simpan struk pembayaran sebagai bukti</li>
                                            </ol>
                                        </div>
                                    </div>
                                @endif

                                <!-- Cancel Payment Button -->
                                @if ($payment->status === 'pending')
                                    <div class="mt-4 pt-3 border-top">
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal">
                                            <i class="fas fa-times"></i> Batalkan Pembayaran
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Card -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-receipt"></i> Ringkasan Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Product Info -->
                                <div class="d-flex mb-3">
                                    @if ($payment->order->product->image)
                                        <img src="{{ asset('storage/' . $payment->order->product->image) }}"
                                            alt="{{ $payment->order->product->nama_motor }}" class="rounded me-3"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">{{ $payment->order->product->name }}</h6>
                                        <small
                                            class="text-muted">{{ $payment->order->product->category ?? 'Motor' }}</small>
                                    </div>
                                </div>

                                <!-- Customer Info -->
                                <div class="mb-3">
                                    <small class="text-muted d-block">Penyewa</small>
                                    <strong>{{ $payment->order->customer_name }}</strong>
                                </div>

                                <!-- Rental Period -->
                                <div class="mb-3">
                                    <small class="text-muted d-block">Periode Sewa</small>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($payment->order->start_date)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($payment->order->end_date)->format('d M Y') }}
                                    </strong>
                                    <br>
                                </div>

                                <!-- Payment Details -->
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Biaya Admin</span>
                                    <span>Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span class="text-primary">Rp
                                        {{ number_format($payment->gross_amount, 0, ',', '.') }}</span>
                                </div>

                                <!-- Payment Method -->
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted d-block">Metode Pembayaran</small>
                                    <strong>
                                        @php
                                            $paymentMethods = [
                                                'bank_transfer' => 'Transfer Bank ' . strtoupper($payment->bank ?? ''),
                                                'credit_card' => 'Kartu Kredit/Debit',
                                                'gopay' => 'GoPay',
                                                'shopeepay' => 'ShopeePay',
                                                'dana' => 'DANA',
                                                'ovo' => 'OVO',
                                                'qris' => 'QRIS',
                                                'cstore' =>
                                                    $payment->payment_code === 'indomaret' ? 'Indomaret' : 'Alfamart',
                                            ];
                                        @endphp
                                        {{ $paymentMethods[$payment->payment_type] ?? ucfirst($payment->payment_type) }}
                                    </strong>
                                </div>

                                <!-- Transaction Info -->
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted d-block">ID Transaksi</small>
                                    <code>{{ $payment->transaction_id }}</code>
                                    <br><br>
                                    <small class="text-muted d-block">Waktu Dibuat</small>
                                    <small>{{ $payment->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Help Card -->
                        <div class="card shadow-sm mt-3">
                            <div class="card-body text-center">
                                <i class="fas fa-headset text-primary fa-2x mb-3"></i>
                                <h6 class="fw-bold">Butuh Bantuan?</h6>
                                <p class="text-muted small mb-3">Tim customer service kami siap membantu Anda</p>
                                <div class="d-grid gap-2">
                                    <a href="https://wa.me/6281234567890" class="btn btn-success btn-sm" target="_blank">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <a href="tel:+6281234567890" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-phone"></i> Telepon
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Payment Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Batalkan Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan pembayaran ini?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Setelah dibatalkan, Anda perlu membuat pembayaran baru jika ingin
                        melanjutkan pesanan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form action="{{ route('payment.cancel', $payment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .info-box {
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .va-number-display,
        .amount-display,
        .payment-code-display {
            position: relative;
        }

        .qr-code-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #countdown-timer {
            font-family: 'Courier New', monospace;
        }

        .confirmation-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .va-number-display h4,
            .amount-display h4 {
                font-size: 1.2rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- QR Code Generator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>

    <script>
        // Generate QR Code if available
        @if ($payment->qr_string)
            document.addEventListener('DOMContentLoaded', function() {
                const qrContainer = document.getElementById('qrcode');
                if (qrContainer) {
                    QRCode.toCanvas(qrContainer, '{{ $payment->qr_string }}', {
                        width: 200,
                        height: 200,
                        colorDark: '#000000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    }, function(error) {
                        if (error) console.error(error);
                    });
                }
            });
        @endif

        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                toast.innerHTML = '<i class="fas fa-check"></i> Berhasil disalin!';
                toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        // Countdown timer for payment expiry
        @if ($payment->status === 'pending' && $payment->expiry_time > now())
            function updateCountdown() {
                const expiryTime = new Date('{{ $payment->expiry_time->toISOString() }}');
                const now = new Date();
                const timeDiff = expiryTime - now;

                if (timeDiff > 0) {
                    const hours = Math.floor(timeDiff / (1000 * 60 * 60));
                    const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                    const countdownElement = document.getElementById('countdown-timer');
                    if (countdownElement) {
                        countdownElement.innerHTML =
                            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                } else {
                    // Payment expired
                    location.reload();
                }
            }

            // Update countdown every second
            setInterval(updateCountdown, 1000);
            updateCountdown(); // Initial call
        @endif
    </script>
@endpush
