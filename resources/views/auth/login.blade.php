@extends('layouts.frontend')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card shadow-lg border-0" style="border-radius: 20px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.95);">
                    <div class="card-body p-5">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-person-check text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="card-title fw-bold text-dark mb-2">Selamat Datang Kembali</h2>
                            <p class="text-muted">Masuk ke akun Anda</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success">
                                @if(session('status') === 'verification-link-sent')
                                    Link verifikasi baru telah dikirim ke email Anda.
                                @else
                                    {{ session('status') }}
                                @endif
                            </div>
                        @endif

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Warning Message -->
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            @if($error === 'These credentials do not match our records.')
                                                Email atau password tidak valid
                                            @elseif($error === 'The password field is required.')
                                                Password wajib diisi
                                            @elseif($error === 'The email field is required.')
                                                Email wajib diisi
                                            @elseif($error === 'The email must be a valid email address.')
                                                Format email tidak valid
                                            @else
                                                {{ $error }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-envelope me-2"></i> Email
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email"
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="Masukkan email Anda"
                                           required autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        @if($message === 'The email field is required.')
                                            Email wajib diisi
                                        @elseif($message === 'The email must be a valid email address.')
                                            Format email tidak valid
                                        @else
                                            {{ $message }}
                                        @endif
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-lock me-2"></i>Password
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Masukkan password Anda"
                                           required>
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        @if($message === 'The password field is required.')
                                            Password wajib diisi
                                        @else
                                            {{ $message }}
                                        @endif
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-semibold">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="border-radius: 50px; background: linear-gradient(45deg, #667eea, #764ba2); border: none; transition: all 0.3s ease;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">Belum memiliki akun?
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Daftar disini</a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});
</script>
@endsection
