{{-- //layouts/sidebar.blade.php --}}
<nav class="mt-5 col-md-3 col-lg-2 d-md-block bg-white sidebar collapse shadow-lg"
    style="width: 260px; border-right: 1px solid #e3e6f0;">
    <div class="position-sticky sidebar-sticky">
        <!-- Header Sidebar -->
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
                            Panel Admin
                        @elseif($userRole === 'rental')
                            Manajer Rental
                        @endif
                    </h6>
                    <small class="text-muted">Sistem {{ ucfirst($userRole === 'rental' ? 'Rental' : ($userRole === 'admin' ? 'Admin' : $userRole)) }}</small>
                </div>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <div class="px-3 py-3">
            <ul class="nav flex-column nav-pills">
                <!-- Dashboard - Tersedia untuk semua role -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard') ?? '#' }}">
                        <i class="fas fa-tachometer-alt me-3" style="width: 16px;"></i>
                        <span>Dasbor</span>
                        <span class="badge bg-light text-dark ms-auto small">{{ \App\Models\User::count() ?? '24' }}</span>
                    </a>
                </li>

                @php
                    $isAdmin = in_array($userRole, ['admin', 'super_admin']);
                    $isSuperAdmin = $userRole === 'super_admin';
                    $isRental = $userRole === 'rental';
                @endphp

                <!-- Manajemen Pengguna - Hanya untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.users.index') ?? '#' }}">
                        <i class="fas fa-users me-3 text-primary" style="width: 16px;"></i>
                        <span>Manajemen Pengguna</span>
                        <span class="badge bg-light text-dark ms-auto small">{{ \App\Models\User::count() ?? '24' }}</span>
                    </a>
                </li>
                @endif

                <!-- Manajemen Produk - Tersedia untuk Admin, Super Admin, dan Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.products.index') ?? '#' }}">
                        <i class="fas fa-box me-3 text-success" style="width: 16px;"></i>
                        <span>{{ $isRental ? 'Barang Rental' : 'Produk' }}</span>
                        <span class="badge bg-success-subtle text-success ms-auto small">156</span>
                    </a>
                </li>
                @endif
{{--
                <!-- Manajemen Kategori - Tersedia untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-tags me-3 text-info" style="width: 16px;"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                @endif --}}

                <!-- Manajemen Pesanan - Tersedia untuk Admin, Super Admin, dan Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.orders.index') ?? '#' }}">
                        <i class="fas fa-shopping-cart me-3 text-warning" style="width: 16px;"></i>
                        <span>{{ $isRental ? 'Pesanan Rental' : 'Pesanan' }}</span>
                    </a>
                </li>
                @endif

                {{-- <!-- Manajemen Inventori - Tersedia untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-warehouse me-3 text-secondary" style="width: 16px;"></i>
                        <span>Inventori</span>
                    </a>
                </li>
                @endif --}}

                <!-- Transaksi - Tersedia untuk Admin, Super Admin, dan Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.payments.index') ?? '#' }}">
                        <i class="fas fa-exchange-alt me-3 text-info" style="width: 16px;"></i>
                        <span>{{ $isRental ? 'Transaksi Rental' : 'Transaksi' }}</span>
                        <span class="badge bg-info-subtle text-info ms-auto small">
                            {{ $isRental ? '5' : '42' }}
                        </span>
                    </a>
                </li>
                @endif

                {{-- <!-- Laporan & Analitik - Tersedia untuk Admin, Super Admin, dan Rental -->
                @if($isAdmin || $isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-chart-bar me-3 text-info" style="width: 16px;"></i>
                        <span>Laporan & Analitik</span>
                    </a>
                </li>
                @endif --}}

                {{-- <!-- Diskon & Kupon - Tersedia untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-percent me-3 text-danger" style="width: 16px;"></i>
                        <span>Diskon & Kupon</span>
                        <span class="badge bg-danger-subtle text-danger ms-auto small">5</span>
                    </a>
                </li>
                @endif --}}
{{--
                <!-- Notifikasi - Tersedia untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-bell me-3 text-warning" style="width: 16px;"></i>
                        <span>Notifikasi</span>
                        <span class="badge bg-warning text-dark ms-auto small">3</span>
                    </a>
                </li>
                @endif --}}

                <!-- Menu Khusus Rental -->
                {{-- @if($isRental)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-calendar-alt me-3 text-info" style="width: 16px;"></i>
                        <span>Kalender Rental</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-clock me-3 text-success" style="width: 16px;"></i>
                        <span>Ketersediaan</span>
                    </a>
                </li>
                @endif --}}

                <!-- Menu Khusus Super Admin -->
                @if($isSuperAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.system.index') ?? '#' }}">
                        <i class="fas fa-server me-3 text-danger" style="width: 16px;"></i>
                        <span>Manajemen Sistem</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.logs.index') ?? '#' }}">
                        <i class="fas fa-file-alt me-3 text-warning" style="width: 16px;"></i>
                        <span>Log Sistem</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.backups.index') ?? '#' }}">
                        <i class="fas fa-database me-3 text-info" style="width: 16px;"></i>
                        <span>Backup Database</span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.maintenance.index') ?? '#' }}">
                        <i class="fas fa-tools me-3 text-secondary" style="width: 16px;"></i>
                        <span>Mode Pemeliharaan</span>
                    </a>
                </li>
                @endif
            </ul>

            <!-- Pembatas -->
            <hr class="my-4 text-muted">

            <!-- Menu Sistem -->
            <div class="mb-2">
                <small class="text-muted text-uppercase fw-bold px-3"
                    style="font-size: 11px; letter-spacing: 0.5px;">Sistem</small>
            </div>

            <ul class="nav flex-column nav-pills">
                <!-- Pengaturan - Tersedia untuk semua role -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('dashboard.profile.show') ?? '#' }}">
                        <i class="fas fa-cog me-3 text-secondary" style="width: 16px;"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>

                <!-- Template Email - Tersedia untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-envelope me-3 text-info" style="width: 16px;"></i>
                        <span>Template Email</span>
                    </a>
                </li>
                @endif

                <!-- Log Aktivitas - Tersedia untuk Admin dan Super Admin -->
                @if($isAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-history me-3 text-warning" style="width: 16px;"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </li>
                @endif

                <!-- Dukungan - Tersedia untuk semua role -->
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="">
                        <i class="fas fa-life-ring me-3 text-secondary" style="width: 16px;"></i>
                        <span>Dukungan</span>
                    </a>
                </li>

                <!-- Manajemen Role - Khusus Super Admin -->
                @if($isSuperAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.roles.index') ?? '#' }}">
                        <i class="fas fa-user-cog me-3 text-primary" style="width: 16px;"></i>
                        <span>Manajemen Role</span>
                    </a>
                </li>
                @endif

                <!-- Izin Akses - Khusus Super Admin -->
                @if($isSuperAdmin)
                <li class="nav-item mb-1">
                    <a class="nav-link d-flex align-items-center px-3 py-2 rounded-pill text-dark hover-item"
                        href="{{ route('superadmin.permissions.index') ?? '#' }}">
                        <i class="fas fa-key me-3 text-danger" style="width: 16px;"></i>
                        <span>Izin Akses</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Bagian Profil Pengguna -->
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
                        {{ Auth::user()->name ?? 'Pengguna Admin' }}
                    </div>
                    <div class="text-muted small text-truncate" style="font-size: 11px;">
                        {{ Auth::user()->email ?? 'admin@example.com' }}
                    </div>
                    <div class="text-muted small" style="font-size: 10px;">
                        <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>
                        {{ $userRole === 'super_admin' ? 'Super Admin' : ($userRole === 'admin' ? 'Admin' : ($userRole === 'rental' ? 'Rental' : ucfirst($userRole))) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


<script>
    // Fungsionalitas navigasi yang ditingkatkan dengan logika berbasis role
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        const userRole = '{{ Auth::user()->role ?? "user" }}';

        console.log('Path saat ini:', currentPath);
        console.log('Role pengguna:', userRole);

        // Tambahkan class berbasis role ke body untuk styling tambahan
        document.body.classList.add('role-' + userRole);

        // Set link aktif berdasarkan path saat ini
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            console.log('Memeriksa link:', href);

            // Hapus class aktif terlebih dahulu
            link.classList.remove('active');
            link.querySelector('i')?.classList.remove('text-white');

            if (href && href !== '#') {
                // Periksa kecocokan exact atau dimulai dengan path
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
                    // Tambahkan class aktif dengan styling yang tepat
                    link.classList.add('active');
                    link.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    link.style.color = 'white';
                    link.style.fontWeight = '500';
                    link.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.3)';

                    // Buat ikon putih juga
                    const icon = link.querySelector('i');
                    if (icon) {
                        icon.style.color = 'white';
                    }

                    console.log('Link aktif diset:', href);
                }
            }
        });

        // Handle klik link nav dengan validasi berbasis role
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                if (href === '#') {
                    e.preventDefault();
                    return;
                }

                // Periksa apakah pengguna memiliki izin untuk route ini
                const requiresAdmin = href.includes('users') || href.includes('superadmin');
                const requiresRental = href.includes('rental');
                const requiresTransactionAccess = href.includes('transactions');

                if (requiresAdmin && !['admin', 'super_admin'].includes(userRole)) {
                    e.preventDefault();
                    alert('Anda tidak memiliki izin untuk mengakses bagian ini.');
                    return;
                }

                if (requiresRental && userRole !== 'rental' && !['admin', 'super_admin'].includes(userRole)) {
                    e.preventDefault();
                    alert('Bagian ini hanya tersedia untuk pengguna rental.');
                    return;
                }

                if (requiresTransactionAccess && !['admin', 'super_admin', 'rental'].includes(userRole)) {
                    e.preventDefault();
                    alert('Anda tidak memiliki izin untuk mengakses transaksi.');
                    return;
                }

                // Tampilkan status loading
                const icon = this.querySelector('i');
                const originalIcon = icon?.className;

                if (icon && !href.startsWith('javascript:')) {
                    icon.className = 'fas fa-spinner fa-spin me-3';

                    // Reset setelah navigasi (fallback)
                    setTimeout(() => {
                        if (originalIcon) {
                            icon.className = originalIcon;
                        }
                    }, 2000);
                }
            });

            // Efek hover yang ditingkatkan
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

        // Sembunyikan sidebar otomatis di mobile setelah klik link
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

    // Fungsi untuk mengatur menu aktif secara manual dengan validasi role
    function setActiveMenu(menuName) {
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        const userRole = '{{ Auth::user()->role ?? "user" }}';

        navLinks.forEach(link => {
            // Reset semua link
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

        // Cari dan aktifkan menu spesifik
        const targetLink = document.querySelector(`.sidebar .nav-link[href*="${menuName}"]`);
        if (targetLink) {
            // Periksa apakah pengguna memiliki izin
            const href = targetLink.getAttribute('href');
            const requiresAdmin = href.includes('users') || href.includes('superadmin');
            const requiresRental = href.includes('rental');
            const requiresTransactionAccess = href.includes('transactions');

            if ((requiresAdmin && !['admin', 'super_admin'].includes(userRole)) ||
                (requiresRental && userRole !== 'rental' && !['admin', 'super_admin'].includes(userRole)) ||
                (requiresTransactionAccess && !['admin', 'super_admin', 'rental'].includes(userRole))) {
                console.log('Pengguna tidak memiliki izin untuk menu ini:', menuName);
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

    // Handle resize window untuk perilaku responsif
    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.sidebar');
        if (window.innerWidth >= 768) {
            sidebar?.classList.remove('show');
        }
    });

    // Tambahkan smooth scrolling untuk sidebar
    function smoothScrollSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.style.scrollBehavior = 'smooth';
        }
    }

    // Initialize smooth scrolling
    smoothScrollSidebar();
</script>
