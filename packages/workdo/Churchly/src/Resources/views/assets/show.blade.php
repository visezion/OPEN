@extends('layouts.main')

@section('page-title', __('Asset details'))
@section('page-breadcrumb', __('Assets'))
@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">{{ __('Inventory') }}</a>
        <a href="{{ route('assets.dashboard') }}" class="btn btn-outline-secondary">{{ __('Dashboard') }}</a>
        <a href="{{ route('assets.reports') }}" class="btn btn-outline-secondary">{{ __('Reports') }}</a>
        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-primary">{{ __('Edit asset') }}</a>
    </div>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between">
                <div>
                    <h4>{{ $asset->asset_name }}</h4>
                    <p class="text-muted">{{ $asset->asset_code }} · {{ $asset->asset_tag }}</p>
                </div>
                <div class="text-end">
                    <h5 class="mb-1">{{ $asset->quantity }}</h5>
                    <small class="text-muted">{{ __('on record') }}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <strong>{{ __('Category') }}</strong>
                    <p>{{ $asset->category ?? __('General') }}</p>
                </div>
                <div class="col-md-3">
                    <strong>{{ __('Branch') }}</strong>
                    <p>{{ optional($asset->branch)->name ?? __('Headquarters') }}</p>
                </div>
                <div class="col-md-3">
                    <strong>{{ __('Department') }}</strong>
                    <p>{{ optional($asset->department)->name ?? __('General') }}</p>
                </div>
                <div class="col-md-3">
                    <strong>{{ __('Status') }}</strong>
                    <p>
                        <span class="badge bg-{{ $asset->status == 'operational' ? 'success' : 'secondary' }}">
                            {{ $statusOptions[$asset->status] ?? ucfirst($asset->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Movements') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('assets.movements.store', $asset) }}" method="post" class="mb-3">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Quantity') }}</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Reason') }}</label>
                                <input type="text" name="reason" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('Notes') }}</label>
                                <input type="text" name="notes" class="form-control">
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-sm btn-primary">{{ __('Record movement') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="list-group">
                        @forelse($movements as $movement)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $movement->quantity }} {{ __('items') }}</strong>
                                    <small class="text-muted">{{ $movement->moved_at->format('Y-m-d H:i') }}</small>
                                </div>
                                <p class="mb-0 small text-muted">
                                    {{ $movement->reason ?? __('Transfer update') }}
                                </p>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">
                                {{ __('No movements recorded yet.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Inspections') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('assets.inspections.store', $asset) }}" method="post" class="mb-3">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Status') }}</label>
                                <select name="status" class="form-select" required>
                                    @foreach($inspectionStatuses as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Cost incurred') }}</label>
                                <input type="number" step="0.01" name="cost_incurred" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('Findings') }}</label>
                                <textarea name="findings" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Inspected at') }}</label>
                                <input type="datetime-local" name="inspected_at" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Next inspection') }}</label>
                                <input type="date" name="next_inspection_date" class="form-control">
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-sm btn-primary">{{ __('Log inspection') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="list-group">
                        @forelse($inspections as $inspection)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $inspection->status }}</strong>
                                    <small class="text-muted">{{ $inspection->inspected_at->format('Y-m-d') }}</small>
                                </div>
                                <p class="mb-0 small text-muted">
                                    {{ $inspection->findings ?? __('No findings shared.') }}
                                </p>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">
                                {{ __('No inspections recorded yet.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
