<?php $__env->startSection('page-title'); ?>
    <?php echo e($event->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Event Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canJoinOnlineMeeting): ?>
        <a href="<?php echo e(route('churchmeet.meetings.join', $attendanceEvent->id)); ?>" class="btn btn-primary btn-sm">
            <i class="ti ti-video"></i> <?php echo e(__('Join Meeting')); ?>

        </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCreateZoomMeeting && !$canJoinOnlineMeeting): ?>
        <form method="POST" action="<?php echo e(route('churchmeet.zoom.meetings.create', $event->id)); ?>" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-video-plus"></i> <?php echo e(__('Create Zoom Meeting')); ?>

            </button>
        </form>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCreateJitsiMeeting && !$canJoinOnlineMeeting): ?>
        <form method="POST" action="<?php echo e(route('churchmeet.jitsi.meetings.create', $event->id)); ?>" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-brand-tabler"></i> <?php echo e(__('Create Jitsi Room')); ?>

            </button>
        </form>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canCreateLivekitMeeting && !$canJoinOnlineMeeting): ?>
        <form method="POST" action="<?php echo e(route('churchmeet.livekit.meetings.create', $event->id)); ?>" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-brand-webrtc"></i> <?php echo e(__('Create LiveKit Room')); ?>

            </button>
        </form>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <a href="<?php echo e(route('churchmeet.events.export.pdf', $event->id)); ?>" class="btn btn-danger btn-sm">
        <i class="ti ti-file-type-pdf"></i> <?php echo e(__('Export PDF')); ?>

    </a>
    <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to Events')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalDuration = (int) $event->programs->sum('duration');
    $hours = intdiv($totalDuration, 60);
    $minutes = $totalDuration % 60;

    $totalRegistered = (int) ($attendanceStats['total_registered'] ?? 0);
    $presentCount = (int) ($attendanceStats['present'] ?? 0);
    $absentCount = (int) ($attendanceStats['absent'] ?? 0);
    $attendanceRate = $totalRegistered > 0 ? (int) round(($presentCount / $totalRegistered) * 100) : 0;

    $statusLabel = ucfirst((string) $event->status);
    $statusClass = 'bg-secondary';
    if ($event->status === 'review') {
        $statusClass = 'bg-info text-dark';
        $statusLabel = __('In Review');
    } elseif ($event->status === 'approved') {
        $statusClass = 'bg-success';
    } elseif ($event->status === 'published') {
        $statusClass = 'bg-primary';
    } elseif ($event->status === 'revision_required') {
        $statusClass = 'bg-warning text-dark';
        $statusLabel = __('Revision Required');
    } elseif ($event->status === 'draft') {
        $statusLabel = __('Draft');
    }
?>

<div class="church-event-show">
    <div class="card event-hero mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h4 class="mb-1"><?php echo e($event->title); ?></h4>
                    <p class="hero-copy mb-0"><?php echo e(__('Complete event profile, attendance outcome, and online meeting controls in one page.')); ?></p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                    <span class="badge bg-light text-dark border"><?php echo e(ucfirst((string) ($event->event_type ?? 'event'))); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label"><?php echo e(__('Start')); ?></span>
                <span class="metric-value"><?php echo e($event->formatted_start); ?></span>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label"><?php echo e(__('Duration')); ?></span>
                <span class="metric-value"><?php echo e($hours ? $hours . 'h ' : ''); ?><?php echo e($minutes); ?>m</span>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label"><?php echo e(__('Program Items')); ?></span>
                <span class="metric-value"><?php echo e($event->programs->count()); ?></span>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label"><?php echo e(__('Attendance Rate')); ?></span>
                <span class="metric-value"><?php echo e($attendanceRate); ?>%</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                        <i class="ti ti-info-circle me-1"></i><?php echo e(__('Overview')); ?>

                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                        <i class="ti ti-users me-1"></i><?php echo e(__('Attendance')); ?>

                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion" type="button" role="tab">
                        <i class="ti ti-message-dots me-1"></i><?php echo e(__('Discussion')); ?>

                    </button>
                </li>
            </ul>

            <div class="tab-content" id="eventTabsContent">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="detail-grid mb-3">
                                <div class="detail-item">
                                    <label><?php echo e(__('Recurrence')); ?></label>
                                    <span><?php echo e(ucfirst((string) ($event->recurrence ?? 'none'))); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label><?php echo e(__('Venue / Link')); ?></label>
                                    <span><?php echo e($event->venue ?: '-'); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label><?php echo e(__('Start Time')); ?></label>
                                    <span><?php echo e($event->formatted_start); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label><?php echo e(__('End Time')); ?></label>
                                    <span><?php echo e($event->formatted_end); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label><?php echo e(__('Lead Minister')); ?></label>
                                    <span><?php echo e($event->lead->name ?? '-'); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label><?php echo e(__('Assistant / Co-Leader')); ?></label>
                                    <span><?php echo e($event->assistant->name ?? '-'); ?></span>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0"><?php echo e(__('Description')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0 text-dark"><?php echo nl2br(e($event->description ?? __('No description provided.'))); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0"><?php echo e(__('Meeting Control')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <p class="muted-copy small mb-2"><?php echo e(__('Platform')); ?></p>
                                    <h6 class="mb-3"><?php echo e(ucfirst($meetingPlatform ?: 'Not configured')); ?></h6>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent): ?>
                                        <div class="small mb-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->meeting_id): ?>
                                                <div class="mb-1"><?php echo e(__('Meeting ID')); ?>: <strong><?php echo e($attendanceEvent->meeting_id); ?></strong></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->meeting_passcode): ?>
                                                <div class="mb-1"><?php echo e(__('Passcode')); ?>: <strong><?php echo e($attendanceEvent->meeting_passcode); ?></strong></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->meeting_link): ?>
                                                <a href="<?php echo e($attendanceEvent->meeting_link); ?>" target="_blank" rel="noopener" class="link-primary small">
                                                    <?php echo e(__('Open External Link')); ?>

                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="d-grid gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canJoinOnlineMeeting): ?>
                                            <a href="<?php echo e(route('churchmeet.meetings.join', $attendanceEvent->id)); ?>" class="btn btn-outline-primary btn-sm">
                                                <?php echo e(__('Open Join Room')); ?>

                                            </a>
                                        <?php elseif($canCreateZoomMeeting): ?>
                                            <form method="POST" action="<?php echo e(route('churchmeet.zoom.meetings.create', $event->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100"><?php echo e(__('Create Zoom Meeting')); ?></button>
                                            </form>
                                        <?php elseif($canCreateJitsiMeeting): ?>
                                            <form method="POST" action="<?php echo e(route('churchmeet.jitsi.meetings.create', $event->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100"><?php echo e(__('Create Jitsi Room')); ?></button>
                                            </form>
                                        <?php elseif($canCreateLivekitMeeting): ?>
                                            <form method="POST" action="<?php echo e(route('churchmeet.livekit.meetings.create', $event->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100"><?php echo e(__('Create LiveKit Room')); ?></button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted small"><?php echo e(__('No online meeting action available for this event.')); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><?php echo e(__('Program Schedule')); ?></h6>
                                    <small class="text-muted"><?php echo e(__('Total')); ?>: <?php echo e($event->programs->count()); ?></small>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="churchmeet-col-60">#</th>
                                                    <th><?php echo e(__('Program Item')); ?></th>
                                                    <th class="churchmeet-col-140"><?php echo e(__('Duration')); ?></th>
                                                    <th class="churchmeet-col-200"><?php echo e(__('Leader')); ?></th>
                                                    <th><?php echo e(__('Notes')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $event->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($loop->iteration); ?></td>
                                                        <td><strong><?php echo e($program->program_item); ?></strong></td>
                                                        <td><?php echo e($program->duration); ?> <?php echo e(__('min')); ?></td>
                                                        <td><?php echo e($program->leader->name ?? '-'); ?></td>
                                                        <td class="text-muted"><?php echo e($program->note ?? '-'); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4"><?php echo e(__('No program items added.')); ?></td>
                                                    </tr>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="attendance" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <div class="metric-card">
                                <span class="metric-label"><?php echo e(__('Total Registered')); ?></span>
                                <span class="metric-value"><?php echo e($totalRegistered); ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="metric-card">
                                <span class="metric-label"><?php echo e(__('Present')); ?></span>
                                <span class="metric-value"><?php echo e($presentCount); ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="metric-card">
                                <span class="metric-label"><?php echo e(__('Absent')); ?></span>
                                <span class="metric-value"><?php echo e($absentCount); ?></span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0"><?php echo e(__('Attachments')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $attachments = is_array($event->attachments)
                                            ? $event->attachments
                                            : json_decode($event->attachments ?? '[]', true);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($attachments)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-sm align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(__('File')); ?></th>
                                                        <th class="churchmeet-col-140"><?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e(basename($file)); ?></td>
                                                            <td>
                                                                <a href="<?php echo e(asset('storage/'.$file)); ?>" target="_blank" class="btn btn-outline-primary btn-sm"><?php echo e(__('View')); ?></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0"><?php echo e(__('No files attached.')); ?></p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="discussion" role="tabpanel">
                    <div class="d-grid gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviewComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="discussion-item">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <strong><?php echo e($comment->user?->name ?? 'System'); ?></strong>
                                    <span class="discussion-meta"><?php echo e(\Carbon\Carbon::parse($comment->commented_at)->diffForHumans()); ?></span>
                                </div>
                                <div class="discussion-message"><?php echo nl2br(e($comment->comment)); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="discussion-item text-center text-muted">
                                <?php echo e(__('No discussion yet for this event.')); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\events\show.blade.php ENDPATH**/ ?>