<?php $__env->startSection('page-title', __('Overall Events Analytics')); ?>
<?php $__env->startSection('page-breadcrumb', __('ChurchMeet,Events Analytics')); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-sm btn-outline-primary">
            <i class="ti ti-calendar-event me-1"></i><?php echo e(__('All Events/Meetings')); ?>

        </a>
        <a href="<?php echo e(route('churchmeet.attendance.reports.dashboard')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-chart-donut-3 me-1"></i><?php echo e(__('Attendance Reports')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css')); ?>">
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
        $topEvent = $eventLeaderboard->first();
        $bottomEvent = $eventLeaderboard->last();
        $topDepartment = $departmentInsights->first();
        $healthTone = $avgRate >= 80 ? __('Thriving') : ($avgRate >= 60 ? __('Steady') : __('Rebuild'));
        $momentumTone = $predictedLift >= 3 ? __('Growing') : ($predictedLift >= 0 ? __('Stable') : __('Watch closely'));
    ?>

    <div class="churchmeet-shell churchmeet-analytics">
        <div class="card churchmeet-hero analytics-hero mb-4">
            <div class="card-body churchmeet-hero-body">
                <div class="hero-layout">
                    <div>
                        <span class="churchmeet-kicker"><i class="ti ti-sparkles"></i><?php echo e(__('ChurchMeet Intelligence')); ?></span>
                        <h2 class="churchmeet-title"><?php echo e(__('Overall Events Analytics and Ministry Insight')); ?></h2>
                        <p class="churchmeet-copy hero-copy"><?php echo e(__('Measure turnout, compare departments, and understand where leadership attention should move next from one stronger ChurchMeet analytics screen.')); ?></p>
                        <div class="churchmeet-stat-grid hero-grid">
                            <div class="churchmeet-stat-card hero-stat">
                                <small class="churchmeet-stat-label"><?php echo e(__('Published Events')); ?></small>
                                <strong class="churchmeet-stat-value"><?php echo e($analyticsSummary['total_events'] ?? 0); ?></strong>
                                <span class="churchmeet-stat-note"><?php echo e(__('Events included in this snapshot.')); ?></span>
                            </div>
                            <div class="churchmeet-stat-card hero-stat">
                                <small class="churchmeet-stat-label"><?php echo e(__('Attendance Records')); ?></small>
                                <strong class="churchmeet-stat-value"><?php echo e($analyticsSummary['total_attendance_records'] ?? 0); ?></strong>
                                <span class="churchmeet-stat-note"><?php echo e(__('Captured records across all tracked events.')); ?></span>
                            </div>
                            <div class="churchmeet-stat-card hero-stat">
                                <small class="churchmeet-stat-label"><?php echo e(__('Average Attendance')); ?></small>
                                <strong class="churchmeet-stat-value"><?php echo e(number_format($avgRate, 1)); ?>%</strong>
                                <span class="churchmeet-stat-note"><?php echo e($avgRate >= 80 ? __('Strong congregational consistency') : ($avgRate >= 60 ? __('Healthy but improvable engagement') : __('Renewal and follow-up needed'))); ?></span>
                            </div>
                            <div class="churchmeet-stat-card hero-stat">
                                <small class="churchmeet-stat-label"><?php echo e(__('Next Events Forecast')); ?></small>
                                <strong class="churchmeet-stat-value"><?php echo e(number_format($predictedRate, 1)); ?>%</strong>
                                <span class="churchmeet-stat-note"><?php echo e($predictedLift >= 0 ? __('Projected lift of :value points.', ['value' => abs($predictedLift)]) : __('Trend suggests stable turnout if follow-up continues.')); ?></span>
                            </div>
                        </div>
                    </div>
                    <aside class="hero-focus">
                        <div class="focus-panel">
                            <div class="focus-head">
                                <span class="focus-kicker"><?php echo e(__('At A Glance')); ?></span>
                                <h5><?php echo e(__('Ministry Focus Window')); ?></h5>
                                <p><?php echo e(__('A quick leadership reading of current turnout strength, forecast direction, and where to lean in next.')); ?></p>
                            </div>
                            <div class="focus-grid">
                                <div class="focus-mini">
                                    <small><?php echo e(__('Health')); ?></small>
                                    <strong><?php echo e($healthTone); ?></strong>
                                    <span><?php echo e(__('Based on current average turnout.')); ?></span>
                                </div>
                                <div class="focus-mini">
                                    <small><?php echo e(__('Momentum')); ?></small>
                                    <strong><?php echo e($momentumTone); ?></strong>
                                    <span><?php echo e(__('Forecast compared with current average.')); ?></span>
                                </div>
                            </div>
                            <div class="focus-list">
                                <div class="focus-item">
                                    <i class="ti ti-trophy"></i>
                                    <div>
                                        <strong><?php echo e(__('Top Event')); ?></strong>
                                        <span><?php echo e($topEvent?->title ?? __('No event data yet')); ?><?php echo e($topEvent ? ' - ' . number_format($topEvent->rate, 1) . '%' : ''); ?></span>
                                    </div>
                                </div>
                                <div class="focus-item">
                                    <i class="ti ti-activity-heartbeat"></i>
                                    <div>
                                        <strong><?php echo e(__('Top Department')); ?></strong>
                                        <span><?php echo e($topDepartment?->name ?? __('No department data yet')); ?><?php echo e($topDepartment ? ' - ' . number_format($topDepartment->rate, 1) . '%' : ''); ?></span>
                                    </div>
                                </div>
                                <div class="focus-item">
                                    <i class="ti ti-alert-triangle"></i>
                                    <div>
                                        <strong><?php echo e(__('Attention Area')); ?></strong>
                                        <span><?php echo e($bottomEvent?->title ?? __('No event data yet')); ?><?php echo e($bottomEvent ? ' - ' . number_format($bottomEvent->rate, 1) . '%' : ''); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card metric h-100">
                    <div class="card-body">
                        <div class="metric-top">
                            <div class="metric-icon"><i class="ti ti-arrow-up-right-circle"></i></div>
                            <span class="churchmeet-badge success"><?php echo e(__('Top turnout')); ?></span>
                        </div>
                        <span class="label"><?php echo e(__('Best Performing Event')); ?></span>
                        <strong><?php echo e(number_format($topEvent?->rate ?? 0, 1)); ?>%</strong>
                        <span class="note"><?php echo e($analyticsSummary['highest_attendance_event'] ?? __('No event data yet')); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card metric h-100">
                    <div class="card-body">
                        <div class="metric-top">
                            <div class="metric-icon"><i class="ti ti-arrow-down-right-circle"></i></div>
                            <span class="churchmeet-badge warning"><?php echo e(__('Review scheduling')); ?></span>
                        </div>
                        <span class="label"><?php echo e(__('Needs Attention')); ?></span>
                        <strong><?php echo e(number_format($bottomEvent?->rate ?? 0, 1)); ?>%</strong>
                        <span class="note"><?php echo e($analyticsSummary['lowest_attendance_event'] ?? __('No event data yet')); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card metric h-100">
                    <div class="card-body">
                        <div class="metric-top">
                            <div class="metric-icon"><i class="ti ti-building-community"></i></div>
                            <span class="churchmeet-badge"><?php echo e(__('Leadership signal')); ?></span>
                        </div>
                        <span class="label"><?php echo e(__('Most Active Department')); ?></span>
                        <strong><?php echo e($analyticsSummary['most_active_dept'] ?? __('N/A')); ?></strong>
                        <span class="note"><?php echo e(__('Highest participation count across event records.')); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card metric h-100">
                    <div class="card-body">
                        <div class="metric-top">
                            <div class="metric-icon"><i class="ti ti-target-arrow"></i></div>
                            <span class="churchmeet-badge"><?php echo e(__('Planning window')); ?></span>
                        </div>
                        <span class="label"><?php echo e(__('Unreached Capacity')); ?></span>
                        <strong><?php echo e(number_format($gapRate, 1)); ?>%</strong>
                        <span class="note"><?php echo e(__('Gap between current turnout and full church attendance.')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-header card-head">
                        <span class="section-kicker"><?php echo e(__('Event Trend')); ?></span>
                        <h5 class="mb-1"><?php echo e(__('Attendance Rate Across Events')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('A rate-based view of how each published event performed against your current member base.')); ?></p>
                    </div>
                    <div class="chart-body">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($eventLeaderboard->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No event analytics yet')); ?></div><div><?php echo e(__('Publish events and capture attendance to populate this chart.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="chart-wrap"><canvas id="churchmeetEventAnalyticsChart"></canvas></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-header card-head">
                        <span class="section-kicker"><?php echo e(__('Pulse')); ?></span>
                        <h5 class="mb-1"><?php echo e(__('Ministry Pulse')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('A compact reading of turnout strength and forecast momentum.')); ?></p>
                    </div>
                    <div class="card-body">
                        <div class="ring" data-ring-angle="<?php echo e($ringAngle); ?>"><div><strong><?php echo e(number_format($avgRate, 1)); ?>%</strong><span><?php echo e(__('Average event attendance')); ?></span></div></div>
                        <div class="mini-grid">
                            <div class="mini"><small><?php echo e(__('Forecast')); ?></small><strong><?php echo e(number_format($predictedRate, 1)); ?>%</strong></div>
                            <div class="mini"><small><?php echo e(__('Momentum')); ?></small><strong><?php echo e($predictedLift >= 0 ? '+' : ''); ?><?php echo e(number_format($predictedLift, 1)); ?></strong></div>
                            <div class="mini"><small><?php echo e(__('Best Events')); ?></small><strong><?php echo e(\Illuminate\Support\Str::limit($analyticsSummary['highest_attendance_event'] ?? __('N/A'), 20)); ?></strong></div>
                            <div class="mini"><small><?php echo e(__('Lowest Events')); ?></small><strong><?php echo e(\Illuminate\Support\Str::limit($analyticsSummary['lowest_attendance_event'] ?? __('N/A'), 20)); ?></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-5">
                <div class="card insight h-100">
                    <div class="card-header card-head">
                        <span class="section-kicker"><?php echo e(__('Insight')); ?></span>
                        <h5 class="mb-1"><?php echo e(__('Spiritual Insight and Recommended Actions')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('A practical reading of engagement patterns for leadership follow-up.')); ?></p>
                    </div>
                    <div class="card-body">
                        <div class="quote"><?php echo e($spiritualInsight); ?></div>
                        <ul class="actions">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $actionSuggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="ti ti-check"></i><span><?php echo e($tip); ?></span></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card ranking h-100">
                    <div class="card-header card-head">
                        <span class="section-kicker"><?php echo e(__('Leaderboard')); ?></span>
                        <h5 class="mb-1"><?php echo e(__('Events Leaderboard')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('Quick ranking of your strongest and weakest events by attendance rate.')); ?></p>
                    </div>
                    <div class="card-body">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($eventLeaderboard->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No leaderboard available')); ?></div><div><?php echo e(__('This section fills automatically once attendance is tracked.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="rank-list">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $eventLeaderboard->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="rank">
                                        <span class="rank-badge">#<?php echo e($loop->iteration); ?></span>
                                        <div>
                                            <div class="rank-title"><?php echo e($event->title); ?></div>
                                            <div class="rank-sub"><?php echo e($event->rate >= 75 ? __('Strong turnout and healthy member pull.') : ($event->rate >= 50 ? __('Solid turnout with room to improve follow-up.') : __('Low turnout. Review communication and timing.'))); ?></div>
                                        </div>
                                        <div class="rank-rate"><?php echo e(number_format($event->rate, 1)); ?>%</div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-header card-head">
                        <span class="section-kicker"><?php echo e(__('Departments')); ?></span>
                        <h5 class="mb-1"><?php echo e(__('Department Attendance Rate')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('Participation rate by department, normalized against registered members in each department.')); ?></p>
                    </div>
                    <div class="chart-body">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($departmentInsights->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No department comparison yet')); ?></div><div><?php echo e(__('Department-based attendance will appear here once members are mapped and checked in.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="chart-wrap"><canvas id="churchmeetDepartmentChart"></canvas></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card h-100">
                    <div class="card-header card-head">
                        <span class="section-kicker"><?php echo e(__('Spotlight')); ?></span>
                        <h5 class="mb-1"><?php echo e(__('Department Spotlight')); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(__('Your most responsive ministry areas right now.')); ?></p>
                    </div>
                    <div class="card-body">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($departmentInsights->isEmpty()): ?>
                            <div class="empty"><div><div class="fw-semibold mb-2"><?php echo e(__('No department spotlight yet')); ?></div><div><?php echo e(__('Assign members to departments and capture attendance to unlock this view.')); ?></div></div></div>
                        <?php else: ?>
                            <div class="dept-top">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departmentInsights->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="dept-box"><small><?php echo e($department->name); ?></small><strong><?php echo e(number_format($department->rate, 1)); ?>%</strong><span><?php echo e($department->present); ?> <?php echo e(__('present')); ?> / <?php echo e($department->total); ?> <?php echo e(__('members')); ?></span></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-head">
                <span class="section-kicker"><?php echo e(__('Breakdown')); ?></span>
                <h5 class="mb-1"><?php echo e(__('Department Comparison Detail')); ?></h5>
                <p class="text-muted mb-0"><?php echo e(__('Detailed comparison of turnout by department, including absolute participation and normalized attendance rate.')); ?></p>
            </div>
            <div class="table-responsive">
                <table class="table churchmeet-table analytics-table align-middle mb-0">
                    <thead><tr><th><?php echo e(__('Department')); ?></th><th class="text-center"><?php echo e(__('Present')); ?></th><th class="text-center"><?php echo e(__('Total Members')); ?></th><th><?php echo e(__('Rate Progress')); ?></th><th class="text-end"><?php echo e(__('Attendance Rate')); ?></th></tr></thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $departmentInsights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong class="d-block"><?php echo e($department->name); ?></strong><small class="text-muted"><?php echo e($department->rate >= 80 ? __('High consistency') : ($department->rate >= 60 ? __('Stable turnout') : __('Needs encouragement'))); ?></small></td>
                                <td class="text-center fw-semibold"><?php echo e($department->present); ?></td>
                                <td class="text-center text-muted"><?php echo e($department->total); ?></td>
                                <td class="churchmeet-min-width-220"><div class="progress-shell"><div class="progress-fill" data-progress-width="<?php echo e(min(100, $department->rate)); ?>"></div></div></td>
                                <td class="text-end fw-bold <?php echo e($department->rate >= 80 ? 'text-success' : ($department->rate >= 60 ? 'text-primary' : 'text-danger')); ?>"><?php echo e(number_format($department->rate, 1)); ?>%</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4"><?php echo e(__('No department attendance comparison data is currently available.')); ?></td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/js/churchmeet-view-helpers.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const shell = document.querySelector('.churchmeet-analytics');
        const css = getComputedStyle(shell || document.documentElement);
        const primary = (css.getPropertyValue('--churchmeet-primary') || css.getPropertyValue('--primary') || '#145388').trim();
        const deep = (css.getPropertyValue('--churchmeet-deep') || css.getPropertyValue('--deep') || '#0f2d4e').trim();
        const muted = (css.getPropertyValue('--churchmeet-muted') || css.getPropertyValue('--muted') || '#68788f').trim();
        const info = '#2f7cb8';
        const warning = '#c69214';
        const success = '#168873';
        const rose = '#c8614f';
        const teal = '#2f8c86';
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
                data: {labels: eventLabels, datasets: [{label: <?php echo json_encode(__('Attendance Rate (%)'), 15, 512) ?>, data: eventRates, borderColor: primary, backgroundColor: 'rgba(20, 83, 136, 0.12)', fill: true, tension: 0.34, borderWidth: 3, pointRadius: 3, pointHoverRadius: 5, pointBackgroundColor: deep, pointBorderColor: '#ffffff', pointBorderWidth: 2}]},
                options: {responsive: true, maintainAspectRatio: false, plugins: {legend: {labels: {color: muted, boxWidth: 14, usePointStyle: true}}, tooltip: {callbacks: {label: ctx => ctx.formattedValue + '%'}}}, scales: {x: {ticks: {color: muted}, grid: {display: false}}, y: {beginAtZero: true, suggestedMax: 100, ticks: {color: muted, callback: value => value + '%'}, grid: {color: softGrid}}}}
            });
        }

        const deptTarget = document.getElementById('churchmeetDepartmentChart');
        if (deptTarget && departmentLabels.length) {
            new Chart(deptTarget, {
                type: 'bar',
                data: {labels: departmentLabels, datasets: [{label: <?php echo json_encode(__('Attendance Rate (%)'), 15, 512) ?>, data: departmentRates, backgroundColor: [primary, info, success, warning, deep, teal, rose], borderRadius: 10, borderSkipped: false}]},
                options: {indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: {legend: {display: false}, tooltip: {callbacks: {afterLabel: ctx => <?php echo json_encode(__('Present records:'), 15, 512) ?> + ' ' + (departmentPresents[ctx.dataIndex] ?? 0)}}}, scales: {x: {beginAtZero: true, suggestedMax: 100, ticks: {color: muted, callback: value => value + '%'}, grid: {color: softGrid}}, y: {ticks: {color: muted}, grid: {display: false}}}}
            });
        }
    })();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\events\analytics-overall.blade.php ENDPATH**/ ?>