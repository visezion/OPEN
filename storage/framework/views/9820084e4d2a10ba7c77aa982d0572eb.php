<?php $__env->startSection('page-title', __('Member Attendance Report')); ?>
<?php $__env->startSection('page-breadcrumb', __('ChurchMeet,Attendance Reports,Member Report')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchmeet.attendance.reports.dashboard')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-chart-donut-3 me-1"></i><?php echo e(__('Reports Dashboard')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $records = $member->attendanceRecords;
    $totalRecords = $records->count();
    $presentRate = round(($records->where('status', 'present')->count() / max(1, $totalRecords)) * 100, 1);
    $longestStreak = $records->max('streak_count') ?? 0;
?>

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-user-heart"></i><?php echo e(__('Member Report')); ?></span>
            <h2 class="churchmeet-title"><?php echo e($member->name); ?></h2>
            <p class="churchmeet-copy mb-0"><?php echo e(__('A unified ChurchMeet view of member attendance history, consistency, and recent participation records.')); ?></p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Events Attended')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($totalRecords); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Attendance records currently attached to this member.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Attendance Rate')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($presentRate); ?>%</strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Present records as a share of all tracked entries.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Longest Streak')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($longestStreak); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Best consistency streak recorded for this member.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Member ID')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e(\Illuminate\Support\Str::limit((string) ($member->member_id ?? __('N/A')), 14)); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('ChurchMeet identity reference for reporting and follow-up.')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5><?php echo e(__('Member Snapshot')); ?></h5>
                    <p><?php echo e(__('Branded summary cards keep the reporting pages visually aligned.')); ?></p>
                </div>
                <div class="churchmeet-section-body">
                    <div class="churchmeet-stack">
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Email')); ?></span>
                            <span class="value"><?php echo e($member->email ?: __('Not provided')); ?></span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Phone')); ?></span>
                            <span class="value"><?php echo e($member->phone ?: __('Not provided')); ?></span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Branch')); ?></span>
                            <span class="value"><?php echo e(optional($member->branch)->name ?? __('Unassigned')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5><?php echo e(__('Attendance Timeline')); ?></h5>
                    <p><?php echo e(__('Detailed event-by-event participation in the same ChurchMeet reporting style.')); ?></p>
                </div>
                <div class="table-responsive">
                    <table class="table churchmeet-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Events')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Device')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $statusClass = $record->status === 'present' ? 'success' : ($record->status === 'late' ? 'warning' : 'danger');
                                ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e(optional(optional($record->attendanceEvent)->event)->title ?? __('Untitled event')); ?></td>
                                    <td><?php echo e(optional(optional($record->attendanceEvent)->event)->date ?? __('N/A')); ?></td>
                                    <td><span class="churchmeet-badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($record->status)); ?></span></td>
                                    <td><?php echo e(strtoupper((string) $record->device_used) ?: __('N/A')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4"><?php echo e(__('No attendance records found for this member.')); ?></td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\reports\member_report.blade.php ENDPATH**/ ?>