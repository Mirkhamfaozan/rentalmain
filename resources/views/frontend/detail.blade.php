@extends('layouts.frontend')

@section('content')
    <header class="py-5"
        style="background-image: url('/images/bgsatu.jpg'); background-size: cover; background-position: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Detail Motor</h1>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset($product['image']) }}" class="img-fluid rounded shadow" alt="{{ $product['name'] }}">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold">{{ $product['name'] }}</h2>
                    <p><strong>Pemilik:</strong> {{ $product['vendor'] }}</p>
                    <p><strong>Harga Sewa:</strong>
                        <span class="text-primary fw-bold">Rp. {{ number_format($product['price'], 0, ',', '.') }} / Hari</span>
                    </p>
                    <p><strong>Lokasi:</strong> {{ $product['location'] }}</p>

                    <!-- Tambahan Informasi -->
                    <hr>
                    <h5>Spesifikasi:</h5>
                    <ul class="list-unstyled">
                        <li><strong>Bahan Bakar:</strong> {{ $product['fuel'] }}</li>
                        <li><strong>Kapasitas Mesin:</strong> {{ $product['cc'] }} cc</li>
                        <li><strong>Transmisi:</strong> {{ $product['transmission'] }}</li>
                        <li>
                            <strong>Ketersediaan:</strong>
                            @if($product['available'])
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger">Tidak Tersedia</span>
                            @endif
                        </li>
                    </ul>

                    <hr>
                    <h5>Deskripsi:</h5>
                    <p>{{ $product['description'] }}</p>

                    <!-- Tombol Aksi -->
                    @if($product['available'])
                        <a href="{{ route('frontend.order', ['id' => $product['id']]) }}" class="btn btn-success mt-3">
                            Sewa Sekarang
                        </a>
                    @else
                        <button class="btn btn-secondary mt-3" disabled>Motor Tidak Tersedia</button>
                    @endif
                    <a href="{{ route('frontend.product') }}" class="btn btn-outline-secondary mt-3 ms-2">Kembali</a>
                </div>
            </div>

            <!-- Rekomendasi Produk -->
            <div class="mt-5">
                <h3 class="mb-4">Rekomendasi Produk Lainnya</h3>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($recommendations as $rec)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset($rec['image']) }}" class="card-img-top" alt="{{ $rec['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $rec['name'] }}</h5>
                                    <p class="text-primary fw-bold">Rp. {{ number_format($rec['price'], 0, ',', '.') }} / Hari</p>
                                    <p class="text-muted small">{{ $rec['location'] }}</p>
                                </div>
                                <div class="text-center mb-3">
                                    <a href="{{ route('frontend.detail', ['id' => $rec['id']]) }}"
                                        class="btn btn-info text-white">Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
