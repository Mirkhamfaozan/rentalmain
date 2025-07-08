@extends('layouts.frontend')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5"
    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card shadow-lg border-0"
                    style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-envelope-check text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="card-title fw-bold text-dark mb-2">Verifikasi Email Anda</h2>
                            <p class="text-muted">Kami telah mengirimkan tautan verifikasi ke email Anda</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            <p class="lead">
                                Kami telah mengirim email verifikasi ke:
                                <span class="fw-bold text-primary">{{ $email ?? '' }}</span>
                            </p>
                            <p class="text-muted">
                                Silakan periksa kotak masuk email Anda dan klik tautan verifikasi untuk melanjutkan.
                            </p>
                        </div>

                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h5 class="alert-heading">Tidak menerima email?</h5>
                                    <p class="mb-0">Periksa folder spam Anda atau kirim ulang email verifikasi dengan mengklik tombol di bawah.</p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email ?? '' }}">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold"
                                    style="border-radius: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border: none; transition: all 0.3s ease;">
                                    <i class="bi bi-envelope-arrow-up me-2"></i>Kirim Ulang Email Verifikasi
                                </button>

                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg fw-semibold mt-2"
                                    style="border-radius: 50px; transition: all 0.3s ease;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Kembali ke Halaman Masuk
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .alert-info {
            background-color: rgba(102, 126, 234, 0.1);
            border-color: rgba(102, 126, 234, 0.3);
            color: #2c3e50;
        }

        .lead {
            font-size: 1.1rem;
            color: #495057;
        }
    </style>
@endpush
