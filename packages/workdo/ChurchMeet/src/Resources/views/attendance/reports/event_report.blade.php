@extends('layouts.main')

@section('page-title', __('Events Attendance Report'))
@section('page-breadcrumb', __('ChurchMeet,Attendance Reports,Events Report'))

@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('churchmeet.attendance.reports.dashboard') }}" class="btn btn-sm btn-outline-primary">
            <i class="ti ti-chart-donut-3 me-1"></i>{{ __('Reports Dashboard') }}
        </a>
        <a href="{{ route('churchmeet.events.show', optional($attendanceEvent->event)->public_view_key ?? $attendanceEvent->event_id) }}" class="btn btn-sm btn-primary">
            <i class="ti ti-calendar-event me-1"></i>{{ __('Open Event') }}
        </a>
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
@endpush

@section('content')
@php
    $event = $attendanceEvent->event;
    $records = $attendanceEvent->records;
    $totalAttendance = $records->count();
    $onsiteAttendance = $records->whereIn('device_used', ['manual', 'qr', 'kiosk', 'face_ai'])->count();
    $onlineAttendance = $records->whereIn('device_used', ['online', 'zoom', 'youtube'])->count();
    $presentAttendance = $records->where('status', 'present')->count();
@endphp

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-report-analytics"></i>{{ __('Events Report') }}</span>
            <h2 class="churchmeet-title">{{ $event->title ?? __('Untitled event') }}</h2>
            <p class="churchmeet-copy mb-0">{{ __('A branded ChurchMeet report of event turnout, channel split, and individual attendance records.') }}</p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Total Attendance') }}</span>
                    <strong class="churchmeet-stat-value">{{ $totalAttendance }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Total records captured for this attendance event.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Onsite') }}</span>
                    <strong class="churchmeet-stat-value">{{ $onsiteAttendance }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Manual, QR, kiosk, and face-AI check-ins.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Online') }}</span>
                    <strong class="churchmeet-stat-value">{{ $onlineAttendance }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Digital attendance captured from online channels.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Present Status') }}</span>
                    <strong class="churchmeet-stat-value">{{ $presentAttendance }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Confirmed present records for this event.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5>{{ __('Events Snapshot') }}</h5>
                    <p>{{ __('The same branded summary structure used across ChurchMeet reporting pages.') }}</p>
                </div>
                <div class="churchmeet-section-body">
                    <div class="churchmeet-stack">
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Events Date') }}</span>
                            <span class="value">{{ $event->date ?? __('N/A') }}</span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Mode') }}</span>
                            <span class="value">{{ ucfirst($attendanceEvent->mode ?? 'in-person') }}</span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Platform') }}</span>
                            <span class="value">{{ ucfirst($attendanceEvent->online_platform ?: ($attendanceEvent->mode ?? 'in-person')) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5>{{ __('Attendance Register') }}</h5>
                    <p>{{ __('Member-by-member attendance detail with consistent table styling and status badges.') }}</p>
                </div>
                <div class="table-responsive">
                    <table class="table churchmeet-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Member') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Check-In') }}</th>
                                <th>{{ __('Device') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                @php
                                    $statusClass = $record->status === 'present' ? 'success' : ($record->status === 'late' ? 'warning' : 'danger');
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $record->member->name ?? __('Visitor') }}</td>
                                    <td><span class="churchmeet-badge {{ $statusClass }}">{{ ucfirst($record->status) }}</span></td>
                                    <td>{{ $record->check_in_time }}</td>
                                    <td>{{ strtoupper((string) $record->device_used) ?: __('N/A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">{{ __('No attendance records have been captured for this event yet.') }}</td>
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
