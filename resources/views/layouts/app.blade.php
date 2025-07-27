
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Laravel Admin</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/sidebar-dashboard.css') }}" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            overflow-y: auto;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
        }

        .navbar-nav .nav-link {
            padding-right: .75rem;
            padding-left: .75rem;
            color: rgba(0, 0, 0, .5);
        }

        .navbar-nav .nav-link.active {
            color: #007bff;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
        }

        .main-content {
            margin-left: 240px;
            padding-top: 48px;
        }

        @media (max-width: 767.98px) {
            .main-content {
                margin-left: 0;
                padding-top: 56px;
            }
        }

        .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
            border-radius: 0.25rem;
        }

        .nav-link:hover:not(.active) {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
        }

        /* Pagination Styles */
        .pagination {
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            cursor: auto;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-light">
    <!-- Top Navigation -->
    @include('layouts.navigation')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid px-4">
            <!-- Page Header -->
            @if(!View::hasSection('no-header'))
                @include('layouts.header')
            @endif

            <!-- Page Content -->
            @yield('content')

            <!-- Footer -->
            <footer class="mt-5 py-4 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted small mb-0">&copy; 2025 AM MOTOR.</p>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Active nav link functionality
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
                    // Remove active class from all links
                    navLinks.forEach(l => {
                        l.classList.remove('active', 'bg-primary', 'text-white');
                        l.classList.add('text-dark');
                    });

                    // Add active class to current link
                    link.classList.add('active', 'bg-primary', 'text-white');
                    link.classList.remove('text-dark');
                }
            });

            // Handle manual nav link clicks
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }

                    // Remove active class from all links
                    navLinks.forEach(l => {
                        l.classList.remove('active', 'bg-primary', 'text-white');
                        l.classList.add('text-dark');
                    });

                    // Add active class to clicked link
                    this.classList.add('active', 'bg-primary', 'text-white');
                    this.classList.remove('text-dark');
                });
            });

            // Handle offcanvas nav links for mobile
            const offcanvasLinks = document.querySelectorAll('#offcanvasSidebar .list-group-item');
            offcanvasLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                    }

                    offcanvasLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
