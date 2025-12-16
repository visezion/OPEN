@extends('layouts.main')

@section('page-title', __('Asset settings'))
@section('page-breadcrumb', __('Assets'))
@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('assets.dashboard') }}" class="btn btn-outline-secondary">{{ __('Dashboard') }}</a>
        <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">{{ __('Inventory') }}</a>
        <a href="{{ route('assets.reports') }}" class="btn btn-outline-secondary">{{ __('Reports') }}</a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Notification preferences') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('assets.settings.update') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Notification methods') }}</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($methods as $method)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="notification_methods[]"
                                        value="{{ $method }}" id="method-{{ $method }}"
                                        {{ in_array($method, $settings->notification_methods ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="method-{{ $method }}">
                                        {{ ucfirst($method) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Notify time') }}</label>
                        <input type="time" name="notification_time" class="form-control"
                            value="{{ $settings->notification_time }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Low stock threshold') }}</label>
                        <input type="number" name="low_stock_threshold" class="form-control"
                            value="{{ $settings->low_stock_threshold ?? 5 }}" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Inspection reminder days') }}</label>
                        <input type="number" name="inspection_reminder_days" class="form-control"
                            value="{{ $settings->inspection_reminder_days ?? 7 }}" min="1">
                    </div>
                    <div class="col-12 text-end">
                        <button class="btn btn-primary">{{ __('Save settings') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
