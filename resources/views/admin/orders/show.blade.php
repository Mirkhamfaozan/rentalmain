@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-description', 'Informasi lengkap tentang pesanan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-hashtag"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nomor Pesanan</span>
                                    <span class="info-box-number">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tanggal Pesanan</span>
                                    <span
                                        class="info-box-number">{{ $order->created_at->translatedFormat('d F Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span
                                    class="info-box-icon
                                    @if ($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'confirmed') bg-success
                                    @elseif($order->status == 'ongoing') bg-info
                                    @elseif($order->status == 'completed') bg-primary
                                    @else bg-danger @endif">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Status Pesanan</span>
                                    <span class="info-box-number">
                                        @switch($order->status)
                                            @case('pending')
                                                Menunggu Pembayaran
                                            @break

                                            @case('confirmed')
                                                Dikonfirmasi
                                            @break

                                            @case('ongoing')
                                                Sedang Berlangsung
                                            @break

                                            @case('completed')
                                                Selesai
                                            @break

                                            @case('cancelled')
                                                Dibatalkan
                                            @break

                                            @default
                                                {{ $order->status }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Informasi Pelanggan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="40%">Nama Lengkap</th>
                                            <td>{{ $order->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $order->email ?? ($order->user->email ?? '-') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor HP/WA</th>
                                            <td>
                                                {{ $order->phone_number }}
                                                @if ($order->phone_number)
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone_number) }}"
                                                        class="btn btn-success btn-sm ms-2" target="_blank">
                                                        <i class="fab fa-whatsapp"></i> Chat WA
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Identitas (KTP)</th>
                                            <td>
                                                @if ($order->foto_ktp)
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#ktpModal">
                                                        <i class="fas fa-id-card me-1"></i> Lihat KTP
                                                    </button>
                                                @else
                                                    <span class="text-muted">Tidak tersedia</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($order->user_id)
                                            <tr>
                                                <th>Akun Terdaftar</th>
                                                <td>
                                                    <span class="badge bg-success">Ya</span>
                                                    <a href="{{ route('dashboard.users.show', $order->user_id) }}"
                                                        class="btn btn-sm btn-outline-info ms-2">
                                                        <i class="fas fa-eye me-1"></i> Lihat Profil
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-motorcycle me-2"></i>Detail Penyewaan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="40%">Tipe Sewa</th>
                                            <td>
                                                <span class="badge bg-primary">{{ ucfirst($order->tipe_sewa) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td>
                                                <i class="far fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($order->tanggal_mulai)->translatedFormat('d F Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Selesai</th>
                                            <td>
                                                <i class="far fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($order->tanggal_selesai)->translatedFormat('d F Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Durasi</th>
                                            <td>
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $order->durasi_hari }} hari
                                                ({{ \Carbon\Carbon::parse($order->tanggal_mulai)->diffInDays($order->tanggal_selesai) }}
                                                hari)
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Harga</th>
                                            <td>
                                                <span class="fw-bold text-primary">Rp
                                                    {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi Pengambilan</th>
                                            <td>{{ $order->lokasi_pengambilan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi Pengembalian</th>
                                            <td>{{ $order->lokasi_pengembalian ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bike me-2"></i>Detail Motor
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                @if ($order->product->gambar_utama)
                                    <img src="{{ Storage::url($order->product->gambar_utama) }}" class="img-thumbnail me-3"
                                        style="width: 150px; height: auto;" alt="{{ $order->product->nama_motor }}">
                                @else
                                    <div class="bg-light p-3 text-center rounded me-3" style="width: 150px;">
                                        <i class="fas fa-motorcycle fa-3x text-secondary"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h5 class="mb-2">{{ $order->product->nama_motor }}</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="mb-1"><small class="text-muted">Brand:</small>
                                                {{ $order->product->brand }}</p>
                                            <p class="mb-1"><small class="text-muted">Tahun:</small>
                                                {{ $order->product->tahun_produksi }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1"><small class="text-muted">Transmisi:</small>
                                                {{ ucfirst($order->product->transmisi_motor) }}</p>
                                            <p class="mb-1"><small class="text-muted">Kapasitas:</small>
                                                {{ $order->product->kapasitas_mesin }} CC</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1"><small class="text-muted">Nomer Kendaran:</small>
                                                {{ ucfirst($order->product->nomor_kendaraan) }}</p>
                                            <p class="mb-1"><small class="text-muted">Nomer Stnk:</small>
                                                {{ $order->product->nomer_stnk }} CC</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1"><small class="text-muted">Nomer Mesin:</small>
                                                {{ ucfirst($order->product->no_mesin) }}</p>
                                            <p class="mb-1"><small class="text-muted">Nomer Ranka:</small>
                                                {{ $order->product->no_rangka }} CC</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('dashboard.products.show', $order->product_id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-info-circle me-1"></i> Detail Motor
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-alt me-2"></i>Informasi Tambahan
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3"><i class="fas fa-sticky-note me-2"></i>Catatan Pesanan</h6>
                            <div class="bg-light p-3 rounded mb-4">
                                @if ($order->catatan)
                                    {{ $order->catatan }}
                                @else
                                    <span class="text-muted">Tidak ada catatan</span>
                                @endif
                            </div>

                            @if ($order->payment)
                                <h6 class="mb-3"><i class="fas fa-money-bill-wave me-2"></i>Informasi Pembayaran</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th width="40%">Metode Pembayaran</th>
                                            <td>{{ $order->payment->metode_pembayaran ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Pembayaran</th>
                                            <td>
                                                <span
                                                    class="badge
                                                @if ($order->payment->status == 'pending') bg-warning
                                                @elseif($order->payment->status == 'paid') bg-success
                                                @elseif($order->payment->status == 'failed') bg-danger
                                                @else bg-secondary @endif">
                                                    {{ ucfirst($order->payment->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pembayaran</th>
                                            <td>{{ $order->payment->created_at->translatedFormat('d F Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bukti Pembayaran</th>
                                            <td>
                                                @if ($order->payment->bukti_pembayaran)
                                                    <a href="{{ Storage::url($order->payment->bukti_pembayaran) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-image me-1"></i> Lihat Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak tersedia</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="btn-group" role="group">
                        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="{{ route('dashboard.orders.edit', $order) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Pesanan
                        </a>
                        @if ($order->status == 'ongoing')
                            <form action="{{ route('dashboard.orders.update-status', $order) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH') 
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Apakah Anda yakin ingin menyelesaikan pesanan ini?')">
                                    <i class="fas fa-check me-1"></i> Selesaikan Pesanan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- KTP Modal -->
            <div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="ktpModalLabel">Foto KTP - {{ $order->name }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            @if ($order->foto_ktp)
                                <img src="{{ asset('storage/' . str_replace('public/', '', $order->foto_ktp)) }}"
                                    class="img-fluid rounded" alt="Foto KTP" style="max-height: 70vh;">
                            @else
                                <p class="text-muted">Tidak ada foto KTP</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Tutup
                            </button>
                            @if ($order->foto_ktp)
                                <a href="{{ asset('storage/' . str_replace('public/', '', $order->foto_ktp)) }}"
                                    download="KTP-{{ $order->name }}.jpg" class="btn btn-primary">
                                    <i class="fas fa-download me-1"></i> Unduh
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .info-box {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .info-box-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            font-size: 24px;
            border-radius: 8px;
            margin-right: 15px;
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-text {
            display: block;
            font-size: 14px;
            color: #6c757d;
        }

        .info-box-number {
            display: block;
            font-size: 18px;
            font-weight: 600;
        }

        .card-header {
            border-radius: 8px 8px 0 0 !important;
        }

        .table-borderless th {
            padding-left: 0;
            color: #6c757d;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        /* Modal fixes */
        .modal-open {
            overflow: hidden !important;
        }

        .modal-backdrop {
            z-index: 1040;
        }

        .modal {
            z-index: 1050;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .info-box {
                margin-bottom: 15px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cleanup modal state saat modal ditutup untuk mencegah halaman stuck
            const ktpModal = document.getElementById('ktpModal');

            if (ktpModal) {
                // Event listener untuk cleanup saat modal disembunyikan
                ktpModal.addEventListener('hidden.bs.modal', function() {
                    // Force cleanup modal state
                    setTimeout(() => {
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';

                        // Remove any leftover modal backdrops
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => {
                            backdrop.remove();
                        });
                    }, 100);
                });

                // Event listener untuk cleanup saat modal error
                ktpModal.addEventListener('hide.bs.modal', function() {
                    // Pastikan modal bisa ditutup
                    document.body.style.overflow = '';
                });
            }

            // Global error handler untuk modal yang stuck
            window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    // Force close modal jika ESC ditekan
                    const openModal = document.querySelector('.modal.show');
                    if (openModal) {
                        const modalInstance = bootstrap.Modal.getInstance(openModal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                }
            });
        });

        // Function untuk force close modal jika terjadi masalah
        function forceCloseModal() {
            const openModals = document.querySelectorAll('.modal.show');
            const backdrops = document.querySelectorAll('.modal-backdrop');

            openModals.forEach(modal => {
                modal.classList.remove('show');
                modal.style.display = 'none';
            });

            backdrops.forEach(backdrop => backdrop.remove());

            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
    </script>
@endpush
