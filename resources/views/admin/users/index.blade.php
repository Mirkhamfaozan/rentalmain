@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'User Management')
@section('page-description', 'Manage and monitor all users in your system.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Export Users
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-filter me-1"></i>Filter
        </button>
        <button type="button" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>Add User
        </button>
    </div>
@endsection

@section('content')
    <!-- User Stats Cards -->
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
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">2,234</div>
                            <div class="text-muted small">Active Users</div>
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
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-user-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">309</div>
                            <div class="text-muted small">Pending Users</div>
                            <div class="text-danger small">
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
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">127</div>
                            <div class="text-muted small">New This Month</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +22.1%
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
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search users...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option selected>All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option selected>All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i>Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">All Users</h5>
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
                                    <th class="border-0 fw-semibold">User</th>
                                    <th class="border-0 fw-semibold">Email</th>
                                    <th class="border-0 fw-semibold">Role</th>
                                    <th class="border-0 fw-semibold">Status</th>
                                    <th class="border-0 fw-semibold">Last Login</th>
                                    <th class="border-0 fw-semibold">Joined</th>
                                    <th class="border-0 fw-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/007bff/ffffff?text=JS"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">John Smith</div>
                                                <div class="text-muted small">ID: #001</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>john.smith@example.com</td>
                                    <td><span class="badge bg-danger">Admin</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="text-muted">2 hours ago</td>
                                    <td class="text-muted">2023-01-15</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/28a745/ffffff?text=SJ"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">Sarah Johnson</div>
                                                <div class="text-muted small">ID: #002</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>sarah.johnson@example.com</td>
                                    <td><span class="badge bg-info">Moderator</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="text-muted">5 hours ago</td>
                                    <td class="text-muted">2023-02-20</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/dc3545/ffffff?text=MW"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">Mike Wilson</div>
                                                <div class="text-muted small">ID: #003</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>mike.wilson@example.com</td>
                                    <td><span class="badge bg-secondary">User</span></td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td class="text-muted">Never</td>
                                    <td class="text-muted">2024-01-10</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/ffc107/ffffff?text=ED"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">Emily Davis</div>
                                                <div class="text-muted small">ID: #004</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>emily.davis@example.com</td>
                                    <td><span class="badge bg-primary">Editor</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="text-muted">1 day ago</td>
                                    <td class="text-muted">2023-11-05</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/17a2b8/ffffff?text=RB"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">Robert Brown</div>
                                                <div class="text-muted small">ID: #005</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>robert.brown@example.com</td>
                                    <td><span class="badge bg-secondary">User</span></td>
                                    <td><span class="badge bg-danger">Suspended</span></td>
                                    <td class="text-muted">1 week ago</td>
                                    <td class="text-muted">2023-08-12</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="Restore">
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
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/6f42c1/ffffff?text=AW"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">Alice White</div>
                                                <div class="text-muted small">ID: #006</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>alice.white@example.com</td>
                                    <td><span class="badge bg-secondary">User</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="text-muted">3 hours ago</td>
                                    <td class="text-muted">2024-01-18</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40x40/fd7e14/ffffff?text=DG"
                                                class="rounded-circle me-3" alt="Avatar" width="40" height="40">
                                            <div>
                                                <div class="fw-semibold">David Green</div>
                                                <div class="text-muted small">ID: #007</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>david.green@example.com</td>
                                    <td><span class="badge bg-secondary">User</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td class="text-muted">6 hours ago</td>
                                    <td class="text-muted">2023-12-03</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
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
                                <span id="selectedCount">0</span> users selected
                            </span>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-check me-1"></i>Activate
                                </button>
                                <button class="btn btn-outline-warning">
                                    <i class="fas fa-pause me-1"></i>Suspend
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                Showing 1 to 7 of 2,543 entries
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
                                        <a class="page-link" href="#">255</a>
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
});
</script>
@endpush
