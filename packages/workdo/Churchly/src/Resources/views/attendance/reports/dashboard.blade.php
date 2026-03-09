@extends('layouts.main')

@section('page-title', __('Attendance Analytics Dashboard'))
@section('page-breadcrumb', __('Attendance,Reports'))

@section('page-action')
    <form method="GET" class="d-flex gap-2 align-items-center">
        <input type="month" name="month" value="{{ $summary['month_value'] }}" class="form-control">
        <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
    </form>
@endsection

@push('css')
    <style>
        .attendance-dashboard {
            padding-bottom: 2rem;
        }

        .attendance-hero {
            border: 0;
            overflow: hidden;
           
            color: #fff;
        }

        .attendance-hero .text-muted {
            color: rgba(0, 0, 0, 0.82) !important;
        }

        .attendance-kpi {
            min-height: 100%;
            border: 0;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        }

        .attendance-kpi .metric-value {
            font-size: 2rem;
            line-height: 1;
        }

        .attendance-panel {
            border: 0;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.08);
        }

        .attendance-table thead th {
            border-bottom: 0;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
            background: #f8fafc;
        }

        .attendance-table tbody td {
            padding-top: 1rem;
            padding-bottom: 1rem;
            vertical-align: middle;
        }

        .attendance-watchlist tbody tr:last-child td,
        .attendance-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .attendance-branch-item:last-child {
            margin-bottom: 0 !important;
        }

        .attendance-stat-grid .stat-box {
            min-height: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1rem;
            background: #fff;
        }

        .attendance-stat-grid .stat-value {
            font-size: 1.85rem;
            font-weight: 700;
            line-height: 1;
            margin-top: 0.5rem;
        }
    </style>
@endpush

@section('content')
    @php
        $monthLabel = $summary['month_label'];
        $totalMembers = $summary['total_members'];
    @endphp
    <div class="attendance-dashboard">
    <div class="card attendance-hero shadow-sm mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="badge rounded-pill text-bg-light text-dark mb-3">{{ __('Attendance Intelligence') }}</span>
                    <h2 class="mb-2">{{ __('Monthly Attendance Command Center') }}</h2>
                    <p class="mb-0 text-muted">
                        {{ __('Review participation trends, event health, and member follow-up signals for :month.', ['month' => $monthLabel]) }}
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="rounded-3 p-3" style="background: rgba(255,255,255,0.10);">
                                <div class="text-uppercase small text-white-50">{{ __('Members') }}</div>
                                <div class="fs-3 fw-semibold">{{ $totalMembers }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded-3 p-3" style="background: rgba(255,255,255,0.10);">
                                <div class="text-uppercase small text-white-50">{{ __('Events') }}</div>
                                <div class="fs-3 fw-semibold">{{ $summary['events_held'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card attendance-kpi h-100">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">{{ __('Reporting Month') }}</span>
                    <div class="metric-value mt-3 mb-2">{{ $monthLabel }}</div>
                    <p class="text-muted mb-0">{{ __('Monthly attendance performance across all tracked events.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card attendance-kpi h-100">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">{{ __('Attendance Rate') }}</span>
                    <div class="metric-value mt-3 mb-2">{{ $summary['attendance_rate'] }}%</div>
                    <p class="text-muted mb-0">{{ __('Based on present and late check-ins versus all recorded statuses.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card attendance-kpi h-100">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">{{ __('Events Covered') }}</span>
                    <div class="metric-value mt-3 mb-2">{{ $summary['events_held'] }}</div>
                    <p class="text-muted mb-0">{{ __('Attendance-enabled services and events held in the selected month.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card attendance-kpi h-100">
                <div class="card-body">
                    <span class="text-muted text-uppercase small">{{ __('Records Logged') }}</span>
                    <div class="metric-value mt-3 mb-2">{{ $summary['total_records'] }}</div>
                    <p class="text-muted mb-0">
                        {{ __('Total attendance records captured for :count members.', ['count' => $totalMembers]) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card attendance-panel h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-1">{{ __('Attendance Status Summary') }}</h5>
                    <p class="text-muted mb-0">
                        {{ __('Status breakdown for all event attendance in :month.', ['month' => $monthLabel]) }}
                    </p>
                </div>
                <div class="card-body">
                    <div class="row g-3 attendance-stat-grid">
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-box">
                                <div class="text-muted small">{{ __('Present') }}</div>
                                <div class="stat-value text-success">{{ $summary['present_count'] }}</div>
                                <div class="mt-2 small text-muted">{{ __('Members who checked in successfully on time.') }}</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-box">
                                <div class="text-muted small">{{ __('Late') }}</div>
                                <div class="stat-value text-warning">{{ $summary['late_count'] }}</div>
                                <div class="mt-2 small text-muted">{{ __('Late arrivals that still contributed to attendance.') }}</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-box">
                                <div class="text-muted small">{{ __('Absent') }}</div>
                                <div class="stat-value text-danger">{{ $summary['absent_count'] }}</div>
                                <div class="mt-2 small text-muted">{{ __('Absences that need follow-up or rescheduling.') }}</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-box">
                                <div class="text-muted small">{{ __('Excused') }}</div>
                                <div class="stat-value text-primary">{{ $summary['excused_count'] }}</div>
                                <div class="mt-2 small text-muted">{{ __('Approved exceptions recorded during the month.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-7">
            <div class="card attendance-panel h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-1">{{ __('Event Performance Summary') }}</h5>
                    <p class="text-muted mb-0">{{ __('Detailed monthly performance for every attendance-enabled event.') }}</p>
                </div>
                <div class="table-responsive">
                    <table class="table attendance-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Event') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Mode') }}</th>
                                <th class="text-center">{{ __('Present') }}</th>
                                <th class="text-center">{{ __('Late') }}</th>
                                <th class="text-center">{{ __('Absent') }}</th>
                                <th class="text-end">{{ __('Rate') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($eventPerformance as $event)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $event->title }}</div>
                                    </td>
                                    <td>{{ $event->date ?: __('N/A') }}</td>
                                    <td>{{ $event->mode }}</td>
                                    <td class="text-center">{{ $event->present }}</td>
                                    <td class="text-center">{{ $event->late }}</td>
                                    <td class="text-center text-danger">{{ $event->absent }}</td>
                                    <td class="text-end">
                                        <span class="badge bg-{{ $event->attendance_rate >= 75 ? 'success' : ($event->attendance_rate >= 50 ? 'warning' : 'danger') }}">
                                            {{ $event->attendance_rate }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">{{ __('No attendance-enabled events found for this month.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card attendance-panel h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="mb-1">{{ __('Branch Participation') }}</h5>
                    <p class="text-muted mb-0">{{ __('Compare branch-level engagement and attention points.') }}</p>
                </div>
                <div class="card-body">
                    @forelse($branchBreakdown as $branch)
                        <div class="attendance-branch-item mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <div>
                                    <div class="fw-semibold">{{ $branch->branch }}</div>
                                    <div class="text-muted small">{{ $branch->engaged }} {{ __('engaged') }} / {{ $branch->total }} {{ __('records') }}</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-semibold">{{ $branch->attendance_rate }}%</div>
                                    <div class="text-danger small">{{ $branch->absent }} {{ __('absent') }}</div>
                                </div>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $branch->attendance_rate }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">{{ __('No branch participation records were found for this month.') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card attendance-panel attendance-watchlist">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <h5 class="mb-1">{{ __('Engagement Follow-up Watchlist') }}</h5>
            <p class="text-muted mb-0">{{ __('Members with repeated absences this month who may need pastoral or follow-up attention.') }}</p>
        </div>
        <div class="table-responsive">
            <table class="table attendance-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Member') }}</th>
                        <th>{{ __('Branch') }}</th>
                        <th class="text-center">{{ __('Present / Late') }}</th>
                        <th class="text-center">{{ __('Absences') }}</th>
                        <th class="text-end">{{ __('Risk Level') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($engagementRisks as $member)
                        @php
                            $riskLevel = $member->monthly_absences >= 4 ? __('High') : ($member->monthly_absences >= 2 ? __('Medium') : __('Low'));
                            $riskClass = $member->monthly_absences >= 4 ? 'danger' : ($member->monthly_absences >= 2 ? 'warning' : 'success');
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $member->name }}</td>
                            <td>{{ optional($member->branch)->name ?? __('Unassigned') }}</td>
                            <td class="text-center">{{ $member->monthly_present }}</td>
                            <td class="text-center text-danger">{{ $member->monthly_absences }}</td>
                            <td class="text-end">
                                <span class="badge bg-{{ $riskClass }}">{{ $riskLevel }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">{{ __('No follow-up risks identified for this month.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
