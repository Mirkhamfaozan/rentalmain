@extends('layouts.frontend')

@section('content')
<!-- Hero Section with Parallax and Gradient Overlay -->
<header class="position-relative py-5 text-white overflow-hidden" style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
      <h1 class="display-3 fw-bold text-warning mb-3">{{ $product->nama_motor }}</h1>
      <p class="lead fs-4 text-white-75">Temukan motor impianmu untuk petualangan tak terlupakan!</p>
    </div>
  </div>
  <!-- Animated Scroll Indicator -->
  <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4">
    <a href="#details" class="text-white text-decoration-none scroll-down">
      <i class="bi bi-chevron-double-down fs-3 animate__animated animate__bounce animate__infinite"></i>
    </a>
  </div>
</header>

<!-- Motor Details Section -->
<section class="py-5 bg-light" id="details">
  <div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-5">
      <!-- Enhanced Carousel with Thumbnails -->
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
        <div class="card shadow-lg rounded-4 overflow-hidden">
          <div id="motorCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <!-- Main Image -->
              <div class="carousel-item active">
                <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                     class="d-block w-100 rounded-top hover-zoom" alt="{{ $product->nama_motor }}"
                     style="object-fit: cover; height: 400px;">
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Motor Information -->
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
        <div class="card shadow-sm border-0 h-100 rounded-4">
          <div class="card-body p-4">
            <h2 class="card-title fw-bold mb-3 text-primary">{{ $product->nama_motor }}</h2>
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 pulse-animation">
                <i class="bi {{ $product->is_available ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                {{ $product->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
              </span>
            </div>
            <p class="mb-2"><strong>Pemilik:</strong> {{ $product->user->name ?? 'Unknown' }}</p>
            <p class="mb-2"><strong>Harga Sewa Harian:</strong>
              <span class="text-primary fw-bold">Rp. {{ number_format($product->harga_harian, 0, ',', '.') }}</span>
            </p>
            <p class="mb-2"><strong>Harga Mingguan:</strong> Rp. {{ number_format($product->harga_mingguan, 0, ',', '.') }}</p>
            <p class="mb-4"><strong>Harga Bulanan:</strong> Rp. {{ number_format($product->harga_bulanan, 0, ',', '.') }}</p>

            <!-- Spesifikasi -->
            <hr>
            <h5 class="fw-semibold mb-3 text-dark">Spesifikasi</h5>
            <ul class="list-group list-group-flush mb-4">
              <li class="list-group-item d-flex align-items-center py-3">
                <i class="bi bi-speedometer2 text-primary me-3 fs-5"></i>
                <span><strong>Kapasitas Mesin:</strong> {{ $product->cc_motor }} cc</span>
              </li>
              <li class="list-group-item d-flex align-items-center py-3">
                <i class="bi bi-gear text-primary me-3 fs-5"></i>
                <span><strong>Transmisi:</strong> {{ $product->transmisi_motor }}</span>
              </li>
              <li class="list-group-item d-flex align-items-center py-3">
                <i class="bi bi-calendar text-primary me-3 fs-5"></i>
                <span><strong>Tahun Produksi:</strong> {{ $product->tahun_produksi }}</span>
              </li>
              <li class="list-group-item d-flex align-items-center py-3">
                <i class="bi bi-paint-bucket text-primary me-3 fs-5"></i>
                <span><strong>Warna:</strong> {{ $product->warna }}</span>
              </li>
            </ul>

            <!-- Deskripsi -->
            <hr>
            <h5 class="fw-semibold mb-3 text-dark">Deskripsi</h5>
            <p class="text-muted lh-lg">{{ $product->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
          </div>
          <div class="card-footer bg-white border-top-0 text-center p-4">
            @if ($product->is_available)
              <a href="{{ route('frontend.order', $product->id) }}"
                 class="btn btn-gradient btn-lg px-5 py-3 rounded-pill shadow-lg hover-scale fw-bold">
                <i class="bi bi-cart me-2"></i>Sewa Sekarang
              </a>
            @else
              <button class="btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold" disabled>
                <i class="bi bi-x-circle me-2"></i>Motor Tidak Tersedia
              </button>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Rekomendasi Produk -->
    @if ($recommendations->isNotEmpty())
      <div class="mt-5" data-aos="fade-up" data-aos-delay="300">
        <h3 class="fw-bold mb-4 text-center text-dark">Rekomendasi Produk Lainnya</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach ($recommendations as $key => $rec)
            <div class="col" data-aos="fade-up" data-aos-delay="{{ ($key % 3) * 100 }}">
              <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-grow">
                <img src="{{ $rec->gambar_utama ? Storage::url($rec->gambar_utama) : '/images/placeholder.jpg' }}"
                     class="card-img-top hover-zoom" alt="{{ $rec->nama_motor }}"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body p-4">
                  <h5 class="card-title fw-bold mb-2 text-truncate">{{ $rec->nama_motor }}</h5>
                  <p class="text-primary fw-bold mb-2">Rp. {{ number_format($rec->harga_harian, 0, ',', '.') }} / Hari</p>
                  <p class="text-muted small mb-0">{{ $rec->brand }}</p>
                </div>
                <div class="card-footer bg-white border-top-0 text-center p-4">
                  <a href="{{ route('frontend.detail', $rec->id) }}"
                     class="btn btn-outline-primary rounded-pill px-4 py-2 hover-scale-sm">
                    <i class="bi bi-eye me-2"></i>Detail
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>

<!-- Custom Styles -->
<style>
/* Root Variables for Consistent Styling */
:root {
  --primary: #0d6efd;
  --warning: #ffc107;
  --animation-duration: 0.3s;
}

/* Gradient Button */
.btn-gradient {
  background: linear-gradient(135deg, var(--primary), #4dabf7);
  color: white;
  transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
}
.btn-gradient:hover {
  transform: scale(1.05);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
}

/* Hover Effects */
.hover-scale {
  transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
}
.hover-scale:hover {
  transform: scale(1.05);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.hover-scale-sm {
  transition: transform var(--animation-duration) ease;
}
.hover-scale-sm:hover {
  transform: scale(1.03);
}

.hover-zoom {
  transition: transform calc(var(--animation-duration) * 2) ease;
}
.hover-zoom:hover {
  transform: scale(1.1);
}

.hover-grow {
  transition: transform var(--animation-duration) ease, box-shadow var(--animation-duration) ease;
}
.hover-grow:hover {
  transform: translateY(-10px);
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
}

/* Scroll Down Animation */
.scroll-down {
  animation: bounce 2s infinite;
}
@keyframes bounce {
  0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
  40% { transform: translateY(-20px); }
  60% { transform: translateY(-10px); }
}

/* Pulse Animation for Badge */
.pulse-animation {
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); }
  70% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); }
  100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
}

/* Carousel Thumbnail Styling */
.thumbnail {
  opacity: 0.6;
  transition: opacity var(--animation-duration) ease;
}
.thumbnail.active, .thumbnail:hover {
  opacity: 1;
  border: 2px solid var(--primary);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .display-3 { font-size: 2.5rem; }
  .carousel-inner img { height: 300px; }
  .card-img-top { height: 150px; }
}

/* Bootstrap Icon Enhancements */
.bi {
  vertical-align: -.125em;
}
</style>

<!-- Custom Scripts -->
<script>
// Initialize AOS
document.addEventListener('DOMContentLoaded', function() {
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: false
  });

  // Carousel Thumbnail Interaction
  document.querySelectorAll('.thumbnail').forEach(thumb => {
    thumb.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Smooth Scroll for Anchor Links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if(target) {
        window.scrollTo({
          top: target.offsetTop - 80,
          behavior: 'smooth'
        });
      }
    });
  });
});
</script>
@endsection
