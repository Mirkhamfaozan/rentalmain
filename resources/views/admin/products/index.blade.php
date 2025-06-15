@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Daftar Motor')
@section('page-description', 'Kelola inventaris dan harga motor Anda.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Ekspor
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-upload me-1"></i>Impor
        </button>
    </div>
    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Motor
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Kartu Statistik Motor -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->count() }}</div>
                            <div class="text-muted small">Total Motor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->where('transmisi_motor', 'Manual')->count() }}</div>
                            <div class="text-muted small">Manual</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-magic"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->where('transmisi_motor', 'Automatic')->count() }}</div>
                            <div class="text-muted small">Otomatis</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">Rp {{ number_format($products->avg('harga_harian'), 0, ',', '.') }}</div>
                            <div class="text-muted small">Rata-rata Harga Harian</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.products.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Cari Motor</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Cari berdasarkan nama motor..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">Rentang CC</label>
                                <select name="cc_range" class="form-select">
                                    <option value="">Semua CC</option>
                                    <option value="0-150" {{ request('cc_range') == '0-150' ? 'selected' : '' }}>0-150cc</option>
                                    <option value="151-250" {{ request('cc_range') == '151-250' ? 'selected' : '' }}>151-250cc</option>
                                    <option value="251-400" {{ request('cc_range') == '251-400' ? 'selected' : '' }}>251-400cc</option>
                                    <option value="400+" {{ request('cc_range') == '400+' ? 'selected' : '' }}>400cc+</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">Transmisi</label>
                                <select name="transmission" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="Otomatis" {{ request('transmission') == 'Otomatis' ? 'selected' : '' }}>Otomatis</option>
                                    <option value="CVT" {{ request('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">Rentang Harga</label>
                                <select name="price_range" class="form-select">
                                    <option value="">Semua Harga</option>
                                    <option value="0-100000" {{ request('price_range') == '0-100000' ? 'selected' : '' }}>Di bawah 100K</option>
                                    <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>100K - 200K</option>
                                    <option value="200000+" {{ request('price_range') == '200000+' ? 'selected' : '' }}>Di atas 200K</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-secondary">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Motor -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Motor</h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary active">
                                    <i class="fas fa-th-list"></i>
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-th"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th class="border-0 fw-semibold">Motor</th>
                                    <th class="border-0 fw-semibold">CC</th>
                                    <th class="border-0 fw-semibold">Transmisi</th>
                                    <th class="border-0 fw-semibold">Harga Harian</th>
                                    <th class="border-0 fw-semibold">Stok</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->gambar_utama)
                                            <img src="{{ Storage::url($product->gambar_utama) }}"
                                                 class="rounded me-3"
                                                 style="width: 48px; height: 48px; object-fit: cover;"
                                                 alt="{{ $product->nama_motor }}">
                                            @else
                                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                 style="width: 48px; height: 48px; font-size: 18px;">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $product->nama_motor }}</div>
                                                <div class="text-muted small">{{ $product->brand }} - {{ $product->tahun_produksi }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge @if($product->cc_motor <= 150) bg-success-subtle text-success @elseif($product->cc_motor <= 250) bg-warning-subtle text-warning @elseif($product->cc_motor <= 400) bg-info-subtle text-info @else bg-danger-subtle text-danger @endif">
                                            {{ $product->cc_motor }}cc
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge @if($product->transmisi_motor == 'Manual') bg-primary-subtle text-primary @elseif($product->transmisi_motor == 'Otomatis') bg-success-subtle text-success @else bg-info-subtle text-info @endif">
                                            {{ $product->transmisi_motor }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($product->harga_harian, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $product->stok }} unit
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->is_available)
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="fas fa-check-circle me-1"></i>Tersedia
                                        </span>
                                        @else
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="fas fa-times-circle me-1"></i>Tidak Tersedia
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dashboard.products.show', $product) }}"
                                               class="btn btn-outline-primary" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.products.edit', $product) }}"
                                               class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger btn-delete"
                                                    title="Hapus"
                                                    data-url="{{ route('dashboard.products.destroy', $product) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-motorcycle fa-3x mb-3"></i>
                                            <p>Tidak ada motor yang ditemukan</p>
                                            <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i>Tambah Motor Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($products->count() > 0)
                    <!-- Aksi Massal -->
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted small">Dengan yang dipilih:</span>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>

                            <!-- Paginasi -->
                            @if(method_exists($products, 'links'))
                            <div>
                                {{ $products->links() }}
                            </div>
                            @else
                            <div class="text-muted small">
                                Menampilkan {{ $products->count() }} motor
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus motor ini? Data yang dihapus tidak dapat dikembalikan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');

        // Ketika tombol hapus diklik
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url');
                deleteForm.action = url;

                // Tampilkan modal
                const modal = new bootstrap.Modal(deleteModal);
                modal.show();
            });
        });
    });
</script>
@endpush
