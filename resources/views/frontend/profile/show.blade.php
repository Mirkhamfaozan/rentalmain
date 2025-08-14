@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    <header class="position-relative py-5 text-white overflow-hidden"
        style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)), url('/images/bgsatu.jpg') center/cover no-repeat fixed;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-4 fw-bold text-warning mb-3">Profil Saya</h1>
                <p class="lead fs-5 text-white-75">Kelola informasi akun dan preferensi Anda</p>
            </div>
        </div>
    </header>

    <!-- Success/Error Popup Modals -->
    @if (session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Sukses</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Error</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Content -->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5">
            <div class="row gx-5">
                <!-- Profile Card -->
                <div class="col-lg-4 mb-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="card-body text-center p-4">
                            <!-- Avatar -->
                            <div class="position-relative mb-4">
                                @if ($user->avatar && Storage::exists($user->avatar))
                                    <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle shadow-lg"
                                        alt="Avatar" style="width: 150px; height: 150px; object-fit: cover;"
                                        onerror="this.src='/images/default-avatar.png'">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow-lg mx-auto"
                                        style="width: 150px; height: 150px;">
                                        <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
                                    </div>
                                @endif
                                <span
                                    class="position-absolute bottom-0 end-0 translate-middle badge rounded-pill
                                    @if ($user->role === 'admin') bg-danger
                                    @elseif($user->role === 'rental') bg-warning
                                    @else bg-success @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <h4 class="fw-bold text-primary mb-2">{{ $user->name }}</h4>
                            <p class="text-muted mb-3">{{ $user->email }}</p>

                            @if ($user->phone)
                                <p class="text-muted mb-3">
                                    <i class="bi bi-telephone-fill me-2"></i>{{ $user->phone }}
                                </p>
                            @endif

                            <!-- Quick Actions -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('profile.edit') }}" class="btn btn-gradient rounded-pill">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                                </a>
                                <a href="{{ route('profile.password.edit') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-shield-lock me-2"></i>Ganti Password
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($user->role === 'rental' && isset($rentalBiodata) && $rentalBiodata)
                        <!-- Rental Info Card -->
                        <div class="card shadow-sm border-0 rounded-4 mt-4" data-aos="fade-right" data-aos-delay="200">
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="bi bi-shop me-2"></i>Info Rental
                                </h5>

                                <!-- Verification Status Popup Triggers -->
                                @if ($rentalBiodata->isRejected())
                                    <button class="btn btn-danger w-100 mb-4" data-bs-toggle="modal" data-bs-target="#verificationRejectedModal">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Verifikasi Ditolak - Klik untuk Detail
                                    </button>
                                @elseif($rentalBiodata->isPending())
                                    <button class="btn btn-warning w-100 mb-4" data-bs-toggle="modal" data-bs-target="#verificationPendingModal">
                                        <i class="bi bi-hourglass-split me-2"></i>Menunggu Verifikasi
                                    </button>
                                @endif

                                <div class="mb-3">
                                    <strong>Status Verifikasi:</strong>
                                    <span class="badge bg-{{ $rentalBiodata->getStatusBadgeClass() }} ms-2">
                                        {{ $rentalBiodata->getStatusLabel() }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <strong>Nama Bisnis:</strong>
                                    <p class="text-muted mb-0">{{ $rentalBiodata->nama_rental }}</p>
                                </div>

                                <div class="mb-3">
                                    <strong>Alamat Bisnis:</strong>
                                    <p class="text-muted mb-0">{{ $rentalBiodata->alamat }}</p>
                                </div>

                                @if ($rentalBiodata->no_wa)
                                    <div class="mb-3">
                                        <strong>WhatsApp:</strong>
                                        <p class="text-muted mb-0">{{ $rentalBiodata->no_wa }}</p>
                                    </div>
                                @endif

                                @if ($rentalBiodata->isVerified())
                                    <button class="btn btn-success w-100 mt-4" data-bs-toggle="modal" data-bs-target="#verificationSuccessModal">
                                        <i class="bi bi-check-circle-fill me-2"></i>Terverifikasi
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Profile Details & Navigation -->
                <div class="col-lg-8" data-aos="fade-left" data-aos-delay="100">
                    <!-- Navigation Tabs -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <nav>
                                <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                                    <button class="nav-link active rounded-pill" id="nav-info-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-info" type="button" role="tab"
                                        aria-controls="nav-info" aria-selected="true">
                                        <i class="bi bi-person-lines-fill me-2"></i>Info Personal
                                    </button>
                                    <button class="nav-link rounded-pill" id="nav-orders-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-orders" type="button" role="tab"
                                        aria-controls="nav-orders" aria-selected="false">
                                        <i class="bi bi-bag-check me-2"></i>Pesanan
                                    </button>
                                    @if ($user->role === 'rental')
                                        <button class="nav-link rounded-pill" id="nav-products-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-products" type="button" role="tab"
                                            aria-controls="nav-products" aria-selected="false">
                                            <i class="bi bi-grid me-2"></i>Produk
                                        </button>
                                    @endif
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold text-primary mb-4">
                                        <i class="bi bi-person-lines-fill me-2"></i>Informasi Personal
                                    </h5>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="bg-light rounded-3 p-3">
                                                <strong class="text-muted d-block mb-1">Nama Lengkap</strong>
                                                <span class="fw-semibold">{{ $user->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light rounded-3 p-3">
                                                <strong class="text-muted d-block mb-1">Email</strong>
                                                <span class="fw-semibold">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="bg-light rounded-3 p-3">
                                                <strong class="text-muted d-block mb-1">Bergabung Sejak</strong>
                                                <span class="fw-semibold">{{ $user->created_at->translatedFormat('d F Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-orders-tab">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="fw-bold text-primary mb-0">
                                            <i class="bi bi-bag-check me-2"></i>Pesanan Saya
                                        </h5>
                                    </div>

                                    @if ($orders->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Motor</th>
                                                        <th>Tanggal & Waktu Sewa</th>
                                                        <th>Durasi</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ $order->product->gambar_utama ? Storage::url($order->product->gambar_utama) : '/images/placeholder.jpg' }}"
                                                                        class="rounded me-3" width="60"
                                                                        height="60" style="object-fit: cover;"
                                                                        onerror="this.src='/images/placeholder.jpg'">
                                                                    <div>
                                                                        <h6 class="mb-0">
                                                                            {{ $order->product->nama_motor }}</h6>
                                                                        <small
                                                                            class="text-muted">{{ $order->product->brand->name ?? '-' }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex flex-column">
                                                                    <div>
                                                                        <strong>Mulai:</strong>
                                                                        {{ $order->tanggal_mulai->translatedFormat('d M Y') }}
                                                                        {{ $order->waktu_mulai ? $order->waktu_mulai->format('H:i') : '00:00' }}
                                                                    </div>
                                                                    <div>
                                                                        <strong>Selesai:</strong>
                                                                        {{ $order->tanggal_selesai->translatedFormat('d M Y') }}
                                                                        {{ $order->waktu_selesai ? $order->waktu_selesai->format('H:i') : '00:00' }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $order->durasi_hari }} hari</td>
                                                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                                            <td>
                                                                @if ($order->status == 'belum_dikonfirmasi')
                                                                    <span class="badge bg-secondary">
                                                                        <i class="bi bi-hourglass me-1"></i> Sedang Dicek Rental
                                                                    </span>
                                                                @elseif($order->status == 'pending')
                                                                    <span class="badge bg-warning text-dark">
                                                                        <i class="bi bi-credit-card me-1"></i> Belum Bayar
                                                                    </span>
                                                                @elseif($order->status == 'confirmed')
                                                                    <span class="badge bg-success">
                                                                        <i class="bi bi-check-circle me-1"></i> Sudah Bayar
                                                                    </span>
                                                                @elseif($order->status == 'ongoing')
                                                                    <span class="badge bg-primary">
                                                                        <i class="bi bi-bicycle me-1"></i> Sedang Dirental
                                                                    </span>
                                                                @elseif($order->status == 'completed')
                                                                    <span class="badge bg-info">
                                                                        <i class="bi bi-check-circle-fill me-1"></i> Rental Selesai
                                                                    </span>
                                                                @elseif($order->status == 'cancelled')
                                                                    <span class="badge bg-danger">
                                                                        <i class="bi bi-x-circle me-1"></i> Dibatalkan
                                                                    </span>
                                                                @elseif($order->status == 'ditolak')
                                                                    <span class="badge bg-danger">
                                                                        <i class="bi bi-x-circle me-1"></i> Ditolak
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($order->status == 'pending')
                                                                    <a href="{{ route('payment.create', $order->id) }}"
                                                                       class="btn btn-sm btn-success rounded-pill mb-1">
                                                                        <i class="bi bi-credit-card me-1"></i> Bayar
                                                                    </a>
                                                                @elseif($order->status == 'ongoing')
                    
                                                                    <a href="{{ route('profile.order.invoice', $order->id) }}"
                                                                       class="btn btn-sm btn-outline-info rounded-pill">
                                                                        <i class="bi bi-receipt me-1"></i> Lihat Invoice
                                                                    </a>
                                                                @elseif($order->status == 'completed')
                                                                    <button class="btn btn-sm btn-outline-secondary rounded-pill mb-1">
                                                                        <i class="bi bi-star me-1"></i> Beri Rating
                                                                    </button>
                                                                    <a href="{{ route('profile.order.invoice', $order->id) }}"
                                                                       class="btn btn-sm btn-outline-info rounded-pill">
                                                                        <i class="bi bi-receipt me-1"></i> Lihat Invoice
                                                                    </a>
                                                                @elseif($order->status == 'ditolak')
                                                                    <button class="btn btn-sm btn-outline-danger rounded-pill mb-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#rejectionNoteModal{{ $order->id }}">
                                                                        <i class="bi bi-info-circle me-1"></i> Lihat Penolakan
                                                                    </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-5">
                                            <i class="bi bi-bag-x display-1 text-muted mb-3"></i>
                                            <p>Belum ada pesanan. <a href="{{ route('frontend.product') }}"
                                                    class="text-primary">Mulai berbelanja</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Products Tab (Rental Only) -->
                        @if ($user->role === 'rental')
                            <div class="tab-pane fade" id="nav-products" role="tabpanel" aria-labelledby="nav-products-tab">
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="fw-bold text-primary mb-0">
                                                <i class="bi bi-grid me-2"></i>Produk Saya
                                            </h5>
                                            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm rounded-pill">
                                                <i class="bi bi-plus-circle me-1"></i> Tambah Produk
                                            </a>
                                        </div>

                                        @if(isset($userProducts) && $userProducts->count() > 0)
                                            <div class="row g-3">
                                                @foreach ($userProducts as $product)
                                                    <div class="col-md-4">
                                                        <div class="card border-0 shadow-sm rounded-3 hover-scale">
                                                            <img src="{{ $product->gambar_utama ? Storage::url($product->gambar_utama) : '/images/placeholder.jpg' }}"
                                                                class="card-img-top"
                                                                style="height: 150px; object-fit: cover;"
                                                                alt="{{ $product->nama_motor }}"
                                                                onerror="this.src='/images/placeholder.jpg'">
                                                            <div class="card-body p-3">
                                                                <h6 class="fw-bold text-truncate mb-2">
                                                                    {{ $product->nama_motor }}</h6>
                                                                <p class="text-success fw-bold mb-0">
                                                                    Rp
                                                                    {{ number_format($product->harga_harian, 0, ',', '.') }}/hari
                                                                </p>
                                                                <div class="d-flex justify-content-between mt-2">
                                                                    <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                                       class="btn btn-sm btn-outline-primary rounded-pill">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </a>
                                                                    <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center text-muted py-5">
                                                <i class="bi bi-plus-circle display-1 text-muted mb-3"></i>
                                                <p>Belum ada produk. <a href="{{ route('dashboard.products.create') }}" class="text-primary">Mulai tambahkan produk Anda</a></p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rejection Note Modals - Placed at the bottom of the page -->
    @foreach ($orders as $order)
        @if ($order->status == 'ditolak')
        <div class="modal fade" id="rejectionNoteModal{{ $order->id }}" tabindex="-1" aria-labelledby="rejectionNoteModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="rejectionNoteModalLabel{{ $order->id }}">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Alasan Penolakan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Pesanan #{{ $order->id }} ditolak oleh rental
                        </div>
                        <div class="mb-3">
                            <strong>Catatan Penolakan:</strong>
                            <p class="mt-2">{{ $order->catatan_ditolak ?? 'Tidak ada catatan tambahan' }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    <!-- Verification Status Modals -->
    @if ($user->role === 'rental' && isset($rentalBiodata) && $rentalBiodata)
        <!-- Verification Rejected Modal -->
        @if ($rentalBiodata->isRejected())
        <div class="modal fade" id="verificationRejectedModal" tabindex="-1" aria-labelledby="verificationRejectedModalLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="verificationRejectedModalLabel">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Verifikasi Ditolak
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger mb-3">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Data rental Anda tidak memenuhi persyaratan verifikasi.</strong>
                        </div>

                        @if($rentalBiodata->catatan_ditolak)
                        <div class="mb-3">
                            <h6 class="fw-bold">Alasan Penolakan:</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $rentalBiodata->catatan_ditolak }}
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <h6 class="fw-bold">Langkah Selanjutnya:</h6>
                            <ul class="mb-0">
                                <li>Perbaiki data sesuai catatan yang diberikan</li>
                                <li>Upload ulang dokumen yang diminta</li>
                                <li>Tunggu proses verifikasi ulang</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2">
                            @if(Route::has('profile.verification-note'))
                            <a href="{{ route('profile.verification-note') }}" class="btn btn-outline-danger">
                                <i class="bi bi-info-circle me-1"></i> Lihat Detail Lengkap
                            </a>
                            @endif

                            @if(Route::has('profile.edit') || Route::has('rental.biodata.edit'))
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i> Perbaiki Data
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Verification Pending Modal -->
        @if ($rentalBiodata->isPending())
        <div class="modal fade" id="verificationPendingModal" tabindex="-1" aria-labelledby="verificationPendingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="verificationPendingModalLabel">
                            <i class="bi bi-hourglass-split me-2"></i>Verifikasi Sedang Diproses
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Data rental Anda sedang dalam proses verifikasi oleh admin.</strong>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold">Status Saat Ini:</h6>
                            <ul class="mb-0">
                                <li>Data telah diterima dan sedang direview</li>
                                <li>Admin akan melakukan verifikasi dalam 1-3 hari kerja</li>
                                <li>Anda akan mendapat notifikasi hasil verifikasi</li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Mohon bersabar menunggu...</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Verification Success Modal -->
        @if ($rentalBiodata->isVerified())
        <div class="modal fade" id="verificationSuccessModal" tabindex="-1" aria-labelledby="verificationSuccessModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="verificationSuccessModalLabel">
                            <i class="bi bi-check-circle-fill me-2"></i>Verifikasi Berhasil
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Selamat! Rental Anda telah terverifikasi.</strong>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold">Keuntungan Verifikasi:</h6>
                            <ul class="mb-0">
                                <li>Dapat menambahkan dan mengelola produk rental</li>
                                <li>Menerima pesanan dari customer</li>
                                <li>Mendapat badge verifikasi di profil</li>
                                <li>Prioritas dalam pencarian</li>
                            </ul>
                        </div>

                        <div class="d-grid">
                            @if(Route::has('dashboard.products.create'))
                            <a href="{{ route('dashboard.products.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Mulai Tambah Produk
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

    <!-- Custom Styles -->
    <style>
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .nav-pills .nav-link {
            border: 1px solid #dee2e6;
            margin: 0 2px;
            color: #6c757d;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        /* Fix for modal z-index */
        .modal {
            z-index: 1060 !important;
        }

        /* Custom styles for time display */
        .table td small.text-muted {
            font-size: 0.8rem;
            display: block;
        }

        .table td div.d-flex {
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }

            .nav-pills {
                flex-direction: column;
            }

            .nav-pills .nav-link {
                margin: 2px 0;
            }

            .table td div.d-flex {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
    </style>

    <!-- JavaScript for Modal Auto-show and AOS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-show success/error modals
            @if (session('success'))
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif

            @if (session('error'))
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            @endif

            // Initialize AOS (Animate On Scroll)
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true
                });
            }

            // Add smooth scrolling for tab navigation
            const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add active state animation
                    setTimeout(() => {
                        const activePane = document.querySelector('.tab-pane.active');
                        if (activePane) {
                            activePane.style.opacity = '0';
                            activePane.style.transform = 'translateY(20px)';

                            setTimeout(() => {
                                activePane.style.transition = 'all 0.3s ease';
                                activePane.style.opacity = '1';
                                activePane.style.transform = 'translateY(0)';
                            }, 50);
                        }
                    }, 150);
                });
            });

            // Enhanced table row hover effects
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.01)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.boxShadow = 'none';
                });
            });

            // Add loading state for action buttons
            const actionButtons = document.querySelectorAll('.btn[href]');
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.classList.contains('btn-outline-danger')) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Loading...';
                        this.disabled = true;

                        // Re-enable after 3 seconds (fallback)
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });
        });
    </script>
@endsection
