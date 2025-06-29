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
                    <form action="{{ route('dashboard.orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label fw-semibold">Pengguna</label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                    <option value="">Pilih Pengguna (Opsional untuk Offline)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            data-email="{{ $user->email }}"
                                            data-phone="{{ $user->phone_number }}"
                                            {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
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

                            <div class="col-12">
                                <label for="foto_ktp" class="form-label fw-semibold">Foto KTP</label>

                                @if($order->foto_ktp)
                                    <div class="mb-3">
                                        <p>Foto KTP Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $order->foto_ktp) }}"
                                             alt="Foto KTP"
                                             class="img-thumbnail"
                                             style="max-width: 300px; max-height: 200px;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="hapus_foto_ktp" id="hapus_foto_ktp">
                                            <label class="form-check-label" for="hapus_foto_ktp">
                                                Hapus foto saat ini
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                <input type="file" name="foto_ktp" id="foto_ktp"
                                       class="form-control @error('foto_ktp') is-invalid @enderror"
                                       accept="image/jpeg,image/png,image/jpg">
                                <div class="form-text">
                                    Unggah foto KTP (format: JPEG, PNG, JPG, maksimal 2MB)
                                </div>
                                @error('foto_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="product_id" class="form-label fw-semibold">Motor</label>
                                <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                                    <option value="">Pilih Motor</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                            data-harga-harian="{{ $product->harga_harian }}"
                                            data-harga-mingguan="{{ $product->harga_mingguan }}"
                                            data-harga-bulanan="{{ $product->harga_bulanan }}"
                                            {{ old('product_id', $order->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->nama_motor }} ({{ $product->brand }}) - Rp {{ number_format($product->harga_harian) }}/hari
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
                                       min="1" readonly>
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
                                       min="0" readonly>
                                <div class="form-text text-end fw-bold" id="total_harga_text">
                                    Rp {{ number_format(old('total_harga', $order->total_harga), 0, ',', '.') }}
                                </div>
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
                minDate: new Date(),
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
                minDate: new Date(),
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

                    // Auto-fill email and phone if user is selected
                    const selectedUser = $('#user_id option:selected');
                    $('#email').val(selectedUser.data('email'));
                    $('#phone_number').val(selectedUser.data('phone'));
                } else {
                    $('#name_field, #phone_number_field, #email_field').show();
                    $('#name, #phone_number, #email').prop('disabled', false);
                }
            }

            // Calculate duration between dates
            function calculateDuration() {
                const startDate = new Date($('#tanggal_mulai').val());
                const endDate = new Date($('#tanggal_selesai').val());

                if (startDate && endDate && endDate > startDate) {
                    const diffTime = endDate - startDate;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    $('#durasi_hari').val(diffDays);
                    calculateTotalPrice();
                } else {
                    $('#durasi_hari').val(0);
                    $('#total_harga').val(0);
                    $('#total_harga_text').text('Rp 0');
                }
            }

            // Calculate total price based on product, duration, and rental type
            function calculateTotalPrice() {
                const productId = $('#product_id').val();
                const duration = parseInt($('#durasi_hari').val()) || 0;
                const rentalType = $('#tipe_sewa').val();

                if (productId && duration > 0) {
                    const selectedProduct = $('#product_id option:selected');
                    let pricePerUnit = 0;

                    if (rentalType === 'harian') {
                        pricePerUnit = parseFloat(selectedProduct.data('harga-harian'));
                    } else if (rentalType === 'mingguan') {
                        pricePerUnit = parseFloat(selectedProduct.data('harga-mingguan'));
                        // Convert weeks to days for display (7 days = 1 week)
                    } else if (rentalType === 'bulanan') {
                        pricePerUnit = parseFloat(selectedProduct.data('harga-bulanan'));
                        // Convert months to days for display (30 days = 1 month)
                    }

                    const totalPrice = pricePerUnit * duration;
                    $('#total_harga').val(totalPrice);
                    $('#total_harga_text').text('Rp ' + totalPrice.toLocaleString('id-ID'));
                } else {
                    $('#total_harga').val(0);
                    $('#total_harga_text').text('Rp 0');
                }
            }

            // Initial toggle based on current user_id value
            toggleFields();

            // Event listeners
            $('#user_id').on('change', toggleFields);

            $('#tanggal_mulai, #tanggal_selesai').on('apply.daterangepicker', function() {
                calculateDuration();
            });

            $('#product_id, #tipe_sewa, #durasi_hari').on('change', function() {
                calculateTotalPrice();
            });

            // Preview image before upload
            $('#foto_ktp').on('change', function() {
                const file = this.files[0];
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB');
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Create preview if not exists
                        if ($('#foto_ktp_preview').length === 0) {
                            $('<div class="mb-3"><p>Preview Foto Baru:</p>' +
                              '<img id="foto_ktp_preview" src="" alt="Preview Foto KTP" ' +
                              'class="img-thumbnail" style="max-width: 300px; max-height: 200px;"></div>')
                              .insertBefore('#foto_ktp');
                        }
                        $('#foto_ktp_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Initial calculations
            calculateDuration();
            calculateTotalPrice();
        });
    </script>
    @endpush
@endsection
