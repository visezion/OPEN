@extends('layouts.main')

@section('page-title', __('Asset reports'))
@section('page-breadcrumb', __('Assets'))
@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('assets.dashboard') }}" class="btn btn-outline-secondary">{{ __('Dashboard') }}</a>
        <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">{{ __('Inventory') }}</a>
        <a href="{{ route('assets.settings.index') }}" class="btn btn-outline-secondary">{{ __('Settings') }}</a>
    </div>
@endsection

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Category breakdown') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Available') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoryBreakdown as $row)
                                <tr>
                                    <td>{{ $row->category ?? __('Uncategorized') }}</td>
                                    <td>{{ $row->total_quantity }}</td>
                                    <td>{{ $row->available_quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        {{ __('No data yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Branch distribution') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Quantity') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branchBreakdown as $row)
                                <tr>
                                    <td>{{ optional($row->branch)->name ?? __('Headquarter') }}</td>
                                    <td>{{ $row->total_quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        {{ __('No data yet.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Inspection status') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($inspectionStatus as $row)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ ucfirst($row->status) }}</span>
                                <span>{{ $row->total }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">
                                {{ __('No inspections logged yet.') }}
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Active movements') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($movementSummary as $summary)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>{{ optional($summary->asset)->asset_name ?? __('Unknown') }}</span>
                                    <strong>{{ $summary->total }}</strong>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">
                                {{ __('No movements recorded yet.') }}
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
