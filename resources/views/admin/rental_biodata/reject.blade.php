@extends('layouts.app')

@section('title', 'Tolak Biodata Rental')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Tolak Biodata Rental</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Anda akan menolak verifikasi biodata rental ini.
                        Silakan berikan alasan penolakan yang jelas.
                    </div>

                    <div class="mb-4">
                        <h5>Detail Biodata</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama Rental:</strong> {{ $biodata->nama_rental }}</p>
                                <p><strong>Pemilik:</strong> {{ $biodata->nama_pemilik }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $biodata->email_perusahaan }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-warning">Belum Verifikasi</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.rental_biodata.reject', $biodata->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="catatan_verifikasi" class="form-label">
                                <strong>Alasan Penolakan</strong> <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_verifikasi" id="catatan_verifikasi"
                                class="form-control @error('catatan_verifikasi') is-invalid @enderror"
                                rows="5" required>{{ old('catatan_verifikasi') }}</textarea>
                            @error('catatan_verifikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Berikan alasan jelas mengapa biodata ini ditolak (maks. 1000 karakter)</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.rental_biodata.show', $biodata->id) }}"
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i> Tolak Biodata
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
