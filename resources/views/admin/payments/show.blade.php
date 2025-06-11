@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-description', 'Informasi lengkap tentang pembayaran.')

@push('styles')
<style>
    .payment-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .payment-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
    }

    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    .info-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 500;
        color: #2d3748;
        margin-bottom: 20px;
    }

    .payment-amount {
        font-size: 2rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .transaction-id {
        font-family: 'Courier New', monospace;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
    }

    .back-btn {
        background: linear-gradient(45deg, #6c5ce7, #a29bfe);
        border: none;
        border-radius: 25px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        color: white;
    }

    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, #e9ecef, transparent);
        margin: 30px 0;
    }

    .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .customer-icon { background: linear-gradient(45deg, #ff6b6b, #ffa8a8); }
    .order-icon { background: linear-gradient(45deg, #4ecdc4, #7fcdcd); }
    .payment-icon { background: linear-gradient(45deg, #45b7d1, #96ceb4); }
    .status-icon { background: linear-gradient(45deg, #f39c12, #f1c40f); }
</style>
@endpush

@section('content')
    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Main Payment Card --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card payment-card">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-3">
                                <i class="fas fa-credit-card me-2"></i>
                                Detail Pembayaran
                            </h2>
                            <div class="transaction-id mb-3">
                                ID: {{ $payment->transaction_id }}
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="payment-amount">
                                Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}
                            </div>
                            <div class="mt-2">
                                <span class="status-indicator
                                    @if($payment->status == 'pending') bg-warning
                                    @elseif($payment->status == 'success') bg-success
                                    @elseif($payment->status == 'failed') bg-danger
                                    @elseif($payment->status == 'expired') bg-secondary
                                    @else bg-info @endif"></span>
                                {{ $payment->status_label }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Information Cards --}}
    <div class="row g-4 mb-4">
        {{-- Customer Information --}}
        <div class="col-lg-6">
            <div class="card info-card h-100">
                <div class="card-body p-4">
                    <div class="icon-wrapper customer-icon">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-user-circle me-2 text-primary"></i>
                        Informasi Pelanggan
                    </h5>

                    <div class="info-label">Nama Pelanggan</div>
                    <div class="info-value">
                        {{ $payment->order->name ?? $payment->order->user->name ?? '-' }}
                    </div>

                    <div class="info-label">Email</div>
                    <div class="info-value">
                        {{ $payment->order->email ?? ($payment->order->user->email ?? '-') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Information --}}
        <div class="col-lg-6">
            <div class="card info-card h-100">
                <div class="card-body p-4">
                    <div class="icon-wrapper order-icon">
                        <i class="fas fa-motorcycle text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-shopping-cart me-2 text-success"></i>
                        Informasi Pesanan
                    </h5>

                    <div class="info-label">ID Pesanan</div>
                    <div class="info-value">
                        #{{ $payment->order->id }} ({{ $payment->order->tipe_sewa }})
                    </div>

                    <div class="info-label">Motor</div>
                    <div class="info-value">
                        {{ $payment->order->product->nama_motor }}
                        <span class="badge bg-light text-dark ms-2">{{ $payment->order->product->brand }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- Payment Information --}}
        <div class="col-lg-6">
            <div class="card info-card h-100">
                <div class="card-body p-4">
                    <div class="icon-wrapper payment-icon">
                        <i class="fas fa-credit-card text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-money-bill-wave me-2 text-info"></i>
                        Detail Pembayaran
                    </h5>

                    <div class="info-label">Tipe Pembayaran</div>
                    <div class="info-value">
                        {{ $payment->payment_type ?? '-' }}
                    </div>

                    <div class="info-label">Bank</div>
                    <div class="info-value">
                        {{ $payment->bank ?? '-' }}
                    </div>

                    @if($payment->va_number)
                    <div class="info-label">Nomor Virtual Account</div>
                    <div class="info-value">
                        <code class="bg-light p-2 rounded">{{ $payment->va_number }}</code>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Status Information --}}
        <div class="col-lg-6">
            <div class="card info-card h-100">
                <div class="card-body p-4">
                    <div class="icon-wrapper status-icon">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-chart-line me-2 text-warning"></i>
                        Status Transaksi
                    </h5>

                    <div class="info-label">Status Pembayaran</div>
                    <div class="info-value">
                        <span class="badge badge-lg
                            @if($payment->status == 'pending') bg-warning text-dark
                            @elseif($payment->status == 'success') bg-success
                            @elseif($payment->status == 'failed') bg-danger
                            @elseif($payment->status == 'expired') bg-secondary
                            @else bg-info @endif">
                            <i class="fas fa-circle me-1"></i>
                            {{ $payment->status_label }}
                        </span>
                    </div>

                    <div class="info-label">Status Midtrans</div>
                    <div class="info-value">
                        {{ $payment->transaction_status_label }}
                    </div>

                    <div class="info-label">Waktu Transaksi</div>
                    <div class="info-value">
                        @if($payment->transaction_time)
                            <i class="fas fa-clock me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($payment->transaction_time)->format('d F Y, H:i') }} WIB
                        @else
                            -
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="row">
        <div class="col-12">
            <div class="d-flex gap-3 justify-content-between align-items-center">
                <a href="{{ route('dashboard.payments.index') }}" class="btn back-btn">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Daftar Pembayaran
                </a>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>
                        Cetak
                    </button>

                    @if($payment->status == 'pending')
                    <button class="btn btn-success" onclick="refreshPaymentStatus()">
                        <i class="fas fa-sync-alt me-1"></i>
                        Refresh Status
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function refreshPaymentStatus() {
        // Add your payment status refresh logic here
        Swal.fire({
            title: 'Memperbarui Status...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                // Make AJAX call to refresh payment status
                // You can implement this based on your backend API
            }
        });
    }

    // Auto-refresh for pending payments
    @if($payment->status == 'pending')
    setInterval(() => {
        // Implement auto-refresh logic for pending payments
        console.log('Checking payment status...');
    }, 30000); // Check every 30 seconds
    @endif
</script>
@endpush
