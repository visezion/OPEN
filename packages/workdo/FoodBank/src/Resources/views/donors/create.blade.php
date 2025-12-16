@extends('layouts.main')

@section('page-title', __('New donor'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('foodbank.donors.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $defaults['name']) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $defaults['phone']) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $defaults['email']) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Address') }}</label>
                    <textarea name="address" class="form-control">{{ old('address', $defaults['address']) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('Notes') }}</label>
                    <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Preferred pickup') }}</label>
                        <input type="text" name="preferred_pickup" class="form-control" value="{{ old('preferred_pickup') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Preferred delivery') }}</label>
                        <input type="text" name="preferred_delivery" class="form-control" value="{{ old('preferred_delivery') }}">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ __('Save donor') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
