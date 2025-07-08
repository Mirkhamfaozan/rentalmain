@extends('layouts.app')

@section('title', 'Biodata Rental')
@section('page-title', 'Manajemen Biodata Rental')
@section('page-description', 'Kelola dan pantau semua biodata rental di sistem Anda.')

@section('page-actions')
    <div class="btn-group me-2 gap-2">
        <button type="button" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="fas fa-download me-1"></i> Ekspor Biodata
        </button>
        <button type="button" class="btn btn-outline-info rounded-pill shadow-sm" data-bs-toggle="collapse"
            data-bs-target="#filterCollapse">
            <i class="fas fa-filter me-1"></i> Filter
        </button>
        <a href="{{ route('dashboard.rental_biodata.create') }}"
            class="btn btn-primary rounded-pill shadow-lg fs-5 px-4 py-2"
            style="background: linear-gradient(45deg, #007bff, #00d4ff); border: none; color: white;"
            title="Tambah Biodata Baru">
            <i class="fas fa-plus me-2"></i> Tambah Biodata
        </a>
    </div>
@endsection

@section('content')
    <!-- Biodata Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow rounded-3 overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">Semua Biodata Rental</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active rounded-start">
                                <i class="fas fa-list"></i>
                            </button>
                            <button class="btn btn-outline-secondary rounded-end">
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
                                    <th class="border-0 fw-semibold ps-4">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0 fw-semibold">Nama Rental</th>
                                    <th class="border-0 fw-semibold">Pemilik</th>
                                    <th class="border-0 fw-semibold">Email Perusahaan</th>
                                    <th class="border-0 fw-semibold">Status Verifikasi</th>
                                    <th class="border-0 fw-semibold">Tanggal Dibuat</th>
                                    <th class="border-0 fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($biodatas as $biodata)
                                    <tr style="transition: background-color 0.2s ease;">
                                        <td class="ps-4">
                                            <input type="checkbox" class="form-check-input" name="selectedBiodatas[]"
                                                value="{{ $biodata->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $biodata->nama_rental }}</div>
                                                    <div class="text-muted small">ID:
                                                        #{{ str_pad($biodata->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $biodata->nama_pemilik }}</td>
                                        <td>{{ $biodata->email_perusahaan }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $biodata->getStatusBadgeClass() }} rounded-pill px-3 py-1">
                                                {{ $biodata->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $biodata->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm gap-1">
                                                <a href="{{ route('dashboard.rental_biodata.show', $biodata->id) }}"
                                                    class="btn btn-outline-primary rounded-circle" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if ($biodata->canUpdate(auth()->user()))
                                                    <a href="{{ route('dashboard.rental_biodata.edit', $biodata->id) }}"
                                                        class="btn btn-outline-teal rounded-circle" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Edit Biodata">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                <button class="btn btn-outline-danger rounded-circle delete-btn"
                                                    data-id="{{ $biodata->id }}" title="Hapus Biodata">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @if ($biodata->canVerify(auth()->user()))
                                                    <button class="btn btn-outline-success rounded-circle verify-btn"
                                                        data-id="{{ $biodata->id }}" title="Verifikasi">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-outline-warning rounded-circle reject-btn"
                                                        data-id="{{ $biodata->id }}" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                                @if (auth()->user()->isAdmin() && !$biodata->isPending())
                                                    <button class="btn btn-outline-info rounded-circle reset-btn"
                                                        data-id="{{ $biodata->id }}" title="Reset Verifikasi">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Tidak ada biodata rental
                                            ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Selected Actions Bar -->
                    <div class="border-top p-3 bg-light d-none" id="selectedActions">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <span id="selectedCount">0</span> biodata dipilih
                            </span>
                            <div class="btn-group btn-group-sm gap-2">
                                @if (auth()->user()->isAdmin())
                                    <button class="btn btn-outline-success rounded-pill shadow-sm bulk-verify-btn">
                                        <i class="fas fa-check me-1"></i> Verifikasi
                                    </button>
                                    <button class="btn btn-outline-warning rounded-pill shadow-sm bulk-reject-btn">
                                        <i class="fas fa-times me-1"></i> Tolak
                                    </button>
                                @endif
                                <button class="btn btn-outline-danger rounded-pill shadow-sm bulk-delete-btn">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-transparent border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                Menampilkan {{ $biodatas->firstItem() }} hingga {{ $biodatas->lastItem() }} dari
                                {{ $biodatas->total() }} entri
                            </span>
                            {{ $biodatas->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
        }

        .btn {
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #00b7ff) !important;
        }

        .btn-outline-teal {
            border-color: #20c997;
            color: #20c997;
        }

        .btn-outline-teal:hover {
            background-color: #20c997;
            color: white;
        }

        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-success,
        .btn-outline-warning,
        .btn-outline-danger,
        .btn-outline-info,
        .btn-outline-teal {
            border-width: 2px;
        }

        .badge {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .rounded-pill {
            border-radius: 50rem !important;
        }

        .rounded-circle {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        [data-bs-toggle="tooltip"] {
            position: relative;
        }

        .tooltip-inner {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            // Handle select all checkbox
            const selectAllCheckbox = document.querySelector('#selectAll');
            const rowCheckboxes = document.querySelectorAll('tbody input[name="selectedBiodatas[]"]');
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
                const checkedBoxes = document.querySelectorAll('tbody input[name="selectedBiodatas[]"]:checked');
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

            // SweetAlert2 configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Single delete action
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const biodataId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menghapus biodata ini secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/dashboard/rental_biodata/${biodataId}`;
                            form.innerHTML = `@csrf @method('DELETE')`;
                            document.body.appendChild(form);
                            form.submit();

                            Toast.fire({
                                icon: 'success',
                                title: 'Biodata berhasil dihapus!'
                            });
                        }
                    });
                });
            });

            // Single verify action
            document.querySelectorAll('.verify-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const biodataId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Verifikasi Biodata',
                        text: "Apakah Anda yakin ingin memverifikasi biodata ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, verifikasi!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/dashboard/rental_biodata/${biodataId}/verify`;
                            form.innerHTML = `@csrf`;
                            document.body.appendChild(form);
                            form.submit();

                            Toast.fire({
                                icon: 'success',
                                title: 'Biodata berhasil diverifikasi!'
                            });
                        }
                    });
                });
            });

            // Single reject action
            document.querySelectorAll('.reject-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const biodataId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Tolak Biodata',
                        text: "Apakah Anda yakin ingin menolak biodata ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc107',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, tolak!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/dashboard/rental_biodata/${biodataId}/reject`;
                            form.innerHTML = `@csrf`;
                            document.body.appendChild(form);
                            form.submit();

                            Toast.fire({
                                icon: 'success',
                                title: 'Biodata berhasil ditolak!'
                            });
                        }
                    });
                });
            });

            // Single reset verification action
            document.querySelectorAll('.reset-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const biodataId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Reset Verifikasi',
                        text: "Apakah Anda yakin ingin mereset status verifikasi biodata ini?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, reset!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/dashboard/rental_biodata/${biodataId}/reset-verification`;
                            form.innerHTML = `@csrf`;
                            document.body.appendChild(form);
                            form.submit();

                            Toast.fire({
                                icon: 'success',
                                title: 'Status verifikasi berhasil direset!'
                            });
                        }
                    });
                });
            });

            // Bulk actions
            document.querySelector('.bulk-delete-btn').addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('tbody input[name="selectedBiodatas[]"]:checked');
                if (checkedBoxes.length === 0) {
                    Swal.fire({
                        title: 'Tidak ada biodata dipilih',
                        text: 'Silakan pilih setidaknya satu biodata untuk dihapus.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Hapus Biodata Terpilih',
                    html: `Anda yakin ingin menghapus <strong>${checkedBoxes.length}</strong> biodata yang dipilih?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/dashboard/rental_biodata/bulk-delete';
                        form.innerHTML = `@csrf @method('DELETE')`;

                        checkedBoxes.forEach(checkbox => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'selectedBiodatas[]';
                            input.value = checkbox.value;
                            form.appendChild(input);
                        });

                        document.body.appendChild(form);
                        form.submit();

                        Toast.fire({
                            icon: 'success',
                            title: 'Biodata berhasil dihapus!'
                        });
                    }
                });
            });

            document.querySelector('.bulk-verify-btn').addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('tbody input[name="selectedBiodatas[]"]:checked');
                if (checkedBoxes.length === 0) {
                    Swal.fire({
                        title: 'Tidak ada biodata dipilih',
                        text: 'Silakan pilih setidaknya satu biodata untuk diverifikasi.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Verifikasi Biodata Terpilih',
                    html: `Anda yakin ingin memverifikasi <strong>${checkedBoxes.length}</strong> biodata yang dipilih?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, verifikasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/dashboard/rental_biodata/bulk-verify';
                        form.innerHTML = `@csrf`;

                        checkedBoxes.forEach(checkbox => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'selectedBiodatas[]';
                            input.value = checkbox.value;
                            form.appendChild(input);
                        });

                        document.body.appendChild(form);
                        form.submit();

                        Toast.fire({
                            icon: 'success',
                            title: 'Biodata berhasil diverifikasi!'
                        });
                    }
                });
            });

            document.querySelector('.bulk-reject-btn').addEventListener('click', function() {
                const checkedBoxes = document.querySelectorAll('tbody input[name="selectedBiodatas[]"]:checked');
                if (checkedBoxes.length === 0) {
                    Swal.fire({
                        title: 'Tidak ada biodata dipilih',
                        text: 'Silakan pilih setidaknya satu biodata untuk ditolak.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Tolak Biodata Terpilih',
                    html: `Anda yakin ingin menolak <strong>${checkedBoxes.length}</strong> biodata yang dipilih?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/dashboard/rental_biodata/bulk-reject';
                        form.innerHTML = `@csrf`;

                        checkedBoxes.forEach(checkbox => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'selectedBiodatas[]';
                            input.value = checkbox.value;
                            form.appendChild(input);
                        });

                        document.body.appendChild(form);
                        form.submit();

                        Toast.fire({
                            icon: 'success',
                            title: 'Biodata berhasil ditolak!'
                        });
                    }
                });
            });
        });
    </script>
@endpush
