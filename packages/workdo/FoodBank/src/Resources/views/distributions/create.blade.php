@extends('layouts.main')

@section('page-title', __('New distribution'))
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('foodbank.distributions.store') }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Request') }}</label>
                        <select name="request_id" class="form-select" required>
                            <option value="">{{ __('Select a request') }}</option>
                            @foreach($requests as $req)
                                <option value="{{ $req->id }}">{{ $req->requester_name }} ({{ $req->quantity_needed }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Inventory item') }}</label>
                        <select name="inventory_id" class="form-select">
                            <option value="">{{ __('None') }}</option>
                            @foreach($inventory as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity_distributed" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Method') }}</label>
                        <select name="method" class="form-select" required>
                            <option value="pickup">{{ __('Pickup') }}</option>
                            <option value="delivery">{{ __('Delivery') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Scheduled at') }}</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('Delivery address') }}</label>
                        <input type="text" name="delivery_address" class="form-control">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ __('Record distribution') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
