@extends('layouts.main')

@section('page-title', __('Food Bank Reports'))
@section('content')
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3">
                <p class="text-muted mb-1">{{ __('Inventory on hand') }}</p>
                <h3>{{ $summary['total_inventory'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <p class="text-muted mb-1">{{ __('Donors registered') }}</p>
                <h3>{{ $summary['donors'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <p class="text-muted mb-1">{{ __('Distributions') }}</p>
                <h3>{{ $summary['distributions'] }}</h3>
            </div>
        </div>
    </div>
@endsection
