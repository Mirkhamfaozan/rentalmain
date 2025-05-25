<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            /* Custom styles untuk memastikan responsivitas */
            @media (max-width: 1023px) {
                .sidebar-open {
                    overflow: hidden;
                }
            }

            /* Pastikan sidebar selalu fixed */
            #sidebar {
                position: fixed !important;
            }

            /* Berikan margin left pada main content untuk desktop */
            @media (min-width: 1024px) {
                .main-content-container {
                    margin-left: 16rem; /* 256px = w-64 */
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            <!-- Mobile menu button - Fixed position -->
            <div class="lg:hidden fixed top-4  z-50">
                <button id="mobile-menu-button" class="bg-white p-2 rounded-lg shadow-lg border hover:bg-gray-50 transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile overlay -->
            <div id="mobile-overlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

            <!-- Sidebar - Selalu fixed -->
            <aside id="sidebar" class="
                fixed inset-y-0 left-0 z-50
                w-64
                transform -translate-x-full lg:translate-x-0
                transition-transform duration-300 ease-in-out
            ">
                @include('layouts.sidebar')
            </aside>

            <!-- Main Content Container dengan margin left untuk desktop -->
            <div class="flex flex-col ">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm border-b">
                        <div class="w-full ">
                            <!-- Mobile: Add left margin for menu button -->
                            {{-- <div class="ml-16 lg:ml-0"> --}}
                                {{ $header }}
                            {{-- </div> --}}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    <div class="w-full px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
                        <!-- Mobile: Add left margin for menu button -->
                        <div class="ml-16 lg:ml-0">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                const body = document.body;

                function openSidebar() {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    body.classList.add('sidebar-open', 'lg:overflow-auto', 'overflow-hidden');
                }

                function closeSidebar() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    body.classList.remove('sidebar-open', 'overflow-hidden');
                }

                // Toggle mobile menu
                if (mobileMenuButton) {
                    mobileMenuButton.addEventListener('click', function() {
                        if (sidebar.classList.contains('-translate-x-full')) {
                            openSidebar();
                        } else {
                            closeSidebar();
                        }
                    });
                }

                // Close sidebar when clicking overlay
                if (overlay) {
                    overlay.addEventListener('click', closeSidebar);
                }

                // Handle window resize
                function handleResize() {
                    if (window.innerWidth >= 1024) {
                        // Desktop - sidebar selalu terlihat
                        sidebar.classList.remove('-translate-x-full');
                        overlay.classList.add('hidden');
                        body.classList.remove('sidebar-open', 'overflow-hidden');
                    } else {
                        // Mobile - periksa status overlay
                        if (!overlay.classList.contains('hidden')) {
                            // Sidebar terbuka di mobile
                            body.classList.add('sidebar-open', 'overflow-hidden');
                        } else {
                            // Sidebar tertutup di mobile
                            sidebar.classList.add('-translate-x-full');
                            body.classList.remove('sidebar-open', 'overflow-hidden');
                        }
                    }
                }

                // Initial check
                handleResize();

                // Listen for resize events
                window.addEventListener('resize', handleResize);

                // Close sidebar with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });
        </script>
    </body>
</html>
