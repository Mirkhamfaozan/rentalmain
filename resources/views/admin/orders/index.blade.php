@extends('layouts.app')

@section('title', 'Orders')
@section('page-title', 'Order Management')
@section('page-description', 'Manage and monitor all orders in your system.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Export Orders
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-filter me-1"></i>Filter
        </button>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>New Order
        </button>
    </div>
@endsection

@section('content')
    <!-- Order Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">1,847</div>
                            <div class="text-muted small">Total Orders</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +8.3%
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
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">1,234</div>
                            <div class="text-muted small">Completed</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +12.1%
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
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">421</div>
                            <div class="text-muted small">Pending</div>
                            <div class="text-warning small">
                                <i class="fas fa-arrow-up"></i> +5.7%
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
                            <div class="fw-bold h4 mb-1">$48,532</div>
                            <div class="text-muted small">Revenue Today</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +18.4%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search orders...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>All Status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>Date Range</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="quarter">This Quarter</option>
                                <option value="year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>Payment Status</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                                <option value="partial">Partial</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>Amount Range</option>
                                <option value="0-50">$0 - $50</option>
                                <option value="50-100">$50 - $100</option>
                                <option value="100-500">$100 - $500</option>
                                <option value="500+">$500+</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">All Orders</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active">
                                <i class="fas fa-list"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-th"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-semibold">
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th class="border-0 fw-semibold">Order ID</th>
                                    <th class="border-0 fw-semibold">Customer</th>
                                    <th class="border-0 fw-semibold">Products</th>
                                    <th class="border-0 fw-semibold">Amount</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Payment</th>
                                    <th class="border-0 fw-semibold">Date</th>
                                    <th class="border-0 fw-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary">#ORD-001</div>
                                        <div class="text-muted small">Express</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32x32/007bff/ffffff?text=JS"
                                                class="rounded-circle me-2" alt="Avatar" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">John Smith</div>
                                                <div class="text-muted small">john.smith@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">3 items</div>
                                        <div class="text-muted small">Laptop, Mouse, Keyboard</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">$1,299.99</div>
                                    </td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td class="text-muted">2024-01-20</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Track">
                                                <i class="fas fa-truck"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Selected Actions Bar -->
                    <div class="border-top p-3 bg-light d-none" id="selectedActions">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <span id="selectedCount">0</span> orders selected
                            </span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-check me-1"></i>Mark as Processed
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="fas fa-truck me-1"></i>Ship Orders
                                </button>
                                <button class="btn btn-outline-warning">
                                    <i class="fas fa-print me-1"></i>Print Labels
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="fas fa-times me-1"></i>Cancel Orders
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                Showing 1 to 7 of 1,847 entries
                            </span>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
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
                                        <span class="page-link">...</span>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">264</a>
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
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle select all checkbox
        const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
        const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        const selectedActions = document.getElementById('selectedActions');
        const selectedCount = document.getElementById('selectedCount');

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedActions();
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedActions);
        });

        function updateSelectedActions() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            const count = checkedBoxes.length;

            if (count > 0) {
                selectedActions.classList.remove('d-none');
                selectedCount.textContent = count;
            } else {
                selectedActions.classList.add('d-none');
            }

            // Update select all checkbox state
            if (count === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (count === rowCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }

        // Handle status badge hover effects
        document.querySelectorAll('.badge').forEach(badge => {
            badge.style.cursor = 'pointer';
            badge.addEventListener('mouseenter', function() {
                this.style.opacity = '0.8';
            });
            badge.addEventListener('mouseleave', function() {
                this.style.opacity = '1';
            });
        });
    });
</script>
@endpush
