@extends('layouts.app')

@section('title', 'Edit Motor')
@section('page-title', 'Edit Motor')
@section('page-description', 'Update motorcycle information in your inventory.')

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-1"></i>View Details
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list me-1"></i>All Motors
        </a>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Current Motor Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 48px; height: 48px;">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Currently Editing</h6>
                            <div class="fw-semibold">{{ $product->nama_motor }}</div>
                            <div class="text-muted small">
                                {{ $product->cc_motor }}cc • {{ $product->transmisi_motor }} •
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Motor ID</div>
                            <div class="fw-bold">#{{ $product->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 48px; height: 48px;">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">Update Motor Information</h5>
                            <p class="text-muted small mb-0">Modify the motorcycle details below</p>
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

                    <form action="{{ route('admin.products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('nama_motor', $product->nama_motor) }}"
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
                                    <i class="fas fa-tachometer-alt me-1 text-success"></i>Engine CC
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control @error('cc_motor') is-invalid @enderror"
                                           id="cc_motor"
                                           name="cc_motor"
                                           value="{{ old('cc_motor', $product->cc_motor) }}"
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
                                @if(old('cc_motor', $product->cc_motor) != $product->cc_motor)
                                    <div class="small text-warning mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Original: {{ $product->cc_motor }}cc
                                    </div>
                                @endif
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
                                    <option value="Manual" {{ old('transmisi_motor', $product->transmisi_motor) == 'Manual' ? 'selected' : '' }}>
                                        Manual
                                    </option>
                                    <option value="Automatic" {{ old('transmisi_motor', $product->transmisi_motor) == 'Automatic' ? 'selected' : '' }}>
                                        Automatic
                                    </option>
                                    <option value="CVT" {{ old('transmisi_motor', $product->transmisi_motor) == 'CVT' ? 'selected' : '' }}>
                                        CVT (Continuously Variable Transmission)
                                    </option>
                                </select>
                                @error('transmisi_motor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(old('transmisi_motor', $product->transmisi_motor) != $product->transmisi_motor)
                                    <div class="small text-warning mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Original: {{ $product->transmisi_motor }}
                                    </div>
                                @endif
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
                                           value="{{ old('harga', $product->harga) }}"
                                           placeholder="1500000"
                                           min="100000"
                                           step="100000"
                                           required>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Motor price in Indonesian Rupiah (minimum Rp 100,000)</div>
                                @if(old('harga', $product->harga) != $product->harga)
                                    <div class="small text-warning mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Original: Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Comparison Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-balance-scale me-1"></i>Before & After Comparison
                                    </h6>
                                    <div class="row">
                                        <!-- Before -->
                                        <div class="col-md-6">
                                            <div class="border rounded p-3 bg-white">
                                                <div class="small text-muted mb-2">BEFORE (Current)</div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px; font-size: 14px;">
                                                        <i class="fas fa-motorcycle"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold small">{{ $product->nama_motor }}</div>
                                                        <div class="text-muted small">
                                                            {{ $product->cc_motor }}cc • {{ $product->transmisi_motor }} •
                                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- After -->
                                        <div class="col-md-6">
                                            <div class="border rounded p-3 bg-white">
                                                <div class="small text-muted mb-2">AFTER (Preview)</div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px; font-size: 14px;">
                                                        <i class="fas fa-motorcycle"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold small" id="preview-name">{{ $product->nama_motor }}</div>
                                                        <div class="text-muted small">
                                                            <span id="preview-cc">{{ $product->cc_motor }}</span>cc •
                                                            <span id="preview-trans">{{ $product->transmisi_motor }}</span> •
                                                            Rp <span id="preview-price">{{ number_format($product->harga, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-between">
                                    <div>
                                        <!-- Danger Zone -->
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fas fa-trash me-1"></i>Delete Motor
                                        </button>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </a>
                                        <button type="reset" class="btn btn-outline-warning">
                                            <i class="fas fa-undo me-1"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Update Motor
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change History Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title text-muted">
                        <i class="fas fa-info-circle me-1"></i>Editing Tips
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="small">
                                    <strong>Double-check:</strong> Verify all changes before saving
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
                                    <strong>Price Updates:</strong> Consider market fluctuations
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-exclamation"></i>
                                </div>
                                <div class="small">
                                    <strong>Specifications:</strong> Don't change CC unless correcting errors
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                     style="width: 24px; height: 24px; font-size: 12px;">
                                    <i class="fas fa-save"></i>
                                </div>
                                <div class="small">
                                    <strong>Save Changes:</strong> Click Update to apply modifications
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Motor
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 64px; height: 64px; font-size: 24px;">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                    <p class="text-center">Are you sure you want to delete this motor?</p>
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center me-3"
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $product->nama_motor }}</div>
                                <div class="text-muted small">
                                    {{ $product->cc_motor }}cc • {{ $product->transmisi_motor }} •
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>Warning:</strong> This action cannot be undone. The motor will be permanently removed from your inventory.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Yes, Delete Motor
                        </button>
                    </form>
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

            // Original values for comparison
            const originalName = '{{ $product->nama_motor }}';
            const originalCC = '{{ $product->cc_motor }}';
            const originalTrans = '{{ $product->transmisi_motor }}';
            const originalPrice = '{{ number_format($product->harga, 0, ",", ".") }}';

            function updatePreview() {
                const newName = namaInput.value || originalName;
                const newCC = ccInput.value || originalCC;
                const newTrans = transInput.value || originalTrans;
                const newPrice = hargaInput.value ? parseInt(hargaInput.value).toLocaleString('id-ID') : originalPrice;

                previewName.textContent = newName;
                previewCC.textContent = newCC;
                previewTrans.textContent = newTrans;
                previewPrice.textContent = newPrice;

                // Highlight changes
                previewName.className = newName !== originalName ? 'fw-semibold small text-primary' : 'fw-semibold small';
                previewCC.className = newCC !== originalCC ? 'text-primary fw-bold' : '';
                previewTrans.className = newTrans !== originalTrans ? 'text-primary fw-bold' : '';
                previewPrice.className = newPrice !== originalPrice ? 'text-primary fw-bold' : '';
            }

            namaInput.addEventListener('input', updatePreview);
            ccInput.addEventListener('input', updatePreview);
            transInput.addEventListener('change', updatePreview);
            hargaInput.addEventListener('input', updatePreview);

            // Format price input
            hargaInput.addEventListener('input', function() {
                let value = this.value.replace(/[^\d]/g, '');
                this.value = value;
            });

            // Reset form functionality
            document.querySelector('button[type="reset"]').addEventListener('click', function() {
                setTimeout(updatePreview, 50); // Small delay to let form reset
            });
        });
    </script>
@endsection
