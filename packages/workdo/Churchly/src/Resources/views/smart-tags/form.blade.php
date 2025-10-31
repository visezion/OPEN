@extends('layouts.main')

@php
    $isEdit = $smartTag->exists;
    $action = $isEdit
        ? route('churchly.smart-tags.update', $smartTag->id)
        : route('churchly.smart-tags.store');
    $definition = old(
        'definition_json',
        $smartTag->definition ? json_encode($smartTag->definition, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : "[\n    {\n        \"type\": \"attendance_count\",\n        \"operator\": \">=\",\n        \"value\": 3,\n        \"days\": 30\n    }\n]"
    );
@endphp

@section('page-title', $isEdit ? __('Edit Smart Tag') : __('Create Smart Tag'))
@section('page-breadcrumb', __('Smart Tags'))

@section('page-action')
    <a href="{{ route('churchly.smart-tags.index') }}" class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> {{ __('Back to list') }}
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $smartTag->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $smartTag->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Definition (JSON)') }}</label>
                        <textarea name="definition_json" class="form-control" rows="12" required>{{ $definition }}</textarea>
                        <small class="text-muted d-block mt-2">
                            {{ __('Each rule is an object within the JSON array. Supported types:') }}
                            <ul class="small mb-0">
                                <li><code>attendance_count</code> – {{ __('Fields: operator, value, days, status') }}</li>
                                <li><code>giving_gap_days</code> – {{ __('Fields: operator, value') }}</li>
                                <li><code>in_department</code> – {{ __('Fields: department_ids[]') }}</li>
                                <li><code>in_branch</code> – {{ __('Fields: branch_ids[]') }}</li>
                                <li><code>membership_status</code> – {{ __('Fields: statuses[]') }}</li>
                            </ul>
                        </small>
                        @error('definition_json')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $smartTag->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Tag is active') }}</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary">{{ $isEdit ? __('Save changes') : __('Create tag') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
