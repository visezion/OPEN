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
    .attendance-analytics-page {
        padding-bottom: 2rem;
    }

    .attendance-analytics-page .card {
        border: 1px solid var(--bs-border-color, #dee2e6) !important;
        border-radius: 12px;
        box-shadow: none !important;
        background: #fff;
    }

    .attendance-analytics-page .card-header {
        border-bottom: 1px solid var(--bs-border-color, #dee2e6) !important;
        background: #fff;
        padding: 1rem 1.25rem;
    }

    .attendance-analytics-page .metric-label {
        font-size: 0.74rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--bs-secondary-color);
    }

    .attendance-analytics-page .metric-value {
        font-size: 1.9rem;
        font-weight: 700;
        line-height: 1.05;
        margin-top: 0.45rem;
        color: var(--bs-heading-color, #1f2937);
    }

    .attendance-analytics-page .metric-help {
        font-size: 0.82rem;
        color: var(--bs-secondary-color);
        margin-top: 0.5rem;
    }

    .attendance-analytics-page .insight-pills {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.65rem;
    }

    .attendance-analytics-page .insight-pill {
        border: 1px solid var(--bs-border-color, #dee2e6);
        border-radius: 10px;
        padding: 0.75rem;
    }

    .attendance-analytics-page .insight-pill .value {
        font-size: 1.15rem;
        font-weight: 700;
    }

    .attendance-analytics-page .analytics-table thead th {
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--bs-secondary-color);
        background: var(--bs-tertiary-bg);
        border-bottom-color: var(--bs-border-color, #dee2e6);
        border-top: 0;
    }

    .attendance-analytics-page .analytics-table tbody td {
        vertical-align: middle;
        border-bottom-color: var(--bs-border-color, #dee2e6);
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
    }

    .attendance-analytics-page .analytics-table tbody tr:hover {
        background: rgba(13, 110, 253, 0.04);
    }

    .attendance-analytics-page .branch-line:last-child {
        margin-bottom: 0 !important;
    }

    .attendance-analytics-page .branch-line .progress {
        height: 8px;
    }

    .attendance-analytics-page .chart-wrap {
        min-height: 280px;
    }

    .attendance-analytics-page .chart-wrap canvas {
        width: 100% !important;
        height: 280px !important;
    }

    .attendance-analytics-page .card-header h5 {
        font-weight: 600;
    }

    @media (max-width: 767.98px) {
        .attendance-analytics-page .metric-value {
            font-size: 1.6rem;
        }

        .attendance-analytics-page .insight-pills {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    @php
        $monthLabel = $summary['month_label'];
        $trendLabels = $trend->pluck('day')->map(fn($day) => \Illuminate\Support\Carbon::parse($day)->format('d M'))->values();
        $trendPresent = $trend->pluck('present_total')->map(fn($value) => (int) $value)->values();
        $trendLate = $trend->pluck('late_total')->map(fn($value) => (int) $value)->values();
        $trendAbsent = $trend->pluck('absent_total')->map(fn($value) => (int) $value)->values();
    @endphp

    <div class="attendance-analytics-page">
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-8">
                        <div class="metric-label">{{ __('Enterprise Attendance Intelligence') }}</div>
                        <h3 class="mb-2">{{ __('Attendance Analytics Overview') }}</h3>
                        <p class="text-muted mb-0">
                            {{ __('Consolidated attendance performance and engagement analytics for :month.', ['month' => $monthLabel]) }}
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <div class="insight-pills">
                            <div class="insight-pill">
                                <div class="text-muted small">{{ __('Events Held') }}</div>
                                <div class="value">{{ $summary['events_held'] }}</div>
                            </div>
                            <div class="insight-pill">
                                <div class="text-muted small">{{ __('Total Members') }}</div>
                                <div class="value">{{ $summary['total_members'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="metric-label">{{ __('Attendance Rate') }}</div>
                        <div class="metric-value">{{ $summary['attendance_rate'] }}%</div>
                        <div class="metric-help">{{ __('Present + late check-ins against all attendance records.') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="metric-label">{{ __('Records Logged') }}</div>
                        <div class="metric-value">{{ $summary['total_records'] }}</div>
                        <div class="metric-help">{{ __('Total attendance records captured this month.') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="metric-label">{{ __('Present + Late') }}</div>
                        <div class="metric-value text-success">{{ $summary['present_count'] + $summary['late_count'] }}</div>
                        <div class="metric-help">{{ __('Members who successfully attended or arrived late.') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="metric-label">{{ __('Absence Load') }}</div>
                        <div class="metric-value text-danger">{{ $summary['absent_count'] }}</div>
                        <div class="metric-help">{{ __('Absences flagged for follow-up attention.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Daily Attendance Trend') }}</h5>
                        <p class="text-muted mb-0">{{ __('Daily attendance movement across present, late, and absent statuses.') }}</p>
                    </div>
                    <div class="card-body chart-wrap">
                        <canvas id="attendanceTrendChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Status Distribution') }}</h5>
                        <p class="text-muted mb-0">{{ __('Monthly attendance status composition.') }}</p>
                    </div>
                    <div class="card-body chart-wrap">
                        <canvas id="attendanceStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Event Performance Summary') }}</h5>
                        <p class="text-muted mb-0">{{ __('Attendance outcomes for each attendance-enabled event.') }}</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table analytics-table align-middle mb-0">
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
                                        <td class="fw-semibold">{{ $event->title }}</td>
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
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-1">{{ __('Branch Participation') }}</h5>
                        <p class="text-muted mb-0">{{ __('Branch-level attendance engagement and risk profile.') }}</p>
                    </div>
                    <div class="card-body">
                        @forelse($branchBreakdown as $branch)
                            <div class="branch-line mb-4">
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
                                <div class="progress">
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

        <div class="card">
            <div class="card-header">
                <h5 class="mb-1">{{ __('Engagement Follow-up Watchlist') }}</h5>
                <p class="text-muted mb-0">{{ __('Members with repeated absences that may require pastoral follow-up.') }}</p>
            </div>
            <div class="table-responsive">
                <table class="table analytics-table align-middle mb-0">
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
                                <td class="text-end"><span class="badge bg-{{ $riskClass }}">{{ $riskLevel }}</span></td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const css = getComputedStyle(document.documentElement);
        const getVar = (name, fallback) => css.getPropertyValue(name).trim() || fallback;
        const primary = getVar('--bs-primary', '#0d6efd');
        const success = getVar('--bs-success', '#198754');
        const warning = getVar('--bs-warning', '#ffc107');
        const danger = getVar('--bs-danger', '#dc3545');
        const muted = getVar('--bs-secondary-color', '#6c757d');

        const trendCtx = document.getElementById('attendanceTrendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            label: @json(__('Present')),
                            data: @json($trendPresent),
                            borderColor: success,
                            tension: 0.35,
                            pointRadius: 2,
                            pointHoverRadius: 4,
                            fill: false
                        },
                        {
                            label: @json(__('Late')),
                            data: @json($trendLate),
                            borderColor: warning,
                            tension: 0.35,
                            pointRadius: 2,
                            pointHoverRadius: 4,
                            fill: false
                        },
                        {
                            label: @json(__('Absent')),
                            data: @json($trendAbsent),
                            borderColor: danger,
                            tension: 0.35,
                            pointRadius: 2,
                            pointHoverRadius: 4,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: muted },
                            grid: { color: 'rgba(148, 163, 184, 0.15)' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: muted, precision: 0 },
                            grid: { color: 'rgba(148, 163, 184, 0.15)' }
                        }
                    }
                }
            });
        }

        const statusCtx = document.getElementById('attendanceStatusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: [@json(__('Present')), @json(__('Late')), @json(__('Absent')), @json(__('Excused'))],
                    datasets: [{
                        data: [
                            {{ (int) $summary['present_count'] }},
                            {{ (int) $summary['late_count'] }},
                            {{ (int) $summary['absent_count'] }},
                            {{ (int) $summary['excused_count'] }}
                        ],
                        backgroundColor: [success, warning, danger, primary],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    })();
</script>
@endpush
