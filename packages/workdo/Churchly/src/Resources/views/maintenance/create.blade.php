@extends('layouts.main')

@section('page-title', __('New maintenance schedule'))
@section('page-breadcrumb', 'Maintenance,Create')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('maintenance.store') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Asset name') }}</label>
                        <div class="input-group">
                            <input list="asset-names" type="text" name="asset_name" value="{{ old('asset_name') }}"
                                class="form-control @error('asset_name') is-invalid @enderror"
                                placeholder="{{ __('Start typing to search existing assets') }}">
                            <a href="{{ route('assets.create') }}" class="btn btn-outline-secondary" title="{{ __('Add new asset') }}">
                                <i class="ti ti-plus"></i>
                            </a>
                        </div>
                        <datalist id="asset-names">
                            @foreach($assetOptions as $assetName)
                                <option value="{{ $assetName }}"></option>
                            @endforeach
                        </datalist>
                        <script>
                            (function () {
                                const assetInput = document.querySelector('input[name="asset_name"]');
                                const assetList = document.getElementById('asset-names');
                                const assets = @json($assetOptions);

                                if (!assetInput || !assetList) {
                                    return;
                                }

                                const renderOptions = (items) => {
                                    assetList.innerHTML = '';
                                    items.forEach(name => {
                                        const option = document.createElement('option');
                                        option.value = name;
                                        assetList.appendChild(option);
                                    });
                                };

                                assetInput.addEventListener('input', () => {
                                    const term = assetInput.value.trim().toLowerCase();
                                    if (!term) {
                                        renderOptions(assets);
                                        return;
                                    }

                                    const filtered = assets.filter(name => name.toLowerCase().includes(term));
                                    renderOptions(filtered);
                                });
                            })();
                        </script>
                        @error('asset_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Asset code') }}</label>
                        <input type="text" name="asset_code" value="{{ old('asset_code') }}" class="form-control">
                        <small class="text-muted">{{ __('Leave blank to auto-generate') }}</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Category') }}</label>
                        <select name="category" class="form-select">
                            @foreach($categoryOptions as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
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
                                <option value="{{ $id }}" {{ old('branch_id') == $id ? 'selected' : '' }}>
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
                                <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Priority') }}</label>
                        <select name="priority" class="form-select">
                            @foreach($priorityOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('priority') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Frequency') }}</label>
                        <select name="frequency_type" class="form-select">
                            @foreach($frequencyOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('frequency_type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Frequency value') }}</label>
                        <input type="number" name="frequency_value" class="form-control" value="{{ old('frequency_value', 1) }}">
                        <small class="text-muted">{{ __('Number of units for the selected frequency') }}</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Start date') }}</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->toDateString()) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('End date') }}</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Estimated duration (minutes)') }}</label>
                        <input type="number" name="estimated_duration_minutes" class="form-control" value="{{ old('estimated_duration_minutes') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Estimated cost') }}</label>
                        <input type="number" step="0.01" name="estimated_cost" class="form-control" value="{{ old('estimated_cost') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Location') }}</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Assigned to') }}</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">{{ __('Unassigned') }}</option>
                            @foreach($assignableUsers as $id => $name)
                                <option value="{{ $id }}" {{ old('assigned_to') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('status', 'active') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ __('Save schedule') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
