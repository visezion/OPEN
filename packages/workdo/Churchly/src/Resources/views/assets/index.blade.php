@extends('layouts.main')

@section('page-title', __('Asset inventory'))
@section('page-breadcrumb', 'Assets,Inventory')
@section('page-action')
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('assets.dashboard') }}" class="btn btn-outline-secondary">{{ __('Dashboard') }}</a>
        <a href="{{ route('assets.reports') }}" class="btn btn-outline-secondary">{{ __('Reports') }}</a>
        <a href="{{ route('assets.export', ['format' => 'excel']) }}" class="btn btn-outline-secondary">{{ __('Export Excel') }}</a>
        <a href="{{ route('assets.export', ['format' => 'pdf']) }}" class="btn btn-outline-secondary">{{ __('Export PDF') }}</a>
        <a href="{{ route('assets.print') }}" class="btn btn-outline-secondary" target="_blank">{{ __('Print') }}</a>
        <a href="{{ route('assets.settings.index') }}" class="btn btn-outline-secondary">{{ __('Settings') }}</a>
        <a href="{{ route('assets.create') }}" class="btn btn-primary">{{ __('Add asset') }}</a>
    </div>
@endsection

@push('css')
<style>
    .asset-inventory-page .card {
        border: 1px solid var(--bs-border-color, #d8e2ef) !important;
        box-shadow: none !important;
    }

    .asset-inventory-page .section-label {
        font-size: 0.74rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--bs-secondary-color);
    }

    .asset-inventory-page .hero-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--bs-heading-color, #1f2937);
    }

    .asset-inventory-page .metric-card .metric-value {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.1;
        margin-top: 0.4rem;
        color: var(--bs-heading-color, #1f2937);
    }

    .asset-inventory-page .metric-card .metric-help {
        font-size: 0.8rem;
        color: var(--bs-secondary-color);
        margin-top: 0.35rem;
    }

    .asset-inventory-page .asset-table thead th {
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--bs-secondary-color);
        background: var(--bs-tertiary-bg);
        border-top: 0;
        border-bottom-color: var(--bs-border-color, #d8e2ef);
        white-space: nowrap;
    }

    .asset-inventory-page .asset-table tbody td {
        border-bottom-color: var(--bs-border-color, #d8e2ef);
        vertical-align: middle;
    }

    .asset-inventory-page .asset-table tbody tr:hover {
        background: rgba(13, 110, 253, 0.04);
    }

    .asset-inventory-page .asset-meta {
        color: var(--bs-secondary-color);
        font-size: 0.78rem;
        margin-top: 0.15rem;
    }

    .asset-inventory-page .stock-meter {
        min-width: 180px;
    }

    .asset-inventory-page .stock-meter .progress {
        height: 8px;
    }

    .asset-inventory-page .status-pill {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--bs-border-color, #d8e2ef);
        border-radius: 999px;
        padding: 0.2rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .asset-inventory-page .status-operational { color: #0f7a45; }
    .asset-inventory-page .status-in_maintenance { color: #8a6d1e; }
    .asset-inventory-page .status-retired { color: #6c757d; }
</style>
@endpush

@section('content')
    @php
        $activeFilterCount = collect($filters)->filter(fn($value) => filled($value))->count();
    @endphp

    <div class="asset-inventory-page">
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-8">
                        <div class="section-label">{{ __('Asset operations') }}</div>
                        <div class="hero-title">{{ __('Enterprise Asset Inventory Control Center') }}</div>
                        <p class="text-muted mb-0">
                            {{ __('Track stock levels, ownership, and lifecycle status across branches with full visibility.') }}
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <span class="badge text-bg-light border px-3 py-2">
                            {{ __('Assets Listed') }}: {{ $assets->total() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label">{{ __('Total items') }}</div>
                        <div class="metric-value">{{ $stats['total_items'] }}</div>
                        <div class="metric-help">{{ __('Distinct tracked assets') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label">{{ __('Total quantity') }}</div>
                        <div class="metric-value">{{ $stats['total_quantity'] }}</div>
                        <div class="metric-help">{{ __('All units on record') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label">{{ __('Available') }}</div>
                        <div class="metric-value">{{ $stats['available_quantity'] }}</div>
                        <div class="metric-help">{{ __('Ready for assignment') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label">{{ __('Low stock') }}</div>
                        <div class="metric-value text-danger">{{ $stats['low_stock'] }}</div>
                        <div class="metric-help">{{ __('Threshold alerts') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label">{{ __('Movements') }}</div>
                        <div class="metric-value">{{ $stats['movements'] }}</div>
                        <div class="metric-help">{{ __('Transfers logged') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card metric-card h-100">
                    <div class="card-body">
                        <div class="section-label">{{ __('Inspections') }}</div>
                        <div class="metric-value">{{ $stats['inspections'] }}</div>
                        <div class="metric-help">{{ __('Audit records') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-transparent">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="mb-1">{{ __('Inventory Filters') }}</h5>
                        <p class="text-muted mb-0">{{ __('Refine records by structure, category, and lifecycle status.') }}</p>
                    </div>
                    <span class="badge text-bg-light border">
                        {{ __('Active filters') }}: {{ $activeFilterCount }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Branch') }}</label>
                        <select name="branch_id" class="form-select">
                            <option value="">{{ __('Any branch') }}</option>
                            @foreach($branches as $id => $name)
                                <option value="{{ $id }}" {{ (string) $filters['branch_id'] === (string) $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Department') }}</label>
                        <select name="department_id" class="form-select">
                            <option value="">{{ __('Any department') }}</option>
                            @foreach($departments as $id => $name)
                                <option value="{{ $id }}" {{ (string) $filters['department_id'] === (string) $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Category') }}</label>
                        <select name="category" class="form-select">
                            <option value="">{{ __('All categories') }}</option>
                            @foreach($categoryOptions as $category)
                                <option value="{{ $category }}" {{ $filters['category'] === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select">
                            <option value="">{{ __('Any status') }}</option>
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ $filters['status'] === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('assets.index') }}" class="btn btn-light border">{{ __('Reset') }}</a>
                        <button class="btn btn-primary">{{ __('Apply filters') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Inventory Register') }}</h5>
                <small class="text-muted">{{ __('Page') }} {{ $assets->currentPage() }} / {{ $assets->lastPage() }}</small>
            </div>
            <div class="table-responsive">
                <table class="table asset-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Asset') }}</th>
                            <th>{{ __('Classification') }}</th>
                            <th>{{ __('Location & Owner') }}</th>
                            <th>{{ __('Stock Health') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            @php
                                $totalQty = max(1, (int) $asset->quantity);
                                $availableQty = max(0, (int) $asset->available_quantity);
                                $availability = min(100, (int) round(($availableQty / $totalQty) * 100));
                                $meterClass = $availability >= 70 ? 'success' : ($availability >= 40 ? 'warning' : 'danger');
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $asset->asset_name }}</div>
                                    <div class="asset-meta">
                                        {{ __('Code') }}: {{ $asset->asset_code ?? __('N/A') }}
                                        @if($asset->asset_tag)
                                            | {{ __('Tag') }}: {{ $asset->asset_tag }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $asset->category ?? __('General') }}</div>
                                    <div class="asset-meta">
                                        {{ $asset->asset_type ?? __('Unspecified type') }}
                                        @if($asset->serial_number)
                                            | {{ __('SN') }}: {{ $asset->serial_number }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $asset->location ?? __('Not set') }}</div>
                                    <div class="asset-meta">
                                        {{ optional($asset->branch)->name ?? __('No branch') }}
                                        | {{ optional($asset->department)->name ?? __('No department') }}
                                    </div>
                                    <div class="asset-meta">
                                        {{ __('Assigned') }}: {{ optional($asset->assignedTo)->name ?? __('Unassigned') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="stock-meter">
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span>{{ $availableQty }} / {{ $totalQty }} {{ __('available') }}</span>
                                            <span>{{ $availability }}%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-{{ $meterClass }}" role="progressbar" style="width: {{ $availability }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-pill status-{{ $asset->status }}">
                                        {{ $statusOptions[$asset->status] ?? ucfirst(str_replace('_', ' ', (string) $asset->status)) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('assets.show', $asset) }}" class="btn btn-sm btn-light border">{{ __('View') }}</a>
                                    <a href="{{ route('assets.edit', $asset) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                    @can('asset inventory delete')
                                        <form action="{{ route('assets.destroy', $asset) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure?') }}');">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    {{ __('No assets recorded yet. Start by adding your first inventory item.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent">
                {{ $assets->links() }}
            </div>
        </div>
    </div>
@endsection

