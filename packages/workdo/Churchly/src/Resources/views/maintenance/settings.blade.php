@extends('layouts.main')

@section('page-title', __('Maintenance Settings'))
@section('page-breadcrumb', __('Maintenance'))
@section('page-action')
    <a href="{{ route('maintenance.index') }}" class="btn btn-primary">
        {{ __('Back to schedules') }}
    </a>
@endsection

@section('content')
    <div class="row gy-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ __('Notifications & Reminders') }}</h5>
                    <span class="badge bg-info">{{ __('Workspace-level') }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('maintenance.settings.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Notification methods') }}</label>
                            <div class="form-check form-check-inline">
                                @foreach($methods as $method)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="notification_methods[]"
                                               value="{{ $method }}" id="method_{{ $method }}"
                                               {{ in_array($method, $settings->notification_methods ?: []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="method_{{ $method }}">
                                            {{ ucfirst($method) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Notification time') }}</label>
                            <input type="time" name="notification_time" class="form-control"
                                   value="{{ $settings->notification_time }}">
                            <small class="text-muted">{{ __('Time when reminders are fired daily.') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Reminder lead time (days)') }}</label>
                            <input type="number" name="reminder_before_days" class="form-control"
                                   value="{{ $settings->reminder_before_days }}" min="0" max="30">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Default category') }}</label>
                            <select name="default_category" class="form-select">
                                <option value="">{{ __('None') }}</option>
                                <option value="General" {{ $settings->default_category === 'General' ? 'selected' : '' }}>
                                    {{ __('General') }}
                                </option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}"
                                            {{ $settings->default_category === $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save settings') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Maintenance categories') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('maintenance.settings.categories') }}" method="post" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name="name" class="form-control" placeholder="{{ __('New category name') }}" required>
                        <button class="btn btn-success">{{ __('Add') }}</button>
                    </form>
                    <div class="list-group">
                        @forelse($categories as $category)
                            <div class="list-group-item d-flex align-items-center justify-content-between">
                                <span>{{ $category->name }}</span>
                                <form action="{{ route('maintenance.settings.categories.destroy', $category) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm">{{ __('Remove') }}</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-muted">{{ __('No custom categories yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
