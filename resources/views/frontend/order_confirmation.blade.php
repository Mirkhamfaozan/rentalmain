@extends('layouts.frontend')

@section('content')
<header class="py-5"
    style="background-image: url('/images/bgsatu.jpg'); background-size: cover; background-position: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Konfirmasi Pesanan</h1>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Pesanan Anda Berhasil Dibuat!</h3>

        <div class="row">
            {{-- Detail Produk --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="mb-1"><strong>Vendor:</strong> {{ $product['vendor'] }}</p>
                        <p class="mb-1"><strong>Lokasi:</strong> {{ $product['location'] }}</p>
                        <p class="mb-1"><strong>Harga per Hari:</strong> Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                        <p class="mt-2">{{ $product['description'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Detail Order & Pembayaran --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Detail Pemesanan</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nama:</strong> {{ $order['name'] }}</li>
                            <li class="list-group-item"><strong>No. WhatsApp:</strong> {{ $order['phone'] }}</li>
                            <li class="list-group-item"><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($order['start_date'])->format('d M Y') }}</li>
                            <li class="list-group-item"><strong>Jumlah Hari:</strong> {{ $order['days'] }} hari</li>
                            <li class="list-group-item"><strong>Harga per Hari:</strong> Rp {{ number_format($product['price'], 0, ',', '.') }}</li>
                            <li class="list-group-item bg-light"><strong>Total Biaya:</strong> <span class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</span></li>
                        </ul>

                        <div class="mt-4">
                            <a href="{{ route('frontend.product') }}" class="btn btn-primary">Kembali ke Daftar Produk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
