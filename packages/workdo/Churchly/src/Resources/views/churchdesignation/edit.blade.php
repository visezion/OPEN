@extends('layouts.main')

@section('page-title', __('Edit Designation'))

@section('content')
<div class="card">
    <div class="card-header">{{ __('Edit Designation') }}</div>
    <div class="card-body">
        <form action="{{ route('churchdesignation.update', $churchdesignation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ $churchdesignation->name }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Branch') }}</label>
                <select name="branch_id" class="form-control" required>
                    @foreach($branches as $id => $name)
                        <option value="{{ $id }}" {{ $churchdesignation->branch_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        </form>
    </div>
</div>
@endsection
