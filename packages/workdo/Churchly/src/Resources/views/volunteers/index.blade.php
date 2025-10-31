@extends('layouts.main')

@section('page-title')
    {{ __('Volunteers') }}
@endsection

@section('page-breadcrumb')
    {{ __('Volunteer Management') }}
@endsection

@section('page-action')
    @permission('church_volunteer create')
        <a href="{{ route('churchly.volunteers.create') }}"
           class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Volunteer') }}
        </a>
    @endpermission
@endsection

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small">{{ __('Active Volunteers') }}</div>
                    <div class="display-6 fw-bold">{{ $summary['active'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small">{{ __('Inactive') }}</div>
                    <div class="display-6 fw-bold">{{ $summary['inactive'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small">{{ __('Paused / On Hold') }}</div>
                    <div class="display-6 fw-bold">{{ $summary['paused'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Volunteer Directory') }}</h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Departments') }}</th>
                            <th>{{ __('Skills') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Joined') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($volunteers as $volunteer)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $volunteer->display_name }}</div>
                                    @if($volunteer->member)
                                        <div class="small text-muted">{{ __('Member ID:') }} {{ $volunteer->member->formatted_member_id ?? $volunteer->member->member_id }}</div>
                                    @endif
                                </td>
                                <td class="small">
                                    @forelse($volunteer->departments as $department)
                                        <span class="badge bg-light text-dark mb-1">
                                            {{ $department->name }}
                                            @if(data_get($department, 'pivot.is_primary'))
                                                <span class="text-success ms-1">{{ __('(Primary)') }}</span>
                                            @endif
                                        </span>
                                    @empty
                                        <span class="text-muted">{{ __('Unassigned') }}</span>
                                    @endforelse
                                </td>
                                <td class="small">
                                    @forelse($volunteer->skills->take(4) as $skill)
                                        <span class="badge bg-secondary mb-1">
                                            {{ $skill->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">{{ __('No skills tagged') }}</span>
                                    @endforelse
                                    @if($volunteer->skills->count() > 4)
                                        <span class="badge bg-light text-dark mb-1">+{{ $volunteer->skills->count() - 4 }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusColor = [
                                            'active' => 'success',
                                            'inactive' => 'secondary',
                                            'paused' => 'warning',
                                        ][$volunteer->status] ?? 'light text-dark';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">{{ ucfirst($volunteer->status) }}</span>
                                </td>
                                <td class="small text-muted">
                                    {{ optional($volunteer->joined_at)->format('d M Y') ?? '—' }}
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('churchly.volunteers.show', $volunteer) }}"
                                           class="btn btn-sm btn-light">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @permission('church_volunteer manage')
                                            <a href="{{ route('churchly.volunteers.edit', $volunteer) }}"
                                               class="btn btn-sm btn-info text-white">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    @include('layouts.nodatafound')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $volunteers->links() }}
        </div>
    </div>
@endsection
