@extends('layouts.app')

@section('title', 'Transactions')
@section('page-title', 'Transaction Management')
@section('page-description', 'Monitor and manage all financial transactions in your system.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Export Transactions
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-filter me-1"></i>Filter
        </button>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Record Transaction
        </button>
    </div>
@endsection

@section('content')
    <!-- Transaction Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-credit-card"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">$284,721</div>
                            <div class="text-muted small">Total Revenue</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +15.2%
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
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">2,847</div>
                            <div class="text-muted small">Total Transactions</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +8.7%
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
                            <div class="fw-bold h4 mb-1">127</div>
                            <div class="text-muted small">Pending</div>
                            <div class="text-warning small">
                                <i class="fas fa-arrow-up"></i> +2.1%
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
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">$8,234</div>
                            <div class="text-muted small">Failed/Refunded</div>
                            <div class="text-danger small">
                                <i class="fas fa-arrow-down"></i> -3.4%
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
                                <input type="text" class="form-control" placeholder="Search transactions...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>All Status</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="failed">Failed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>Transaction Type</option>
                                <option value="payment">Payment</option>
                                <option value="refund">Refund</option>
                                <option value="chargeback">Chargeback</option>
                                <option value="adjustment">Adjustment</option>
                                <option value="fee">Fee</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select">
                                <option selected>Payment Method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="crypto">Cryptocurrency</option>
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

    <!-- Transactions Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">All Transactions</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active">
                                <i class="fas fa-list"></i>
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-chart-bar"></i>
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
                                    <th class="border-0 fw-semibold">Transaction ID</th>
                                    <th class="border-0 fw-semibold">Customer</th>
                                    <th class="border-0 fw-semibold">Type</th>
                                    <th class="border-0 fw-semibold">Amount</th>
                                    <th class="border-0 fw-semibold">Payment Method</th>
                                    <th class="border-0 fw-semibold">Status</th>
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
                                        <div class="fw-semibold text-primary">#TXN-001</div>
                                        <div class="text-muted small">Order #ORD-001</div>
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
                                        <span class="badge bg-info">Payment</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-success">+$1,299.99</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-cc-visa text-primary me-2"></i>
                                            <div>
                                                <div class="fw-semibold">Visa</div>
                                                <div class="text-muted small">****1234</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td class="text-muted">
                                        <div>2024-01-20</div>
                                        <div class="small">10:30 AM</div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Receipt">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                            <button class="btn btn-outline-warning" title="Refund">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary">#TXN-002</div>
                                        <div class="text-muted small">Order #ORD-002</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32x32/28a745/ffffff?text=MJ"
                                                class="rounded-circle me-2" alt="Avatar" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Mary Johnson</div>
                                                <div class="text-muted small">mary.johnson@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Payment</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-success">+$599.50</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-paypal text-primary me-2"></i>
                                            <div>
                                                <div class="fw-semibold">PayPal</div>
                                                <div class="text-muted small">mary.j***@gmail.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td class="text-muted">
                                        <div>2024-01-20</div>
                                        <div class="small">09:15 AM</div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Receipt">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Process">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary">#TXN-003</div>
                                        <div class="text-muted small">Refund #REF-001</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32x32/dc3545/ffffff?text=RW"
                                                class="rounded-circle me-2" alt="Avatar" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Robert Wilson</div>
                                                <div class="text-muted small">robert.wilson@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Refund</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-danger">-$299.00</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-cc-mastercard text-danger me-2"></i>
                                            <div>
                                                <div class="fw-semibold">Mastercard</div>
                                                <div class="text-muted small">****5678</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td class="text-muted">
                                        <div>2024-01-19</div>
                                        <div class="small">03:45 PM</div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Receipt">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="History">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary">#TXN-004</div>
                                        <div class="text-muted small">Order #ORD-004</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32x32/6f42c1/ffffff?text=LD"
                                                class="rounded-circle me-2" alt="Avatar" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Lisa Davis</div>
                                                <div class="text-muted small">lisa.davis@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Payment</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-success">+$899.99</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-university text-info me-2"></i>
                                            <div>
                                                <div class="fw-semibold">Bank Transfer</div>
                                                <div class="text-muted small">Wells Fargo</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-danger">Failed</span></td>
                                    <td class="text-muted">
                                        <div>2024-01-19</div>
                                        <div class="small">01:22 PM</div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-warning" title="Retry">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Contact">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary">#TXN-005</div>
                                        <div class="text-muted small">Order #ORD-005</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32x32/fd7e14/ffffff?text=TB"
                                                class="rounded-circle me-2" alt="Avatar" width="32" height="32">
                                            <div>
                                                <div class="fw-semibold">Tom Brown</div>
                                                <div class="text-muted small">tom.brown@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Payment</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-success">+$1,599.00</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-bitcoin text-warning me-2"></i>
                                            <div>
                                                <div class="fw-semibold">Bitcoin</div>
                                                <div class="text-muted small">1A2b3C...xyz</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">Processing</span></td>
                                    <td class="text-muted">
                                        <div>2024-01-19</div>
                                        <div class="small">11:05 AM</div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-info" title="Blockchain">
                                                <i class="fas fa-link"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Monitor">
                                                <i class="fas fa-chart-line"></i>
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
                                <span id="selectedCount">0</span> transactions selected
                            </span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-check me-1"></i>Process Selected
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="fas fa-download me-1"></i>Export Selected
                                </button>
                                <button class="btn btn-outline-warning">
                                    <i class="fas fa-receipt me-1"></i>Generate Receipts
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="fas fa-ban me-1"></i>Flag as Suspicious
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                Showing 1 to 5 of 2,847 entries
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
                                        <a class="page-link" href="#">570</a>
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

        // Add amount color coding based on type
        document.querySelectorAll('td .fw-semibold').forEach(element => {
            if (element.textContent.includes('+$')) {
                element.classList.add('text-success');
            } else if (element.textContent.includes('-$')) {
                element.classList.add('text-danger');
            }
        });

        // Transaction status color updates
        const statusBadges = document.querySelectorAll('.badge');
        statusBadges.forEach(badge => {
            const status = badge.textContent.toLowerCase().trim();
            badge.addEventListener('click', function() {
                // You can add modal or dropdown for status change here
                console.log('Status clicked:', status);
            });
        });
    });
</script>
@endpush
