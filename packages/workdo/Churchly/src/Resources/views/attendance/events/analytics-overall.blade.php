@extends('layouts.main')

@section('page-title')
    Overall Event Analytics & Insights
@endsection

@section('page-breadcrumb')
    Analytics Dashboard
@endsection

@section('content')
<br>

<div class="card shadow-sm border-0 rounded-3 p-4 overflow-hidden">

    <div class="row g-4">

        <!-- ================= KPI SUMMARY ================= -->
        <div class="col-md-2 col-sm-6">
            <div class="card border-0 shadow-sm text-center rounded-3">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Total Events</h6>
                    <h3 class="fw-bold text-primary mb-0">{{ $analyticsSummary['total_events'] }}</h3>
                    <small class="text-muted">Published & Completed</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card border-0 shadow-sm text-center rounded-3">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Attendance Records</h6>
                    <h3 class="fw-bold text-success mb-0">{{ $analyticsSummary['total_attendance_records'] }}</h3>
                    <small class="text-muted">Across All Events</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-sm-6">
            <div class="card border-0 shadow-sm text-center rounded-3">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Avg. Attendance</h6>
                    <h3 class="fw-bold text-primary mb-0">{{ $analyticsSummary['avg_attendance_rate'] }}%</h3>
                    <small class="text-muted">Engagement Strength</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center rounded-3">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Most Active Department</h6>
                    <h5 class="fw-bold text-warning mb-0">{{ $analyticsSummary['most_active_dept'] ?? 'N/A' }}</h5>
                    <small class="text-muted">Highest Participation</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm text-center rounded-3">
                <div class="card-body">
                    <h6 class="text-muted fw-semibold">Predicted Attendance</h6>
                    <h3 class="fw-bold mb-0"
                        style="background:linear-gradient(90deg,#007bff,#6610f2);
                               -webkit-background-clip:text;
                               -webkit-text-fill-color:transparent;">
                        {{ $analyticsSummary['predicted_next_attendance'] }}%
                    </h3>
                    <small class="text-muted">Based on Past Trends</small>
                </div>
            </div>
        </div>

        <!-- ================= DEPARTMENT COMPARISON TABLE ================= -->
        

        <!-- ================= SPIRITUAL INSIGHT ================= -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="bg-gradient text-white p-2 px-3 fw-bold"
                     style="background:linear-gradient(90deg,#007bff,#6610f2)">
                    <i class="ti ti-sparkles"></i> Spiritual Insights & Recommendations
                </div>
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-md-8">
                            <blockquote class="blockquote border-start border-4 ps-3 mb-3">
                                <p class="mb-1 text-dark fs-5">
                                    “{{ $spiritualInsight }}”
                                </p>
                                <footer class="blockquote-footer mt-2">
                                    {{ config('app.name') }} – AI Insight Engine
                                </footer>
                            </blockquote>
                            <p class="small text-muted">
                                These insights are automatically generated based on attendance trends,
                                engagement levels, and department activity — reflecting the spiritual climate
                                and readiness of your congregation.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <h6 class="fw-bold mb-3 text-primary">Actionable Recommendations</h6>
                                <ul class="small mb-0">
                                    @foreach($actionSuggestions as $tip)
                                        <li class="mb-1">{{ $tip }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= ATTENDANCE TREND ================= -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light fw-bold text-dark">
                    <i class="ti ti-trending-up"></i> Attendance Trends by Event
                </div>
                <div class="card-body bg-white">
                    <canvas id="attendanceChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <!-- ================= DEPARTMENT PARTICIPATION ================= -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light fw-bold text-dark">
                    <i class="ti ti-users-group"></i> Department Attendance Rate
                </div>
                <div class="card-body bg-white">
                    <canvas id="deptChart" height="240"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light fw-bold text-dark">
                    <i class="ti ti-chart-bar"></i> Department Attendance Comparison
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Department</th>
                                    <th class="text-center">Present</th>
                                    <th class="text-center">Total Members</th>
                                    <th class="text-center">Attendance Rate (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentComparison as $dept => $stats)
                                    <tr>
                                        <td><strong>{{ $dept }}</strong></td>
                                        <td class="text-center text-primary fw-semibold">{{ $stats['present'] }}</td>
                                        <td class="text-center text-muted">{{ $stats['total'] }}</td>
                                        <td class="text-center fw-bold 
                                            @if($stats['rate'] >= 90) text-primary
                                            @elseif($stats['rate'] >= 70) text-info
                                            @elseif($stats['rate'] >= 50) text-warning
                                            @else text-danger @endif">
                                            {{ $stats['rate'] }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-muted small">
                    <i class="ti ti-info-circle"></i>
                    Calculated based on actual attendance per department compared to total registered members.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx1 = document.getElementById('attendanceChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
            label: 'Attendance Rate (%)',
            data: {!! json_encode($chartData['data']) !!},
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.15)',
            borderWidth: 2,
            tension: 0.35,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#6610f2',
            pointBorderWidth: 1.5,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true, labels: { color: '#444' } },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#eee' }, ticks: { color: '#555' } },
            x: { ticks: { color: '#555' } }
        }
    }
});

const ctx2 = document.getElementById('deptChart').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartData['department_labels']) !!},
        datasets: [{
            label: 'Attendance Rate (%)',
            data: {!! json_encode($chartData['department_data']) !!},
            backgroundColor: [
                '#007bff', '#6610f2', '#20c997', '#ffc107', '#6f42c1', '#dc3545'
            ],
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.formattedValue + '% attendance';
                    }
                }
            }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#eee' }, ticks: { color: '#555' } },
            x: { ticks: { color: '#555' } }
        }
    }
});
</script>
@endpush
