@extends('layouts.frontend')

@section('content')
<header class="py-5"
    style="background-image: url('/images/bgsatu.jpg'); background-size: cover; background-position: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Form Sewa Motor</h1>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Sewa: {{ $product['name'] }}</h3>

        {{-- Detail Barang dan Form Sewa --}}
        <div class="row">
            {{-- Kolom Kiri: Detail Barang --}}
            <div class="col-md-6 mb-4">
                <img src="{{ asset($product['image']) }}" class="img-fluid rounded mb-3" alt="{{ $product['name'] }}">
                <h4>{{ $product['name'] }}</h4>
                <p><strong>Vendor:</strong> {{ $product['vendor'] }}</p>
                <p><strong>Lokasi:</strong> {{ $product['location'] }}</p>
                <p><strong>Harga per Hari:</strong> Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                <p>{{ $product['description'] }}</p>
            </div>

            {{-- Kolom Kanan: Form Sewa --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('frontend.order.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Penyewa</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor WhatsApp</label>
                                <input type="text" class="form-control" name="phone" required>
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai Sewa</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>

                            <div class="mb-3">
                                <label for="days" class="form-label">Jumlah Hari Sewa</label>
                                <input type="number" class="form-control" name="days" min="1" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Submit Pesanan</button>
                                <a href="{{ route('frontend.product') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
