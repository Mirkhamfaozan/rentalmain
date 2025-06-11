<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Rental Motor - Laravel</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    rel="stylesheet" />
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
    rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}" />
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

  <style>
    /* Minimal custom CSS - hanya untuk gradient yang tidak tersedia di Bootstrap */
    .navbar-brand-gradient {
      background: linear-gradient(45deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .btn-gradient {
      background: linear-gradient(45deg, #667eea, #764ba2);
      border: none;
    }

    .bg-gradient-footer {
      background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
    }

    .nav-link-active::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      bottom: -5px;
      left: 0;
      background: linear-gradient(45deg, #667eea, #764ba2);
      border-radius: 2px;
    }

    .notification-badge {
      position: absolute;
      top: -5px;
      right: -10px;
      font-size: 0.75rem;
      padding: 2px 6px;
    }
  </style>
</head>

<body class="d-flex flex-column h-100">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand fw-bold fs-4 navbar-brand-gradient text-decoration-none" href="#">
        <i class="bi bi-motorcycle me-2"></i>AM MOTOR
      </a>
      <button
        class="navbar-toggler border-0"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-4">
          <li class="nav-item">
            <a class="nav-link fw-medium position-relative {{ Request::routeIs('frontend.homepage') ? 'text-primary fw-semibold nav-link-active' : '' }}"
               href="{{ route('frontend.homepage') }}">
              <i class="bi bi-house me-1"></i>Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium position-relative {{ Request::routeIs('frontend.product') ? 'text-primary fw-semibold nav-link-active' : '' }}"
               href="{{ route('frontend.product') }}">
              <i class="bi bi-grid me-1"></i>Product
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium position-relative {{ Request::routeIs('frontend.contact') ? 'text-primary fw-semibold nav-link-active' : '' }}"
               href="{{ route('frontend.contact') }}">
              <i class="bi bi-envelope me-1"></i>Contact
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium position-relative {{ Request::routeIs('frontend.carasewa') ? 'text-primary fw-semibold nav-link-active' : '' }}"
               href="{{ route('frontend.carasewa') }}">
              <i class="bi bi-info-circle me-1"></i>Cara Sewa
            </a>
          </li>
        </ul>

        @auth
        <div class="d-flex align-items-center gap-3">
          <!-- Notification Button -->
          @php
            $notificationCount = Auth::user()->orders()
              ->whereHas('payment', function ($query) {
                  $query->whereIn('status', ['pending', 'success']);
              })->count();
          @endphp
          <a href="{{ route('user.notifications') }}" class="position-relative text-decoration-none text-dark" title="Notifications">
            <i class="bi bi-bell fs-5"></i>
            @if($notificationCount > 0)
            <span class="badge bg-danger rounded-pill notification-badge">{{ $notificationCount }}</span>
            @endif
          </a>

          <!-- Profile Dropdown -->
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
               id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                   style="width: 35px; height: 35px;">
                <i class="bi bi-person-fill text-white"></i>
              </div>
              <span class="fw-medium">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="profileDropdown">
              @if(Auth::user()->canAccessDashboard())
              <li>
                <a class="dropdown-item py-2" href="/dashboard">
                  <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              @endif
              <li>
                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                  <i class="bi bi-person me-2"></i>Profile
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger py-2">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
        @endauth

        @guest
        <div class="d-flex gap-2">
          <a href="{{ route('login')}}" class="btn btn-outline-primary px-4 fw-medium">
            <i class="bi bi-box-arrow-in-right me-1"></i>Login
          </a>
          <a class="btn btn-info text-white px-4 fw-medium"
            href="{{ route('register')}}">
            <i class="bi bi-person-plus me-1"></i>Register
          </a>
        </div>
        @endguest
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow-1">
    @yield('content')
  </main>

  <!-- Footer-->
  <footer class="py-4 bg-gradient-footer text-white mt-auto">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="m-0 fw-light">
            <i class="bi bi-c-circle me-1"></i>
            Copyright © AM MOTOR {{ date('Y') }}. All rights reserved.
          </p>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="d-flex justify-content-md-end justify-content-center gap-3 mt-2 mt-md-0">
            <a href="#" class="text-white-50 text-decoration-none">
              <i class="bi bi-facebook fs-5"></i>
            </a>
            <a href="#" class="text-white-50 text-decoration-none">
              <i class="bi bi-instagram fs-5"></i>
            </a>
            <a href="#" class="text-white-50 text-decoration-none">
              <i class="bi bi-twitter fs-5"></i>
            </a>
            <a href="#" class="text-white-50 text-decoration-none">
              <i class="bi bi-envelope fs-5"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="{{ asset('frontend/js/scripts.js') }}"></script>

  <script>
    // Bootstrap-based interactions
    document.addEventListener('DOMContentLoaded', function() {
      // Smooth scroll for anchor links using Bootstrap's smooth scroll
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });

      // Add Bootstrap tooltip initialization for notification button
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      // Add Bootstrap popover initialization if needed
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
      var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
      });
    });
  </script>
</body>

</html>
