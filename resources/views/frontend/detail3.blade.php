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
                src="images/scoopy.jpg"
                alt="..."
              />
              <!-- Product details-->
              <div class="card-body card-body-custom pt-4">
                <div>
                  <!-- Product name-->
                  <h3 class="fw-bolder text-primary">Deskripsi</h3>
                  <p>
                  Honda Scoopy 2018 adalah salah satu skuter matik (skutik) populer dari Honda yang mengusung desain retro-modern. Motor ini dikenal dengan tampilannya yang stylish dan fitur yang cocok untuk penggunaan harian, terutama di perkotaan.
                  </p>

                  <p>
                  Spesifikasi Umum Honda Scoopy 2018:
                  </p>-Mesin: 108,2 cc, SOHC, 4-langkah, berpendingin udara
-Daya Maksimal: 9 PS @ 7.500 rpm
-Torsi Maksimal: 9,4 Nm @ 6.000 rpm
-Transmisi: Otomatis (V-Matic)
-Sistem Bahan Bakar: PGM-FI (Programmed Fuel Injection)
-Kapasitas Tangki Bahan Bakar: 4 liter
-Jenis Rem: Cakram (depan) dan tromol (belakang)
-Ban: Tubeless dengan ukuran depan 100/90-12 dan belakang 110/90-12
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
                        >Rp.200.000/</span
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
                      <span style="font-weight: 600">110</span>
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