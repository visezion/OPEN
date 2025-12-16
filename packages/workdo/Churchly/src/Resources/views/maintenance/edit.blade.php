@extends('layouts.main')

@section('page-title', __('Edit maintenance schedule'))
@section('page-breadcrumb', 'Maintenance,Edit')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('maintenance.update', $schedule) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Asset name') }}</label>
                        <input type="text" name="asset_name" value="{{ old('asset_name', $schedule->asset_name) }}"
                            class="form-control @error('asset_name') is-invalid @enderror">
                        @error('asset_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Asset code') }}</label>
                        <input type="text" name="asset_code" value="{{ old('asset_code', $schedule->asset_code) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Category') }}</label>
                        <select name="category" class="form-select">
                            @foreach($categoryOptions as $category)
                                <option value="{{ $category }}" {{ old('category', $schedule->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Branch') }}</label>
                        <select name="branch_id" class="form-select">
                            <option value="">{{ __('Headquarters') }}</option>
                            @foreach($branches as $id => $name)
                                <option value="{{ $id }}" {{ old('branch_id', $schedule->branch_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Department') }}</label>
                        <select name="department_id" class="form-select">
                            <option value="">{{ __('General') }}</option>
                            @foreach($departments as $id => $name)
                                <option value="{{ $id }}" {{ old('department_id', $schedule->department_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Priority') }}</label>
                        <select name="priority" class="form-select">
                            @foreach($priorityOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('priority', $schedule->priority) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Frequency') }}</label>
                        <select name="frequency_type" class="form-select">
                            @foreach($frequencyOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('frequency_type', $schedule->frequency_type) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Frequency value') }}</label>
                        <input type="number" name="frequency_value" class="form-control"
                            value="{{ old('frequency_value', $schedule->frequency_value) }}">
                        <small class="text-muted">{{ __('Number of units for the selected frequency') }}</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Start date') }}</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', optional($schedule->start_date)->toDateString()) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('End date') }}</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', optional($schedule->end_date)->toDateString()) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Estimated duration (minutes)') }}</label>
                        <input type="number" name="estimated_duration_minutes" class="form-control"
                            value="{{ old('estimated_duration_minutes', $schedule->estimated_duration_minutes) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Estimated cost') }}</label>
                        <input type="number" step="0.01" name="estimated_cost" class="form-control"
                            value="{{ old('estimated_cost', $schedule->estimated_cost) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Location') }}</label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location', $schedule->location) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Assigned to') }}</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">{{ __('Unassigned') }}</option>
                            @foreach($assignableUsers as $id => $name)
                                <option value="{{ $id }}" {{ old('assigned_to', $schedule->assigned_to) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $schedule->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ __('Update schedule') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
