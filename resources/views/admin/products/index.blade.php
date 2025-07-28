

@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Daftar Motor')
@section('page-description', 'Kelola inventaris dan harga motor Anda.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-download me-1"></i>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('dashboard.products.index') }}?export=csv">Ekspor ke CSV</a></li>
            <li><a class="dropdown-item" href="{{ route('dashboard.products.index') }}?export=xlsx">Ekspor ke Excel</a></li>
            <li><a class="dropdown-item" href="{{ route('dashboard.products.index') }}?export=pdf">Ekspor ke PDF</a></li>
        </ul>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-upload me-1"></i>
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-4 g-3">
        <div class="col-xl-3 col-md-6">
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
                            <div class="fw-bold h4 mb-1">{{ $products->total() }}</div>
                            <div class="text-muted small">Total Motor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
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

        <div class="col-xl-3 col-md-6">
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

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->where('is_available', true)->count() }}</div>
                            <div class="text-muted small">Tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('dashboard.products.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Cari nama, merek, atau plat nomor..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="cc_range" class="form-select">
                                    <option value="">Semua CC</option>
                                    <option value="0-150" {{ request('cc_range') == '0-150' ? 'selected' : '' }}>0-150cc</option>
                                    <option value="151-250" {{ request('cc_range') == '151-250' ? 'selected' : '' }}>151-250cc</option>
                                    <option value="251-400" {{ request('cc_range') == '251-400' ? 'selected' : '' }}>251-400cc</option>
                                    <option value="400+" {{ request('cc_range') == '400+' ? 'selected' : '' }}>400cc+</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="transmission" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="Otomatis" {{ request('transmission') == 'Otomatis' ? 'selected' : '' }}>Otomatis</option>
                                    <option value="CVT" {{ request('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="price_range" class="form-select">
                                    <option value="">Semua Harga</option>
                                    <option value="0-100000" {{ request('price_range') == '0-100000' ? 'selected' : '' }}>Di bawah 100K</option>
                                    <option value="100000-200000" {{ request('price_range') == '100000-200000' ? 'selected' : '' }}>100K - 200K</option>
                                    <option value="200000+" {{ request('price_range') == '200000+' ? 'selected' : '' }}>Di atas 200K</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="availability" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Motor</h5>
                    <div class="d-flex gap-2">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active" data-view="list">
                                <i class="fas fa-th-list"></i>
                            </button>
                            <button class="btn btn-outline-secondary" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0">Motor</th>
                                    <th class="border-0">Nomor Kendaraan</th>
                                    <th class="border-0">CC</th>
                                    <th class="border-0">Transmisi</th>
                                    <th class="border-0">Tahun</th>
                                    <th class="border-0">Harga Harian</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->gambar_utama)
                                            <img src="{{ Storage::url($product->gambar_utama) }}"
                                                 class="rounded me-3"
                                                 style="width: 48px; height: 48px; object-fit: cover;"
                                                 alt="{{ $product->nama_motor }}"
                                                 loading="lazy">
                                            @else
                                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                 style="width: 48px; height: 48px; font-size: 18px;">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $product->nama_motor }}</div>
                                                <div class="text-muted small">{{ $product->brand }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product->nomor_kendaraan }}</td>
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
                                    <td>{{ $product->tahun_produksi }}</td>
                                    <td class="fw-bold">Rp {{ number_format($product->harga_harian, 0, ',', '.') }}</td>
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
                                    <td colspan="9" class="text-center py-4">
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

                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="text-muted">
                                Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari {{ $products->total() }} entri
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
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
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const deleteForm = document.getElementById('deleteForm');

        // Handle single delete
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                deleteForm.action = this.getAttribute('data-url');
                deleteModal.show();
            });
        });

        // Handle view toggle (list/grid)
        document.querySelectorAll('[data-view]').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('[data-view]').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // You can add logic here to switch between list and grid views
                // For example, by adding/removing CSS classes or making AJAX requests
            });
        });
    });
</script>
@endpush
