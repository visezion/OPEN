@extends('layouts.main')

@section('page-title', __('Maintenance log'))
@section('page-breadcrumb', 'Maintenance,LogDetail')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0">{{ __('Log for :asset', ['asset' => $log->schedule->asset_name]) }}</h5>
                <a href="{{ route('maintenance.show', $log->schedule) }}" class="btn btn-outline-secondary btn-sm">
                    {{ __('Back to schedule') }}
                </a>
            </div>
            <div class="row mt-4 g-3">
                <div class="col-md-4">
                    <p class="text-muted mb-1">{{ __('Due date') }}</p>
                    <strong>{{ optional($log->due_date)->format('Y-m-d') }}</strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">{{ __('Status') }}</p>
                    <span class="badge bg-primary">{{ ucfirst($log->status) }}</span>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">{{ __('Performed by') }}</p>
                    <strong>{{ $log->performedBy->name ?? __('Pending') }}</strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">{{ __('Reported by') }}</p>
                    <strong>{{ $log->reportedBy->name ?? __('System') }}</strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">{{ __('Started at') }}</p>
                    <strong>{{ optional($log->started_at)->format('Y-m-d H:i') ?? __('Not started') }}</strong>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-1">{{ __('Completed at') }}</p>
                    <strong>{{ optional($log->completed_at)->format('Y-m-d H:i') ?? __('Pending') }}</strong>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1">{{ __('Notes') }}</p>
                    <div class="border rounded-2 p-3 bg-light">
                        {{ $log->notes ?? __('No notes recorded') }}
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1">{{ __('Cost incurred') }}</p>
                    <strong>{{ $log->cost_incurred ?? __('N/A') }}</strong>
                </div>
                <div class="col-12">
                    <p class="text-muted mb-1">{{ __('Attachments') }}</p>
                    <strong>{{ $log->attachments ?? __('None') }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
