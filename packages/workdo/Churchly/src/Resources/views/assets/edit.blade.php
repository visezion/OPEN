@extends('layouts.main')

@section('page-title', __('Edit asset'))
@section('page-breadcrumb', 'Assets,Edit')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('assets.update', $asset) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Asset name') }}</label>
                        <input type="text" name="asset_name" value="{{ old('asset_name', $asset->asset_name) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Asset code') }}</label>
                        <input type="text" name="asset_code" value="{{ old('asset_code', $asset->asset_code) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Asset tag') }}</label>
                        <input type="text" name="asset_tag" value="{{ old('asset_tag', $asset->asset_tag) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Category') }}</label>
                        <select name="category" class="form-select">
                            <option value="">{{ __('Select') }}</option>
                            @foreach($categoryOptions as $category)
                                <option value="{{ $category }}" {{ old('category', $asset->category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Asset type') }}</label>
                        <input type="text" name="asset_type" value="{{ old('asset_type', $asset->asset_type) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Serial number') }}</label>
                        <input type="text" name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Location') }}</label>
                        <input type="text" name="location" value="{{ old('location', $asset->location) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Condition') }}</label>
                        <input type="text" name="condition" value="{{ old('condition', $asset->condition) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Acquired at') }}</label>
                        <input type="date" name="acquired_at" value="{{ old('acquired_at', optional($asset->acquired_at)->toDateString()) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Warranty expires') }}</label>
                        <input type="date" name="warranty_expires_at" value="{{ old('warranty_expires_at', optional($asset->warranty_expires_at)->toDateString()) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $asset->quantity) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Available quantity') }}</label>
                        <input type="number" name="available_quantity" value="{{ old('available_quantity', $asset->available_quantity) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Branch') }}</label>
                        <select name="branch_id" class="form-select">
                            <option value="">{{ __('Any') }}</option>
                            @foreach($branches as $id => $name)
                                <option value="{{ $id }}" {{ old('branch_id', $asset->branch_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Department') }}</label>
                        <select name="department_id" class="form-select">
                            <option value="">{{ __('Any') }}</option>
                            @foreach($departments as $id => $name)
                                <option value="{{ $id }}" {{ old('department_id', $asset->department_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $asset->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Assigned to') }}</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">{{ __('None') }}</option>
                            @foreach($assignableUsers as $id => $name)
                                <option value="{{ $id }}" {{ old('assigned_to', $asset->assigned_to) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('Notes') }}</label>
                        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $asset->notes) }}</textarea>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ __('Update asset') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
