@extends('layouts.app')

@section('title', 'Edit Biodata Rental')
@section('page-title', 'Edit Biodata Rental')
@section('page-description', 'Perbarui informasi biodata rental di bawah ini.')

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('dashboard.rental_biodata.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.rental_biodata.update', $biodata->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_rental" class="form-label">Nama Rental <span class="text-danger">*</span></label>
                                <input type="text" name="nama_rental" id="nama_rental" class="form-control @error('nama_rental') is-invalid @enderror"
                                       value="{{ old('nama_rental', $biodata->nama_rental) }}" required>
                                @error('nama_rental')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nama_pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pemilik" id="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror"
                                       value="{{ old('nama_pemilik', $biodata->nama_pemilik) }}" required>
                                @error('nama_pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email_perusahaan" class="form-label">Email Perusahaan <span class="text-danger">*</span></label>
                                <input type="email" name="email_perusahaan" id="email_perusahaan" class="form-control @error('email_perusahaan') is-invalid @enderror"
                                       value="{{ old('email_perusahaan', $biodata->email_perusahaan) }}" required>
                                @error('email_perusahaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label">No Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="no_telepon" id="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror"
                                       value="{{ old('no_telepon', $biodata->no_telepon) }}" required>
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4" required>{{ old('alamat', $biodata->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="dokumen_legalitas" class="form-label">Dokumen Legalitas (PDF, maks 2MB)</label>
                                <input type="file" name="dokumen_legalitas" id="dokumen_legalitas" class="form-control @error('dokumen_legalitas') is-invalid @enderror"
                                       accept="application/pdf">
                                @if ($biodata->dokumen_legalitas)
                                    <small class="form-text text-muted">
                                        Dokumen saat ini: <a href="{{ Storage::url($biodata->dokumen_legalitas) }}" target="_blank">Lihat dokumen</a>
                                    </small>
                                @endif
                                @error('dokumen_legalitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                            <a href="{{ route('dashboard.rental_biodata.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
