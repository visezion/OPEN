@extends('layouts.main')

@section('page-title', __('Asset dashboard'))
@section('page-breadcrumb', __('Assets'))
@section('page-action')
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">{{ __('Inventory') }}</a>
        <a href="{{ route('assets.reports') }}" class="btn btn-outline-secondary">{{ __('Reports') }}</a>
        <a href="{{ route('assets.settings.index') }}" class="btn btn-outline-secondary">{{ __('Settings') }}</a>
    </div>
@endsection

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Total items') }}</h6>
                <strong class="fs-4">{{ $stats['total_items'] }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Quantity on record') }}</h6>
                <strong class="fs-4">{{ $stats['total_quantity'] }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Available') }}</h6>
                <strong class="fs-4">{{ $stats['available_quantity'] }}</strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Low stock alerts') }}</h6>
                <strong class="fs-4 text-danger">{{ $stats['low_stock'] }}</strong>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5>{{ __('Recent movements') }}</h5>
                    <p class="text-muted">{{ __('Latest transfers tracked per asset.') }}</p>
                    <div class="list-group">
                        @forelse($recentMovements as $movement)
                            <div class="list-group-item">
                                <strong>{{ $movement->asset->asset_name ?? __('Unknown asset') }}</strong>
                                <div class="text-muted small">
                                    {{ $movement->quantity }} {{ __('items') }} · {{ $movement->moved_at->diffForHumans() }}
                                </div>
                                <div class="text-muted small">
                                    {{ __('From') }} {{ optional($movement->fromBranch)->name ?? __('N/A') }}
                                    {{ __('to') }} {{ optional($movement->toBranch)->name ?? __('N/A') }}
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-muted">
                                {{ __('No recent movements.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5>{{ __('Recent inspections') }}</h5>
                    <p class="text-muted">{{ __('Track latest audit statuses.') }}</p>
                    <div class="list-group">
                        @forelse($recentInspections as $inspection)
                            <div class="list-group-item">
                                <strong>{{ $inspection->asset->asset_name ?? __('Unknown asset') }}</strong>
                                <div class="text-muted small">
                                    {{ __('Status') }}: {{ $inspection->status }}
                                    · {{ $inspection->inspected_at->format('Y-m-d H:i') }}
                                </div>
                                @if($inspection->findings)
                                    <div class="text-muted small">
                                        {{ \Illuminate\Support\Str::limit($inspection->findings, 80) }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="list-group-item text-muted">
                                {{ __('No inspections logged.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>{{ __('Notification settings') }}</h5>
                    <p class="text-muted">{{ __('Delivery preferences for low stock and inspection reminders.') }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Methods') }}</span>
                            <span class="text-primary">
                                {{ implode(', ', $settings->notification_methods ?? []) ?: __('Not configured') }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Low stock threshold') }}</span>
                            <span>{{ $settings->low_stock_threshold }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Inspection reminder (days)') }}</span>
                            <span>{{ $settings->inspection_reminder_days }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Notification time') }}</span>
                            <span>{{ $settings->notification_time ?? __('Anytime') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
