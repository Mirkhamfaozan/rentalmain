@extends('layouts.frontend')

@section('content')
<header class="bg-dark py-5">
      <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
          <h1 class="display-4 fw-bolder">Detail Motor</h1>
        </div>
      </div>
    </header>
    <!-- Section-->
    <section class="py-5">
      <div class="container px-4 px-lg-5 mt-5">
        <div class="row justify-content-center">
          <div class="col-lg-8 mb-5">
            <div class="card h-100">
              <!-- Product image-->
              <img
                class="card-img-top"
                src="images/vario.jpg"
                alt="..."
              />
              <!-- Product details-->
              <div class="card-body card-body-custom pt-4">
                <div>
                  <!-- Product name-->
                  <h3 class="fw-bolder text-primary">Deskripsi</h3>
                  <p>
                  Honda Vario 150 adalah skuter matik (skutik) premium dari Honda yang mengusung desain sporty dan modern dengan performa mesin yang lebih bertenaga. Motor ini sangat populer di kalangan anak muda dan pekerja urban karena tampilannya yang agresif, fitur lengkap, dan mesin yang responsif.
                  </p>

                  <p>
                  Spesifikasi Umum Honda Vario 150:
Mesin: 150 cc, 4-langkah, SOHC, eSP (Enhanced Smart Power)
Daya Maksimal: 13,1 PS @ 8.500 rpm
Torsi Maksimal: 13,4 Nm @ 5.000 rpm
Transmisi: Otomatis (V-Matic)
Sistem Bahan Bakar: PGM-FI (Programmed Fuel Injection)
Kapasitas Tangki Bahan Bakar: 5,5 liter
Jenis Rem: Cakram (depan) dan tromol (belakang) dengan CBS (Combi Brake System)
Ban: Tubeless ukuran depan 90/80-14 dan belakang 100/80-14
Berat: 112 kg
                  </p>
                  <div class="mobil-info-list border-top pt-4">
                    <ul class="list-unstyled">
                      <li>
                        <i class="ri-checkbox-circle-line"></i>
                        <span>Jas Hujan</span>
                      </li>
                      
                      <li>
                        <i class="ri-checkbox-circle-line"></i>
                        <span>Helm</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-5">
            <div class="card">
              <!-- Product details-->
              <div class="card-body card-body-custom pt-4">
                <div class="text-center">
                  <!-- Product name-->
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <h5 class="fw-bolder">Special Item</h5>
                    <div class="rent-price mb-3">
                      <span style="font-size: 1rem" class="text-primary"
                        >Rp.90.000/</span
                      >day
                    </div>
                  </div>
                  <ul class="list-unstyled list-style-group">
                    <li
                      class="border-bottom p-2 d-flex justify-content-between"
                    >
                      <span>Bahan Bakar</span>
                      <span style="font-weight: 600">Bensin</span>
                    </li>
                    <li
                      class="border-bottom p-2 d-flex justify-content-between"
                    >
                      <span>CC</span>
                      <span style="font-weight: 600">150</span>
                    </li>
                    <li
                      class="border-bottom p-2 d-flex justify-content-between"
                    >
                      <span>Transmisi</span>
                      <span style="font-weight: 600">Matic</span>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Product actions-->
              <div class="card-footer border-top-0 bg-transparent">
                <div class="text-center">
                  <a
                    class="btn d-flex align-items-center justify-content-center btn-primary mt-auto"
                    href="#"
                    style="column-gap: 0.4rem"
                    >Sewa Motor </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection