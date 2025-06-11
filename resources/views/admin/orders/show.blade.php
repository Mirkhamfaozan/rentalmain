@extends('layouts.app')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-description', 'Lihat detail pesanan sewa motor.')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="card-title mb-0">Pesanan #{{ $order->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">Informasi Pelanggan</h6>
                        <div class="mb-2">
                            <span class="fw-semibold">Nama:</span> {{ $order->name ?? '-' }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Email:</span> {{ $order->email ?? ($order->user->email ?? '-') }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Nomor HP:</span> {{ $order->phone_number ?? '-' }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Pengguna:</span> {{ $order->user ? $order->user->name : 'Tanpa Pengguna' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">Informasi Motor</h6>
                        <div class="d-flex align-items-center mb-2">
                            @if($order->product->gambar_utama)
                                <img src="{{ Storage::url($order->product->gambar_utama) }}"
                                     class="rounded me-3"
                                     style="width: 64px; height: 64px; object-fit: cover;"
                                     alt="{{ $order->product->nama_motor }}"
                                     loading="lazy">
                            @else
                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                     style="width: 64px; height: 64px; font-size: 24px;">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold">{{ $order->product->nama_motor }}</div>
                                <div class="text-muted small">{{ $order->product->brand }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">Detail Sewa</h6>
                        <div class="mb-2">
                            <span class="fw-semibold">Tanggal Mulai:</span> {{ \Carbon\Carbon::parse($order->tanggal_mulai)->format('d/m/Y') }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Tanggal Selesai:</span> {{ \Carbon\Carbon::parse($order->tanggal_selesai)->format('d/m/Y') }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Durasi:</span> {{ $order->durasi_hari }} hari
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Tipe Sewa:</span> {{ ucfirst($order->tipe_sewa) }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Total Harga:</span> Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold mb-3">Status & Lokasi</h6>
                        <div class="mb-2">
                            <span class="fw-semibold">Status:</span>
                            <span class="badge
                                @if($order->status == 'pending') bg-warning-subtle text-warning
                                @elseif($order->status == 'confirmed') bg-success-subtle text-success
                                @elseif($order->status == 'ongoing') bg-info-subtle text-info
                                @elseif($order->status == 'completed') bg-primary-subtle text-primary
                                @else bg-danger-subtle text-danger @endif">
                                {{ $order->getStatusLabelAttribute() }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Lokasi Pengambilan:</span> {{ $order->lokasi_pengambilan ?? '-' }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-semibold">Lokasi Pengembalian:</span> {{ $order->lokasi_pengembalian ?? '-' }}
                        </div>
                    </div>
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">Catatan</h6>
                        <p>{{ $order->catatan ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard.orders.edit', $order) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Pesanan
                    </a>
                    <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Hapus Pesanan
                        </button>
                    </form>
                    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
