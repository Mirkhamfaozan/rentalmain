@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Welcome back, John! Here\'s what\'s happening with your business today.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Export
        </button>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add New
        </button>
    </div>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">2,543</div>
                            <div class="text-muted small">Total Users</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +12.5%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">1,234</div>
                            <div class="text-muted small">Total Orders</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +8.2%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">$45,678</div>
                            <div class="text-muted small">Total Revenue</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +15.3%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">98.5%</div>
                            <div class="text-muted small">Conversion Rate</div>
                            <div class="text-danger small">
                                <i class="fas fa-arrow-down"></i> -2.1%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Activity Row -->
    <div class="row mb-4">
        <div class="col-xl-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">Revenue Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                        style="height: 300px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-chart-area fa-3x mb-3"></i>
                            <p class="mb-1">Chart will be rendered here</p>
                            <small>Integrate with Chart.js or similar library</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 32px; height: 32px;">
                                    <i class="fas fa-user fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">New user registered</div>
                                    <div class="text-muted small">2 minutes ago</div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 32px; height: 32px;">
                                    <i class="fas fa-shopping-cart fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">Order #1234 completed</div>
                                    <div class="text-muted small">5 minutes ago</div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 32px; height: 32px;">
                                    <i class="fas fa-credit-card fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">Payment received</div>
                                    <div class="text-muted small">10 minutes ago</div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 32px; height: 32px;">
                                    <i class="fas fa-box fa-sm"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold small">Product added</div>
                                    <div class="text-muted small">15 minutes ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Orders</h5>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>New Order
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">Order ID</th>
                                    <th class="border-0 fw-semibold">Customer</th>
                                    <th class="border-0 fw-semibold">Product</th>
                                    <th class="border-0 fw-semibold">Amount</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Date</th>
                                    <th class="border-0 fw-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-primary">#1234</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; font-size: 12px;">
                                                JS
                                            </div>
                                            John Smith
                                        </div>
                                    </td>
                                    <td>Laravel Course</td>
                                    <td class="fw-bold">$299</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td class="text-muted">2024-01-15</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary">#1235</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; font-size: 12px;">
                                                SJ
                                            </div>
                                            Sarah Johnson
                                        </div>
                                    </td>
                                    <td>React Components</td>
                                    <td class="fw-bold">$199</td>
                                    <td><span class="badge bg-warning text-dark">Processing</span></td>
                                    <td class="text-muted">2024-01-15</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary">#1236</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; font-size: 12px;">
                                                MW
                                            </div>
                                            Mike Wilson
                                        </div>
                                    </td>
                                    <td>Bootstrap Template</td>
                                    <td class="fw-bold">$149</td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                    <td class="text-muted">2024-01-14</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary">#1237</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; font-size: 12px;">
                                                ED
                                            </div>
                                            Emily Davis
                                        </div>
                                    </td>
                                    <td>Vue.js Tutorial</td>
                                    <td class="fw-bold">$249</td>
                                    <td><span class="badge bg-primary">Pending</span></td>
                                    <td class="text-muted">2024-01-14</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-primary">#1238</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; font-size: 12px;">
                                                RB
                                            </div>
                                            Robert Brown
                                        </div>
                                    </td>
                                    <td>PHP Framework</td>
                                    <td class="fw-bold">$399</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td class="text-muted">2024-01-13</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-transparent border-0">
                        <nav>
                            <ul class="pagination pagination-sm justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
