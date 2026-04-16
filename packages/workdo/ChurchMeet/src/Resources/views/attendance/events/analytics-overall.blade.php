@extends('layouts.main')

@section('page-title', __('Overall Event Analytics'))
@section('page-breadcrumb', __('ChurchMeet,Event Analytics'))

@section('page-action')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('churchmeet.events.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="ti ti-calendar-event me-1"></i>{{ __('All Events') }}
        </a>
        <a href="{{ route('churchmeet.attendance.reports.dashboard') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-chart-donut-3 me-1"></i>{{ __('Attendance Reports') }}
        </a>
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css') }}">
@endpush

@section('content')
    @php
        $avgRate = (float) ($analyticsSummary['avg_attendance_rate'] ?? 0);
        $predictedRate = (float) ($analyticsSummary['predicted_next_attendance'] ?? 0);
        $predictedLift = round($predictedRate - $avgRate, 1);
        $gapRate = max(0, round(100 - $avgRate, 1));
        $ringAngle = max(12, min(360, round(($avgRate / 100) * 360)));

        $eventLeaderboard = collect($chartData['labels'] ?? [])->map(function ($label, $index) use ($chartData) {
            return (object) ['title' => $label, 'rate' => (float) ($chartData['data'][$index] ?? 0)];
        })->sortByDesc('rate')->values();

        $departmentInsights = collect($departmentComparison ?? [])->map(function ($stats, $name) {
            return (object) ['name' => $name, 'present' => (int) ($stats['present'] ?? 0), 'total' => (int) ($stats['total'] ?? 0), 'rate' => (float) ($stats['rate'] ?? 0)];
        })->sortByDesc('rate')->values();

        $departmentLabels = $departmentInsights->pluck('name')->values();
        $departmentRates = $departmentInsights->pluck('rate')->values();
        $departmentPresents = $departmentInsights->pluck('present')->values();
    @endphp

    <div class="churchmeet-analytics">
        <div class="card hero mb-4">
            <div class="card-body">
                <span class="eyebrow"><i class="ti ti-sparkles"></i>{{ __('ChurchMeet Intelligence') }}</span>
                <h2>{{ __('Overall Event Analytics and Ministry Insight') }}</h2>
                <p>{{ __('Measure turnout, compare departments, and understand where leadership attention should move next from one stronger ChurchMeet analytics screen.') }}</p>
                <div class="hero-grid">
                    <div class="hero-stat"><small>{{ __('Published Events') }}</small><strong>{{ $analyticsSummary['total_events'] ?? 0 }}</strong><span>{{ __('Events included in this snapshot.') }}</span></div>
                    <div class="hero-stat"><small>{{ __('Attendance Records') }}</small><strong>{{ $analyticsSummary['total_attendance_records'] ?? 0 }}</strong><span>{{ __('Captured records across all tracked events.') }}</span></div>
                    <div class="hero-stat"><small>{{ __('Average Attendance') }}</small><strong>{{ number_format($avgRate, 1) }}%</strong><span>{{ $avgRate >= 80 ? __('Strong congregational consistency') : ($avgRate >= 60 ? __('Healthy but improvable engagement') : __('Renewal and follow-up needed')) }}</span></div>
                    <div class="hero-stat"><small>{{ __('Next Event Forecast') }}</small><strong>{{ number_format($predictedRate, 1) }}%</strong><span>{{ $predictedLift >= 0 ? __('Projected lift of :value points.', ['value' => abs($predictedLift)]) : __('Trend suggests stable turnout if follow-up continues.') }}</span></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-arrow-up-right-circle"></i></div><span class="label">{{ __('Best Performing Event') }}</span><strong>{{ number_format(optional($eventLeaderboard->first())->rate ?? 0, 1) }}%</strong><span class="note">{{ $analyticsSummary['highest_attendance_event'] ?? __('No event data yet') }}</span><span class="chip ok">{{ __('Top turnout') }}</span></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-arrow-down-right-circle"></i></div><span class="label">{{ __('Needs Attention') }}</span><strong>{{ number_format(optional($eventLeaderboard->last())->rate ?? 0, 1) }}%</strong><span class="note">{{ $analyticsSummary['lowest_attendance_event'] ?? __('No event data yet') }}</span><span class="chip warn">{{ __('Review scheduling') }}</span></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-building-community"></i></div><span class="label">{{ __('Most Active Department') }}</span><strong>{{ $analyticsSummary['most_active_dept'] ?? __('N/A') }}</strong><span class="note">{{ __('Highest participation count across event records.') }}</span><span class="chip neutral">{{ __('Leadership signal') }}</span></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-target-arrow"></i></div><span class="label">{{ __('Unreached Capacity') }}</span><strong>{{ number_format($gapRate, 1) }}%</strong><span class="note">{{ __('Gap between current turnout and full church attendance.') }}</span><span class="chip neutral">{{ __('Planning window') }}</span></div></div></div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1">{{ __('Attendance Rate by Event') }}</h5><p class="text-muted mb-0">{{ __('A rate-based view of how each published event performed against your current member base.') }}</p></div>
                    <div class="chart-body">
                        @if ($eventLeaderboard->isEmpty())
                            <div class="empty"><div><div class="fw-semibold mb-2">{{ __('No event analytics yet') }}</div><div>{{ __('Publish events and capture attendance to populate this chart.') }}</div></div></div>
                        @else
                            <div class="chart-wrap"><canvas id="churchmeetEventAnalyticsChart"></canvas></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1">{{ __('Ministry Pulse') }}</h5><p class="text-muted mb-0">{{ __('A compact reading of turnout strength and forecast momentum.') }}</p></div>
                    <div class="card-body">
                        <div class="ring" data-ring-angle="{{ $ringAngle }}"><div><strong>{{ number_format($avgRate, 1) }}%</strong><span>{{ __('Average event attendance') }}</span></div></div>
                        <div class="mini-grid">
                            <div class="mini"><small>{{ __('Forecast') }}</small><strong>{{ number_format($predictedRate, 1) }}%</strong></div>
                            <div class="mini"><small>{{ __('Momentum') }}</small><strong>{{ $predictedLift >= 0 ? '+' : '' }}{{ number_format($predictedLift, 1) }}</strong></div>
                            <div class="mini"><small>{{ __('Best Event') }}</small><strong>{{ \Illuminate\Support\Str::limit($analyticsSummary['highest_attendance_event'] ?? __('N/A'), 20) }}</strong></div>
                            <div class="mini"><small>{{ __('Lowest Event') }}</small><strong>{{ \Illuminate\Support\Str::limit($analyticsSummary['lowest_attendance_event'] ?? __('N/A'), 20) }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-5">
                <div class="card insight h-100">
                    <div class="card-header"><h5 class="mb-1">{{ __('Spiritual Insight and Recommended Actions') }}</h5><p class="text-muted mb-0">{{ __('A practical reading of engagement patterns for leadership follow-up.') }}</p></div>
                    <div class="card-body">
                        <div class="quote">{{ $spiritualInsight }}</div>
                        <ul class="actions">
                            @foreach ($actionSuggestions as $tip)
                                <li><i class="ti ti-check"></i><span>{{ $tip }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card ranking h-100">
                    <div class="card-header"><h5 class="mb-1">{{ __('Event Leaderboard') }}</h5><p class="text-muted mb-0">{{ __('Quick ranking of your strongest and weakest events by attendance rate.') }}</p></div>
                    <div class="card-body">
                        @if ($eventLeaderboard->isEmpty())
                            <div class="empty"><div><div class="fw-semibold mb-2">{{ __('No leaderboard available') }}</div><div>{{ __('This section fills automatically once attendance is tracked.') }}</div></div></div>
                        @else
                            <div class="rank-list">
                                @foreach ($eventLeaderboard->take(5) as $event)
                                    <div class="rank">
                                        <span class="rank-badge">#{{ $loop->iteration }}</span>
                                        <div>
                                            <div class="rank-title">{{ $event->title }}</div>
                                            <div class="rank-sub">{{ $event->rate >= 75 ? __('Strong turnout and healthy member pull.') : ($event->rate >= 50 ? __('Solid turnout with room to improve follow-up.') : __('Low turnout. Review communication and timing.')) }}</div>
                                        </div>
                                        <div class="rank-rate">{{ number_format($event->rate, 1) }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1">{{ __('Department Attendance Rate') }}</h5><p class="text-muted mb-0">{{ __('Participation rate by department, normalized against registered members in each department.') }}</p></div>
                    <div class="chart-body">
                        @if ($departmentInsights->isEmpty())
                            <div class="empty"><div><div class="fw-semibold mb-2">{{ __('No department comparison yet') }}</div><div>{{ __('Department-based attendance will appear here once members are mapped and checked in.') }}</div></div></div>
                        @else
                            <div class="chart-wrap"><canvas id="churchmeetDepartmentChart"></canvas></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1">{{ __('Department Spotlight') }}</h5><p class="text-muted mb-0">{{ __('Your most responsive ministry areas right now.') }}</p></div>
                    <div class="card-body">
                        @if ($departmentInsights->isEmpty())
                            <div class="empty"><div><div class="fw-semibold mb-2">{{ __('No department spotlight yet') }}</div><div>{{ __('Assign members to departments and capture attendance to unlock this view.') }}</div></div></div>
                        @else
                            <div class="dept-top">
                                @foreach ($departmentInsights->take(4) as $department)
                                    <div class="dept-box"><small>{{ $department->name }}</small><strong>{{ number_format($department->rate, 1) }}%</strong><span>{{ $department->present }} {{ __('present') }} / {{ $department->total }} {{ __('members') }}</span></div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-1">{{ __('Department Comparison Detail') }}</h5><p class="text-muted mb-0">{{ __('Detailed comparison of turnout by department, including absolute participation and normalized attendance rate.') }}</p></div>
            <div class="table-responsive">
                <table class="table analytics-table align-middle mb-0">
                    <thead><tr><th>{{ __('Department') }}</th><th class="text-center">{{ __('Present') }}</th><th class="text-center">{{ __('Total Members') }}</th><th>{{ __('Rate Progress') }}</th><th class="text-end">{{ __('Attendance Rate') }}</th></tr></thead>
                    <tbody>
                        @forelse ($departmentInsights as $department)
                            <tr>
                                <td><strong class="d-block">{{ $department->name }}</strong><small class="text-muted">{{ $department->rate >= 80 ? __('High consistency') : ($department->rate >= 60 ? __('Stable turnout') : __('Needs encouragement')) }}</small></td>
                                <td class="text-center fw-semibold">{{ $department->present }}</td>
                                <td class="text-center text-muted">{{ $department->total }}</td>
                                <td class="churchmeet-min-width-220"><div class="progress-shell"><div class="progress-fill" data-progress-width="{{ min(100, $department->rate) }}"></div></div></td>
                                <td class="text-end fw-bold {{ $department->rate >= 80 ? 'text-success' : ($department->rate >= 60 ? 'text-primary' : 'text-danger') }}">{{ number_format($department->rate, 1) }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">{{ __('No department attendance comparison data is currently available.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/js/churchmeet-view-helpers.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const css = getComputedStyle(document.documentElement);
        const primary = (css.getPropertyValue('--bs-primary') || '#145388').trim();
        const info = (css.getPropertyValue('--bs-info') || '#2f7cb8').trim();
        const warning = (css.getPropertyValue('--bs-warning') || '#c69214').trim();
        const success = (css.getPropertyValue('--bs-success') || '#168873').trim();
        const muted = (css.getPropertyValue('--bs-secondary-color') || '#68788f').trim();
        const softGrid = 'rgba(107, 122, 144, 0.12)';

        const eventLabels = @json(array_values($chartData['labels'] ?? []));
        const eventRates = @json(array_values($chartData['data'] ?? []));
        const departmentLabels = @json($departmentLabels);
        const departmentRates = @json($departmentRates);
        const departmentPresents = @json($departmentPresents);

        const eventTarget = document.getElementById('churchmeetEventAnalyticsChart');
        if (eventTarget && eventLabels.length) {
            new Chart(eventTarget, {
                type: 'line',
                data: {labels: eventLabels, datasets: [{label: @json(__('Attendance Rate (%)')), data: eventRates, borderColor: primary, backgroundColor: 'rgba(20, 83, 136, 0.12)', fill: true, tension: 0.34, borderWidth: 3, pointRadius: 3, pointHoverRadius: 5, pointBackgroundColor: warning}]},
                options: {responsive: true, maintainAspectRatio: false, plugins: {legend: {labels: {color: muted, boxWidth: 14, usePointStyle: true}}, tooltip: {callbacks: {label: ctx => ctx.formattedValue + '%'}}}, scales: {x: {ticks: {color: muted}, grid: {display: false}}, y: {beginAtZero: true, suggestedMax: 100, ticks: {color: muted, callback: value => value + '%'}, grid: {color: softGrid}}}}
            });
        }

        const deptTarget = document.getElementById('churchmeetDepartmentChart');
        if (deptTarget && departmentLabels.length) {
            new Chart(deptTarget, {
                type: 'bar',
                data: {labels: departmentLabels, datasets: [{label: @json(__('Attendance Rate (%)')), data: departmentRates, backgroundColor: [primary, info, success, warning, '#8f67d0', '#3a9d9c', '#d46b3b'], borderRadius: 10, borderSkipped: false}]},
                options: {indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: {legend: {display: false}, tooltip: {callbacks: {afterLabel: ctx => @json(__('Present records:')) + ' ' + (departmentPresents[ctx.dataIndex] ?? 0)}}}, scales: {x: {beginAtZero: true, suggestedMax: 100, ticks: {color: muted, callback: value => value + '%'}, grid: {color: softGrid}}, y: {ticks: {color: muted}, grid: {display: false}}}}
            });
        }
    })();
</script>
@endpush
