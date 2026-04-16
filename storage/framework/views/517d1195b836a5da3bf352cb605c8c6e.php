<?php $__env->startSection('page-title', __('Events Attendance Report')); ?>
<?php $__env->startSection('page-breadcrumb', __('ChurchMeet,Attendance Reports,Events Report')); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('churchmeet.attendance.reports.dashboard')); ?>" class="btn btn-sm btn-outline-primary">
            <i class="ti ti-chart-donut-3 me-1"></i><?php echo e(__('Reports Dashboard')); ?>

        </a>
        <a href="<?php echo e(route('churchmeet.events.show', $attendanceEvent->event_id)); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-calendar-event me-1"></i><?php echo e(__('Open Event')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $event = $attendanceEvent->event;
    $records = $attendanceEvent->records;
    $totalAttendance = $records->count();
    $onsiteAttendance = $records->whereIn('device_used', ['manual', 'qr', 'kiosk', 'face_ai'])->count();
    $onlineAttendance = $records->whereIn('device_used', ['online', 'zoom', 'youtube'])->count();
    $presentAttendance = $records->where('status', 'present')->count();
?>

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-report-analytics"></i><?php echo e(__('Events Report')); ?></span>
            <h2 class="churchmeet-title"><?php echo e($event->title ?? __('Untitled event')); ?></h2>
            <p class="churchmeet-copy mb-0"><?php echo e(__('A branded ChurchMeet report of event turnout, channel split, and individual attendance records.')); ?></p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Total Attendance')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($totalAttendance); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Total records captured for this attendance event.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Onsite')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($onsiteAttendance); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Manual, QR, kiosk, and face-AI check-ins.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Online')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($onlineAttendance); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Digital attendance captured from online channels.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Present Status')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($presentAttendance); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Confirmed present records for this event.')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5><?php echo e(__('Events Snapshot')); ?></h5>
                    <p><?php echo e(__('The same branded summary structure used across ChurchMeet reporting pages.')); ?></p>
                </div>
                <div class="churchmeet-section-body">
                    <div class="churchmeet-stack">
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Events Date')); ?></span>
                            <span class="value"><?php echo e($event->date ?? __('N/A')); ?></span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Mode')); ?></span>
                            <span class="value"><?php echo e(ucfirst($attendanceEvent->mode ?? 'in-person')); ?></span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Platform')); ?></span>
                            <span class="value"><?php echo e(ucfirst($attendanceEvent->online_platform ?: ($attendanceEvent->mode ?? 'in-person'))); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5><?php echo e(__('Attendance Register')); ?></h5>
                    <p><?php echo e(__('Member-by-member attendance detail with consistent table styling and status badges.')); ?></p>
                </div>
                <div class="table-responsive">
                    <table class="table churchmeet-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Member')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Check-In')); ?></th>
                                <th><?php echo e(__('Device')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $statusClass = $record->status === 'present' ? 'success' : ($record->status === 'late' ? 'warning' : 'danger');
                                ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($record->member->name ?? __('Visitor')); ?></td>
                                    <td><span class="churchmeet-badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($record->status)); ?></span></td>
                                    <td><?php echo e($record->check_in_time); ?></td>
                                    <td><?php echo e(strtoupper((string) $record->device_used) ?: __('N/A')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4"><?php echo e(__('No attendance records have been captured for this event yet.')); ?></td>
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\reports\event_report.blade.php ENDPATH**/ ?>