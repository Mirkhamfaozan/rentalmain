@extends('layouts.app')

@section('title', 'Pesanan')
@section('page-title', 'Daftar Pesanan')
@section('page-description', 'Kelola pesanan sewa motor Anda.')

@section('page-actions')
    <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary" data-bs-toggle="tooltip"
        title="Tambah pesanan baru">
        <i class="fas fa-plus me-1"></i>Tambah Pesanan
    </a>
@endsection

@section('content')

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Kartu Statistik Pesanan -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-list-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $orders->count() }}</div>
                            <div class="text-muted small">Total Pesanan</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +3.5%
                            </div>
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
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $orders->where('status', 'confirmed')->count() }}</div>
                            <div class="text-muted small">Dikonfirmasi</div>
                            <div class="text-info small">
                                <i class="fas fa-info-circle"></i> Status
                            </div>
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
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $orders->where('status', 'ongoing')->count() }}</div>
                            <div class="text-muted small">Sedang Berlangsung</div>
                            <div class="text-info small">
                                <i class="fas fa-info-circle"></i> Status
                            </div>
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
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
                            </div>
                            <div class="text-muted small">Total Pendapatan</div>
                            <div class="text-success small">
                                <i class="fas fa-rupiah-sign"></i> IDR
                            </div>
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
                    <form method="GET" action="{{ route('dashboard.orders.index') }}" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="searchInput" class="form-label small fw-semibold">Cari Pesanan</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Cari berdasarkan nama pelanggan atau motor..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="statusSelect" class="form-label small fw-semibold">Status</label>
                                <select name="status" id="statusSelect" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Sedang
                                        Pembayaran</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Sudah
                                        Bayar</option>
                                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang
                                        Berlangsung</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateRangePicker" class="form-label small fw-semibold">Rentang Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" name="date_range" class="form-control"
                                        placeholder="Pilih rentang tanggal" value="{{ request('date_range') }}"
                                        id="dateRangePicker">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold"> </label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-secondary" id="filterButton">
                                        <i class="fas fa-filter me-1"></i>Filter
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pesanan -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Pesanan</h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary active" data-view="list"
                                    title="Tampilan daftar">
                                    <i class="fas fa-th-list"></i>
                                </button>
                                <button class="btn btn-outline-secondary" data-view="grid" title="Tampilan grid">
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
                                    <th class="border-0 fw-semibold" scope="col">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0 fw-semibold" scope="col">Pesanan</th>
                                    <th class="border-0 fw-semibold" scope="col">Pelanggan</th>
                                    <th class="border-0 fw-semibold" scope="col">Motor</th>
                                    <th class="border-0 fw-semibold" scope="col">Tanggal Mulai</th>
                                    <th class="border-0 fw-semibold" scope="col">Tanggal Selesai</th>
                                    <th class="border-0 fw-semibold" scope="col">Lokasi Pengambilan</th>
                                    <th class="border-0 fw-semibold" scope="col">Lokasi Pengembalian</th>
                                    <th class="border-0 fw-semibold" scope="col">Total Harga</th>
                                    <th class="border-0 fw-semibold" scope="col">Status</th>
                                    <th class="border-0 fw-semibold" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input order-checkbox"
                                                value="{{ $order->id }}">
                                        </td>
                                        <td>
                                            <div class="fw-semibold">Pesanan #{{ $order->id }}</div>
                                            <div class="text-muted small">{{ $order->tipe_sewa }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $order->name }}</div>
                                            <div class="text-muted small">
                                                {{ $order->email ?? ($order->Hugh1->user->email ?? '-') }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($order->product->gambar_utama)
                                                    <img src="{{ Storage::url($order->product->gambar_utama) }}"
                                                        class="rounded me-3"
                                                        style="width: 48px; height: 48px; object-fit: cover;"
                                                        alt="{{ $order->product->nama_motor }}" loading="lazy">
                                                @else
                                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                        style="width: 48px; height: 48px; font-size: 18px;">
                                                        <i class="fas fa-motorcycle"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $order->product->nama_motor }}</div>
                                                    <div class="text-muted small">{{ $order->product->brand }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->tanggal_mulai)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->tanggal_selesai)->format('d/m/Y') }}</td>
                                        <td>{{ $order->lokasi_pengambilan ?? '-' }}</td>
                                        <td>{{ $order->lokasi_pengembalian ?? '-' }}</td>
                                        <td class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge
        @if ($order->status == 'pending') bg-warning-subtle text-warning
        @elseif($order->status == 'confirmed') bg-success-subtle text-success
        @elseif($order->status == 'ongoing') bg-info-subtle text-info
        @elseif($order->status == 'completed') bg-primary-subtle text-primary
        @else bg-danger-subtle text-danger @endif">
                                                @switch($order->status)
                                                    @case('pending')
                                                        Sedang Pembayaran
                                                    @break

                                                    @case('confirmed')
                                                        Sudah Bayar
                                                    @break

                                                    @case('ongoing')
                                                        Sedang Berlangsung
                                                    @break

                                                    @case('completed')
                                                        Selesai
                                                    @break

                                                    @case('cancelled')
                                                        Dibatalkan
                                                    @break

                                                    @default
                                                        {{ $order->status }}
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('dashboard.orders.show', $order) }}"
                                                    class="btn btn-outline-primary" title="Lihat detail pesanan">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.orders.edit', $order) }}"
                                                    class="btn btn-outline-secondary" title="Edit pesanan">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger"
                                                    title="Hapus pesanan" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-order-id="{{ $order->id }}"
                                                    data-order-number="{{ $order->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-list-alt fa-3x mb-3"></i>
                                                    <p>Tidak ada pesanan yang ditemukan</p>
                                                    <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Tambah Pesanan Pertama
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($orders->count() > 0)
                            <!-- Aksi Massal -->
                            <div class="card-footer bg-light border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="text-muted small">Dengan yang dipilih:</span>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-secondary" id="bulkEdit" disabled>
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
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
                        <p id="deleteModalMessage">Apakah Anda yakin ingin menghapus pesanan ini?</p>
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                $(document).ready(function() {
                    // Initialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Initialize date range picker
                    $('#dateRangePicker').daterangepicker({
                        locale: {
                            format: 'YYYY-MM-DD',
                            separator: ' to ',
                            applyLabel: 'Terapkan',
                            cancelLabel: 'Batal',
                            customRangeLabel: 'Kustom',
                            daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                            monthNames: [
                                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ],
                            firstDay: 1
                        },
                        autoUpdateInput: false,
                        ranges: {
                            'Hari Ini': [moment(), moment()],
                            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                'month').endOf('month')]
                        },
                        alwaysShowCalendars: true,
                        showDropdowns: true
                    });

                    $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format(
                            'YYYY-MM-DD'));
                    });

                    $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
                        $(this).val('');
                    });

                    // Handle form submission with loading state
                    $('#filterForm').on('submit', function() {
                        $('#filterButton').find('.spinner-border').removeClass('d-none');
                        $('#filterButton').prop('disabled', true);
                    });

                    // Handle select all checkbox
                    $('#selectAll').on('change', function() {
                        $('.order-checkbox').prop('checked', this.checked);
                        toggleBulkActions();
                    });

                    // Handle individual checkbox changes
                    $('.order-checkbox').on('change', toggleBulkActions);

                    function toggleBulkActions() {
                        const checkedCount = $('.order-checkbox:checked').length;
                        $('#bulkEdit').prop('disabled', checkedCount === 0);
                    }

                    // Handle view toggle (list/grid)
                    $('[data-view]').on('click', function() {
                        $('[data-view]').removeClass('active');
                        $(this).addClass('active');
                        // Add grid view implementation here if needed
                    });

                    // Handle delete button click
                    $('button[data-bs-target="#deleteModal"]').on('click', function() {
                        const orderId = $(this).data('order-id');
                        const orderNumber = $(this).data('order-number');
                        $('#deleteModalMessage').text(`Apakah Anda yakin ingin menghapus Pesanan #${orderNumber}?`);
                        $('#deleteForm').attr('action', `{{ url('dashboard/orders') }}/${orderId}`);
                    });

                    // Handle confirm delete in modal
                    $('#confirmDelete').on('click', function() {
                        $('#deleteForm').submit();
                    });
                });
            </script>
        @endpush
    @endsection
