@extends('layouts.main')

@section('page-title', __('Member Attendance Report'))
@section('page-breadcrumb', __('ChurchMeet,Attendance Reports,Member Report'))

@section('page-action')
    <a href="{{ route('churchmeet.attendance.reports.dashboard') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-chart-donut-3 me-1"></i>{{ __('Reports Dashboard') }}
    </a>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
@endpush

@section('content')
@php
    $records = $member->attendanceRecords;
    $totalRecords = $records->count();
    $presentRate = round(($records->where('status', 'present')->count() / max(1, $totalRecords)) * 100, 1);
    $longestStreak = $records->max('streak_count') ?? 0;
@endphp

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-user-heart"></i>{{ __('Member Report') }}</span>
            <h2 class="churchmeet-title">{{ $member->name }}</h2>
            <p class="churchmeet-copy mb-0">{{ __('A unified ChurchMeet view of member attendance history, consistency, and recent participation records.') }}</p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Events Attended') }}</span>
                    <strong class="churchmeet-stat-value">{{ $totalRecords }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Attendance records currently attached to this member.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Attendance Rate') }}</span>
                    <strong class="churchmeet-stat-value">{{ $presentRate }}%</strong>
                    <span class="churchmeet-stat-note">{{ __('Present records as a share of all tracked entries.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Longest Streak') }}</span>
                    <strong class="churchmeet-stat-value">{{ $longestStreak }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Best consistency streak recorded for this member.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Member ID') }}</span>
                    <strong class="churchmeet-stat-value">{{ \Illuminate\Support\Str::limit((string) ($member->member_id ?? __('N/A')), 14) }}</strong>
                    <span class="churchmeet-stat-note">{{ __('ChurchMeet identity reference for reporting and follow-up.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5>{{ __('Member Snapshot') }}</h5>
                    <p>{{ __('Branded summary cards keep the reporting pages visually aligned.') }}</p>
                </div>
                <div class="churchmeet-section-body">
                    <div class="churchmeet-stack">
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Email') }}</span>
                            <span class="value">{{ $member->email ?: __('Not provided') }}</span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Phone') }}</span>
                            <span class="value">{{ $member->phone ?: __('Not provided') }}</span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Branch') }}</span>
                            <span class="value">{{ optional($member->branch)->name ?? __('Unassigned') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5>{{ __('Attendance Timeline') }}</h5>
                    <p>{{ __('Detailed event-by-event participation in the same ChurchMeet reporting style.') }}</p>
                </div>
                <div class="table-responsive">
                    <table class="table churchmeet-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Event') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Device') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                @php
                                    $statusClass = $record->status === 'present' ? 'success' : ($record->status === 'late' ? 'warning' : 'danger');
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ optional(optional($record->attendanceEvent)->event)->title ?? __('Untitled event') }}</td>
                                    <td>{{ optional(optional($record->attendanceEvent)->event)->date ?? __('N/A') }}</td>
                                    <td><span class="churchmeet-badge {{ $statusClass }}">{{ ucfirst($record->status) }}</span></td>
                                    <td>{{ strtoupper((string) $record->device_used) ?: __('N/A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">{{ __('No attendance records found for this member.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
