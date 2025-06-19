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
                                <label class="form-label small fw-semibold"> </label>
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
                                    <th class="border-0 fw-semibold" scope="col">KTP</th>
                                    <th class="border-0 fw-semibold" scope="col">Motor</th>
                                    <th class="border-0 fw-semibold" scope="col">Tanggal Mulai</th>
                                    <th class="border-0 fw-semibold" scope="col">Tanggal Selesai</th>
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
                                                {{ $order->email ?? ($order->user->email ?? '-') }}</div>
                                        </td>
                                        <td>
                                            @if($order->foto_ktp)
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . str_replace('public/', '', $order->foto_ktp)) }}"
                                                         class="ktp-thumbnail"
                                                         alt="Foto KTP"
                                                         style="cursor: pointer;"
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#ktpModal"
                                                         data-ktp-image="{{ asset('storage/' . str_replace('public/', '', $order->foto_ktp)) }}"
                                                         data-customer-name="{{ $order->name }}">
                                                    <div class="position-absolute top-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center ktp-overlay"
                                                         style="width: 20px; height: 20px; font-size: 10px; transform: translate(25%, -25%);">
                                                        <i class="fas fa-search-plus"></i>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted small">Tidak ada</span>
                                            @endif
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

        <!-- KTP Preview Modal -->
        <div class="modal fade" id="ktpModal" tabindex="-1" aria-labelledby="ktpModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ktpModalLabel">Foto KTP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status" id="ktpImageLoader">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <img id="ktpPreviewImage" class="img-fluid" alt="Foto KTP" style="max-height: 70vh; display: none;">
                        <p id="ktpNoImage" class="text-muted" style="display: none;">Tidak ada foto KTP</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Tutup
                        </button>
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

        @push('styles')
        <!-- jQuery CDN (jika belum ada di layout utama) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Moment.js untuk date range picker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <!-- DateRangePicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css">

        <style>
            .ktp-thumbnail {
                width: 60px;
                height: 40px;
                object-fit: cover;
                border-radius: 4px;
                border: 1px solid #dee2e6;
                transition: all 0.3s ease;
            }

            .ktp-thumbnail:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .ktp-overlay {
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .ktp-thumbnail:hover + .ktp-overlay,
            .position-relative:hover .ktp-overlay {
                opacity: 1;
            }

            .ktp-preview {
                max-width: 100%;
                height: auto;
                max-height: 300px;
                border: 1px solid #dee2e6;
                border-radius: 4px;
            }

            #ktpModal .modal-body {
                min-height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
        @endpush

        @push('scripts')
            <script>
                // Pastikan jQuery sudah dimuat
                document.addEventListener('DOMContentLoaded', function() {
                    // Jika jQuery tersedia, gunakan jQuery
                    if (typeof $ !== 'undefined') {
                        initializeWithJQuery();
                    } else {
                        // Jika jQuery tidak tersedia, gunakan Vanilla JavaScript
                        initializeWithVanillaJS();
                    }
                });

                function initializeWithJQuery() {
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

                    // Handle KTP image preview modal
                    $('#ktpModal').on('show.bs.modal', function (event) {
                        const button = $(event.relatedTarget);
                        const ktpImageSrc = button.data('ktp-image');
                        const customerName = button.data('customer-name');

                        const modal = $(this);
                        const modalTitle = modal.find('#ktpModalLabel');
                        const imageLoader = modal.find('#ktpImageLoader');
                        const previewImage = modal.find('#ktpPreviewImage');
                        const noImageText = modal.find('#ktpNoImage');

                        // Update modal title
                        modalTitle.text(`Foto KTP - ${customerName}`);

                        // Reset modal state
                        imageLoader.show();
                        previewImage.hide();
                        noImageText.hide();

                        if (ktpImageSrc) {
                            // Create new image object to preload
                            const img = new Image();

                            img.onload = function() {
                                imageLoader.hide();
                                previewImage.attr('src', ktpImageSrc).show();
                            };

                            img.onerror = function() {
                                imageLoader.hide();
                                noImageText.show();
                            };

                            img.src = ktpImageSrc;
                        } else {
                            imageLoader.hide();
                            noImageText.show();
                        }
                    });

                    // Reset modal when closed
                    $('#ktpModal').on('hidden.bs.modal', function () {
                        const modal = $(this);
                        modal.find('#ktpPreviewImage').attr('src', '').hide();
                        modal.find('#ktpImageLoader').show();
                        modal.find('#ktpNoImage').hide();
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
                }

                function initializeWithVanillaJS() {
                    // Initialize tooltips (Bootstrap 5)
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });

                    // Handle form submission with loading state
                    const filterForm = document.getElementById('filterForm');
                    const filterButton = document.getElementById('filterButton');

                    if (filterForm && filterButton) {
                        filterForm.addEventListener('submit', function() {
                            const spinner = filterButton.querySelector('.spinner-border');
                            if (spinner) {
                                spinner.classList.remove('d-none');
                            }
                            filterButton.disabled = true;
                        });
                    }

                    // Handle select all checkbox
                    const selectAllCheckbox = document.getElementById('selectAll');
                    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
                    const bulkEditBtn = document.getElementById('bulkEdit');

                    if (selectAllCheckbox && orderCheckboxes.length > 0) {
                        selectAllCheckbox.addEventListener('change', function() {
                            orderCheckboxes.forEach(checkbox => {
                                checkbox.checked = this.checked;
                            });
                            toggleBulkActions();
                        });

                        orderCheckboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', toggleBulkActions);
                        });
                    }

                    function toggleBulkActions() {
                        const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
                        if (bulkEditBtn) {
                            bulkEditBtn.disabled = checkedCount === 0;
                        }
                    }

                    // Handle view toggle (list/grid)
                    const viewButtons = document.querySelectorAll('[data-view]');
                    viewButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            viewButtons.forEach(btn => btn.classList.remove('active'));
                            this.classList.add('active');
                        });
                    });

                    // Handle KTP image preview modal
                    const ktpModal = document.getElementById('ktpModal');
                    const ktpThumbnails = document.querySelectorAll('.ktp-thumbnail[data-bs-toggle="modal"]');

                    if (ktpModal && ktpThumbnails.length > 0) {
                        ktpModal.addEventListener('show.bs.modal', function (event) {
                            const button = event.relatedTarget;
                            const ktpImageSrc = button.getAttribute('data-ktp-image');
                            const customerName = button.getAttribute('data-customer-name');

                            const modalTitle = ktpModal.querySelector('#ktpModalLabel');
                            const imageLoader = ktpModal.querySelector('#ktpImageLoader');
                            const previewImage = ktpModal.querySelector('#ktpPreviewImage');
                            const noImageText = ktpModal.querySelector('#ktpNoImage');

                            // Update modal title
                            if (modalTitle) {
                                modalTitle.textContent = `Foto KTP - ${customerName}`;
                            }

                            // Reset modal state
                            if (imageLoader) imageLoader.style.display = 'block';
                            if (previewImage) previewImage.style.display = 'none';
                            if (noImageText) noImageText.style.display = 'none';

                            if (ktpImageSrc) {
                                // Create new image object to preload
                                const img = new Image();

                                img.onload = function() {
                                    if (imageLoader) imageLoader.style.display = 'none';
                                    if (previewImage) {
                                        previewImage.src = ktpImageSrc;
                                        previewImage.style.display = 'block';
                                    }
                                };

                                img.onerror = function() {
                                    if (imageLoader) imageLoader.style.display = 'none';
                                    if (noImageText) noImageText.style.display = 'block';
                                };

                                img.src = ktpImageSrc;
                            } else {
                                if (imageLoader) imageLoader.style.display = 'none';
                                if (noImageText) noImageText.style.display = 'block';
                            }
                        });

                        // Reset modal when closed
                        ktpModal.addEventListener('hidden.bs.modal', function () {
                            const previewImage = ktpModal.querySelector('#ktpPreviewImage');
                            const imageLoader = ktpModal.querySelector('#ktpImageLoader');
                            const noImageText = ktpModal.querySelector('#ktpNoImage');

                            if (previewImage) {
                                previewImage.src = '';
                                previewImage.style.display = 'none';
                            }
                            if (imageLoader) imageLoader.style.display = 'block';
                            if (noImageText) noImageText.style.display = 'none';
                        });
                    }

                    // Handle delete button click
                    const deleteButtons = document.querySelectorAll('button[data-bs-target="#deleteModal"]');
                    const deleteForm = document.getElementById('deleteForm');
                    const deleteModalMessage = document.getElementById('deleteModalMessage');

                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const orderId = this.getAttribute('data-order-id');
                            const orderNumber = this.getAttribute('data-order-number');

                            if (deleteModalMessage) {
                                deleteModalMessage.textContent = `Apakah Anda yakin ingin menghapus Pesanan #${orderNumber}?`;
                            }
                            if (deleteForm) {
                                deleteForm.action = `{{ url('dashboard/orders') }}/${orderId}`;
                            }
                        });
                    });

                    // Handle confirm delete in modal
                    const confirmDeleteBtn = document.getElementById('confirmDelete');
                    if (confirmDeleteBtn && deleteForm) {
                        confirmDeleteBtn.addEventListener('click', function() {
                            deleteForm.submit();
                        });
                    }
                }
            </script>
        @endpush
    @endsection
