@extends('layouts.app')

@section('title', 'Tambah Pesanan')
@section('page-title', 'Tambah Pesanan Baru')
@section('page-description', 'Buat pesanan sewa motor baru.')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">Formulir Pesanan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.orders.store') }}" method="POST" id="orderForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <!-- Customer Section -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label fw-semibold">Pengguna (Opsional)</label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                    <option value="">Tanpa Pengguna</option>
                                    @foreach (\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="product_id" class="form-label fw-semibold">Motor <span class="text-danger">*</span></label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="">Pilih Motor</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                                data-harian="{{ $product->harga_harian }}"
                                                data-mingguan="{{ $product->harga_mingguan }}"
                                                data-bulanan="{{ $product->harga_bulanan }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->nama_motor }} ({{ $product->brand }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Guest Fields -->
                            <div class="col-md-4" id="name_field">
                                <label for="name" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Masukkan nama pelanggan">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4" id="phone_field">
                                <label for="phone_number" class="form-label fw-semibold">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                       value="{{ old('phone_number') }}" placeholder="Masukkan nomor HP">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4" id="email_field">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="Masukkan email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rental Period Section -->
                            <div class="col-md-3">
                                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                       value="{{ old('tanggal_mulai') }}" min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="waktu_mulai" class="form-label fw-semibold">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror"
                                       value="{{ old('waktu_mulai', '08:00') }}" required>
                                @error('waktu_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                       value="{{ old('tanggal_selesai') }}" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="waktu_selesai" class="form-label fw-semibold">Waktu Selesai <span class="text-danger">*</span></label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror"
                                       value="{{ old('waktu_selesai', '17:00') }}" required>
                                @error('waktu_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rental Details Section -->
                            <div class="col-md-3">
                                <label for="durasi_hari" class="form-label fw-semibold">Durasi Hari</label>
                                <input type="number" name="durasi_hari" id="durasi_hari" class="form-control @error('durasi_hari') is-invalid @enderror"
                                       value="{{ old('durasi_hari', 1) }}" min="1" readonly>
                                @error('durasi_hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tipe_sewa" class="form-label fw-semibold">Tipe Sewa <span class="text-danger">*</span></label>
                                <select name="tipe_sewa" id="tipe_sewa" class="form-select @error('tipe_sewa') is-invalid @enderror" required>
                                    <option value="harian" {{ old('tipe_sewa') == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="mingguan" {{ old('tipe_sewa') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ old('tipe_sewa') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                </select>
                                @error('tipe_sewa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="total_harga" class="form-label fw-semibold">Total Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="total_harga" id="total_harga" class="form-control @error('total_harga') is-invalid @enderror"
                                       value="{{ old('total_harga') }}" min="0" step="1000" required>
                                @error('total_harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="ongkir" class="form-label fw-semibold">Ongkos Kirim (Rp)</label>
                                <input type="number" name="ongkir" id="ongkir" class="form-control @error('ongkir') is-invalid @enderror"
                                       value="{{ old('ongkir', 0) }}" min="0" step="1000">
                                @error('ongkir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status and Notes Section -->
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="belum_dikonfirmasi" {{ old('status') == 'belum_dikonfirmasi' ? 'selected' : '' }}>Belum Dikonfirmasi</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="dikonfirmasi" {{ old('status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="foto_ktp" class="form-label fw-semibold">Foto KTP</label>
                                <input type="file" name="foto_ktp" id="foto_ktp" class="form-control @error('foto_ktp') is-invalid @enderror"
                                       accept="image/*">
                                @error('foto_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPEG, PNG, JPG (maks. 2MB)</small>
                            </div>

                            <div class="col-12">
                                <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror"
                                          rows="3">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lokasi_pengambilan" class="form-label fw-semibold">Lokasi Pengambilan</label>
                                <input type="text" name="lokasi_pengambilan" id="lokasi_pengambilan" class="form-control @error('lokasi_pengambilan') is-invalid @enderror"
                                       value="{{ old('lokasi_pengambilan') }}" placeholder="Masukkan lokasi pengambilan">
                                @error('lokasi_pengambilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lokasi_pengembalian" class="form-label fw-semibold">Lokasi Pengembalian</label>
                                <input type="text" name="lokasi_pengembalian" id="lokasi_pengembalian" class="form-control @error('lokasi_pengembalian') is-invalid @enderror"
                                       value="{{ old('lokasi_pengembalian') }}" placeholder="Masukkan lokasi pengembalian">
                                @error('lokasi_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Section -->
                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" id="submitButton">
                                        <i class="fas fa-save me-1"></i> Simpan Pesanan
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
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
            $(document).ready(function() {
                // Toggle guest fields based on user selection
                function toggleGuestFields() {
                    const userId = $('#user_id').val();
                    if (userId) {
                        $('#name_field, #phone_field, #email_field').hide().find('input').prop('disabled', true);
                    } else {
                        $('#name_field, #phone_field, #email_field').show().find('input').prop('disabled', false);
                    }
                }

                // Calculate rental duration
                function calculateDuration() {
                    const startDate = $('#tanggal_mulai').val();
                    const endDate = $('#tanggal_selesai').val();

                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                        $('#durasi_hari').val(diffDays > 0 ? diffDays : 1);

                        // Auto-select rental type based on duration
                        if (diffDays >= 30) {
                            $('#tipe_sewa').val('bulanan');
                        } else if (diffDays >= 7) {
                            $('#tipe_sewa').val('mingguan');
                        } else {
                            $('#tipe_sewa').val('harian');
                        }
                    }
                }

                // Calculate total price
                function calculateTotalPrice() {
                    const productId = $('#product_id').val();
                    const duration = parseInt($('#durasi_hari').val()) || 1;
                    const rentalType = $('#tipe_sewa').val();
                    const shippingCost = parseFloat($('#ongkir').val()) || 0;

                    if (productId) {
                        const product = $('#product_id option:selected');
                        const dailyPrice = parseFloat(product.data('harian'));
                        const weeklyPrice = parseFloat(product.data('mingguan'));
                        const monthlyPrice = parseFloat(product.data('bulanan'));

                        let subtotal = 0;

                        if (rentalType === 'bulanan' && duration >= 30) {
                            const months = Math.floor(duration / 30);
                            const remainingDays = duration % 30;
                            subtotal = months * monthlyPrice;

                            if (remainingDays > 0) {
                                if (remainingDays >= 7) {
                                    const weeks = Math.floor(remainingDays / 7);
                                    const extraDays = remainingDays % 7;
                                    subtotal += weeks * weeklyPrice + extraDays * dailyPrice;
                                } else {
                                    subtotal += remainingDays * dailyPrice;
                                }
                            }
                        } else if (rentalType === 'mingguan' && duration >= 7) {
                            const weeks = Math.floor(duration / 7);
                            const remainingDays = duration % 7;
                            subtotal = weeks * weeklyPrice + remainingDays * dailyPrice;
                        } else {
                            subtotal = duration * dailyPrice;
                        }

                        $('#total_harga').val(subtotal + shippingCost);
                    }
                }

                // Initialize
                toggleGuestFields();

                // Event listeners
                $('#user_id').on('change', toggleGuestFields);
                $('#tanggal_mulai, #tanggal_selesai').on('change', function() {
                    const startDate = $('#tanggal_mulai').val();
                    if (startDate) {
                        const minEndDate = new Date(startDate);
                        minEndDate.setDate(minEndDate.getDate() + 1);
                        $('#tanggal_selesai').attr('min', minEndDate.toISOString().split('T')[0]);
                    }
                    calculateDuration();
                    calculateTotalPrice();
                });

                $('#product_id, #tipe_sewa, #ongkir').on('change', calculateTotalPrice);
                $('#durasi_hari').on('change', calculateTotalPrice);

                // Form submission
                $('#orderForm').on('submit', function() {
                    $('#submitButton').prop('disabled', true);
                    $('#submitButton .spinner-border').removeClass('d-none');
                });

                // If old values exist, calculate them
                if ($('#tanggal_mulai').val() && $('#tanggal_selesai').val()) {
                    calculateDuration();
                    calculateTotalPrice();
                }
            });
        </script>
    @endpush
@endsection
