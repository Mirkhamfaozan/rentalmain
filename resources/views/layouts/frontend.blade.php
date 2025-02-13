<!DOCTYPE html>
<html lang="en">

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
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="{{ asset('frontend/css/styles.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}" />
</head>

<body>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="#">AM MOTOR</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('frontend.homepage') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('frontend.product') }}">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('frontend.contact') }}">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('frontend.carasewa') }}">Cara Sewa</a>
          </li>
          
        </ul>

        @auth
        <div class="d-flex ms-3">
          <a href="{{ route('dashboard') }}" class="me-3 text-decoration-none text-dark">
            Halo, {{ Auth::user()->name }}!
          </a>

        </div>
        @endauth

        @guest
        <div class="d-flex ms-3">
          <a href="{{ route('login')}}" class="btn btn-outline-primary me-2">Login</a>
          <a class="btn btn-info mt-auto text-white"
            href="{{ route('register')}}">Register</a>
        </div>
        @endguest


      </div>
  </nav>
  <!-- Header-->
  @yield('content')
  <!-- Footer-->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">
        Copyright &copy; Your Website 2022
      </p>
    </div>
  </footer>
  <!-- Bootstrap core JS-->
  <script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
  <!-- Core theme JS-->
  <script src="{{ asset('frontend/js/scripts.js') }}"></script>
</body>

</html>