@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-description', 'Informasi lengkap tentang pesanan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor Pesanan</label>
                                <p class="form-control-static">#{{ $order->id }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pesanan</label>
                                <p class="form-control-static">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <p class="form-control-static">
                                    <span
                                        class="badge
                                    @if ($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'confirmed') bg-success
                                    @elseif($order->status == 'ongoing') bg-info
                                    @elseif($order->status == 'completed') bg-primary
                                    @else bg-danger @endif">
                                        @switch($order->status)
                                            @case('pending')
                                                Sedang Pembayaran
                                            @break
                                            @case('confirmed')
                                                Sudah Bayar
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
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipe Sewa</label>
                                <p class="form-control-static">{{ ucfirst($order->tipe_sewa) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <p class="form-control-static">
                                    {{ \Carbon\Carbon::parse($order->tanggal_mulai)->format('d/m/Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <p class="form-control-static">
                                    {{ \Carbon\Carbon::parse($order->tanggal_selesai)->format('d/m/Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Durasi</label>
                                <p class="form-control-static">{{ $order->durasi_hari }} hari</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Harga</label>
                                <p class="form-control-static fw-bold">Rp
                                    {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <p class="form-control-static">{{ $order->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <p class="form-control-static">{{ $order->email ?? ($order->user->email ?? '-') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <p class="form-control-static">{{ $order->phone_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Foto KTP</label>
                                @if ($order->foto_ktp)
                                    <div>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#ktpModal" class="d-inline-block mb-2">
                                            <img src="{{ asset('storage/' . str_replace('public/', '', $order->foto_ktp)) }}"
                                                 class="ktp-preview" alt="Foto KTP">
                                        </a>
                                        <small class="text-muted d-block">Klik gambar untuk memperbesar</small>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada foto KTP</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Motor</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Motor</label>
                                <p class="form-control-static">{{ $order->product->nama_motor }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Brand</label>
                                <p class="form-control-static">{{ $order->product->brand }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <p class="form-control-static">{{ $order->product->tahun }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gambar Motor</label>
                                @if ($order->product->gambar_utama)
                                    <img src="{{ Storage::url($order->product->gambar_utama) }}" class="img-thumbnail"
                                        style="max-width: 200px; height: auto;" alt="{{ $order->product->nama_motor }}">
                                @else
                                    <div class="bg-light p-3 text-center rounded">
                                        <i class="fas fa-motorcycle fa-3x text-secondary"></i>
                                        <p class="mt-2 mb-0">Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Tambahan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lokasi Pengambilan</label>
                                <p class="form-control-static">{{ $order->lokasi_pengambilan ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lokasi Pengembalian</label>
                                <p class="form-control-static">{{ $order->lokasi_pengembalian ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <p class="form-control-static">{{ $order->catatan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KTP Modal -->
            <div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ktpModalLabel">Foto KTP - {{ $order->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            @if ($order->foto_ktp)
                                <img src="{{ asset('storage/' . str_replace('public/', '', $order->foto_ktp)) }}"
                                     class="img-fluid" alt="Foto KTP" style="max-height: 70vh;">
                            @else
                                <p class="text-muted">Tidak ada foto KTP</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('dashboard.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <a href="{{ route('dashboard.orders.edit', $order) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Edit Pesanan
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .ktp-preview {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ktp-preview:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-control-static {
            min-height: 1.5em;
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
            margin-bottom: 0;
        }

        /* Modal styling */
        #ktpModal .modal-content {
            border-radius: 10px;
        }

        #ktpModal .modal-header {
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
        }

        #ktpModal .modal-title {
            font-weight: 600;
        }

        #ktpModal .modal-body {
            padding: 20px;
            background-color: #fcfcfc;
        }

        #ktpModal .modal-footer {
            border-top: 1px solid #eee;
            background-color: #f8f9fa;
        }

        #ktpModal .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        #ktpModal .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle KTP preview click
            document.querySelectorAll('.ktp-preview').forEach(img => {
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modal = new bootstrap.Modal(document.getElementById('ktpModal'));
                    modal.show();
                });
            });

            // Handle modal close when clicking outside
            const ktpModal = document.getElementById('ktpModal');
            if (ktpModal) {
                ktpModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        const modal = bootstrap.Modal.getInstance(this);
                        modal.hide();
                    }
                });

                // Prevent modal close when clicking inside modal content
                ktpModal.querySelector('.modal-content').addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                // Ensure backdrop and modal-open class are removed when modal is hidden
                ktpModal.addEventListener('hidden.bs.modal', function () {
                    // Remove all modal backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                    // Remove modal-open class and restore body styles
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = 'auto';
                    document.body.style.paddingRight = '';
                });
            }
        });
    </script>
@endpush
