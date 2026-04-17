<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $event = $attendanceEvent->event;
    $platform = strtolower((string) $attendanceEvent->online_platform);
    $platformLabel = $platform !== '' ? strtoupper($platform) : __('Online');
?>

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-user-check"></i><?php echo e(__('ChurchMeet Check-In')); ?></span>
            <h1 class="churchmeet-title"><?php echo e($event->title); ?></h1>
            <p class="churchmeet-copy mb-0"><?php echo e(__('Confirm your presence and join the live session from one branded check-in page.')); ?></p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Platform')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($platformLabel); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Attendance will be recorded for this online session.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Mode')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e(ucfirst($attendanceEvent->mode ?: 'online')); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('This page is optimized for quick member confirmation.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Meeting Access')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e($attendanceEvent->meeting_link ? __('Ready') : __('Pending')); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('Use the join link below if a room is available.')); ?></span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label"><?php echo e(__('Events')); ?></span>
                    <strong class="churchmeet-stat-value"><?php echo e(\Illuminate\Support\Str::limit($event->title, 16)); ?></strong>
                    <span class="churchmeet-stat-note"><?php echo e(__('ChurchMeet keeps your attendance and room access in sync.')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5><?php echo e(__('Confirm Presence')); ?></h5>
                    <p><?php echo e(__('Use one tap to mark yourself present before joining the session.')); ?></p>
                </div>
                <div class="churchmeet-section-body">
                    <form action="<?php echo e(route('churchmeet.attendance.onlineCheckIn', $attendanceEvent->id)); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="ti ti-check me-1"></i><?php echo e(__('I Am Here')); ?>

                        </button>
                    </form>

                    <div class="churchmeet-stack">
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Session Type')); ?></span>
                            <span class="value"><?php echo e(ucfirst($attendanceEvent->mode ?: 'online')); ?></span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label"><?php echo e(__('Room Platform')); ?></span>
                            <span class="value"><?php echo e($platformLabel); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5><?php echo e(__('Join Session')); ?></h5>
                    <p><?php echo e(__('Meeting access stays in the same ChurchMeet visual language as the rest of the module.')); ?></p>
                </div>
                <div class="churchmeet-section-body">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($platform === 'zoom' && $attendanceEvent->meeting_link): ?>
                        <a href="<?php echo e($attendanceEvent->meeting_link); ?>" target="_blank" rel="noopener" class="btn btn-outline-primary">
                            <i class="ti ti-brand-zoom me-1"></i><?php echo e(__('Join Zoom Meeting')); ?>

                        </a>
                    <?php elseif($platform === 'livekit'): ?>
                        <a href="<?php echo e(route('churchmeet.meetings.join', $attendanceEvent->public_join_key)); ?>" target="_blank" rel="noopener" class="btn btn-outline-primary">
                            <i class="ti ti-brand-webrtc me-1"></i><?php echo e(__('Open Meeting Room')); ?>

                        </a>
                    <?php elseif($platform === 'youtube' && $attendanceEvent->meeting_link): ?>
                        <iframe
                            class="churchmeet-embed"
                            src="<?php echo e($attendanceEvent->meeting_link); ?>"
                            title="<?php echo e(__('Live stream player')); ?>"
                            allowfullscreen></iframe>
                    <?php else: ?>
                        <div class="churchmeet-empty">
                            <div>
                                <div class="fw-semibold mb-2"><?php echo e(__('Meeting link not available')); ?></div>
                                <div><?php echo e(__('The organizer has not published a join link for this session yet.')); ?></div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\check_in.blade.php ENDPATH**/ ?>