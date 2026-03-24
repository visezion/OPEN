<?php $__env->startSection('page-title', __('Overall Event Analytics')); ?>
<?php $__env->startSection('page-breadcrumb', __('ChurchMeet,Event Analytics')); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-sm btn-outline-primary">
            <i class="ti ti-calendar-event me-1"></i><?php echo e(__('All Events')); ?>

        </a>
        <a href="<?php echo e(route('churchmeet.attendance.reports.dashboard')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-chart-donut-3 me-1"></i><?php echo e(__('Attendance Reports')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .churchmeet-analytics{--ink:#13253b;--muted:#68788f;--line:#d8e1ec;--soft:#f5f7fa;--primary:#145388;--deep:#0f2d4e;color:var(--ink);padding-bottom:2rem}
    .churchmeet-analytics .card{border:1px solid var(--line)!important;border-radius:14px;background:#fff;box-shadow:none!important}
    .churchmeet-analytics .card-header{background:#fff;border-bottom:1px solid rgba(216,225,236,.9)!important;padding:1rem 1.2rem .9rem}
    .churchmeet-analytics .hero{overflow:hidden;background:#fff;border-top:3px solid var(--primary)}
    .churchmeet-analytics .hero .card-body{padding:1.45rem}
    .churchmeet-analytics .eyebrow{display:inline-flex;align-items:center;gap:.45rem;border-radius:999px;padding:.32rem .75rem;background:#f1f5f9;color:var(--primary);font-size:.74rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
    .churchmeet-analytics .hero h2{font-size:clamp(1.8rem,2.8vw,2.35rem);line-height:1.08;font-weight:800;color:var(--deep);margin:.85rem 0 .65rem}
    .churchmeet-analytics .hero p{max-width:760px;color:var(--muted);line-height:1.7;margin:0}
    .churchmeet-analytics .hero-grid,.churchmeet-analytics .dept-top{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.85rem;margin-top:1.2rem}
    .churchmeet-analytics .hero-stat,.churchmeet-analytics .dept-box,.churchmeet-analytics .mini{border:1px solid rgba(216,225,236,.9);border-radius:12px;background:var(--soft);padding:1rem}
    .churchmeet-analytics .hero-stat small,.churchmeet-analytics .mini small,.churchmeet-analytics .label{display:block;color:var(--muted);font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
    .churchmeet-analytics .hero-stat strong,.churchmeet-analytics .metric strong,.churchmeet-analytics .mini strong,.churchmeet-analytics .dept-box strong{display:block;margin-top:.45rem;font-size:1.7rem;line-height:1;color:var(--deep)}
    .churchmeet-analytics .hero-stat span,.churchmeet-analytics .note{display:block;margin-top:.45rem;color:var(--muted);font-size:.83rem;line-height:1.6}
    .churchmeet-analytics .metric .card-body,.churchmeet-analytics .insight .card-body,.churchmeet-analytics .ranking .card-body{padding:1.2rem 1.25rem}
    .churchmeet-analytics .metric-icon{width:42px;height:42px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;background:#f1f5f9;color:var(--primary);font-size:1.05rem;margin-bottom:.95rem}
    .churchmeet-analytics .metric strong{font-size:2rem}
    .churchmeet-analytics .chip{display:inline-flex;margin-top:.85rem;padding:.34rem .6rem;border-radius:999px;font-size:.76rem;font-weight:700;color:var(--primary);background:#eef4fb}
    .churchmeet-analytics .chip.ok,.churchmeet-analytics .chip.warn,.churchmeet-analytics .chip.neutral{color:var(--primary);background:#eef4fb}
    .churchmeet-analytics .quote{padding:1rem 1.05rem 1rem 1.15rem;border-radius:12px;background:var(--soft);border:1px solid rgba(216,225,236,.85);color:var(--deep);line-height:1.8;margin-bottom:1rem}
    .churchmeet-analytics .actions{display:grid;gap:.75rem;margin:0;padding:0;list-style:none}
    .churchmeet-analytics .actions li{display:flex;gap:.7rem;align-items:flex-start;padding:.8rem .9rem;border-radius:12px;background:#fff;border:1px solid rgba(216,225,236,.85)}
    .churchmeet-analytics .actions i{color:var(--primary);margin-top:.1rem}
    .churchmeet-analytics .ring{width:188px;height:188px;border-radius:50%;padding:14px;background:conic-gradient(var(--primary) 0deg,var(--primary) var(--ring),rgba(20,83,136,.1) var(--ring),rgba(20,83,136,.1) 360deg);display:grid;place-items:center;margin:0 auto}
    .churchmeet-analytics .ring>div{width:100%;height:100%;border-radius:50%;display:grid;place-items:center;text-align:center;background:#fff;padding:1rem}
    .churchmeet-analytics .ring>div strong{font-size:2.1rem;font-weight:800;color:var(--deep)} .churchmeet-analytics .ring>div span{color:var(--muted);font-size:.84rem}
    .churchmeet-analytics .mini-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.8rem;margin-top:1rem}
    .churchmeet-analytics .chart-body{padding:1rem 1.1rem 1.2rem;min-height:320px}
    .churchmeet-analytics .chart-wrap{height:300px}
    .churchmeet-analytics .chart-wrap canvas{width:100%!important;height:300px!important}
    .churchmeet-analytics .empty{display:grid;place-items:center;min-height:280px;text-align:center;color:var(--muted);border:1px dashed rgba(216,225,236,.95);border-radius:12px;background:var(--soft);padding:1rem}
    .churchmeet-analytics .rank-list{display:grid;gap:.85rem}
    .churchmeet-analytics .rank{display:grid;grid-template-columns:auto 1fr auto;gap:.9rem;align-items:center;padding:.95rem 1rem;border-radius:12px;background:#fff;border:1px solid rgba(216,225,236,.85)}
    .churchmeet-analytics .rank-badge{width:34px;height:34px;border-radius:10px;background:#edf2f7;color:var(--deep);display:inline-flex;align-items:center;justify-content:center;font-size:.88rem;font-weight:700}
    .churchmeet-analytics .rank-title{font-weight:700;color:var(--deep)} .churchmeet-analytics .rank-sub{margin-top:.2rem;color:var(--muted);font-size:.82rem} .churchmeet-analytics .rank-rate{font-size:1.08rem;font-weight:800;color:var(--primary)}
    .churchmeet-analytics .analytics-table thead th{border-top:0;border-bottom-color:rgba(216,225,236,.9);background:#f8fafc;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;font-size:.72rem;font-weight:800;padding:.95rem 1rem}
    .churchmeet-analytics .analytics-table tbody td{vertical-align:middle;border-bottom-color:rgba(216,225,236,.85);padding:1rem}
    .churchmeet-analytics .analytics-table tbody tr:hover{background:rgba(20,83,136,.03)}
    .churchmeet-analytics .progress-shell{height:10px;border-radius:999px;background:rgba(20,83,136,.08);overflow:hidden}
    .churchmeet-analytics .progress-fill{height:100%;border-radius:inherit;background:var(--primary)}
    @media (max-width:1199.98px){.churchmeet-analytics .hero-grid,.churchmeet-analytics .dept-top{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media (max-width:991.98px){.churchmeet-analytics .hero-grid,.churchmeet-analytics .mini-grid,.churchmeet-analytics .dept-top{grid-template-columns:1fr}.churchmeet-analytics .ring{width:170px;height:170px}}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
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
    ?>

    <div class="churchmeet-analytics">
        <div class="card hero mb-4">
            <div class="card-body">
                <span class="eyebrow"><i class="ti ti-sparkles"></i><?php echo e(__('ChurchMeet Intelligence')); ?></span>
                <h2><?php echo e(__('Overall Event Analytics and Ministry Insight')); ?></h2>
                <p><?php echo e(__('Measure turnout, compare departments, and understand where leadership attention should move next from one stronger ChurchMeet analytics screen.')); ?></p>
                <div class="hero-grid">
                    <div class="hero-stat"><small><?php echo e(__('Published Events')); ?></small><strong><?php echo e($analyticsSummary['total_events'] ?? 0); ?></strong><span><?php echo e(__('Events included in this snapshot.')); ?></span></div>
                    <div class="hero-stat"><small><?php echo e(__('Attendance Records')); ?></small><strong><?php echo e($analyticsSummary['total_attendance_records'] ?? 0); ?></strong><span><?php echo e(__('Captured records across all tracked events.')); ?></span></div>
                    <div class="hero-stat"><small><?php echo e(__('Average Attendance')); ?></small><strong><?php echo e(number_format($avgRate, 1)); ?>%</strong><span><?php echo e($avgRate >= 80 ? __('Strong congregational consistency') : ($avgRate >= 60 ? __('Healthy but improvable engagement') : __('Renewal and follow-up needed'))); ?></span></div>
                    <div class="hero-stat"><small><?php echo e(__('Next Event Forecast')); ?></small><strong><?php echo e(number_format($predictedRate, 1)); ?>%</strong><span><?php echo e($predictedLift >= 0 ? __('Projected lift of :value points.', ['value' => abs($predictedLift)]) : __('Trend suggests stable turnout if follow-up continues.')); ?></span></div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-arrow-up-right-circle"></i></div><span class="label"><?php echo e(__('Best Performing Event')); ?></span><strong><?php echo e(number_format(optional($eventLeaderboard->first())->rate ?? 0, 1)); ?>%</strong><span class="note"><?php echo e($analyticsSummary['highest_attendance_event'] ?? __('No event data yet')); ?></span><span class="chip ok"><?php echo e(__('Top turnout')); ?></span></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-arrow-down-right-circle"></i></div><span class="label"><?php echo e(__('Needs Attention')); ?></span><strong><?php echo e(number_format(optional($eventLeaderboard->last())->rate ?? 0, 1)); ?>%</strong><span class="note"><?php echo e($analyticsSummary['lowest_attendance_event'] ?? __('No event data yet')); ?></span><span class="chip warn"><?php echo e(__('Review scheduling')); ?></span></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-building-community"></i></div><span class="label"><?php echo e(__('Most Active Department')); ?></span><strong><?php echo e($analyticsSummary['most_active_dept'] ?? __('N/A')); ?></strong><span class="note"><?php echo e(__('Highest participation count across event records.')); ?></span><span class="chip neutral"><?php echo e(__('Leadership signal')); ?></span></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="card metric h-100"><div class="card-body"><div class="metric-icon"><i class="ti ti-target-arrow"></i></div><span class="label"><?php echo e(__('Unreached Capacity')); ?></span><strong><?php echo e(number_format($gapRate, 1)); ?>%</strong><span class="note"><?php echo e(__('Gap between current turnout and full church attendance.')); ?></span><span class="chip neutral"><?php echo e(__('Planning window')); ?></span></div></div></div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1"><?php echo e(__('Attendance Rate by Event')); ?></h5><p class="text-muted mb-0"><?php echo e(__('A rate-based view of how each published event performed against your current member base.')); ?></p></div>
                    <div class="chart-body">
                        <?php if($eventLeaderboard->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No event analytics yet')); ?></div><div><?php echo e(__('Publish events and capture attendance to populate this chart.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="chart-wrap"><canvas id="churchmeetEventAnalyticsChart"></canvas></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1"><?php echo e(__('Ministry Pulse')); ?></h5><p class="text-muted mb-0"><?php echo e(__('A compact reading of turnout strength and forecast momentum.')); ?></p></div>
                    <div class="card-body">
                        <div class="ring" style="--ring: <?php echo e($ringAngle); ?>deg;"><div><strong><?php echo e(number_format($avgRate, 1)); ?>%</strong><span><?php echo e(__('Average event attendance')); ?></span></div></div>
                        <div class="mini-grid">
                            <div class="mini"><small><?php echo e(__('Forecast')); ?></small><strong><?php echo e(number_format($predictedRate, 1)); ?>%</strong></div>
                            <div class="mini"><small><?php echo e(__('Momentum')); ?></small><strong><?php echo e($predictedLift >= 0 ? '+' : ''); ?><?php echo e(number_format($predictedLift, 1)); ?></strong></div>
                            <div class="mini"><small><?php echo e(__('Best Event')); ?></small><strong><?php echo e(\Illuminate\Support\Str::limit($analyticsSummary['highest_attendance_event'] ?? __('N/A'), 20)); ?></strong></div>
                            <div class="mini"><small><?php echo e(__('Lowest Event')); ?></small><strong><?php echo e(\Illuminate\Support\Str::limit($analyticsSummary['lowest_attendance_event'] ?? __('N/A'), 20)); ?></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-5">
                <div class="card insight h-100">
                    <div class="card-header"><h5 class="mb-1"><?php echo e(__('Spiritual Insight and Recommended Actions')); ?></h5><p class="text-muted mb-0"><?php echo e(__('A practical reading of engagement patterns for leadership follow-up.')); ?></p></div>
                    <div class="card-body">
                        <div class="quote"><?php echo e($spiritualInsight); ?></div>
                        <ul class="actions">
                            <?php $__currentLoopData = $actionSuggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="ti ti-check"></i><span><?php echo e($tip); ?></span></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card ranking h-100">
                    <div class="card-header"><h5 class="mb-1"><?php echo e(__('Event Leaderboard')); ?></h5><p class="text-muted mb-0"><?php echo e(__('Quick ranking of your strongest and weakest events by attendance rate.')); ?></p></div>
                    <div class="card-body">
                        <?php if($eventLeaderboard->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No leaderboard available')); ?></div><div><?php echo e(__('This section fills automatically once attendance is tracked.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="rank-list">
                                <?php $__currentLoopData = $eventLeaderboard->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rank">
                                        <span class="rank-badge">#<?php echo e($loop->iteration); ?></span>
                                        <div>
                                            <div class="rank-title"><?php echo e($event->title); ?></div>
                                            <div class="rank-sub"><?php echo e($event->rate >= 75 ? __('Strong turnout and healthy member pull.') : ($event->rate >= 50 ? __('Solid turnout with room to improve follow-up.') : __('Low turnout. Review communication and timing.'))); ?></div>
                                        </div>
                                        <div class="rank-rate"><?php echo e(number_format($event->rate, 1)); ?>%</div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1"><?php echo e(__('Department Attendance Rate')); ?></h5><p class="text-muted mb-0"><?php echo e(__('Participation rate by department, normalized against registered members in each department.')); ?></p></div>
                    <div class="chart-body">
                        <?php if($departmentInsights->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No department comparison yet')); ?></div><div><?php echo e(__('Department-based attendance will appear here once members are mapped and checked in.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="chart-wrap"><canvas id="churchmeetDepartmentChart"></canvas></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-1"><?php echo e(__('Department Spotlight')); ?></h5><p class="text-muted mb-0"><?php echo e(__('Your most responsive ministry areas right now.')); ?></p></div>
                    <div class="card-body">
                        <?php if($departmentInsights->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No department spotlight yet')); ?></div><div><?php echo e(__('Assign members to departments and capture attendance to unlock this view.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="dept-top">
                                <?php $__currentLoopData = $departmentInsights->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="dept-box"><small><?php echo e($department->name); ?></small><strong><?php echo e(number_format($department->rate, 1)); ?>%</strong><span><?php echo e($department->present); ?> <?php echo e(__('present')); ?> / <?php echo e($department->total); ?> <?php echo e(__('members')); ?></span></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-1"><?php echo e(__('Department Comparison Detail')); ?></h5><p class="text-muted mb-0"><?php echo e(__('Detailed comparison of turnout by department, including absolute participation and normalized attendance rate.')); ?></p></div>
            <div class="table-responsive">
                <table class="table analytics-table align-middle mb-0">
                    <thead><tr><th><?php echo e(__('Department')); ?></th><th class="text-center"><?php echo e(__('Present')); ?></th><th class="text-center"><?php echo e(__('Total Members')); ?></th><th><?php echo e(__('Rate Progress')); ?></th><th class="text-end"><?php echo e(__('Attendance Rate')); ?></th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $departmentInsights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong class="d-block"><?php echo e($department->name); ?></strong><small class="text-muted"><?php echo e($department->rate >= 80 ? __('High consistency') : ($department->rate >= 60 ? __('Stable turnout') : __('Needs encouragement'))); ?></small></td>
                                <td class="text-center fw-semibold"><?php echo e($department->present); ?></td>
                                <td class="text-center text-muted"><?php echo e($department->total); ?></td>
                                <td style="min-width:220px"><div class="progress-shell"><div class="progress-fill" style="width: <?php echo e(min(100, $department->rate)); ?>%;"></div></div></td>
                                <td class="text-end fw-bold <?php echo e($department->rate >= 80 ? 'text-success' : ($department->rate >= 60 ? 'text-primary' : 'text-danger')); ?>"><?php echo e(number_format($department->rate, 1)); ?>%</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4"><?php echo e(__('No department attendance comparison data is currently available.')); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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

        const eventLabels = <?php echo json_encode(array_values($chartData['labels'] ?? []), 15, 512) ?>;
        const eventRates = <?php echo json_encode(array_values($chartData['data'] ?? []), 15, 512) ?>;
        const departmentLabels = <?php echo json_encode($departmentLabels, 15, 512) ?>;
        const departmentRates = <?php echo json_encode($departmentRates, 15, 512) ?>;
        const departmentPresents = <?php echo json_encode($departmentPresents, 15, 512) ?>;

        const eventTarget = document.getElementById('churchmeetEventAnalyticsChart');
        if (eventTarget && eventLabels.length) {
            new Chart(eventTarget, {
                type: 'line',
                data: {labels: eventLabels, datasets: [{label: <?php echo json_encode(__('Attendance Rate (%)'), 15, 512) ?>, data: eventRates, borderColor: primary, backgroundColor: 'rgba(20, 83, 136, 0.12)', fill: true, tension: 0.34, borderWidth: 3, pointRadius: 3, pointHoverRadius: 5, pointBackgroundColor: warning}]},
                options: {responsive: true, maintainAspectRatio: false, plugins: {legend: {labels: {color: muted, boxWidth: 14, usePointStyle: true}}, tooltip: {callbacks: {label: ctx => ctx.formattedValue + '%'}}}, scales: {x: {ticks: {color: muted}, grid: {display: false}}, y: {beginAtZero: true, suggestedMax: 100, ticks: {color: muted, callback: value => value + '%'}, grid: {color: softGrid}}}}
            });
        }

        const deptTarget = document.getElementById('churchmeetDepartmentChart');
        if (deptTarget && departmentLabels.length) {
            new Chart(deptTarget, {
                type: 'bar',
                data: {labels: departmentLabels, datasets: [{label: <?php echo json_encode(__('Attendance Rate (%)'), 15, 512) ?>, data: departmentRates, backgroundColor: [primary, info, success, warning, '#8f67d0', '#3a9d9c', '#d46b3b'], borderRadius: 10, borderSkipped: false}]},
                options: {indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: {legend: {display: false}, tooltip: {callbacks: {afterLabel: ctx => <?php echo json_encode(__('Present records:'), 15, 512) ?> + ' ' + (departmentPresents[ctx.dataIndex] ?? 0)}}}, scales: {x: {beginAtZero: true, suggestedMax: 100, ticks: {color: muted, callback: value => value + '%'}, grid: {color: softGrid}}, y: {ticks: {color: muted}, grid: {display: false}}}}
            });
        }
    })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Providers/../Resources/views/attendance/events/analytics-overall.blade.php ENDPATH**/ ?>