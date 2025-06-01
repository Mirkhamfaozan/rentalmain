@extends('layouts.frontend')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    <div class="card-body p-5 text-center">

                        <!-- Email Icon -->
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 80px; height: 80px;">
                                <i class="bi bi-envelope-check text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>

                        <!-- Header -->
                        <h2 class="card-title fw-bold text-dark mb-3">Verify Your Email</h2>
                        <p class="text-muted mb-4 px-2">
                            Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just sent to you.
                        </p>

                        <!-- Success Message -->
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success border-0 mb-4" style="background: linear-gradient(45deg, #d4edda, #c3e6cb); border-radius: 15px;">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Email Sent!</strong> A new verification link has been sent to your email address.
                            </div>
                        @endif

                        <!-- Status Message -->
                        @if (session('status') && session('status') != 'verification-link-sent')
                            <div class="alert alert-info border-0 mb-4" style="background: linear-gradient(45deg, #cce7ff, #b3d9ff); border-radius: 15px;">
                                <i class="bi bi-info-circle me-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Email Info Box -->
                        <div class="bg-light rounded-3 p-4 mb-4" style="border-left: 4px solid #667eea;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-envelope text-primary me-3" style="font-size: 1.5rem;"></i>
                                <div class="text-start">
                                    <small class="text-muted d-block">Email sent to:</small>
                                    <strong class="text-dark">{{ Auth::user()->email }}</strong>
                                </div>
            </div>
                        </div>

                        <!-- Resend Form -->
                        <div class="mb-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold px-4" style="border-radius: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border: none; transition: all 0.3s ease;">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Resend Verification Email
                                </button>
                            </form>
                        </div>

                        <!-- Divider -->
                        <div class="position-relative my-4">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">OR</span>
                        </div>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary fw-semibold" style="border-radius: 50px; transition: all 0.3s ease;">
                                <i class="bi bi-box-arrow-right me-2"></i>Log Out
                            </button>
                        </form>

                        <!-- Help Text -->
                        <div class="mt-4 pt-3 border-top">
                            <p class="text-muted small mb-2">
                                <i class="bi bi-question-circle me-1"></i>
                                <strong>Didn't receive the email?</strong>
                            </p>
                            <p class="text-muted small mb-0">
                                Check your spam folder or click "Resend" to get a new verification link.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add hover effects to buttons
document.querySelector('.btn-primary').addEventListener('mouseover', function() {
    this.style.transform = 'translateY(-2px)';
    this.style.boxShadow = '0 8px 25px rgba(102, 126, 234, 0.4)';
});

document.querySelector('.btn-primary').addEventListener('mouseout', function() {
    this.style.transform = 'translateY(0)';
    this.style.boxShadow = 'none';
});

document.querySelector('.btn-outline-secondary').addEventListener('mouseover', function() {
    this.style.transform = 'translateY(-1px)';
});

document.querySelector('.btn-outline-secondary').addEventListener('mouseout', function() {
    this.style.transform = 'translateY(0)';
});

// Auto-hide success message after 5 seconds
const successAlert = document.querySelector('.alert-success');
if (successAlert) {
    setTimeout(function() {
        successAlert.style.transition = 'opacity 0.5s ease';
        successAlert.style.opacity = '0';
        setTimeout(function() {
            successAlert.remove();
        }, 500);
    }, 5000);
}
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

.btn-primary:hover {
    transform: translateY(-2px) !important;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
    border-color: #6c757d;
}

/* Pulse animation for email icon */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
    }
    70% {
        box-shadow: 0 0 0 20px rgba(102, 126, 234, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
    }
}

.bg-primary.bg-opacity-10 {
    animation: pulse 2s infinite;
}
</style>
@endsection
