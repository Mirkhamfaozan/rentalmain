@extends('layouts.app')

@section('title', 'Detail Motor')
@section('page-title', 'Detail Motor')
@section('page-description', 'Informasi lengkap tentang motor ini')

@section('page-actions')
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Motor
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Main Card -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <!-- Card Header with Gradient Background -->
                <div class="card-header bg-gradient-primary bg-opacity-10 border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-25 text-primary rounded-3 p-3 me-3">
                            <i class="fas fa-motorcycle fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $product->nama_motor }}</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $product->brand }}</span>
                                <span class="badge bg-info bg-opacity-10 text-info">{{ $product->cc_motor }}cc</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $product->tahun_produksi }}</span>
                                @if($product->is_available)
                                    <span class="badge bg-success bg-opacity-10 text-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger">Tidak Tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Main Content with Tabs -->
                    <div class="row g-0">
                        <!-- Left Column - Image Gallery -->
                        <div class="col-lg-5 border-end">
                            <div class="p-4">
                                <!-- Main Image -->
                                <div class="mb-4">
                                    @if($product->gambar_utama)
                                        <img src="{{ asset('storage/'.$product->gambar_utama) }}"
                                             class="img-fluid rounded-3 shadow-sm"
                                             alt="{{ $product->nama_motor }}"
                                             id="mainImage">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                             style="height: 250px;">
                                            <i class="fas fa-motorcycle fa-4x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Thumbnail Gallery -->
                                <div class="row g-2">
                                    <div class="col-3">
                                        <div class="ratio ratio-1x1 cursor-pointer border rounded-2 overflow-hidden">
                                            <img src="{{ asset('storage/'.$product->gambar_utama) }}"
                                                 class="object-fit-cover"
                                                 onclick="changeMainImage(this)">
                                        </div>
                                    </div>
                                    <!-- Add more thumbnails here if you have additional images -->
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Details -->
                        <div class="col-lg-7">
                            <div class="p-4">
                                <!-- Navigation Tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom mb-4" id="productTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="specs-tab" data-bs-toggle="tab"
                                                data-bs-target="#specs" type="button" role="tab">
                                            <i class="fas fa-list-alt me-2"></i>Spesifikasi
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="registration-tab" data-bs-toggle="tab"
                                                data-bs-target="#registration" type="button" role="tab">
                                            <i class="fas fa-file-alt me-2"></i>Registrasi
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pricing-tab" data-bs-toggle="tab"
                                                data-bs-target="#pricing" type="button" role="tab">
                                            <i class="fas fa-tags me-2"></i>Harga
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="productTabsContent">
                                    <!-- Specifications Tab -->
                                    <div class="tab-pane fade show active" id="specs" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="bg-light rounded-2 p-3 h-100">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-cog me-2"></i>Detail Mesin</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Kapasitas</small>
                                                        <strong>{{ $product->cc_motor }} cc</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Tipe Mesin</small>
                                                        <strong>{{ $product->tipe_motor }}</strong>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Transmisi</small>
                                                        <strong>{{ $product->transmisi_motor }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bg-light rounded-2 p-3 h-100">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-palette me-2"></i>Penampilan</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Warna</small>
                                                        <strong>{{ $product->warna }}</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Tahun</small>
                                                        <strong>{{ $product->tahun_produksi }}</strong>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Stok</small>
                                                        <strong>{{ $product->stok }} unit</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="mt-4">
                                            <h6 class="text-muted mb-3"><i class="fas fa-align-left me-2"></i>Deskripsi</h6>
                                            <div class="bg-light rounded-2 p-3">
                                                {!! nl2br(e($product->deskripsi)) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Registration Tab -->
                                    <div class="tab-pane fade" id="registration" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="bg-light rounded-2 p-3 h-100">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-id-card me-2"></i>Dokumen</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Nomor STNK</small>
                                                        <strong>{{ $product->nomor_stnk }}</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Plat Nomor</small>
                                                        <strong>{{ $product->nomor_kendaraan }}</strong>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Foto STNK</small>
                                                        @if($product->foto_stnk)
                                                            <a href="{{ asset('storage/'.$product->foto_stnk) }}"
                                                               target="_blank"
                                                               class="btn btn-sm btn-outline-primary mt-1">
                                                                <i class="fas fa-eye me-1"></i>Lihat
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Tidak tersedia</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bg-light rounded-2 p-3 h-100">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-barcode me-2"></i>Identitas</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Nomor Mesin</small>
                                                        <strong>{{ $product->no_mesin }}</strong>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Nomor Rangka</small>
                                                        <strong>{{ $product->no_rangka }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pricing Tab -->
                                    <div class="tab-pane fade" id="pricing" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="bg-light rounded-2 p-3 h-100">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-money-bill-wave me-2"></i>Harga Sewa</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Harian</small>
                                                        <h5 class="text-primary">Rp {{ number_format($product->harga_harian, 0, ',', '.') }}</h5>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">Mingguan</small>
                                                        <h5 class="text-primary">Rp {{ number_format($product->harga_harian * 7 - ($product->harga_harian * $product->diskon_mingguan), 0, ',', '.') }}</h5>
                                                        <small class="text-success">
                                                            <i class="fas fa-gift me-1"></i>
                                                            Diskon: {{ $product->diskon_mingguan }} hari gratis
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Bulanan</small>
                                                        <h5 class="text-primary">Rp {{ number_format($product->harga_harian * 30 - ($product->harga_harian * $product->diskon_bulanan), 0, ',', '.') }}</h5>
                                                        <small class="text-success">
                                                            <i class="fas fa-gift me-1"></i>
                                                            Diskon: {{ $product->diskon_bulanan }} hari gratis
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bg-light rounded-2 p-3 h-100">
                                                    <h6 class="text-muted mb-3"><i class="fas fa-percentage me-2"></i>Perhitungan Contoh</h6>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">1 Hari</small>
                                                        <strong>Rp {{ number_format($product->harga_harian, 0, ',', '.') }}</strong>
                                                    </div>
                                                    <div class="mb-2">
                                                        <small class="text-muted d-block">7 Hari</small>
                                                        <strong>Rp {{ number_format($product->harga_harian * 7, 0, ',', '.') }}</strong>
                                                        <small class="d-block text-success">
                                                            Setelah diskon: Rp {{ number_format($product->harga_harian * 7 - ($product->harga_harian * $product->diskon_mingguan), 0, ',', '.') }}
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">30 Hari</small>
                                                        <strong>Rp {{ number_format($product->harga_harian * 30, 0, ',', '.') }}</strong>
                                                        <small class="d-block text-success">
                                                            Setelah diskon: Rp {{ number_format($product->harga_harian * 30 - ($product->harga_harian * $product->diskon_bulanan), 0, ',', '.') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer with Action Buttons -->
                    <div class="card-footer bg-transparent border-top py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <span class="me-3">
                                    <i class="fas fa-calendar me-1"></i>
                                    Dibuat: {{ $product->created_at->translatedFormat('d F Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-sync me-1"></i>
                                    Diperbarui: {{ $product->updated_at->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Tutup
                                </a>
                                <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Motor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .nav-tabs-custom .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            position: relative;
        }
        .nav-tabs-custom .nav-link.active {
            color: #0d6efd;
            background-color: transparent;
        }
        .nav-tabs-custom .nav-link.active:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 3px 3px 0 0;
        }
        .nav-tabs-custom .nav-link:hover:not(.active) {
            color: #0d6efd;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .object-fit-cover {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function changeMainImage(element) {
            document.getElementById('mainImage').src = element.src;
        }
    </script>
@endpush
