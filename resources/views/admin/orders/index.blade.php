@extends('layouts.app')

@section('title', 'Daftar Pesanan')
@section('page-title', 'Daftar Pesanan')
@section('page-description', 'Kelola semua pesanan sewa motor.')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Pesanan</h5>
                    <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Pesanan
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('dashboard.orders.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari nama atau motor..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="belum_dikonfirmasi" {{ request('status') == 'belum_dikonfirmasi' ? 'selected' : '' }}>Belum Dikonfirmasi</option>
                                    <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Pembayaran Dikonfirmasi</option>
                                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="date_range" id="date_range" class="form-control"
                                    placeholder="Pilih rentang tanggal" value="{{ request('date_range') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Motor</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Total Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user ? $order->user->name : $order->name }}</td>
                                        <td>{{ $order->product ? $order->product->nama_motor : 'Motor Tidak Ditemukan' }}</td>
                                        <td>
                                            @if ($order->product && $order->product->gambar_utama)
                                                <img src="{{ asset('storage/' . $order->product->gambar_utama) }}"
                                                    alt="Gambar Motor" class="img-thumbnail" style="max-width: 100px;">
                                            @else
                                                <span>Tidak Ada Gambar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->status === 'belum_dikonfirmasi')
                                                <span class="badge bg-secondary">Belum Dikonfirmasi</span>
                                            @elseif($order->status === 'dikonfirmasi')
                                                <span class="badge bg-success">Dikonfirmasi</span>
                                            @elseif($order->status === 'pending')
                                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                                            @elseif($order->status === 'confirmed')
                                                <span class="badge bg-primary">Pembayaran Dikonfirmasi</span>
                                            @elseif($order->status === 'ongoing')
                                                <span class="badge bg-info">Sedang Berlangsung</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($order->status === 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @elseif($order->status === 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->tanggal_mulai)->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('dashboard.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if(Auth::user()->isRental())
                                                @if($order->status === 'belum_dikonfirmasi')
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $order->id }}" title="Konfirmasi Pesanan">
                                                        <i class="fas fa-check"></i> Konfirmasi
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $order->id }}" title="Tolak Pesanan">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>

                                                    <!-- Verification Modal -->
                                                    <div class="modal fade" id="verifyModal{{ $order->id }}" tabindex="-1" aria-labelledby="verifyModalLabel{{ $order->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('dashboard.orders.verify', $order) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="approve">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="verifyModalLabel{{ $order->id }}">Konfirmasi Pesanan</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="ongkir{{ $order->id }}" class="form-label">Ongkos Kirim (Rp)</label>
                                                                            <input type="number" class="form-control" id="ongkir{{ $order->id }}" name="ongkir" required min="0" value="{{ old('ongkir', $order->ongkir ?? 0) }}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="catatan{{ $order->id }}" class="form-label">Catatan (Opsional)</label>
                                                                            <textarea class="form-control" id="catatan{{ $order->id }}" name="catatan" rows="3">{{ old('catatan', $order->catatan ?? '') }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Rejection Modal -->
                                                    <div class="modal fade" id="rejectModal{{ $order->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $order->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('dashboard.orders.verify', $order) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="reject">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="rejectModalLabel{{ $order->id }}">Tolak Pesanan</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="catatan_ditolak{{ $order->id }}" class="form-label">Alasan Penolakan</label>
                                                                            <textarea class="form-control" id="catatan_ditolak{{ $order->id }}" name="catatan_ditolak" rows="3" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger">Tolak Pesanan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($order->status === 'confirmed')
                                                    <form action="{{ route('dashboard.orders.mark-as-ongoing', $order) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" title="Tandai sebagai Ongoing">
                                                            <i class="fas fa-play"></i> Mulai
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif

                                            <a href="{{ route('dashboard.orders.edit', $order) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada pesanan ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Date Range Picker -->
        <script>
            $(document).ready(function() {
                $('#date_range').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD',
                        applyLabel: 'Terapkan',
                        cancelLabel: 'Batal',
                        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        monthNames: [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ],
                        firstDay: 1
                    }
                });

                // Validation for verification modal
                $('[id^="verifyModal"] form').on('submit', function(e) {
                    const ongkirInput = $(this).find('input[name="ongkir"]');
                    const ongkir = ongkirInput.val();

                    if (!ongkir || isNaN(ongkir) || parseFloat(ongkir) < 0) {
                        e.preventDefault();
                        alert('Harap masukkan ongkos kirim yang valid (angka positif)');
                        ongkirInput.focus();
                        return false;
                    }
                });

                // Validation for rejection modal
                $('[id^="rejectModal"] form').on('submit', function(e) {
                    const reasonInput = $(this).find('textarea[name="catatan_ditolak"]');
                    const reason = reasonInput.val().trim();

                    if (!reason) {
                        e.preventDefault();
                        alert('Harap masukkan alasan penolakan');
                        reasonInput.focus();
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
