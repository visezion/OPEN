@extends('layouts.main')

@section('page-title', __('Maintenance'))
@section('page-breadcrumb', 'Maintenance')
@section('page-action')
    <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
        {{ __('New Schedule') }}
    </a>
@endsection

@section('content')
    @php
        $filters = $filters ?? [];
        $query = request()->query() ?: [];
        $excelQuery = array_merge($query, ['format' => 'excel']);
        $pdfQuery = array_merge($query, ['format' => 'pdf']);
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Active schedules') }}</h6>
                <div class="d-flex align-items-center justify-content-between">
                    <strong class="fs-4">{{ $stats['total_active'] }}</strong>
                    <span class="badge bg-soft-success">{{ __('Live') }}</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Overdue tasks') }}</h6>
                <strong class="fs-4 text-danger">{{ $stats['overdue'] }}</strong>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Due this week') }}</h6>
                <strong class="fs-4">{{ $stats['due_this_week'] }}</strong>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1">{{ __('Completed this month') }}</h6>
                <strong class="fs-4">{{ $stats['completed_this_month'] }}</strong>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{ __('Filters') }}</h5>
                <div class="btn-group" role="group">
                    <a href="{{ route('maintenance.export', $excelQuery) }}" target="_blank" class="btn btn-outline-success btn-sm">
                        {{ __('Download Excel') }}
                    </a>
                    <a href="{{ route('maintenance.export', $pdfQuery) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                        {{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('maintenance.print', $query) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        {{ __('Printable view') }}
                    </a>
                </div>
            </div>
            <form method="get" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">{{ __('Status') }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ __('Any status') }}</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ data_get($filters, 'status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Priority') }}</label>
                    <select name="priority" class="form-select">
                        <option value="">{{ __('All') }}</option>
                        @foreach($priorityOptions as $value => $label)
                            <option value="{{ $value }}" {{ data_get($filters, 'priority') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Category') }}</label>
                    <select name="category" class="form-select">
                        <option value="">{{ __('Any') }}</option>
                        @foreach($categoryOptions as $category)
                            <option value="{{ $category }}" {{ data_get($filters, 'category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Branch') }}</label>
                    <select name="branch_id" class="form-select">
                        <option value="">{{ __('Any branch') }}</option>
                        @foreach($branches as $id => $name)
                            <option value="{{ $id }}" {{ data_get($filters, 'branch_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Department') }}</label>
                    <select name="department_id" class="form-select">
                        <option value="">{{ __('Any department') }}</option>
                        @foreach($departments as $id => $name)
                            <option value="{{ $id }}" {{ data_get($filters, 'department_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">{{ __('From') }}</label>
                    <input type="date" name="from" class="form-control" value="{{ data_get($filters, 'from') ?? '' }}">
                </div>
                <div class="col-md-1">
                    <label class="form-label">{{ __('To') }}</label>
                    <input type="date" name="to" class="form-control" value="{{ data_get($filters, 'to') ?? '' }}">
                </div>
                <div class="col-md-12 text-end">
                    <button class="btn btn-secondary">{{ __('Apply filters') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Asset') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Branch / Department') }}</th>
                        <th>{{ __('Priority') }}</th>
                        <th>{{ __('Next due') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Assigned to') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr>
                            <td>
                                <strong>{{ $schedule->asset_name }}</strong><br>
                                <small class="text-muted">{{ $schedule->asset_code }}</small>
                            </td>
                            <td>{{ $schedule->category }}</td>
                            <td>
                                {{ $schedule->branch->name ?? __('Headquarters') }} /
                                {{ $schedule->department->name ?? __('General') }}
                            </td>
                            <td>
                                <span class="badge bg-soft-{{ match ($schedule->priority) {
                                    'critical' => 'danger',
                                    'high' => 'warning',
                                    'low' => 'secondary',
                                    default => 'primary',
                                } }}">
                                    {{ ucfirst($schedule->priority) }}
                                </span>
                            </td>
                            <td>
                                {{ optional($schedule->next_due_date)->format('Y-m-d') }}
                                @if($schedule->next_due_date && $schedule->next_due_date->isBefore(today()))
                                    <span class="badge bg-danger">{{ __('Overdue') }}</span>
                                @elseif($schedule->next_due_date && $schedule->next_due_date->isBetween(today(), today()->addDays(3)))
                                    <span class="badge bg-warning">{{ __('Due soon') }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $schedule->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $statusOptions[$schedule->status] ?? ucfirst($schedule->status) }}
                                </span>
                            </td>
                            <td>{{ $schedule->assignedTo->name ?? __('Unassigned') }}</td>
                            <td class="text-end">
                                <a href="{{ route('maintenance.show', $schedule) }}" class="btn btn-sm btn-outline-primary">{{ __('View') }}</a>
                                @can('maintenance schedule edit')
                                    <a href="{{ route('maintenance.edit', $schedule) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                @endcan
                                @can('maintenance schedule delete')
                                    <form action="{{ route('maintenance.destroy', $schedule) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure?') }}');">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">{{ __('No maintenance schedules matched the current filters.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $schedules->links() }}
        </div>
    </div>
@endsection
