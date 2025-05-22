@extends('layouts.frontend')

@section('content')
<header class="py-5" style="background-image: url('/images/bg.jpg'); background-size: cover; background-position: center;">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center text-white">
      <h1 class="display-4 fw-bolder">Sewa Motor</h1>
      <p class="lead fw-normal text-white-50 mb-0">hanya dengan satu sentuhan</p>
    </div>
  </div>
</header>

<div class="site-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 text-center">
          <div class="img-wrap-1 mb-5">
            <img class="img-fluid w-75" src="images/pcx23.jpeg" alt="Pelayanan Terbaik">
          </div>
        </div>
        <div class="col-lg-5">
          <h3 class="mb-4 section-heading"><strong>Kami berkomitmen untuk memberikan pelayanan terbaik</strong></h3>
          <p class="mb-5">Dengan memastikan setiap pelanggan mendapatkan pengalaman sewa motor yang nyaman, aman, dan memuaskan. Kepuasan Anda adalah prioritas kami, dan kami selalu berusaha memberikan layanan berkualitas tinggi dengan kendaraan yang terawat serta proses sewa yang mudah dan cepat</p>
          <p><a href="#" class="btn btn-primary">Kontak Kami</a></p>
        </div>
      </div>
    </div>
  </div>

<!-- Section-->
<section class="py-5">
  <div class="container px-4 px-lg-5 mt-5">
    <h3 class="text-center mb-5">Daftar Motor</h3>
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col mb-5">
        <div class="card h-100">
          <div class="badge badge-custom bg-warning text-white position-absolute" style="top: 0; right: 0">Tidak Tersedia</div>
          <img class="card-img-top" src="images/beat.jpg" alt="...">
          <div class="card-body pt-4">
            <div class="text-center">
              <h5 class="fw-bolder">Special Item</h5>
              <div class="rent-price mb-3">
                <span class="text-primary">Rp.60.000/</span>day
              </div>
              <ul class="list-unstyled">
                <li class="border-bottom p-2 d-flex justify-content-between"><span>Bahan bakar</span><span class="fw-bold">Bensin</span></li>
                <li class="border-bottom p-2 d-flex justify-content-between"><span>CC</span><span class="fw-bold">110</span></li>
                <li class="border-bottom p-2 d-flex justify-content-between"><span>Transmisi</span><span class="fw-bold">Matic</span></li>
              </ul>
            </div>
          </div>
          <div class="card-footer border-top-0 bg-transparent">
            <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a class="btn btn-info mt-auto text-white" href="{{ route('frontend.detail1') }}">Detail</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col mb-5">
        <div class="card h-100">
          <div class="badge badge-custom bg-success text-white position-absolute" style="top: 0; right: 0">Tersedia</div>
          <img class="card-img-top" src="images/vario.jpg" alt="...">
          <div class="card-body pt-4">
            <div class="text-center">
              <h5 class="fw-bolder">Special Item</h5>
              <div class="rent-price mb-3">
                <span class="text-primary">Rp.90.000/</span>day
              </div>
              <ul class="list-unstyled">
                <li class="border-bottom p-2 d-flex justify-content-between"><span>Bahan bakar</span><span class="fw-bold">Bensin</span></li>
                <li class="border-bottom p-2 d-flex justify-content-between"><span>CC</span><span class="fw-bold">150</span></li>
                <li class="border-bottom p-2 d-flex justify-content-between"><span>Transmisi</span><span class="fw-bold">Matic</span></li>
              </ul>
            </div>
          </div>
          <div class="card-footer border-top-0 bg-transparent">
            <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a class="btn btn-info mt-auto text-white" href="{{ route('frontend.detail2') }}">Detail</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col mb-5">
        <div class="card h-100">
          <div class="badge badge-custom bg-success text-white position-absolute" style="top: 0; right: 0">Tersedia</div>
          <img class="card-img-top" src="images/scoopy.jpg" alt="...">
          <div class="card-body pt-4">
            <div class="text-center">
              <h5 class="fw-bolder">Special Item</h5>
              <div class="rent-price mb-3">
                <span class="text-primary">Rp.60.000/</span>day
              </div>
              <ul class="list-unstyled">
                <li class="border-bottom p-2 d-flex justify-content-between"><span>Bahan bakar</span><span class="fw-bold">Bensin</span></li>
                <li class="border-bottom p-2 d-flex justify-content-between"><span>CC</span><span class="fw-bold">110</span></li>
                <li class="border-bottom p-2 d-flex justify-content-between"><span>Transmisi</span><span class="fw-bold">Matic</span></li>
              </ul>
            </div>
          </div>
          <div class="card-footer border-top-0 bg-transparent">
            <div class="text-center">
              <a class="btn btn-primary mt-auto" href="#">Sewa</a>
              <a class="btn btn-info mt-auto text-white" href="{{ route('frontend.detail3') }}">Detail</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- About Section -->
  
</section>
@endsection
