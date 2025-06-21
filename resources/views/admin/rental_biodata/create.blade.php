@extends('layouts.app')

@section('title', 'Tambah Biodata Rental')
@section('page-title', 'Tambah Biodata Rental Baru')
@section('page-description', 'Lengkapi formulir berikut untuk menambahkan biodata rental baru ke sistem.')

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('dashboard.rental_biodata.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Formulir Biodata Rental
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($users->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Tidak ada user dengan role rental yang tersedia atau semua user rental sudah memiliki biodata.
                            <a href="{{ route('dashboard.users.create') }}" class="alert-link">Tambah user rental baru</a>
                        </div>
                    @else
                        <form action="{{ route('dashboard.rental_biodata.store') }}" method="POST" enctype="multipart/form-data" id="rentalBiodataForm">
                            @csrf

                            <!-- Section 1: Informasi Dasar -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                </h6>
                                <div class="row g-3">
                                    <!-- User Selection -->
                                    <div class="col-md-6">
                                        <label for="user_id" class="form-label fw-bold">
                                            Pemilik Rental <span class="text-danger">*</span>
                                        </label>
                                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                            <option value="" selected disabled>Pilih Pemilik Rental</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Pilih user yang akan menjadi pemilik rental ini
                                        </small>
                                    </div>

                                    <!-- Nama Rental -->
                                    <div class="col-md-6">
                                        <label for="nama_rental" class="form-label fw-bold">
                                            Nama Rental <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nama_rental" id="nama_rental"
                                               class="form-control @error('nama_rental') is-invalid @enderror"
                                               value="{{ old('nama_rental') }}" required maxlength="255"
                                               placeholder="Contoh: CV. Rental Mobil Sejahtera">
                                        @error('nama_rental')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nama Pemilik -->
                                    <div class="col-md-6">
                                        <label for="nama_pemilik" class="form-label fw-bold">
                                            Nama Pemilik <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="nama_pemilik" id="nama_pemilik"
                                               class="form-control @error('nama_pemilik') is-invalid @enderror"
                                               value="{{ old('nama_pemilik') }}" required maxlength="255"
                                               placeholder="Nama lengkap pemilik rental">
                                        @error('nama_pemilik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email Perusahaan -->
                                    <div class="col-md-6">
                                        <label for="email_perusahaan" class="form-label fw-bold">
                                            Email Perusahaan
                                        </label>
                                        <input type="email" name="email_perusahaan" id="email_perusahaan"
                                               class="form-control @error('email_perusahaan') is-invalid @enderror"
                                               value="{{ old('email_perusahaan') }}" maxlength="255"
                                               placeholder="info@namarental.com">
                                        @error('email_perusahaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Opsional - email resmi perusahaan</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Informasi Kontak -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-phone me-2"></i>Informasi Kontak
                                </h6>
                                <div class="row g-3">
                                    <!-- No Telepon -->
                                    <div class="col-md-6">
                                        <label for="no_telepon" class="form-label fw-bold">
                                            No Telepon <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="no_telepon" id="no_telepon"
                                               class="form-control @error('no_telepon') is-invalid @enderror"
                                               value="{{ old('no_telepon') }}" required maxlength="20"
                                               placeholder="Contoh: 021-1234567 atau 081234567890">
                                        @error('no_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- No WhatsApp -->
                                    <div class="col-md-6">
                                        <label for="no_wa" class="form-label fw-bold">No WhatsApp</label>
                                        <input type="text" name="no_wa" id="no_wa"
                                               class="form-control @error('no_wa') is-invalid @enderror"
                                               value="{{ old('no_wa') }}" maxlength="20"
                                               placeholder="Contoh: 081234567890">
                                        @error('no_wa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Opsional - untuk komunikasi WhatsApp</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Alamat -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Perusahaan
                                </h6>
                                <div class="row g-3">
                                    <!-- Alamat -->
                                    <div class="col-12">
                                        <label for="alamat" class="form-label fw-bold">
                                            Alamat Lengkap <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="alamat" id="alamat"
                                                  class="form-control @error('alamat') is-invalid @enderror"
                                                  rows="3" required maxlength="500"
                                                  placeholder="Masukkan alamat lengkap termasuk nama jalan, nomor, RT/RW">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Maksimal 500 karakter</small>
                                    </div>

                                    <!-- Kota -->
                                    <div class="col-md-4">
                                        <label for="kota" class="form-label fw-bold">
                                            Kota/Kabupaten <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="kota" id="kota"
                                               class="form-control @error('kota') is-invalid @enderror"
                                               value="{{ old('kota') }}" required maxlength="100"
                                               placeholder="Contoh: Jakarta Selatan">
                                        @error('kota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Provinsi -->
                                    <div class="col-md-4">
                                        <label for="provinsi" class="form-label fw-bold">
                                            Provinsi <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="provinsi" id="provinsi"
                                               class="form-control @error('provinsi') is-invalid @enderror"
                                               value="{{ old('provinsi') }}" required maxlength="100"
                                               placeholder="Contoh: DKI Jakarta">
                                        @error('provinsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kode Pos -->
                                    <div class="col-md-4">
                                        <label for="kode_pos" class="form-label fw-bold">Kode Pos</label>
                                        <input type="text" name="kode_pos" id="kode_pos"
                                               class="form-control @error('kode_pos') is-invalid @enderror"
                                               value="{{ old('kode_pos') }}" maxlength="10"
                                               placeholder="Contoh: 12345">
                                        @error('kode_pos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Opsional</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: Dokumen -->
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-file-alt me-2"></i>Dokumen Persyaratan
                                </h6>
                                <div class="row g-3">
                                    <!-- Foto KTP -->
                                    <div class="col-md-4">
                                        <label for="foto_ktp" class="form-label fw-bold">Foto KTP Pemilik</label>
                                        <input type="file" name="foto_ktp" id="foto_ktp"
                                               class="form-control @error('foto_ktp') is-invalid @enderror"
                                               accept="image/jpeg,image/jpg,image/png">
                                        @error('foto_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format: JPG, JPEG, PNG (maksimal 2MB)
                                        </small>
                                        <div id="ktp-preview" class="mt-2" style="display: none;">
                                            <img src="" alt="Preview KTP" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    </div>

                                    <!-- Surat Izin Usaha -->
                                    <div class="col-md-4">
                                        <label for="foto_surat_izin_usaha" class="form-label fw-bold">Surat Izin Usaha</label>
                                        <input type="file" name="foto_surat_izin_usaha" id="foto_surat_izin_usaha"
                                               class="form-control @error('foto_surat_izin_usaha') is-invalid @enderror"
                                               accept="image/jpeg,image/jpg,image/png">
                                        @error('foto_surat_izin_usaha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format: JPG, JPEG, PNG (maksimal 2MB)
                                        </small>
                                        <div id="business-license-preview" class="mt-2" style="display: none;">
                                            <img src="" alt="Preview Surat Izin" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    </div>

                                    <!-- Foto Tempat Usaha -->
                                    <div class="col-md-4">
                                        <label for="foto_tempat" class="form-label fw-bold">Foto Tempat Usaha</label>
                                        <input type="file" name="foto_tempat" id="foto_tempat"
                                               class="form-control @error('foto_tempat') is-invalid @enderror"
                                               accept="image/jpeg,image/jpg,image/png">
                                        @error('foto_tempat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Format: JPG, JPEG, PNG (maksimal 2MB)
                                        </small>
                                        <div id="business-place-preview" class="mt-2" style="display: none;">
                                            <img src="" alt="Preview Tempat Usaha" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Semua dokumen bersifat opsional namun sangat disarankan untuk dilengkapi
                                    </small>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 pt-3 border-top">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Biodata
                                </button>
                                <a href="{{ route('dashboard.rental_biodata.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Phone number formatting
                function formatPhoneNumber(input) {
                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/[^\d+\-\s()]/g, '');
                        e.target.value = value;
                    });
                }

                formatPhoneNumber(document.getElementById('no_telepon'));
                formatPhoneNumber(document.getElementById('no_wa'));

                // Postal code validation (numbers only)
                document.getElementById('kode_pos').addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });

                // File input validations and previews
                function setupFileInput(inputId, maxSizeMB, previewId) {
                    const input = document.getElementById(inputId);
                    const preview = document.getElementById(previewId);
                    const maxSize = maxSizeMB * 1024 * 1024;
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                    input.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Validate file size
                            if (file.size > maxSize) {
                                alert(`Ukuran file terlalu besar. Maksimum ${maxSizeMB}MB.`);
                                e.target.value = '';
                                preview.style.display = 'none';
                                return;
                            }

                            // Validate file type
                            if (!allowedTypes.includes(file.type)) {
                                alert('Format file tidak didukung. Hanya JPEG, JPG, dan PNG yang diperbolehkan.');
                                e.target.value = '';
                                preview.style.display = 'none';
                                return;
                            }

                            // Show preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = preview.querySelector('img');
                                if (img) {
                                    img.src = e.target.result;
                                    preview.style.display = 'block';
                                }
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.style.display = 'none';
                        }
                    });
                }

                // Setup file inputs
                setupFileInput('foto_ktp', 2, 'ktp-preview');
                setupFileInput('foto_surat_izin_usaha', 2, 'business-license-preview');
                setupFileInput('foto_tempat', 2, 'business-place-preview');

                // Form validation
                document.getElementById('rentalBiodataForm').addEventListener('submit', function(e) {
                    const requiredFields = ['user_id', 'nama_rental', 'nama_pemilik', 'no_telepon', 'alamat', 'kota', 'provinsi'];

                    let isValid = true;
                    requiredFields.forEach(fieldName => {
                        const field = document.getElementsByName(fieldName)[0];
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Mohon lengkapi semua field yang wajib diisi.');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = e.target.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                });

                // Auto-populate nama_pemilik from selected user
                document.getElementById('user_id').addEventListener('change', function(e) {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    if (selectedOption.value) {
                        const userName = selectedOption.text.split(' (')[0];
                        document.getElementById('nama_pemilik').value = userName;
                    }
                });

                // Real-time validation feedback
                document.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
                    field.addEventListener('blur', function() {
                        if (this.value.trim()) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        } else {
                            this.classList.remove('is-valid');
                            this.classList.add('is-invalid');
                        }
                    });
                });

                // Character count for textarea
                const alamatField = document.getElementById('alamat');
                const alamatCounter = document.createElement('small');
                alamatCounter.className = 'form-text text-muted';
                alamatCounter.innerHTML = '<span id="alamat-count">0</span>/500 karakter';
                alamatField.parentNode.appendChild(alamatCounter);

                alamatField.addEventListener('input', function() {
                    const count = this.value.length;
                    document.getElementById('alamat-count').textContent = count;

                    if (count > 500) {
                        alamatCounter.classList.remove('text-muted');
                        alamatCounter.classList.add('text-danger');
                    } else {
                        alamatCounter.classList.remove('text-danger');
                        alamatCounter.classList.add('text-muted');
                    }
                });
            });
        </script>
    @endsection
@endsection
