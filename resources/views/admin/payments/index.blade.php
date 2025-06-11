@extends('layouts.app')

@section('title', 'Pembayaran')
@section('page-title', 'Daftar Pembayaran')
@section('page-description', 'Kelola pembayaran untuk pesanan sewa motor Anda.')


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

    <!-- Kartu Statistik Pembayaran -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $payments->count() }}</div>
                            <div class="text-muted small">Total Pembayaran</div>
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
                            <div class="fw-bold h4 mb-1">{{ $payments->where('status', 'success')->count() }}</div>
                            <div class="text-muted small">Berhasil</div>
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
                            <div class="fw-bold h4 mb-1">{{ $payments->where('status', 'pending')->count() }}</div>
                            <div class="text-muted small">Menunggu</div>
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
                            <div class="fw-bold h4 mb-1">Rp {{ number_format($payments->where('status', 'success')->sum('gross_amount'), 0, ',', '.') }}</div>
                            <div class="text-muted small">Total Penerimaan</div>
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
                    <form method="GET" action="{{ route('dashboard.payments.index') }}" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="searchInput" class="form-label small fw-semibold">Cari Pembayaran</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                           placeholder="Cari berdasarkan nama pelanggan, motor, atau ID transaksi..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="statusSelect" class="form-label small fw-semibold">Status</label>
                                <select name="status" id="statusSelect" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Berhasil</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="dateRangePicker" class="form-label small fw-semibold">Rentang Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" name="date_range" class="form-control"
                                           placeholder="Pilih rentang tanggal"
                                           value="{{ request('date_range') }}"
                                           id="dateRangePicker">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-secondary" id="filterButton">
                                        <i class="fas fa-filter me-1"></i>Filter
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Pembayaran -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Pembayaran</h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary active" data-view="list" title="Tampilan daftar">
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
                                    <th class="border-0 fw-semibold" scope="col">ID Transaksi</th>
                                    <th class="border-0 fw-semibold" scope="col">Pesanan</th>
                                    <th class="border-0 fw-semibold" scope="col">Pelanggan</th>
                                    <th class="border-0 fw-semibold" scope="col">Motor</th>
                                    <th class="border-0 fw-semibold" scope="col">Jumlah</th>
                                    <th class="border-0 fw-semibold" scope="col">Status</th>
                                    <th class="border-0 fw-semibold" scope="col">Waktu Transaksi</th>
                                    <th class="border-0 fw-semibold" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input payment-checkbox" value="{{ $payment->id }}">
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $payment->transaction_id }}</div>
                                        <div class="text-muted small">{{ $payment->payment_type ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Pesanan #{{ $payment->order->id }}</div>
                                        <div class="text-muted small">{{ $payment->order->tipe_sewa }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $payment->order->name ?? $payment->order->user->name ?? '-' }}</div>
                                        <div class="text-muted small">{{ $payment->order->email ?? ($payment->order->user->email ?? '-') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($payment->order->product->gambar_utama)
                                            <img src="{{ Storage::url($payment->order->product->gambar_utama) }}"
                                                 class="rounded me-3"
                                                 style="width: 48px; height: 48px; object-fit: cover;"
                                                 alt="{{ $payment->order->product->nama_motor }}"
                                                 loading="lazy">
                                            @else
                                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                 style="width: 48px; height: 48px; font-size: 18px;">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $payment->order->product->nama_motor }}</div>
                                                <div class="text-muted small">{{ $payment->order->product->brand }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge
                                            @if($payment->status == 'pending') bg-warning-subtle text-warning
                                            @elseif($payment->status == 'success') bg-success-subtle text-success
                                            @elseif($payment->status == 'failed') bg-danger-subtle text-danger
                                            @elseif($payment->status == 'expired') bg-secondary-subtle text-secondary
                                            @else bg-info-subtle text-info @endif">
                                            {{ $payment->status_label }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->transaction_time ? \Carbon\Carbon::parse($payment->transaction_time)->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dashboard.payments.show', $payment) }}"
                                               class="btn btn-outline-primary" title="Lihat detail pembayaran">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-wallet fa-3x mb-3"></i>
                                            <p>Tidak ada pembayaran yang ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($payments->count() > 0)
                    <!-- Aksi Massal -->
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted small">Dengan yang dipilih:</span>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary" id="bulkEdit" disabled>
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-outline-danger" id="bulkDelete" disabled>
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                            <div>
                                {{ $payments->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
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
                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                alwaysShowCalendars: true,
                showDropdowns: true
            });

            $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
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
                $('.payment-checkbox').prop('checked', this.checked);
                toggleBulkActions();
            });

            // Handle individual checkbox changes
            $('.payment-checkbox').on('change', toggleBulkActions);

            function toggleBulkActions() {
                const checkedCount = $('.payment-checkbox:checked').length;
                $('#bulkEdit, #bulkDelete').prop('disabled', checkedCount === 0);
            }

            // Handle view toggle (list/grid)
            $('[data-view]').on('click', function() {
                $('[data-view]').removeClass('active');
                $(this).addClass('active');
                // Add grid view implementation here if needed
            });
        });
    </script>
    @endpush
@endsection
