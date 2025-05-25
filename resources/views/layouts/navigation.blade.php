<nav class="navbar navbar-expand-lg bg-white navbar-dark bg-gradient shadow-sm fixed-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container-fluid">
        <!-- Brand/Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') ?? '#' }}">
            <div class="bg-white bg-opacity-20 rounded-3 p-2 me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="fas fa-cube text-black"></i>
            </div>
            <span class="text-black">Laravel Admin</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none d-md-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
            <i class="fas fa-bars text-black"></i>
        </button>

        <!-- Right Side Navigation -->
        <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
            <!-- Search Bar (Hidden on mobile) -->
            <div class="nav-item me-3 d-none d-lg-block">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-opacity-20 border-0">
                        <i class="fas fa-search "></i>
                    </span>
                    <input type="text" class="form-control bg-white bg-opacity-20 border-0 text-white placeholder-white-50"
                           placeholder="Search..." style="--bs-bg-opacity: 0.2;">
                </div>
            </div>

            <!-- Notifications -->
            <div class="nav-item dropdown me-3">
                <a class="nav-link position-relative p-2 rounded-3 bg-white bg-opacity-10 hover-bg-opacity-20 transition-all"
                   href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell text-black"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate-pulse"
                          style="font-size: 0.6rem;">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3" style="min-width: 300px;" aria-labelledby="notificationDropdown">
                    <li class="dropdown-header bg-light py-3 rounded-top-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-dark fw-semibold">Notifications</h6>
                            <span class="badge bg-primary rounded-pill">3</span>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider my-0"></li>
                    <li>
                        <a class="dropdown-item text-center py-3 text-primary fw-semibold" href="#">
                            <i class="fas fa-eye me-2"></i>View All Notifications
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Messages -->
            <div class="nav-item dropdown me-3">
                <a class="nav-link position-relative p-2 rounded-3 bg-white bg-opacity-10 hover-bg-opacity-20 transition-all"
                   href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-envelope text-black"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success animate-pulse"
                          style="font-size: 0.6rem;">2</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3" style="min-width: 320px;" aria-labelledby="messageDropdown">
                    <li class="dropdown-header bg-light py-3 rounded-top-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-dark fw-semibold">Messages</h6>
                            <span class="badge bg-success rounded-pill">2</span>
                        </div>
                    </li>
                    <li><a class="dropdown-item py-3 border-bottom" href="#">
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     style="width: 45px; height: 45px; font-size: 14px;">JS</div>
                                <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle"
                                      style="width: 12px; height: 12px;"></span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark">John Smith</div>
                                <div class="text-muted small">How can I help you with the new project?</div>
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-clock me-1"></i>Just now
                                </div>
                            </div>
                        </div>
                    </a></li>
                    <li><a class="dropdown-item py-3" href="#">
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-3">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     style="width: 45px; height: 45px; font-size: 14px;">MD</div>
                                <span class="position-absolute bottom-0 end-0 bg-warning border border-white rounded-circle"
                                      style="width: 12px; height: 12px;"></span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark">Maria Davis</div>
                                <div class="text-muted small">Thanks for the quick response!</div>
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-clock me-1"></i>5 min ago
                                </div>
                            </div>
                        </div>
                    </a></li>
                    <li><hr class="dropdown-divider my-0"></li>
                    <li>
                        <a class="dropdown-item text-center py-3 text-primary fw-semibold" href="#">
                            <i class="fas fa-comments me-2"></i>View All Messages
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Profile -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center p-2 rounded-3 bg-white bg-opacity-10 hover-bg-opacity-20 transition-all"
                   href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold"
                         style="width: 35px; height: 35px; font-size: 12px;">
                        {{ substr(Auth::user()->name ?? 'Admin', 0, 2) }}
                    </div>
                    <div class="d-none d-lg-block text-white">
                        <div class="fw-semibold small">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="small opacity-75">Administrator</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3" style="min-width: 250px;" aria-labelledby="userDropdown">
                    <li class="dropdown-header bg-light py-3 rounded-top-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold"
                                 style="width: 40px; height: 40px; font-size: 14px;">
                                {{ substr(Auth::user()->name ?? 'Admin', 0, 2) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ Auth::user()->name ?? 'Admin' }}</div>
                                <small class="text-muted">{{ Auth::user()->email ?? 'admin@example.com' }}</small>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider my-0"></li>
                    <li><a class="dropdown-item py-2 rounded-2 mx-2 my-1" href="#">
                        <i class="fas fa-user me-3 text-primary"></i>My Profile
                    </a></li>
                    <li><a class="dropdown-item py-2 rounded-2 mx-2 my-1" href="#">
                        <i class="fas fa-cog me-3 text-success"></i>Account Settings
                    </a></li>
                    <li><a class="dropdown-item py-2 rounded-2 mx-2 my-1" href="#">
                        <i class="fas fa-bell me-3 text-warning"></i>Notifications
                    </a></li>
                    <li><a class="dropdown-item py-2 rounded-2 mx-2 my-1" href="#">
                        <i class="fas fa-question-circle me-3 text-info"></i>Help & Support
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="px-2">
                        @if(Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 rounded-2 text-danger fw-semibold">
                                    <i class="fas fa-sign-out-alt me-3"></i>Sign Out
                                </button>
                            </form>
                        @else
                            <a class="dropdown-item py-2 rounded-2 text-danger fw-semibold" href="#">
                                <i class="fas fa-sign-out-alt me-3"></i>Sign Out
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel"
     style="background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);">
    <div class="offcanvas-header border-bottom border-white border-opacity-20 pb-4">
        <div class="d-flex align-items-center">
            <div class="bg-white bg-opacity-20 rounded-3 p-2 me-3 d-flex align-items-center justify-content-center"
                 style="width: 40px; height: 40px;">
                <i class="fas fa-cube text-white"></i>
            </div>
            <h5 class="offcanvas-title text-white fw-bold mb-0" id="offcanvasSidebarLabel">Laravel Admin</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 pt-3">
        <div class="px-3 mb-4">
            <div class="d-flex align-items-center bg-white bg-opacity-10 rounded-3 p-3">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold"
                     style="width: 40px; height: 40px; font-size: 14px;">
                    {{ substr(Auth::user()->name ?? 'Admin', 0, 2) }}
                </div>
                <div class="text-white">
                    <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <small class="opacity-75">Administrator</small>
                </div>
            </div>
        </div>

        <div class="nav flex-column px-3">
            <a href="{{ route('dashboard') ?? '#' }}" class="nav-link text-white rounded-3 mb-1 py-3 px-3 active"
               style="background: rgba(255,255,255,0.1);">
                <i class="fas fa-tachometer-alt me-3"></i>Dashboard
            </a>
            <a href="#" class="nav-link text-white rounded-3 mb-1 py-3 px-3 hover-bg-white-10">
                <i class="fas fa-users me-3"></i>Users Management
            </a>
            <a href="{{ route('admin.products.index') ?? '#' }}" class="nav-link text-white rounded-3 mb-1 py-3 px-3 hover-bg-white-10">
                <i class="fas fa-box me-3"></i>Products
            </a>
            <a href="#" class="nav-link text-white rounded-3 mb-1 py-3 px-3 hover-bg-white-10">
                <i class="fas fa-shopping-cart me-3"></i>Orders
            </a>
            <a href="#" class="nav-link text-white rounded-3 mb-1 py-3 px-3 hover-bg-white-10">
                <i class="fas fa-chart-bar me-3"></i>Analytics
            </a>
            <a href="#" class="nav-link text-white rounded-3 mb-1 py-3 px-3 hover-bg-white-10">
                <i class="fas fa-credit-card me-3"></i>Payments
            </a>
            <a href="#" class="nav-link text-white rounded-3 mb-1 py-3 px-3 hover-bg-white-10">
                <i class="fas fa-cog me-3"></i>Settings
            </a>
        </div>
    </div>
</div>
