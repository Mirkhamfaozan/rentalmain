@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Motor Products')
@section('page-description', 'Manage your motorcycle inventory and pricing.')

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i>Export
        </button>
        <button type="button" class="btn btn-outline-info">
            <i class="fas fa-upload me-1"></i>Import
        </button>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Add Motor
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Product Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px;">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->count() }}</div>
                            <div class="text-muted small">Total Motors</div>
                            <div class="text-success small">
                                <i class="fas fa-arrow-up"></i> +5.2%
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
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->where('transmisi_motor', 'Manual')->count() }}</div>
                            <div class="text-muted small">Manual</div>
                            <div class="text-info small">
                                <i class="fas fa-wrench"></i> Transmission
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
                                <i class="fas fa-magic"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ $products->where('transmisi_motor', 'Automatic')->count() }}</div>
                            <div class="text-muted small">Automatic</div>
                            <div class="text-info small">
                                <i class="fas fa-magic"></i> Transmission
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
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold h4 mb-1">{{ number_format($products->avg('harga')) }}</div>
                            <div class="text-muted small">Avg Price</div>
                            <div class="text-success small">
                                <i class="fas fa-rupiah-sign"></i> IDR
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Search Motors</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Search by motor name..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">CC Range</label>
                                <select name="cc_range" class="form-select">
                                    <option value="">All CC</option>
                                    <option value="0-150" {{ request('cc_range') == '0-150' ? 'selected' : '' }}>0-150cc</option>
                                    <option value="151-250" {{ request('cc_range') == '151-250' ? 'selected' : '' }}>151-250cc</option>
                                    <option value="251-400" {{ request('cc_range') == '251-400' ? 'selected' : '' }}>251-400cc</option>
                                    <option value="400+" {{ request('cc_range') == '400+' ? 'selected' : '' }}>400cc+</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">Transmission</label>
                                <select name="transmission" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="Automatic" {{ request('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="CVT" {{ request('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">Price Range</label>
                                <select name="price_range" class="form-select">
                                    <option value="">All Prices</option>
                                    <option value="0-20000000" {{ request('price_range') == '0-20000000' ? 'selected' : '' }}>Under 20M</option>
                                    <option value="20000000-50000000" {{ request('price_range') == '20000000-50000000' ? 'selected' : '' }}>20M - 50M</option>
                                    <option value="50000000+" {{ request('price_range') == '50000000+' ? 'selected' : '' }}>Above 50M</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-semibold">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-secondary">
                                        <i class="fas fa-filter me-1"></i>Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Motor List</h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary active">
                                    <i class="fas fa-th-list"></i>
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-th"></i>
                                </button>
                            </div>
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
                                    <th class="border-0 fw-semibold">Motor</th>
                                    <th class="border-0 fw-semibold">CC</th>
                                    <th class="border-0 fw-semibold">Transmission</th>
                                    <th class="border-0 fw-semibold">Price</th>
                                    <th class="border-0 fw-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center me-3"
                                                 style="width: 48px; height: 48px; font-size: 18px;">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $product->nama_motor }}</div>
                                                <div class="text-muted small">{{ $product->cc_motor }}cc Motor</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge
                                            @if($product->cc_motor <= 150) bg-success-subtle text-success
                                            @elseif($product->cc_motor <= 250) bg-warning-subtle text-warning
                                            @elseif($product->cc_motor <= 400) bg-info-subtle text-info
                                            @else bg-danger-subtle text-danger
                                            @endif">
                                            {{ $product->cc_motor }}cc
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge
                                            @if($product->transmisi_motor == 'Manual') bg-primary-subtle text-primary
                                            @elseif($product->transmisi_motor == 'Automatic') bg-success-subtle text-success
                                            @else bg-info-subtle text-info
                                            @endif">
                                            {{ $product->transmisi_motor }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.products.show', $product) }}"
                                               class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                               class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this motor?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-motorcycle fa-3x mb-3"></i>
                                            <p>No motors found</p>
                                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i>Add First Motor
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($products->count() > 0)
                    <!-- Bulk Actions -->
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted small">With selected:</span>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-outline-danger">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>

                            <!-- Pagination placeholder -->
                            <div class="text-muted small">
                                Showing {{ $products->count() }} motors
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
