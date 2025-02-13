@extends('layouts.frontend')

@section('content')
<header class="py-5" style="background-image: url('/images/bgsatu.jpg'); background-size: cover; background-position: center;">
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
                <option selected>Wilayah</option>
                <option value="tegal_selatan">Tegal Selatan</option>
                <option value="tegal_utara">Tegal Timur</option>
            </select>
            <button class="btn btn-primary">Konfirmasi</button>
        </div>

        <!-- Daftar Motor -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Honda Vario 2020 -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/vario.jpg" class="card-img-top" alt="Honda Vario 2020">
                    <div class="card-body">
                        <h5 class="card-title">Honda Vario 2020</h5>
                        <p class="card-text">Ale Sewa Motor</p>
                        <p class="text-primary fw-bold">Rp. 90.000 / Hari</p>
                        <p><i class="bi bi-geo-alt-fill"></i> Kramat</p>
                    </div>
                    <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a
                class="btn btn-info mt-auto text-white"
                href="{{ route('frontend.detail2') }}">Detail</a>
            </div>
                </div>
            </div>

            <!-- Honda PCX 2021 -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/pcx21.png" class="card-img-top" alt="Honda PCX 2021">
                    <div class="card-body">
                        <h5 class="card-title">Honda PCX 2021</h5>
                        <p class="card-text">Balakosa Motor Tegal</p>
                        <p class="text-primary fw-bold">Rp. 120.000 / Hari</p>
                        <p><i class="bi bi-geo-alt-fill"></i> Kramat</p>
                    </div>
                    <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a
                class="btn btn-info mt-auto text-white"
                href="{{ route('frontend.detail2') }}">Detail</a>
            </div>
                </div>
            </div>

            <!-- Honda Scoopy 2018 -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/scoopy.jpg" class="card-img-top" alt="Honda Scoopy 2018">
                    <div class="card-body">
                        <h5 class="card-title">Honda Scoopy 2018</h5>
                        <p class="card-text">Sewa Motor ASRI TIGA</p>
                        <p class="text-primary fw-bold">Rp. 60.000 / Hari</p>
                        <p><i class="bi bi-geo-alt-fill"></i> Tegal Timur</p>
                    </div>
                    
            <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a
                class="btn btn-info mt-auto text-white"
                href="{{ route('frontend.detail3') }}">Detail</a>
            </div>
                </div>
            </div>

            <!-- Yamaha Aerox 2018 -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/aerox1.png" class="card-img-top" alt="Yamaha Aerox 2018">
                    <div class="card-body">
                        <h5 class="card-title">Yamaha Aerox 2018</h5>
                        <p class="card-text">Lavanya Motor</p>
                        <p class="text-primary fw-bold">Rp. 80.000 / Hari</p>
                        <p><i class="bi bi-geo-alt-fill"></i> Tegal Timur</p>
                    </div>
                    <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a
                class="btn btn-info mt-auto text-white"
                href="{{ route('frontend.detail2') }}">Detail</a>
            </div>
                </div>
            </div>

            <!-- nmax 2021 -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/nmax21.png" class="card-img-top" alt="Yamaha NMAX 2021">
                    <div class="card-body">
                        <h5 class="card-title">Yamaha NMAX 2021</h5>
                        <p class="card-text">Sewa Motor ASRI TIGA</p>
                        <p class="text-primary fw-bold">Rp. 100.000 / Hari</p>
                        <p><i class="bi bi-geo-alt-fill"></i> Tegal Timur</p>
                    </div>
                    
            <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a
                class="btn btn-info mt-auto text-white"
                href="{{ route('frontend.detail3') }}">Detail</a>
            </div>
                </div>
            </div>

            <!-- Honda Scoopy 2018 -->
            <div class="col">
                <div class="card h-100">
                    <img src="images/pcx23.jpeg" class="card-img-top" alt="Honda PCX 2023">
                    <div class="card-body">
                        <h5 class="card-title">Honda PCX 2023</h5>
                        <p class="card-text">Sewa Motor ASRI TIGA</p>
                        <p class="text-primary fw-bold">Rp. 100.000 / Hari</p>
                        <p><i class="bi bi-geo-alt-fill"></i> Tegal Timur</p>
                    </div>
                    
            <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a
                class="btn btn-info mt-auto text-white"
                href="{{ route('frontend.detail3') }}">Detail</a>
            </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
