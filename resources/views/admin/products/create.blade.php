@extends('layouts.app')

@section('title', 'Tambah Motor Baru')
@section('page-title', 'Tambah Motor Baru')
@section('page-description', 'Tambahkan motor baru ke inventaris Anda.')

@section('page-actions')
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Motor
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 48px; height: 48px;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Informasi Motor</h5>
                            <p class="text-muted small mb-0">Isi detail untuk motor baru</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 pb-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>Harap perbaiki kesalahan berikut:
                            </h6>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Bagian Informasi Dasar -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-info-circle me-1"></i>Informasi Dasar
                                </h6>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Nama Motor -->
                            <div class="col-md-6">
                                <label for="nama_motor" class="form-label fw-semibold">
                                    <i class="fas fa-motorcycle me-1 text-primary"></i>Nama Motor
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('nama_motor') is-invalid @enderror"
                                       id="nama_motor"
                                       name="nama_motor"
                                       value="{{ old('nama_motor') }}"
                                       placeholder="Contoh: Honda Vario 125, Yamaha NMAX, dll."
                                       required>
                                @error('nama_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Merek -->
                            <div class="col-md-6">
                                <label for="brand" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1 text-primary"></i>Merek
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('brand') is-invalid @enderror"
                                        id="brand"
                                        name="brand"
                                        required>
                                    <option value="">Pilih merek</option>
                                    <option value="Honda" {{ old('brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                                    <option value="Yamaha" {{ old('brand') == 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
                                    <option value="Kawasaki" {{ old('brand') == 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
                                    <option value="Suzuki" {{ old('brand') == 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
                                    <option value="TVS" {{ old('brand') == 'TVS' ? 'selected' : '' }}>TVS</option>
                                    <option value="Lainnya" {{ old('brand') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CC Motor -->
                            <div class="col-md-4">
                                <label for="cc_motor" class="form-label fw-semibold">
                                    <i class="fas fa-tachometer-alt me-1 text-success"></i>Kapasitas Mesin (CC)
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('cc_motor') is-invalid @enderror"
                                           id="cc_motor"
                                           name="cc_motor"
                                           value="{{ old('cc_motor') }}"
                                           placeholder="125"
                                           min="50"
                                           max="2000"
                                           required>
                                    <span class="input-group-text">cc</span>
                                </div>
                                @error('cc_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Transmisi -->
                            <div class="col-md-4">
                                <label for="transmisi_motor" class="form-label fw-semibold">
                                    <i class="fas fa-cogs me-1 text-warning"></i>Transmisi
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('transmisi_motor') is-invalid @enderror"
                                        id="transmisi_motor"
                                        name="transmisi_motor"
                                        required>
                                    <option value="">Pilih jenis transmisi</option>
                                    <option value="Manual" {{ old('transmisi_motor') == 'Manual' ? 'selected' : '' }}>
                                        Manual
                                    </option>
                                    <option value="Automatic" {{ old('transmisi_motor') == 'Automatic' ? 'selected' : '' }}>
                                        Otomatis
                                    </option>
                                    <option value="CVT" {{ old('transmisi_motor') == 'CVT' ? 'selected' : '' }}>
                                        CVT (Transmisi Variabel Kontinu)
                                    </option>
                                </select>
                                @error('transmisi_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipe Motor -->
                            <div class="col-md-4">
                                <label for="tipe_motor" class="form-label fw-semibold">
                                    <i class="fas fa-list me-1 text-info"></i>Tipe Motor
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipe_motor') is-invalid @enderror"
                                        id="tipe_motor"
                                        name="tipe_motor"
                                        required>
                                    <option value="">Pilih tipe motor</option>
                                    <option value="Scooter" {{ old('tipe_motor') == 'Scooter' ? 'selected' : '' }}>Skuter</option>
                                    <option value="Sport" {{ old('tipe_motor') == 'Sport' ? 'selected' : '' }}>Sport</option>
                                    <option value="Naked" {{ old('tipe_motor') == 'Naked' ? 'selected' : '' }}>Naked</option>
                                    <option value="Cruiser" {{ old('tipe_motor') == 'Cruiser' ? 'selected' : '' }}>Cruiser</option>
                                    <option value="Adventure" {{ old('tipe_motor') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                    <option value="Standard" {{ old('tipe_motor') == 'Standard' ? 'selected' : '' }}>Standar</option>
                                </select>
                                @error('tipe_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tahun Produksi -->
                            <div class="col-md-6">
                                <label for="tahun_produksi" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1 text-secondary"></i>Tahun Produksi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control @error('tahun_produksi') is-invalid @enderror"
                                       id="tahun_produksi"
                                       name="tahun_produksi"
                                       value="{{ old('tahun_produksi', date('Y')) }}"
                                       min="1900"
                                       max="{{ date('Y') + 1 }}"
                                       required>
                                @error('tahun_produksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Warna -->
                            <div class="col-md-6">
                                <label for="warna" class="form-label fw-semibold">
                                    <i class="fas fa-palette me-1 text-danger"></i>Warna
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('warna') is-invalid @enderror"
                                       id="warna"
                                       name="warna"
                                       value="{{ old('warna') }}"
                                       placeholder="Contoh: Merah, Biru, Hitam, dll."
                                       required>
                                @error('warna')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bagian Registrasi Kendaraan -->
                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-file-alt me-1"></i>Registrasi Kendaraan
                                </h6>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Nomor STNK -->
                            <div class="col-md-6">
                                <label for="nomor_stnk" class="form-label fw-semibold">
                                    <i class="fas fa-id-card me-1 text-primary"></i>Nomor STNK
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('nomor_stnk') is-invalid @enderror"
                                       id="nomor_stnk"
                                       name="nomor_stnk"
                                       value="{{ old('nomor_stnk') }}"
                                       placeholder="Masukkan nomor STNK"
                                       required>
                                @error('nomor_stnk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Plat Nomor -->
                            <div class="col-md-6">
                                <label for="nomor_kendaraan" class="form-label fw-semibold">
                                    <i class="fas fa-car me-1 text-success"></i>Plat Nomor
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('nomor_kendaraan') is-invalid @enderror"
                                       id="nomor_kendaraan"
                                       name="nomor_kendaraan"
                                       value="{{ old('nomor_kendaraan') }}"
                                       placeholder="Contoh: B 1234 ABC"
                                       required>
                                @error('nomor_kendaraan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nomor Mesin -->
                            <div class="col-md-6">
                                <label for="no_mesin" class="form-label fw-semibold">
                                    <i class="fas fa-engine me-1 text-warning"></i>Nomor Mesin
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('no_mesin') is-invalid @enderror"
                                       id="no_mesin"
                                       name="no_mesin"
                                       value="{{ old('no_mesin') }}"
                                       placeholder="Masukkan nomor mesin"
                                       required>
                                @error('no_mesin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nomor Rangka -->
                            <div class="col-md-6">
                                <label for="no_rangka" class="form-label fw-semibold">
                                    <i class="fas fa-barcode me-1 text-info"></i>Nomor Rangka
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('no_rangka') is-invalid @enderror"
                                       id="no_rangka"
                                       name="no_rangka"
                                       value="{{ old('no_rangka') }}"
                                       placeholder="Masukkan nomor rangka"
                                       required>
                                @error('no_rangka')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Foto STNK -->
                            <div class="col-12">
                                <label for="foto_stnk" class="form-label fw-semibold">
                                    <i class="fas fa-camera me-1 text-primary"></i>Foto STNK
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                       class="form-control @error('foto_stnk') is-invalid @enderror"
                                       id="foto_stnk"
                                       name="foto_stnk"
                                       accept="image/jpeg,image/png,image/jpg"
                                       required>
                                @error('foto_stnk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Unggah foto STNK (JPEG, PNG, JPG - Maks 2MB)</div>
                            </div>
                        </div>

                        <!-- Bagian Harga & Stok -->
                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-money-bill-wave me-1"></i>Harga & Stok
                                </h6>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Harga Harian -->
                            <div class="col-md-4">
                                <label for="harga_harian" class="form-label fw-semibold">
                                    <i class="fas fa-rupiah-sign me-1 text-success"></i>Harga Harian
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           class="form-control @error('harga_harian') is-invalid @enderror"
                                           id="harga_harian"
                                           name="harga_harian"
                                           value="{{ old('harga_harian') }}"
                                           placeholder="100000"
                                           min="0"
                                           step="1000"
                                           required>
                                </div>
                                @error('harga_harian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Diskon Mingguan -->
                            <div class="col-md-4">
                                <label for="diskon_mingguan" class="form-label fw-semibold">
                                    <i class="fas fa-percentage me-1 text-warning"></i>Diskon Mingguan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('diskon_mingguan') is-invalid @enderror"
                                           id="diskon_mingguan"
                                           name="diskon_mingguan"
                                           value="{{ old('diskon_mingguan', 0) }}"
                                           min="0"
                                           max="6"
                                           required>
                                    <span class="input-group-text">hari</span>
                                </div>
                                @error('diskon_mingguan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Hari gratis untuk sewa mingguan (0-6 hari)</div>
                            </div>

                            <!-- Diskon Bulanan -->
                            <div class="col-md-4">
                                <label for="diskon_bulanan" class="form-label fw-semibold">
                                    <i class="fas fa-percentage me-1 text-info"></i>Diskon Bulanan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('diskon_bulanan') is-invalid @enderror"
                                           id="diskon_bulanan"
                                           name="diskon_bulanan"
                                           value="{{ old('diskon_bulanan', 0) }}"
                                           min="0"
                                           max="29"
                                           required>
                                    <span class="input-group-text">hari</span>
                                </div>
                                @error('diskon_bulanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Hari gratis untuk sewa bulanan (0-29 hari)</div>
                            </div>

                            <!-- Stok -->
                            <div class="col-md-6">
                                <label for="stok" class="form-label fw-semibold">
                                    <i class="fas fa-boxes me-1 text-secondary"></i>Jumlah Stok
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control @error('stok') is-invalid @enderror"
                                       id="stok"
                                       name="stok"
                                       value="{{ old('stok', 1) }}"
                                       min="1"
                                       required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ketersediaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-toggle-on me-1 text-success"></i>Ketersediaan
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('is_available') is-invalid @enderror"
                                           type="checkbox"
                                           id="is_available"
                                           name="is_available"
                                           value="1"
                                           {{ old('is_available', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">
                                        Tersedia untuk disewa
                                    </label>
                                </div>
                                @error('is_available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bagian Gambar & Deskripsi -->
                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold mb-3">
                                    <i class="fas fa-images me-1"></i>Gambar & Deskripsi
                                </h6>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Gambar Utama -->
                            <div class="col-12">
                                <label for="gambar_utama" class="form-label fw-semibold">
                                    <i class="fas fa-image me-1 text-primary"></i>Gambar Utama
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                       class="form-control @error('gambar_utama') is-invalid @enderror"
                                       id="gambar_utama"
                                       name="gambar_utama"
                                       accept="image/jpeg,image/png,image/jpg"
                                       required>
                                @error('gambar_utama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Unggah gambar utama motor (JPEG, PNG, JPG - Maks 2MB)</div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-1 text-secondary"></i>Deskripsi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                          id="deskripsi"
                                          name="deskripsi"
                                          rows="4"
                                          placeholder="Deskripsikan fitur motor, kondisi, dan catatan khusus..."
                                          required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bagian Pratinjau -->
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-eye me-1"></i>Pratinjau
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                             style="width: 48px; height: 48px; font-size: 18px;">
                                            <i class="fas fa-motorcycle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold" id="preview-name">Nama Motor</div>
                                            <div class="text-muted small">
                                                <span id="preview-brand">Merek</span> •
                                                <span id="preview-cc">000</span>cc •
                                                <span id="preview-trans">Transmisi</span> •
                                                Rp <span id="preview-price">0</span>/hari
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('dashboard.products.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Simpan Motor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kartu Bantuan -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title text-muted">
                        <i class="fas fa-info-circle me-1"></i>Tips Menambahkan Motor
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="small">
                                    <strong>Nama Motor:</strong> Sertakan merek dan model untuk kejelasan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="small">
                                    <strong>Registrasi:</strong> Pastikan semua nomor unik dan benar
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="small">
                                    <strong>Harga:</strong> Tetapkan harga harian yang kompetitif dan diskon yang sesuai
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="small">
                                    <strong>Gambar:</strong> Unggah foto yang jelas dan berkualitas tinggi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi pratinjau langsung
        document.addEventListener('DOMContentLoaded', function() {
            const namaInput = document.getElementById('nama_motor');
            const brandInput = document.getElementById('brand');
            const ccInput = document.getElementById('cc_motor');
            const transInput = document.getElementById('transmisi_motor');
            const hargaInput = document.getElementById('harga_harian');

            const previewName = document.getElementById('preview-name');
            const previewBrand = document.getElementById('preview-brand');
            const previewCC = document.getElementById('preview-cc');
            const previewTrans = document.getElementById('preview-trans');
            const previewPrice = document.getElementById('preview-price');

            function updatePreview() {
                previewName.textContent = namaInput.value || 'Nama Motor';
                previewBrand.textContent = brandInput.value || 'Merek';
                previewCC.textContent = ccInput.value || '000';
                previewTrans.textContent = transInput.value || 'Transmisi';

                const price = hargaInput.value ? parseInt(hargaInput.value).toLocaleString('id-ID') : '0';
                previewPrice.textContent = price;
            }

            namaInput.addEventListener('input', updatePreview);
            brandInput.addEventListener('change', updatePreview);
            ccInput.addEventListener('input', updatePreview);
            transInput.addEventListener('change', updatePreview);
            hargaInput.addEventListener('input', updatePreview);

            // Format input harga
            hargaInput.addEventListener('input', function() {
                // Hapus karakter non-numerik kecuali titik desimal
                let value = this.value.replace(/[^\d]/g, '');
                this.value = value;
            });
        });
    </script>
@endsection
