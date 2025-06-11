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
                    <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label fw-semibold">Pengguna (Opsional)</label>
                                <select name="user_id" id="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror">
                                    <option value="">Tanpa Pengguna</option>
                                    @foreach (\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="product_id" class="form-label fw-semibold">Motor</label>
                                <select name="product_id" id="product_id"
                                        class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="">Pilih Motor</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->nama_motor }} ({{ $product->brand }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4" id="name_field">
                                <label for="name" class="form-label fw-semibold">Nama</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Masukkan nama pelanggan">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4" id="phone_field">
                                <label for="phone_number" class="form-label fw-semibold">Nomor HP</label>
                                <input type="text" name="phone_number" id="phone_number"
                                       class="form-control @error('phone_number') is-invalid @enderror"
                                       value="{{ old('phone_number') }}" placeholder="Masukkan nomor HP">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4" id="email_field">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="Masukkan email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                           class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           value="{{ old('tanggal_mulai') }}"
                                           min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                           required>
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
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                           class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                           value="{{ old('tanggal_selesai') }}"
                                           min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                                           required>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="durasi_hari" class="form-label fw-semibold">Durasi Hari</label>
                                <input type="number" name="durasi_hari" id="durasi_hari"
                                       class="form-control @error('durasi_hari') is-invalid @enderror"
                                       value="{{ old('durasi_hari', 1) }}" min="1" readonly>
                                @error('durasi_hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tipe_sewa" class="form-label fw-semibold">Tipe Sewa</label>
                                <select name="tipe_sewa" id="tipe_sewa"
                                        class="form-select @error('tipe_sewa') is-invalid @enderror" required>
                                    <option value="harian" {{ old('tipe_sewa') == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="mingguan" {{ old('tipe_sewa') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ old('tipe_sewa') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                </select>
                                @error('tipe_sewa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="total_harga" class="form-label fw-semibold">Total Harga (Rp)</label>
                                <input type="number" name="total_harga" id="total_harga"
                                       class="form-control @error('total_harga') is-invalid @enderror"
                                       value="{{ old('total_harga') }}" min="0" step="1" required>
                                @error('total_harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                <textarea name="catatan" id="catatan"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          rows="4">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lokasi_pengambilan" class="form-label fw-semibold">Lokasi Pengambilan</label>
                                <input type="text" name="lokasi_pengambilan" id="lokasi_pengambilan"
                                       class="form-control @error('lokasi_pengambilan') is-invalid @enderror"
                                       value="{{ old('lokasi_pengambilan') }}" placeholder="Masukkan lokasi pengambilan">
                                @error('lokasi_pengambilan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lokasi_pengembalian" class="form-label fw-semibold">Lokasi Pengembalian</label>
                                <input type="text" name="lokasi_pengembalian" id="lokasi_pengembalian"
                                       class="form-control @error('lokasi_pengembalian') is-invalid @enderror"
                                       value="{{ old('lokasi_pengembalian') }}" placeholder="Masukkan lokasi pengembalian">
                                @error('lokasi_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" id="submitButton">
                                        <i class="fas fa-save me-1"></i>Simpan Pesanan
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
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
            $(document).ready(function() {
                // Toggle name, phone, and email fields based on user_id selection
                function toggleGuestFields() {
                    const userId = $('#user_id').val();
                    const $guestFields = $('#name_field, #phone_field, #email_field');
                    if (userId) {
                        $guestFields.hide().find('input').prop('disabled', true).removeAttr('required');
                    } else {
                        $guestFields.show().find('input').prop('disabled', false).attr('required', true);
                    }
                }

                // Initialize guest fields visibility
                toggleGuestFields();

                // Update guest fields when user_id changes
                $('#user_id').on('change', toggleGuestFields);

                // Calculate duration based on date inputs
                function calculateDuration() {
                    const startDate = $('#tanggal_mulai').val();
                    const endDate = $('#tanggal_selesai').val();

                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const diffTime = end - start;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Include start day
                        $('#durasi_hari').val(diffDays > 0 ? diffDays : 1);
                    } else {
                        $('#durasi_hari').val(1);
                    }
                }

                // Update duration when dates change
                $('#tanggal_mulai, #tanggal_selesai').on('change', calculateDuration);

                // Initialize duration if old values exist
                if ($('#tanggal_mulai').val() && $('#tanggal_selesai').val()) {
                    calculateDuration();
                }

                // Handle form submission with loading state
                $('#orderForm').on('submit', function() {
                    $('#submitButton').find('.spinner-border').removeClass('d-none');
                    $('#submitButton').prop('disabled', true);
                });

                // Ensure end date is after start date
                $('#tanggal_mulai').on('change', function() {
                    const startDate = $(this).val();
                    if (startDate) {
                        const minEndDate = new Date(startDate);
                        minEndDate.setDate(minEndDate.getDate() + 1);
                        const minEndDateStr = minEndDate.toISOString().split('T')[0];
                        $('#tanggal_selesai').attr('min', minEndDateStr);
                        if ($('#tanggal_selesai').val() <= startDate) {
                            $('#tanggal_selesai').val('');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
