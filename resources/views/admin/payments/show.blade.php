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
    .rental-icon { background: linear-gradient(45deg, #9b59b6, #8e44ad); }
    .timeline-icon { background: linear-gradient(45deg, #3498db, #2980b9); }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #3498db;
        border: 2px solid white;
    }

    .timeline-date {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        margin-top: 5px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 10px;
    }

    .detail-label {
        flex: 0 0 180px;
        font-weight: 600;
        color: #6c757d;
    }

    .detail-value {
        flex: 1;
    }

    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5em 0.8em;
    }
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
                            <div class="d-flex align-items-center">
                                <span class="status-indicator
                                    @if($payment->status == 'pending') bg-warning
                                    @elseif($payment->status == 'success') bg-success
                                    @elseif($payment->status == 'failed') bg-danger
                                    @elseif($payment->status == 'expired') bg-secondary
                                    @else bg-info @endif"></span>
                                <span class="me-3">{{ $payment->status_label }}</span>

                                @if($payment->fraud_status)
                                <span class="badge bg-{{ $payment->fraud_status == 'accept' ? 'success' : 'danger' }}">
                                    Fraud: {{ $payment->fraud_status }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="payment-amount">
                                Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}
                            </div>
                            <div class="mt-2">
                                <small>
                                    @if($payment->transaction_time)
                                        {{ \Carbon\Carbon::parse($payment->transaction_time)->format('d M Y, H:i') }} WIB
                                    @else
                                        {{ $payment->created_at->format('d M Y, H:i') }} WIB
                                    @endif
                                </small>
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

                    <div class="detail-row">
                        <div class="detail-label">Nama Lengkap</div>
                        <div class="detail-value">
                            {{ $payment->order->name ?? $payment->order->user->name ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">
                            {{ $payment->order->email ?? ($payment->order->user->email ?? '-') }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Nomor Telepon</div>
                        <div class="detail-value">
                            {{ $payment->order->phone_number ?? ($payment->order->user->phone ?? '-') }}
                        </div>
                    </div>

                    @if($payment->order->user)
                    <div class="detail-row">
                        <div class="detail-label">Bergabung Sejak</div>
                        <div class="detail-value">
                            {{ $payment->order->user->created_at->format('d M Y') }}
                            ({{ $payment->order->user->created_at->diffForHumans() }})
                        </div>
                    </div>
                    @endif
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

                    <div class="detail-row">
                        <div class="detail-label">ID Pesanan</div>
                        <div class="detail-value">
                            #{{ $payment->order->id }}
                            <span class="badge bg-light text-dark ms-2">{{ $payment->order->tipe_sewa }}</span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Motor</div>
                        <div class="detail-value">
                            {{ $payment->order->product->nama_motor }}
                            <span class="badge bg-light text-dark ms-2">{{ $payment->order->product->brand }}</span>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Nomor Kendaraan</div>
                        <div class="detail-value">
                            {{ $payment->order->product->nomor_kendaraan }}
                            <span class="badge bg-light text-dark ms-2">{{ $payment->order->product->cc_motor }} cc</span>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">  Nomor Mesin</div>
                        <div class="detail-value">
                            {{ $payment->order->product->no_mesin }}
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Nomor Rangka</div>
                        <div class="detail-value">
                            {{ $payment->order->product->no_rangka }}
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Nomor Stnk</div>
                        <div class="detail-value">
                            {{ $payment->order->product->nomor_stnk }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Durasi Sewa</div>
                        <div class="detail-value">
                            {{ $payment->order->durasi_hari }} hari
                            ({{ $payment->order->tanggal_mulai->format('d M Y') }} -
                            {{ $payment->order->tanggal_selesai->format('d M Y') }})
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Total Harga</div>
                        <div class="detail-value">
                            Rp {{ number_format($payment->order->total_harga, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Status Pesanan</div>
                        <div class="detail-value">
                            <span class="badge badge-lg
                                @if($payment->order->status == 'pending') bg-warning text-dark
                                @elseif($payment->order->status == 'confirmed') bg-primary
                                @elseif($payment->order->status == 'ongoing') bg-info
                                @elseif($payment->order->status == 'completed') bg-success
                                @elseif($payment->order->status == 'cancelled') bg-danger
                                @else bg-secondary @endif">
                                {{ $payment->order->status_label }}
                            </span>
                        </div>
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

                    <div class="detail-row">
                        <div class="detail-label">Tipe Pembayaran</div>
                        <div class="detail-value">
                            {{ $payment->payment_type ?? '-' }}
                            @if($payment->payment_type == 'bank_transfer')
                                ({{ $payment->bank }})
                            @endif
                        </div>
                    </div>

                    @if($payment->va_number)
                    <div class="detail-row">
                        <div class="detail-label">Nomor Virtual Account</div>
                        <div class="detail-value">
                            <code>{{ $payment->va_number }}</code>
                        </div>
                    </div>
                    @endif

                    @if($payment->bill_key || $payment->biller_code)
                    <div class="detail-row">
                        <div class="detail-label">Kode Pembayaran</div>
                        <div class="detail-value">
                            @if($payment->bill_key) Bill Key: <code>{{ $payment->bill_key }}</code> @endif
                            @if($payment->biller_code) Biller Code: <code>{{ $payment->biller_code }}</code> @endif
                        </div>
                    </div>
                    @endif

                    <div class="detail-row">
                        <div class="detail-label">Gross Amount</div>
                        <div class="detail-value">
                            Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}
                        </div>
                    </div>

                    @if($payment->currency)
                    <div class="detail-row">
                        <div class="detail-label">Mata Uang</div>
                        <div class="detail-value">
                            {{ $payment->currency }}
                        </div>
                    </div>
                    @endif

                    @if($payment->approval_code)
                    <div class="detail-row">
                        <div class="detail-label">Kode Persetujuan</div>
                        <div class="detail-value">
                            <code>{{ $payment->approval_code }}</code>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Status and Rental Information --}}
        <div class="col-lg-6">
            <div class="card info-card h-100">
                <div class="card-body p-4">
                    <div class="icon-wrapper status-icon">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-chart-line me-2 text-warning"></i>
                        Status & Rental
                    </h5>

                    <div class="detail-row">
                        <div class="detail-label">Status Pembayaran</div>
                        <div class="detail-value">
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
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Status Midtrans</div>
                        <div class="detail-value">
                            {{ $payment->transaction_status_label }}
                        </div>
                    </div>

                    @if($payment->order->product->user)
                    <div class="detail-row">
                        <div class="detail-label">Pemilik Motor</div>
                        <div class="detail-value">
                            {{ $payment->order->product->user->name }}
                            <span class="badge bg-light text-dark ms-2">
                                {{ $payment->order->product->user->phone }}
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="detail-row">
                        <div class="detail-label">Waktu Transaksi</div>
                        <div class="detail-value">
                            @if($payment->transaction_time)
                                <i class="fas fa-clock me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($payment->transaction_time)->format('d F Y, H:i') }} WIB
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    @if($payment->settlement_time)
                    <div class="detail-row">
                        <div class="detail-label">Waktu Settlement</div>
                        <div class="detail-value">
                            <i class="fas fa-clock me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($payment->settlement_time)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                    @endif

                    @if($payment->expiry_time)
                    <div class="detail-row">
                        <div class="detail-label">Waktu Kedaluwarsa</div>
                        <div class="detail-value">
                            <i class="fas fa-clock me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($payment->expiry_time)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline and Additional Info --}}
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card info-card">
                <div class="card-body p-4">
                    <div class="icon-wrapper timeline-icon">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-stream me-2 text-info"></i>
                        Timeline Pembayaran
                    </h5>

                    <div class="timeline">
                        @if($payment->transaction_time)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                {{ \Carbon\Carbon::parse($payment->transaction_time)->format('d M Y, H:i') }}
                            </div>
                            <div class="timeline-content">
                                Transaksi dibuat dengan status:
                                <span class="badge bg-secondary">{{ $payment->transaction_status }}</span>
                            </div>
                        </div>
                        @endif

                        @if($payment->status_history)
                            @foreach(json_decode($payment->status_history, true) as $history)
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($history['time'])->format('d M Y, H:i') }}
                                </div>
                                <div class="timeline-content">
                                    Status berubah menjadi:
                                    <span class="badge bg-{{ $history['status'] == 'success' ? 'success' : 'warning' }}">
                                        {{ $history['status'] }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        @endif

                        @if($payment->settlement_time)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                {{ \Carbon\Carbon::parse($payment->settlement_time)->format('d M Y, H:i') }}
                            </div>
                            <div class="timeline-content">
                                Pembayaran berhasil diselesaikan
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card info-card">
                <div class="card-body p-4">
                    <div class="icon-wrapper rental-icon">
                        <i class="fas fa-store text-white"></i>
                    </div>
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Tambahan
                    </h5>

                    <div class="detail-row">
                        <div class="detail-label">Metode Pembayaran</div>
                        <div class="detail-value">
                            {{ $payment->payment_method ?? 'Bank Transfer' }}
                        </div>
                    </div>

                    @if($payment->order->lokasi_pengambilan)
                    <div class="detail-row">
                        <div class="detail-label">Lokasi Pengambilan</div>
                        <div class="detail-value">
                            {{ $payment->order->lokasi_pengambilan }}
                        </div>
                    </div>
                    @endif

                    @if($payment->order->lokasi_pengembalian)
                    <div class="detail-row">
                        <div class="detail-label">Lokasi Pengembalian</div>
                        <div class="detail-value">
                            {{ $payment->order->lokasi_pengembalian }}
                        </div>
                    </div>
                    @endif

                    @if($payment->order->catatan)
                    <div class="detail-row">
                        <div class="detail-label">Catatan</div>
                        <div class="detail-value">
                            {{ $payment->order->catatan }}
                        </div>
                    </div>
                    @endif

                    @if($payment->order->foto_ktp)
                    <div class="detail-row">
                        <div class="detail-label">Foto KTP</div>
                        <div class="detail-value">
                            <a href="{{ Storage::url($payment->order->foto_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                Lihat KTP
                            </a>
                        </div>
                    </div>
                    @endif
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
                    @if($payment->status == 'pending')
                    <button class="btn btn-success" onclick="refreshPaymentStatus()">
                        <i class="fas fa-sync-alt me-1"></i>
                        Refresh Status
                    </button>
                    @endif

                    @if(Auth::user()->isAdmin())
                    <button class="btn btn-danger" onclick="showRefundModal()">
                        <i class="fas fa-undo me-1"></i>
                        Proses Refund
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
        Swal.fire({
            title: 'Memperbarui Status...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function showRefundModal() {
        const modal = new bootstrap.Modal(document.getElementById('refundModal'));
        modal.show();
    }

    // Auto-refresh for pending payments
    @if($payment->status == 'pending')
    setInterval(() => {
        console.log('Checking payment status...');
    }, 30000);
    @endif
</script>
@endpush
