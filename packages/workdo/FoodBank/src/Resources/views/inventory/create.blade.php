@extends('layouts.main')

@section('page-title', __('Add inventory'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('foodbank.inventory.store') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Item name') }}</label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Category') }}</label>
                        <input type="text" name="category" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Unit') }}</label>
                        <input type="text" name="unit" class="form-control" value="pcs">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Received at') }}</label>
                        <input type="date" name="received_at" class="form-control" value="{{ now()->toDateString() }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Pickup location') }}</label>
                        <input type="text" name="pickup_location" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Delivery details') }}</label>
                        <input type="text" name="delivery_details" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ __('Log inventory') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
