@extends('layouts.main')

@section('page-title')
    {{ __('System Analytics') }}
@endsection

@section('page-breadcrumb')
    {{ __('System Analytics') }}
@endsection

@section('content')
    <div class="row gy-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small">{{ __('Requests Today') }}</h6>
                    <div class="fs-3 fw-bold">{{ number_format($todayRequests ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small">{{ __('Requests This Week') }}</h6>
                    <div class="fs-3 fw-bold">{{ number_format($weekRequests ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small">{{ __('Requests This Month') }}</h6>
                    <div class="fs-3 fw-bold">{{ number_format($monthRequests ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small">{{ __('Active Users This Month') }}</h6>
                    <div class="fs-3 fw-bold">{{ number_format($uniqueUsersThisMonth ?? 0) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">{{ __('Requests Per Day (Last 30 days)') }}</h5>
            <div class="d-flex align-items-end gap-2" style="height: 130px;">
                @foreach($dailyUsage as $day => $count)
                    <div class="flex-fill text-center">
                        <div class="bg-primary rounded" style="height: {{ $dailyUsage ? ($count / max(1, max($dailyUsage))) * 100 : 2 }}%; min-height: 10px;"></div>
                        <small class="text-muted d-block mt-2" style="font-size:.65rem;">{{ \Illuminate\Support\Str::substr($day, 5) }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Top Routes') }}</h5>
                    <div class="list-group list-group-flush">
                        @foreach($topRoutes as $route)
                            <div class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $route->route ?? __('(unnamed)') }}</strong>
                                    <div class="small text-muted">{{ __('Hits: :count', ['count' => $route->hits]) }}</div>
                                </div>
                                <span class="badge bg-soft-primary text-primary">{{ number_format($route->hits) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ __('Slowest Routes') }}</h5>
                    <div class="list-group list-group-flush">
                        @foreach($slowRoutes as $route)
                            <div class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $route->route ?? __('(unnamed)') }}</strong>
                                </div>
                                <span class="badge bg-soft-danger text-danger">{{ number_format($route->avg_time ?? 0, 2) }}s</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-0">{{ __('Top Browsers') }}</h5>
                    <small class="text-muted">{{ __('From recent requests') }}</small>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th>{{ __('Browser') }}</th>
                                    <th>{{ __('Usage') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($browserStats as $label => $count)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>{{ $count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">{{ __('No browser data yet.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-0">{{ __('Device Usage') }}</h5>
                    <small class="text-muted">{{ __('Device breakdown from agent strings') }}</small>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th>{{ __('Device') }}</th>
                                    <th>{{ __('Usage') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deviceStats as $label => $count)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td>{{ $count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">{{ __('No device data yet.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Function Tracking') }}</h5>
                    <div class="table-responsive mt-2">
                        <table class="table table-sm mb-0">
                            <thead class="text-muted small">
                                <tr>
                                    <th>{{ __('Function') }}</th>
                                    <th>{{ __('Calls') }}</th>
                                    <th>{{ __('Avg Time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($functionStats as $func)
                                    <tr>
                                        <td>{{ $func->name }}</td>
                                        <td>{{ $func->calls }}</td>
                                        <td>{{ number_format($func->avg_time ?? 0, 3) }}s</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Latest Errors') }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($latestErrors as $error)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>{{ $error->route ?? __('Unknown route') }}</strong>
                                        <div class="small text-muted">{{ $error->message }}</div>
                                    </div>
                                    <span class="small text-muted">{{ $error->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Workspace Activity') }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($workspaceStats as $workspace)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $workspaceNames[$workspace->workspace_id] ?? __('Workspace :id', ['id' => $workspace->workspace_id]) }}</span>
                                <strong>{{ number_format($workspace->total_requests) }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Active Users') }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($activeUsers as $user)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $userNames[$user->user_id] ?? __('User :id', ['id' => $user->user_id]) }}</span>
                                <strong>{{ number_format($user->requests) }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('superadmin.system.analytics.map') }}" class="btn btn-outline-primary">
                {{ __('View User Location Map') }}
            </a>
        </div>
    </div>
@endsection
