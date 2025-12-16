@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.main')

@section('page-title', $schedule->asset_name)
@section('page-breadcrumb', 'Maintenance,Detail')
@section('page-action')
    <a href="{{ route('maintenance.calendar') }}" class="btn btn-outline-primary">{{ __('View calendar') }}</a>
@endsection

@section('content')
    <div class="row gy-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Schedule overview') }}</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1">{{ __('Asset code') }}</p>
                            <strong>{{ $schedule->asset_code }}</strong>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1">{{ __('Next due') }}</p>
                            <strong>{{ optional($schedule->next_due_date)->toDateString() }}</strong>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1">{{ __('Status') }}</p>
                            <span class="badge bg-{{ $schedule->status === 'active' ? 'success' : 'secondary' }}">
                                {{ $statusOptions[$schedule->status] ?? ucfirst($schedule->status) }}
                            </span>
                        </div>
                        <div class="col-md-4 mt-3">
                            <p class="mb-1">{{ __('Assigned to') }}</p>
                            <strong>{{ $schedule->assignedTo->name ?? __('Unassigned') }}</strong>
                        </div>
                        <div class="col-md-4 mt-3">
                            <p class="mb-1">{{ __('Frequency') }}</p>
                            <strong>{{ $frequencyOptions[$schedule->frequency_type] ?? ucfirst($schedule->frequency_type) }}</strong>
                        </div>
                        <div class="col-md-4 mt-3">
                            <p class="mb-1">{{ __('Priority') }}</p>
                            <strong>{{ ucfirst($schedule->priority) }}</strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <p class="mb-1">{{ __('Location') }}</p>
                            <strong>{{ $schedule->location ?? __('Not set') }}</strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <p class="mb-1">{{ __('Branch / department') }}</p>
                            <strong>
                                {{ $schedule->branch->name ?? __('Headquarters') }}
                                /
                                {{ $schedule->department->name ?? __('General') }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Maintenance log history') }}</h5>
                    <div class="list-group">
                        @forelse($logs as $log)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ optional($log->due_date)->toDateString() }}</strong>
                                        <span class="text-muted">({{ ucfirst($log->status) }})</span>
                                        <div class="small text-muted">
                                            {{ $log->notes ? Str::limit($log->notes, 80) : __('No notes provided') }}
                                        </div>
                                    </div>
                                    <a href="{{ route('maintenance.logs.show', $log) }}" class="btn btn-sm btn-outline-secondary">
                                        {{ __('View log') }}
                                    </a>
                                </div>
                                <div class="mt-2 text-muted">
                                    {{ __('Performed by') }}: {{ $log->performedBy->name ?? __('Pending') }}
                                    | {{ __('Cost') }}: {{ $log->cost_incurred ?? '—' }}
                                </div>
                            </div>
                        @empty
                            <div class="list-group-item text-center text-muted">
                                {{ __('No logs recorded yet.') }}
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Add maintenance log') }}</h5>
                    <form action="{{ route('maintenance.logs.store', $schedule) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Due date') }}</label>
                            <input type="date" name="due_date" class="form-control" value="{{ now()->toDateString() }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="status" class="form-select">
                                @foreach(['pending','in_progress','completed','overdue','cancelled'] as $status)
                                    <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Performed by') }}</label>
                            <select name="performed_by" class="form-select">
                                <option value="">{{ __('Select') }}</option>
                                @foreach($assignableUsers as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Cost incurred') }}</label>
                            <input type="number" step="0.01" name="cost_incurred" class="form-control">
                        </div>
                        <button class="btn btn-primary w-100">{{ __('Save log') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
