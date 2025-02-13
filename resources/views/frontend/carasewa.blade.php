@extends('layouts.frontend')

@section('content')
<!-- Header -->
<header class="py-5" style="background-image: url('/images/bgtiga.jpg'); background-size: cover; background-position: center;">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center text-white">
      <h1 class="display-4 fw-bolder"></h1>
      <p class="lead fw-normal text-white-50 mb-0">
        Ikuti langkah dibawah ini untuk menyewa motor
      </p>
    </div>
  </div>
</header>


<!-- Cara Sewa Section -->
<section class="py-5">
  <div class="container px-4 px-lg-5 mt-5">
    <div class="row justify-content-center">
      <!-- Langkah 1 -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <h5 class="fw-bolder">1. Pilih Penyedia Layanan</h5>
            <p>Pilih salah satu penyedia layanan yang tersedia.</p>
          </div>
        </div>
      </div>

      <!-- Panah -->
      <div class="col-md-1 d-flex align-items-center justify-content-center">
        <h1>➡️</h1>
      </div>

      <!-- Langkah 2 -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <h5 class="fw-bolder">2. Pilih Tipe Motor</h5>
            <p>Pilih motor sesuai dengan budget Anda.</p>
          </div>
        </div>
      </div>

      <!-- Panah -->
      <div class="col-md-1 d-flex align-items-center justify-content-center">
        <h1>➡️</h1>
      </div>

      <!-- Langkah 3 -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <h5 class="fw-bolder">3. Pilih Jenis Motor</h5>
            <p>Pilih jenis atau tahun motor yang diinginkan.</p>
          </div>
        </div>
      </div>

      <!-- Langkah 4 -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <h5 class="fw-bolder">4. Pilih Durasi Sewa</h5>
            <p>Pilih durasi sewa per jam atau harian.</p>
          </div>
        </div>
      </div>

      <!-- Panah -->
      <div class="col-md-1 d-flex align-items-center justify-content-center">
        <h1>➡️</h1>
      </div>

      <!-- Langkah 5 -->
      <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <h5 class="fw-bolder">5. Pilih Jenis Transaksi</h5>
            <p>Pilih jenis transaksi COD atau lainnya.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Tombol Sewa -->
    <div class="text-center mt-5">
      <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success btn-lg">
        Nomor whatsapp <i class="ri-whatsapp-line"></i>
      </a>
    </div>
  </div>
</section>
@endsection
