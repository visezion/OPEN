@extends('layouts.main')

@section('page-title', __('Food Bank Dashboard'))
@section('page-breadcrumb', __('Food Bank'))
@section('page-action')
    <a href="{{ route('foodbank.donors.index') }}" class="btn btn-primary">{{ __('Manage Donors') }}</a>
@endsection

@section('content')
    <div class="row g-3">
        <div class="col-xxl-4 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1">{{ __('Donors registered') }}</p>
                    <h3 class="mb-0">{{ $totals['donors'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1">{{ __('Inventory items available') }}</p>
                    <h3 class="mb-0">{{ $totals['inventory_items'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1">{{ __('Distributions completed') }}</p>
                    <h3 class="mb-0">{{ $totals['distributed'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-xxl-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Recent donors') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($recentDonors as $donor)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $donor->name }}</strong><br>
                                        <small class="text-muted">{{ $donor->phone ?? $donor->email ?? __('Contact not available') }}</small>
                                    </div>
                                    <span class="badge rounded-pill bg-soft-info text-info">{{ $donor->preferred_pickup ?? __('Pickup') }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">{{ __('No donors yet') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Tips for helpers') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled lh-lg">
                        <li>{{ __('Log donations immediately so allocation is accurate.') }}</li>
                        <li>{{ __('Keep pickup and delivery details handy so donors know where to drop off.') }}</li>
                        <li>{{ __('Ask about dietary restrictions and number of children before packing the box.') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
