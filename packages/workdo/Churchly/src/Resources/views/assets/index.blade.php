@extends('layouts.main')

@section('page-title', __('Asset inventory'))
@section('page-breadcrumb', 'Assets,Inventory')
@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('assets.dashboard') }}" class="btn btn-outline-secondary">
            {{ __('Dashboard') }}
        </a>
        <a href="{{ route('assets.reports') }}" class="btn btn-outline-secondary">
            {{ __('Reports') }}
        </a>
        <a href="{{ route('assets.export', ['format' => 'excel']) }}" class="btn btn-outline-secondary">
            {{ __('Export Excel') }}
        </a>
        <a href="{{ route('assets.export', ['format' => 'pdf']) }}" class="btn btn-outline-secondary">
            {{ __('Export PDF') }}
        </a>
        <a href="{{ route('assets.print') }}" class="btn btn-outline-secondary" target="_blank">
            {{ __('Print') }}
        </a>
        <a href="{{ route('assets.settings.index') }}" class="btn btn-outline-secondary">
            {{ __('Settings') }}
        </a>
        <a href="{{ route('assets.create') }}" class="btn btn-primary">
            {{ __('Add asset') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Total items') }}</h6>
                <strong class="fs-4">{{ $stats['total_items'] }}</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Total quantity') }}</h6>
                <strong class="fs-4">{{ $stats['total_quantity'] }}</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Low stock alerts') }}</h6>
                <strong class="fs-4 text-danger">{{ $stats['low_stock'] }}</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Movements') }}</h6>
                <strong class="fs-4">{{ $stats['movements'] }}</strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Inspections') }}</h6>
                <strong class="fs-4">{{ $stats['inspections'] }}</strong>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Branch') }}</label>
                    <select name="branch_id" class="form-select">
                        <option value="">{{ __('Any branch') }}</option>
                        @foreach($branches as $id => $name)
                            <option value="{{ $id }}" {{ $filters['branch_id'] == $id ? 'selected' : '' }}>
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
                            <option value="{{ $id }}" {{ $filters['department_id'] == $id ? 'selected' : '' }}>
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
                            <option value="{{ $category }}" {{ $filters['category'] == $category ? 'selected' : '' }}>
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
                            <option value="{{ $value }}" {{ $filters['status'] == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 text-end">
                    <button class="btn btn-light border">{{ __('Apply filters') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Asset') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Location') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Available') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                        <tr>
                            <td>
                                <strong>{{ $asset->asset_name }}</strong><br>
                                <small class="text-muted">{{ $asset->asset_code }}</small>
                            </td>
                            <td>{{ $asset->category ?? __('General') }}</td>
                            <td>{{ $asset->location ?? __('Not set') }}</td>
                            <td>{{ $asset->quantity }}</td>
                            <td>{{ $asset->available_quantity }}</td>
                            <td>
                                <span class="badge bg-{{ $asset->status == 'operational' ? 'success' : 'secondary' }}">
                                    {{ $statusOptions[$asset->status] ?? ucfirst($asset->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('assets.edit', $asset) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                @can('asset inventory delete')
                                    <form action="{{ route('assets.destroy', $asset) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('{{ __('Are you sure?') }}');">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                {{ __('No assets recorded yet.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $assets->links() }}
        </div>
    </div>
@endsection
