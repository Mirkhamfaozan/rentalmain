@extends('layouts.app')

@section('title', 'Dasbor')
@section('page-title', 'Dasbor')
@section('page-description', 'Selamat datang kembali, Berikut adalah yang terjadi dengan bisnis Anda hari ini.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Ekspor
        </button>
        @if(auth()->user()->isAdmin() || auth()->user()->isRental())
            <button type="button" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Tambah Baru
            </button>
        @endif
    </div>
@endsection

@section('content')
    <!-- Kartu Statistik -->
    <div class="row mb-4">
        @if(auth()->user()->isAdmin())
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ number_format($data['cards']['total_users']) }}</div>
                                <div class="text-muted small">Total Pengguna</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +12.5%
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
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ number_format($data['cards']['total_orders']) }}</div>
                                <div class="text-muted small">Total Pesanan</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +8.2%
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
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">Rp{{ number_format($data['cards']['total_revenue'], 0, ',', '.') }}</div>
                                <div class="text-muted small">Total Pendapatan</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +15.3%
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
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ $data['cards']['pending_payments'] }}</div>
                                <div class="text-muted small">Pembayaran Tertunda</div>
                                <div class="text-danger small">
                                    <i class="fas fa-arrow-down"></i> -2.1%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->isRental())
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ number_format($data['cards']['total_products']) }}</div>
                                <div class="text-muted small">Total Produk</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +10.0%
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
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ number_format($data['cards']['total_orders']) }}</div>
                                <div class="text-muted small">Total Pesanan</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +8.2%
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
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">Rp{{ number_format($data['cards']['total_revenue'], 0, ',', '.') }}</div>
                                <div class="text-muted small">Total Pendapatan</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +15.3%
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
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ $data['cards']['pending_orders'] }}</div>
                                <div class="text-muted small">Pesanan Tertunda</div>
                                <div class="text-danger small">
                                    <i class="fas fa-arrow-down"></i> -2.1%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ number_format($data['cards']['total_orders']) }}</div>
                                <div class="text-muted small">Total Pesanan</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +10.0%
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
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">Rp{{ number_format($data['cards']['total_spent'], 0, ',', '.') }}</div>
                                <div class="text-muted small">Total Pengeluaran</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +8.2%
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
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 48px; height: 48px;">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ $data['cards']['active_rentals'] }}</div>
                                <div class="text-muted small">Sewa Aktif</div>
                                <div class="text-success small">
                                    <i class="fas fa-arrow-up"></i> +5.0%
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
                                    <i class="fas fa-credit-card"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold h4 mb-1">{{ $data['cards']['pending_payments'] }}</div>
                                <div class="text-muted small">Pembayaran Tertunda</div>
                                <div class="text-danger small">
                                    <i class="fas fa-arrow-down"></i> -2.1%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Baris Grafik dan Aktivitas -->
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">
                        @if(auth()->user()->isCustomer())
                            Pengeluaran Bulanan
                        @else
                            Analisis Pendapatan
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($data['tables']['recent_orders'] as $order)
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'primary' : 'warning') }} text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 32px; height: 32px;">
                                        <i class="fas fa-{{ $order->status == 'completed' ? 'shopping-cart' : ($order->status == 'pending' ? 'clock' : 'exclamation') }} fa-sm"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small">
                                            Pesanan #{{ $order->id }}
                                            @if($order->status == 'completed')
                                                selesai
                                            @elseif($order->status == 'pending')
                                                tertunda
                                            @elseif($order->status == 'ongoing')
                                                berlangsung
                                            @else
                                                {{ $order->status }}
                                            @endif
                                        </div>
                                        <div class="text-muted small">{{ $order->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pesanan Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                        @if(auth()->user()->isAdmin() || auth()->user()->isRental())
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Pesanan Baru
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">ID Pesanan</th>
                                    <th class="border-0 fw-semibold">Pelanggan</th>
                                    <th class="border-0 fw-semibold">Produk</th>
                                    <th class="border-0 fw-semibold">Jumlah</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Tanggal</th>
                                    <th class="border-0 fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['tables']['recent_orders'] as $order)
                                    <tr>
                                        <td class="fw-bold text-primary">#{{ $order->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-{{ $order->user ? ($order->status == 'completed' ? 'success' : 'secondary') : 'danger' }} text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 32px; height: 32px; font-size: 12px;">
                                                    {{ $order->user ? substr($order->user->name, 0, 2) : 'TA' }}
                                                </div>
                                                {{ $order->user ? $order->user->name : 'Tidak Diketahui' }}
                                            </div>
                                        </td>
                                        <td>{{ $order->product ? $order->product->name : 'Tidak Diketahui' }}</td>
                                        <td class="fw-bold">Rp{{ number_format($order->payment ? $order->payment->gross_amount : 0, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'primary' : ($order->status == 'ongoing' ? 'warning' : 'danger')) }}">
                                                @if($order->status == 'completed')
                                                    Selesai
                                                @elseif($order->status == 'pending')
                                                    Tertunda
                                                @elseif($order->status == 'ongoing')
                                                    Berlangsung
                                                @elseif($order->status == 'cancelled')
                                                    Dibatalkan
                                                @else
                                                    {{ ucfirst($order->status) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginasi -->
                    <div class="card-footer bg-transparent border-0">
                        <nav>
                            <ul class="pagination pagination-sm justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Selanjutnya</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Chart.js -->
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const chartData = @json(auth()->user()->isCustomer() ? $data['charts']['monthly_spending'] : $data['charts']['monthly_revenue']);
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dataValues = labels.map(month => chartData[month] || 0);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '{{ auth()->user()->isCustomer() ? "Pengeluaran Bulanan" : "Pendapatan Bulanan" }}',
                        data: dataValues,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // AJAX untuk mengambil statistik real-time
            async function fetchStats() {
                try {
                    const response = await fetch('/dashboard/stats', {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const stats = await response.json();
                    // Update statistik secara dinamis (contoh: update total_orders_today untuk admin)
                    console.log(stats); // Implementasikan update DOM sesuai kebutuhan
                } catch (error) {
                    console.error('Error mengambil statistik:', error);
                }
            }

            // Ambil statistik setiap 30 detik
            setInterval(fetchStats, 30000);
            fetchStats(); // Ambil data awal
        </script>
    @endsection
@endsection
