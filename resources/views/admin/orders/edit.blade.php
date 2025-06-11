@extends('layouts.app')

@section('title', 'Edit Pesanan')
@section('page-title', 'Edit Pesanan')
@section('page-description', 'Perbarui detail pesanan sewa motor.')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">Edit Pesanan #{{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label fw-semibold">Pengguna</label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                    <option value="">Pilih Pengguna (Opsional untuk Offline)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="name_field">
                                <label for="name" class="form-label fw-semibold">Nama</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $order->name) }}"
                                       placeholder="Masukkan nama pelanggan">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="phone_number_field">
                                <label for="phone_number" class="form-label fw-semibold">Nomor HP</label>
                                <input type="text" name="phone_number" id="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       value="{{ old('phone_number', $order->phone_number) }}"
                                       placeholder="Masukkan nomor HP">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="email_field">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $order->email) }}"
                                       placeholder="Masukkan email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="product_id" class="form-label fw-semibold">Motor</label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                                    <option value="">Pilih Motor</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id', $order->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->nama_motor }} ({{ $product->brand }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" name="tanggal_mulai" id="tanggal_mulai"
                                           class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($order->tanggal_mulai)->format('Y-m-d')) }}"
                                           placeholder="Pilih tanggal mulai">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="text" name="tanggal_selesai" id="tanggal_selesai"
                                           class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                           value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($order->tanggal_selesai)->format('Y-m-d')) }}"
                                           placeholder="Pilih tanggal selesai">
                                       </div>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="durasi_hari" class="form-label fw-semibold">Durasi Hari</label>
                                <input type="number" name="durasi_hari" id="durasi_hari"
                                       class="form-control @error('durasi_hari') is-invalid @enderror"
                                       value="{{ old('durasi_hari', $order->durasi_hari) }}"
                                       min="1">
                                @error('durasi_hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tipe_sewa" class="form-label fw-semibold">Tipe Sewa</label>
                                <select name="tipe_sewa" id="tipe_sewa" class="form-select @error('tipe_sewa') is-invalid @enderror">
                                    <option value="harian" {{ old('tipe_sewa', $order->tipe_sewa) == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="mingguan" {{ old('tipe_sewa', $order->tipe_sewa) == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ old('tipe_sewa', $order->tipe_sewa) == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                </select>
                                @error('tipe_sewa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="total_harga" class="form-label fw-semibold">Total Harga (Rp)</label>
                                <input type="number" name="total_harga" id="total_harga"
                                       class="form-control @error('total_harga') is-invalid @enderror"
                                       value="{{ old('total_harga', $order->total_harga) }}"
                                       min="0">
                                @error('total_harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="ongoing" {{ old('status', $order->status) == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                <textarea name="catatan" id="catatan"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          rows="4">{{ old('catatan', $order->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lokasi_pengambilan" class="form-label fw-semibold">Lokasi Pengambilan</label>
                                <input type="text" name="lokasi_pengambilan" id="lokasi_pengambilan"
                                       class="form-control @error('lokasi_pengambilan') is-invalid @enderror"
                                       value="{{ old('lokasi_pengambilan', $order->lokasi_pengambilan) }}"
                                       placeholder="Masukkan lokasi pengambilan">
                                @error('lokasi_pengambilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lokasi_pengembalian" class="form-label fw-semibold">Lokasi Pengembalian</label>
                                <input type="text" name="lokasi_pengembalian" id="lokasi_pengembalian"
                                       class="form-control @error('lokasi_pengembalian') is-invalid @enderror"
                                       value="{{ old('lokasi_pengembalian', $order->lokasi_pengembalian) }}"
                                       placeholder="Masukkan lokasi pengembalian">
                                @error('lokasi_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Perbarui Pesanan
                                    </button>
                                    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize datepickers
            $('#tanggal_mulai').daterangepicker({
                singleDatePicker: true,
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

            $('#tanggal_selesai').daterangepicker({
                singleDatePicker: true,
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

            // Function to toggle visibility of name, phone_number, and email fields
            function toggleFields() {
                if ($('#user_id').val() !== '') {
                    $('#name_field, #phone_number_field, #email_field').hide();
                    $('#name, #phone_number, #email').prop('disabled', true);
                } else {
                    $('#name_field, #phone_number_field, #email_field').show();
                    $('#name, #phone_number, #email').prop('disabled', false);
                }
            }

            // Initial toggle based on current user_id value
            toggleFields();

            // Toggle fields when user_id changes
            $('#user_id').on('change', toggleFields);
        });
    </script>
    @endpush
@endsection
