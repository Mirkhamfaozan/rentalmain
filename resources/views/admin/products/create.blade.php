@extends('layouts.app')

@section('title', 'Add New Motor')
@section('page-title', 'Add New Motor')
@section('page-description', 'Add a new motorcycle to your inventory.')

@section('page-actions')
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Motors
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 48px; height: 48px;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Motor Information</h5>
                            <p class="text-muted small mb-0">Fill in the details for the new motorcycle</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 pb-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>Please fix the following errors:
                            </h6>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Motor Name -->
                            <div class="col-12">
                                <label for="nama_motor" class="form-label fw-semibold">
                                    <i class="fas fa-motorcycle me-1 text-primary"></i>Motor Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('nama_motor') is-invalid @enderror"
                                       id="nama_motor"
                                       name="nama_motor"
                                       value="{{ old('nama_motor') }}"
                                       placeholder="e.g., Honda Vario 125, Yamaha NMAX, etc."
                                       required>
                                @error('nama_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Enter the complete motor name and model</div>
                            </div>

                            <!-- CC Motor -->
                            <div class="col-md-6">
                                <label for="cc_motor" class="form-label fw-semibold">
                                    <i cla1ss="fas fa-tachometer-alt me-1 text-success"></i>Engine CC
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
                                    @error('cc_motor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Engine capacity (50cc - 2000cc)</div>
                            </div>

                            <!-- Transmission -->
                            <div class="col-md-6">
                                <label for="transmisi_motor" class="form-label fw-semibold">
                                    <i class="fas fa-cogs me-1 text-warning"></i>Transmission
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('transmisi_motor') is-invalid @enderror"
                                        id="transmisi_motor"
                                        name="transmisi_motor"
                                        required>
                                    <option value="">Choose transmission type</option>
                                    <option value="Manual" {{ old('transmisi_motor') == 'Manual' ? 'selected' : '' }}>
                                        Manual
                                    </option>
                                    <option value="Automatic" {{ old('transmisi_motor') == 'Automatic' ? 'selected' : '' }}>
                                        Automatic
                                    </option>
                                    <option value="CVT" {{ old('transmisi_motor') == 'CVT' ? 'selected' : '' }}>
                                        CVT (Continuously Variable Transmission)
                                    </option>
                                </select>
                                @error('transmisi_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="col-12">
                                <label for="harga" class="form-label fw-semibold">
                                    <i class="fas fa-rupiah-sign me-1 text-info"></i>Price
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number"
                                           class="form-control @error('harga') is-invalid @enderror"
                                           id="harga"
                                           name="harga"
                                           value="{{ old('harga') }}"
                                           placeholder="1500000"
                                           min="100000"
                                           step="1000000"
                                           required>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Motor price in Indonesian Rupiah (minimum Rp 100,000)</div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                             style="width: 48px; height: 48px; font-size: 18px;">
                                            <i class="fas fa-motorcycle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold" id="preview-name">Motor Name</div>
                                            <div class="text-muted small">
                                                <span id="preview-cc">000</span>cc •
                                                <span id="preview-trans">Transmission</span> •
                                                Rp <span id="preview-price">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-1"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Save Motor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title text-muted">
                        <i class="fas fa-info-circle me-1"></i>Tips for Adding Motors
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="small">
                                    <strong>Motor Name:</strong> Include brand and model for clarity
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
                                    <strong>Engine CC:</strong> Check official specifications
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
                                    <strong>Price:</strong> Use current market price
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
                                    <strong>Transmission:</strong> Choose the correct type
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const namaInput = document.getElementById('nama_motor');
            const ccInput = document.getElementById('cc_motor');
            const transInput = document.getElementById('transmisi_motor');
            const hargaInput = document.getElementById('harga');

            const previewName = document.getElementById('preview-name');
            const previewCC = document.getElementById('preview-cc');
            const previewTrans = document.getElementById('preview-trans');
            const previewPrice = document.getElementById('preview-price');

            function updatePreview() {
                previewName.textContent = namaInput.value || 'Motor Name';
                previewCC.textContent = ccInput.value || '000';
                previewTrans.textContent = transInput.value || 'Transmission';

                const price = hargaInput.value ? parseInt(hargaInput.value).toLocaleString('id-ID') : '0';
                previewPrice.textContent = price;
            }

            namaInput.addEventListener('input', updatePreview);
            ccInput.addEventListener('input', updatePreview);
            transInput.addEventListener('change', updatePreview);
            hargaInput.addEventListener('input', updatePreview);

            // Format price input
            hargaInput.addEventListener('input', function() {
                // Remove non-numeric characters except for the decimal point
                let value = this.value.replace(/[^\d]/g, '');
                this.value = value;
            });
        });
    </script>
@endsection
