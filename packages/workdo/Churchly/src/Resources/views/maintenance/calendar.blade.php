@extends('layouts.main')

@section('page-title', __('Maintenance calendar'))
@section('page-breadcrumb', 'Maintenance,Calendar')

@section('content')
    <div class="card mb-3">
        <div class="card-body d-flex flex-wrap gap-3">
            <div>
                <h5 class="mb-1">{{ __('Upcoming maintenance') }}</h5>
                <p class="text-muted">{{ __('Events plotted by due date and status') }}</p>
            </div>
            <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary ms-auto">{{ __('Back to list') }}</a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-3">
        @foreach($events as $event)
            <div class="col">
                <div class="card h-100 shadow-sm border-secondary">
                    <div class="card-body">
                        <h6 class="card-title">{{ $event['title'] }}</h6>
                        <p class="card-text">
                            <strong>{{ \Carbon\Carbon::parse($event['start'])->format('M d, Y') }}</strong><br>
                            <span class="text-muted">{{ ucfirst($event['status']) }}</span>
                        </p>
                        <a href="{{ $event['url'] }}" class="stretched-link">{{ __('View schedule') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($events->isEmpty())
        <div class="text-center text-muted mt-4">
            {{ __('No events scheduled yet. Begin by creating a maintenance plan.') }}
        </div>
    @endif
@endsection
