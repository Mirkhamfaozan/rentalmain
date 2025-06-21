@extends('layouts.app')

@section('title', 'Detail Biodata Rental')
@section('page-title', 'Detail Biodata Rental')
@section('page-description', 'Lihat detail lengkap biodata rental.')

@section('page-actions')
    <div class="btn-group">
        @if ($biodata->canUpdate(auth()->user()))
            <a href="{{ route('dashboard.rental_biodata.edit', $biodata->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i>Edit Biodata
            </a>
        @endif
        @if ($biodata->canDelete(auth()->user()))
            <form action="{{ route('dashboard.rental_biodata.destroy', $biodata->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus biodata ini?')">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </form>
        @endif
        <a href="{{ route('dashboard.rental_biodata.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
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

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">Detail Biodata Rental #{{ str_pad($biodata->id, 3, '0', STR_PAD_LEFT) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Rental Information -->
                        <div class="col-lg-6 mb-4">
                            <h6 class="fw-semibold mb-3">Informasi Rental</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" style="width: 200px;">Nama Rental</td>
                                            <td>{{ $biodata->nama_rental }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Nama Pemilik</td>
                                            <td>{{ $biodata->nama_pemilik }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Alamat</td>
                                            <td>{{ $biodata->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Kota</td>
                                            <td>{{ $biodata->kota }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Provinsi</td>
                                            <td>{{ $biodata->provinsi }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Kode Pos</td>
                                            <td>{{ $biodata->kode_pos }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-lg-6 mb-4">
                            <h6 class="fw-semibold mb-3">Informasi Kontak</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" style="width: 200px;">No Telepon</td>
                                            <td>{{ $biodata->no_telepon }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">No WhatsApp</td>
                                            <td>{{ $biodata->no_wa }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Email Perusahaan</td>
                                            <td>{{ $biodata->email_perusahaan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Verification Information -->
                        <div class="col-lg-6 mb-4">
                            <h6 class="fw-semibold mb-3">Informasi Verifikasi</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-medium" style="width: 200px;">Status Verifikasi</td>
                                            <td>
                                                <span class="badge bg-{{ $biodata->getStatusBadgeClass() }}">
                                                    {{ $biodata->getStatusLabel() }}
                                                </span>
                                            </td>
                                        </tr>
                                        @if ($biodata->catatan_verifikasi)
                                            <tr>
                                                <td class="fw-medium">Catatan Verifikasi</td>
                                                <td>{{ $biodata->catatan_verifikasi }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="fw-medium">Tanggal Dibuat</td>
                                            <td>{{ $biodata->created_at ? $biodata->created_at->format('Y-m-d H:i:s') : 'Tidak Tersedia' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-medium">Terakhir Diperbarui</td>
                                            <td>{{ $biodata->updated_at ? $biodata->updated_at->format('Y-m-d H:i:s') : 'Tidak Tersedia' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="col-lg-6 mb-4">
                            <h6 class="fw-semibold mb-3">Dokumen</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-2">
                                            <h6 class="fw-medium mb-2">Foto KTP</h6>
                                            <a href="{{ Storage::url($biodata->foto_ktp) }}" target="_blank">
                                                <img src="{{ Storage::url($biodata->foto_ktp) }}" class="img-fluid rounded"
                                                    alt="Foto KTP" style="max-height: 200px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-2">
                                            <h6 class="fw-medium mb-2">Surat Izin Usaha</h6>
                                            <a href="{{ Storage::url($biodata->foto_surat_izin_usaha) }}" target="_blank">
                                                <img src="{{ Storage::url($biodata->foto_surat_izin_usaha) }}"
                                                    class="img-fluid rounded" alt="Surat Izin Usaha"
                                                    style="max-height: 200px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Actions -->
                    @if ($biodata->canVerify(auth()->user()))
                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-header bg-transparent border-0">
                                <h6 class="fw-semibold mb-0">Aksi Verifikasi</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dashboard.rental_biodata.verify', $biodata->id) }}" method="POST"
                                    class="mb-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="catatan_verifikasi" class="form-label">Catatan Verifikasi
                                            (Opsional)</label>
                                        <textarea name="catatan_verifikasi" id="catatan_verifikasi" class="form-control" rows="4"
                                            placeholder="Masukkan catatan verifikasi..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Apakah Anda yakin ingin memverifikasi biodata ini?')">
                                        <i class="fas fa-check me-1"></i>Verifikasi
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.rental_biodata.reject', $biodata->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="catatan_verifikasi_reject" class="form-label">Catatan Penolakan <span
                                                class="text-danger">*</span></label>
                                        <textarea name="catatan_verifikasi" id="catatan_verifikasi_reject" class="form-control" rows="4"
                                            placeholder="Masukkan alasan penolakan..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-warning"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak biodata ini?')">
                                        <i class="fas fa-times me-1"></i>Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
