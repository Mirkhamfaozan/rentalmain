{{-- //layouts/sidebar.blade.php --}}
<nav class="mt-5 col-md-3 col-lg-2 d-md-block bg-white sidebar collapse shadow-lg"
    style="width: 260px; border-right: 1px solid #e3e6f0;">
    <div class="position-sticky sidebar-sticky">
        <!-- Sidebar Header -->
        <div class="sidebar-header px-3 py-4 border-bottom">
            <div class="d-flex align-items-center">
                @php
                    $userRole = Auth::user()->role ?? 'user';
                    $headerGradient = match($userRole) {
                        'super_admin' => 'linear-gradient(135deg, #dc3545 0%, #fd7e14 100%)',
                        'admin' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'rental' => 'linear-gradient(135deg, #28a745 0%, #20c997 100%)',
                        default => 'linear-gradient(135deg, #6c757d 0%, #495057 100%)'
                    };
                    $headerIcon = match($userRole) {
                        'super_admin' => 'fas fa-crown',
                        'admin' => 'fas fa-shield-alt',
                        'rental' => 'fas fa-store',
                        default => 'fas fa-user'
                    };
                @endphp
                <div class="bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 40px; height: 40px; background: {{ $headerGradient }};">
                    <i class="{{ $headerIcon }}"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">
                        @if($userRole === 'super_admin')
                            Super Admin
                        @elseif($userRole === 'admin')
                            Admin Panel
                        @elseif($userRole === 'rental')
                            Rental Manager

                        @endif
                    </h6>
                    <small class="text-muted">{{ ucfirst($userRole) }} System</small>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="px-3 py-3">
            <ul class="nav flex-column nav-pills">
                <!-- Dashboard - Available for all roles -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard') ?? '#' }}">
                        <i class="fas fa-tachometer-alt me-3" style="width: 16px;"></i>
                        <span>Dashboard</span>
                        <span class="badge bg-light text-dark ms-auto small">{{ \App\Models\User::count() ?? '24' }}</span>
                    </a>
                </li>

                @php
                    $isAdmin = in_array($userRole, ['admin', 'super_admin']);
                    $isSuperAdmin = $userRole === 'super_admin';
                    $isRental = $userRole === 'rental';
                @endphp

                <!-- Users Management - Only for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.users.index') ?? '#' }}">
                        <i class="fas fa-users me-3 text-primary" style="width: 16px;"></i>
                        <span>Users Management</span>
                        <span class="badge bg-light text-dark ms-auto small">{{ \App\Models\User::count() ?? '24' }}</span>
                    </a>
                </li>
                @endif

                <!-- Products Management - Available for Admin, Super Admin, and Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.products.index') ?? '#' }}">
                        <i class="fas fa-box me-3 text-success" style="width: 16px;"></i>
                        <span>{{ $isRental ? 'Rental Items' : 'Products' }}</span>
                        <span class="badge bg-success-subtle text-success ms-auto small">156</span>
                    </a>
                </li>
                @endif
{{--
                <!-- Categories Management - Available for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-tags me-3 text-info" style="width: 16px;"></i>
                        <span>Categories</span>
                    </a>
                </li>
                @endif --}}

                <!-- Orders Management - Available for Admin, Super Admin, and Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.orders.index') ?? '#' }}">
                        <i class="fas fa-shopping-cart me-3 text-warning" style="width: 16px;"></i>
                        <span>{{ $isRental ? 'Rental Orders' : 'Orders' }}</span>
                    </a>
                </li>
                @endif

                {{-- <!-- Inventory Management - Available for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-warehouse me-3 text-secondary" style="width: 16px;"></i>
                        <span>Inventory</span>
                    </a>
                </li>
                @endif --}}

                <!-- Transactions - Available for Admin, Super Admin, and Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.payments.index') ?? '#' }}">
                        <i class="fas fa-exchange-alt me-3 text-info" style="width: 16px;"></i>
                        <span>{{ $isRental ? 'Rental Transactions' : 'Transactions' }}</span>
                        <span class="badge bg-info-subtle text-info ms-auto small">
                            {{ $isRental ? '5' : '42' }}
                        </span>
                    </a>
                </li>
                @endif

                {{-- <!-- Reports & Analytics - Available for Admin, Super Admin, and Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-chart-bar me-3 text-info" style="width: 16px;"></i>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
                @endif --}}

                {{-- <!-- Discounts & Coupons - Available for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-percent me-3 text-danger" style="width: 16px;"></i>
                        <span>Discounts & Coupons</span>
                        <span class="badge bg-danger-subtle text-danger ms-auto small">5</span>
                    </a>
                </li>
                @endif --}}
{{--
                <!-- Notifications - Available for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-bell me-3 text-warning" style="width: 16px;"></i>
                        <span>Notifications</span>
                        <span class="badge bg-warning text-dark ms-auto small">3</span>
                    </a>
                </li>
                @endif --}}

                <!-- Rental Specific Menu Items -->
                @if($isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-calendar-alt me-3 text-info" style="width: 16px;"></i>
                        <span>Rental Calendar</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-clock me-3 text-success" style="width: 16px;"></i>
                        <span>Availability</span>
                    </a>
                </li>
                @endif

                <!-- Super Admin Only Menu Items -->
                @if($isSuperAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.system.index') ?? '#' }}">
                        <i class="fas fa-server me-3 text-danger" style="width: 16px;"></i>
                        <span>System Management</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.logs.index') ?? '#' }}">
                        <i class="fas fa-file-alt me-3 text-warning" style="width: 16px;"></i>
                        <span>System Logs</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.backups.index') ?? '#' }}">
                        <i class="fas fa-database me-3 text-info" style="width: 16px;"></i>
                        <span>Database Backups</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.maintenance.index') ?? '#' }}">
                        <i class="fas fa-tools me-3 text-secondary" style="width: 16px;"></i>
                        <span>Maintenance Mode</span>
                    </a>
                </li>
                @endif
            </ul>

            <!-- Divider -->
            <hr class="my-4 text-muted">

            <!-- System Menu -->
            <div class="mb-2">
                <small class="text-muted text-uppercase fw-bold px-3"
                    style="font-size: 11px; letter-spacing: 0.5px;">System</small>
            </div>

            <ul class="nav flex-column nav-pills">
                <!-- Settings - Available for all roles -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-cog me-3 text-secondary" style="width: 16px;"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <!-- Email Templates - Available for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-envelope me-3 text-info" style="width: 16px;"></i>
                        <span>Email Templates</span>
                    </a>
                </li>
                @endif

                <!-- Activity Logs - Available for Admin and Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-history me-3 text-warning" style="width: 16px;"></i>
                        <span>Activity Logs</span>
                    </a>
                </li>
                @endif

                <!-- Support - Available for all roles -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-life-ring me-3 text-secondary" style="width: 16px;"></i>
                        <span>Support</span>
                    </a>
                </li>

                <!-- Role Management - Super Admin Only -->
                @if($isSuperAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.roles.index') ?? '#' }}">
                        <i class="fas fa-user-cog me-3 text-primary" style="width: 16px;"></i>
                        <span>Role Management</span>
                    </a>
                </li>
                @endif

                <!-- Permissions - Super Admin Only -->
                @if($isSuperAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.permissions.index') ?? '#' }}">
                        <i class="fas fa-key me-3 text-danger" style="width: 16px;"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <!-- User Profile Section -->
        <div class="mt-auto border-top bg-light mx-3 rounded-3 p-3" style="margin-bottom: 20px;">
            <div class="d-flex align-items-center">
                <div class="position-relative me-3">
                    <div class="bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px; background: {{ $headerGradient }}; font-size: 14px; font-weight: 600;">
                        {{ substr(Auth::user()->name ?? 'AD', 0, 2) }}
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white"
                        style="width: 12px; height: 12px;"></div>
                </div>
                <div class="flex-grow-1 min-width-0">
                    <div class="fw-semibold text-dark small mb-0" style="font-size: 13px;">
                        {{ Auth::user()->name ?? 'Admin User' }}
                    </div>
                    <div class="text-muted small text-truncate" style="font-size: 11px;">
                        {{ Auth::user()->email ?? 'admin@example.com' }}
                    </div>
                    <div class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>
                        {{ ucfirst($userRole) }}
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary border-0 dropdown-toggle-no-caret" type="button"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width: 160px;">
                        <li><a class="dropdown-item small" href="">
                            <i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item small" href="">
                            <i class="fas fa-edit me-2"></i>Edit Profile</a></li>
                        <li><a class="dropdown-item small" href="">
                            <i class="fas fa-cog me-2"></i>Account Settings</a></li>
                        @if($isSuperAdmin)
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item small" href="">
                            <i class="fas fa-user-secret me-2"></i>Impersonate User</a></li>
                        <li><a class="dropdown-item small" href="">
                            <i class="fas fa-bug me-2"></i>Debug Panel</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item small text-danger border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>


<script>
    // Enhanced navigation functionality with role-based logic
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        const userRole = '{{ Auth::user()->role ?? "user" }}';

        console.log('Current path:', currentPath);
        console.log('User role:', userRole);

        // Add role-based class to body for additional styling
        document.body.classList.add('role-' + userRole);

        // Set active link based on current path
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            console.log('Checking link:', href);

            // Remove active classes first
            link.classList.remove('active');
            link.querySelector('i')?.classList.remove('text-white');

            if (href && href !== '#') {
                // Check for exact match or starts with the path
                const isActive = currentPath === href ||
                    currentPath.startsWith(href + '/') ||
                    (href.includes('dashboard') && currentPath.includes('dashboard')) ||
                    (href.includes('orders') && currentPath.includes('orders')) ||
                    (href.includes('users') && currentPath.includes('users')) ||
                    (href.includes('products') && currentPath.includes('products')) ||
                    (href.includes('transactions') && currentPath.includes('transactions')) ||
                    (href.includes('rental') && currentPath.includes('rental')) ||
                    (href.includes('analytics') && currentPath.includes('analytics')) ||
                    (href.includes('payments') && currentPath.includes('payments'));

                if (isActive) {
                    // Add active class with proper styling
                    link.classList.add('active');
                    link.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    link.style.color = 'white';
                    link.style.fontWeight = '500';
                    link.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.3)';

                    // Make icon white too
                    const icon = link.querySelector('i');
                    if (icon) {
                        icon.style.color = 'white';
                    }

                    console.log('Active link set:', href);
                }
            }
        });

        // Handle nav link clicks with role-based validation
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                if (href === '#') {
                    e.preventDefault();
                    return;
                }

                // Check if user has permission for this route
                const requiresAdmin = href.includes('users') || href.includes('superadmin');
                const requiresRental = href.includes('rental');
                const requiresTransactionAccess = href.includes('transactions');

                if (requiresAdmin && !['admin', 'super_admin'].includes(userRole)) {
                    e.preventDefault();
                    alert('You do not have permission to access this section.');
                    return;
                }

                if (requiresRental && userRole !== 'rental' && !['admin', 'super_admin'].includes(userRole)) {
                    e.preventDefault();
                    alert('This section is only available for rental users.');
                    return;
                }

                if (requiresTransactionAccess && !['admin', 'super_admin', 'rental'].includes(userRole)) {
                    e.preventDefault();
                    alert('You do not have permission to access transactions.');
                    return;
                }

                // Show loading state
                const icon = this.querySelector('i');
                const originalIcon = icon?.className;

                if (icon && !href.startsWith('javascript:')) {
                    icon.className = 'fas fa-spinner fa-spin me-3';

                    // Reset after navigation (fallback)
                    setTimeout(() => {
                        if (originalIcon) {
                            icon.className = originalIcon;
                        }
                    }, 2000);
                }
            });

            // Enhanced hover effects
            link.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = '#f8f9ff';
                    this.style.color = '#5a67d8';
                    this.style.transform = 'translateX(2px)';
                    this.style.transition = 'all 0.2s ease';
                }
            });

            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.backgroundColor = '';
                    this.style.color = '';
                    this.style.transform = 'translateX(0)';
                }
            });
        });

        // Auto-hide sidebar on mobile after link click
        const sidebarCollapse = document.querySelector('.sidebar.collapse');
        if (sidebarCollapse) {
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        const bsCollapse = new bootstrap.Collapse(sidebarCollapse, {
                            hide: true
                        });
                    }
                });
            });
        }
    });

    // Function to manually set active menu with role validation
    function setActiveMenu(menuName) {
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        const userRole = '{{ Auth::user()->role ?? "user" }}';

        navLinks.forEach(link => {
            // Reset all links
            link.classList.remove('active');
            link.style.background = '';
            link.style.color = '';
            link.style.fontWeight = '';
            link.style.boxShadow = '';

            const icon = link.querySelector('i');
            if (icon) {
                icon.style.color = '';
            }
        });

        // Find and activate the specific menu
        const targetLink = document.querySelector(`.sidebar .nav-link[href*="${menuName}"]`);
        if (targetLink) {
            // Check if user has permission
            const href = targetLink.getAttribute('href');
            const requiresAdmin = href.includes('users') || href.includes('superadmin');
            const requiresRental = href.includes('rental');
            const requiresTransactionAccess = href.includes('transactions');

            if ((requiresAdmin && !['admin', 'super_admin'].includes(userRole)) ||
                (requiresRental && userRole !== 'rental' && !['admin', 'super_admin'].includes(userRole)) ||
                (requiresTransactionAccess && !['admin', 'super_admin', 'rental'].includes(userRole))) {
                console.log('User does not have permission for this menu:', menuName);
                return;
            }

            targetLink.classList.add('active');
            targetLink.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            targetLink.style.color = 'white';
            targetLink.style.fontWeight = '500';
            targetLink.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.3)';

            const icon = targetLink.querySelector('i');
            if (icon) {
                icon.style.color = 'white';
            }
        }
    }

    // Handle window resize for responsive behavior
    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.sidebar');
        if (window.innerWidth >= 768) {
            sidebar?.classList.remove('show');
        }
    });

    // Add smooth scrolling for sidebar
    function smoothScrollSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.style.scrollBehavior = 'smooth';
        }
    }

    // Initialize smooth scrolling
    smoothScrollSidebar();
</script>
