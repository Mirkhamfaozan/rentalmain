@extends('layouts.frontend')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    <div class="card-body p-5 text-center">

                        <!-- Header -->
                        <div class="mb-4">
                            <div class="mb-3">
                                <i class="bi bi-envelope-check text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h2 class="card-title fw-bold text-dark mb-2">Verify Your Email</h2>
                            <p class="text-muted">We've sent a verification link to your email address.</p>
                        </div>

                        <!-- Display session status -->
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                A new verification link has been sent to your email address.
                            </div>
                        @endif

                        <div class="mb-4">
                            <p class="text-muted">
                                Before continuing, please check your email for a verification link.
                                If you didn't receive the email, click the button below to request another.
                            </p>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <!-- Resend Verification Email -->
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="border-radius: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border: none;">
                                    <i class="bi bi-envelope me-2"></i>Resend Verification Email
                                </button>
                            </form>

                            <!-- Back to Login -->
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg" style="border-radius: 50px;">
                                <i class="bi bi-arrow-left me-2"></i>Back to Login
                            </a>
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link text-muted small">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
