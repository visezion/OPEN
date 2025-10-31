@extends('layouts.main')

@section('page-title', __('Add Designation'))

@section('content')
<div class="card">
    <div class="card-header">{{ __('Add Designation') }}</div>
    <div class="card-body">
        <form action="{{ route('churchdesignation.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Branch') }}</label>
                <select name="branch_id" class="form-control" required>
                    @foreach($branches as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
@endsection
