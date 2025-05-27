@extends('layouts.frontend')

@section('content')
    <header class="py-5"
        style="background-image: url('/images/bgsatu.jpg'); background-size: cover; background-position: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Pilihan Motor</h1>
                <p class="lead fw-normal text-white-50 mb-0">
                    hanya dengan satu sentuhan
                </p>
            </div>
        </div>
    </header>


    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <!-- Filter Wilayah -->
            <div class="d-flex justify-content-center mb-4">
                <select class="form-select me-2" style="width: 200px;">
                    <option selected>Pilih Wilayah</option>
                    <option value="kota">Kota</option>
                    <option value="kabupaten">Kabupaten</option>
                </select>
                <select class="form-select me-2" style="width: 200px;">
                    <option selected>Harga</option>
                    <option value="termurah">Termurah</option>
                    <option value="termahal">Termahal</option>
                </select>
                <button class="btn btn-primary">Konfirmasi</button>
            </div>

            <!-- Daftar Motor -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['name'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] }}</h5>
                                <p class="card-text">{{ $product['vendor'] }}</p>
                                <p class="text-primary fw-bold">Rp. {{ number_format($product['price'], 0, ',', '.') }} /
                                    Hari</p>
                                <p><i class="bi bi-geo-alt-fill"></i> {{ $product['location'] }}</p>
                            </div>
                            <div class="text-center mb-3">
                                <a href="{{ route('frontend.order', ['id' => $product['id']]) }}" class="btn btn-success mt-auto text-white">Sewa Sekarang</a>

                                <a class="btn btn-info mt-auto text-white"
                                    href="{{ route('frontend.detail', ['id' => 1]) }}">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
