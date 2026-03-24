

<?php $__env->startSection('page-title'); ?>
    <?php echo e($event->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Event Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if($canJoinZoomMeeting): ?>
        <a href="<?php echo e(route('churchmeet.zoom.meetings.join', $attendanceEvent->id)); ?>" class="btn btn-primary btn-sm">
            <i class="ti ti-video"></i> <?php echo e(__('Join Meeting')); ?>

        </a>
    <?php endif; ?>
    <?php if($canCreateZoomMeeting && !$canJoinZoomMeeting): ?>
        <form method="POST" action="<?php echo e(route('churchmeet.zoom.meetings.create', $event->id)); ?>" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-video-plus"></i> <?php echo e(__('Create Zoom Meeting')); ?>

            </button>
        </form>
    <?php endif; ?>
    <a href="<?php echo e(route('churchmeet.events.export.pdf', $event->id)); ?>" class="btn btn-danger btn-sm">
        <i class="ti ti-file-type-pdf"></i> Export PDF
    </a>
    <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> Back to Events
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg,#007bff,#6610f2);">
        <h5 class="mb-0"><i class="ti ti-calendar-event"></i> <?php echo e($event->title); ?></h5>
        <span class="badge bg-white text-dark px-3 py-2"><?php echo e(ucfirst($event->event_type)); ?></span>
    </div>

    <div class="card-body">

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                        type="button" role="tab"><i class="ti ti-info-circle"></i> Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance"
                        type="button" role="tab"><i class="ti ti-users"></i> Attendance</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion"
                        type="button" role="tab"><i class="ti ti-message-dots"></i> Discussion</button>
            </li>
        </ul>

        <div class="tab-content" id="eventTabsContent">

            <!-- Ã°Å¸Å¸Â¦ TAB 1: Overview -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <!-- Overview Info -->
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Status</p>
                                <?php switch($event->status):
                                    case ('draft'): ?> <span class="badge bg-secondary">Draft</span> <?php break; ?>
                                    <?php case ('review'): ?> <span class="badge bg-info text-dark">In Review</span> <?php break; ?>
                                    <?php case ('approved'): ?> <span class="badge bg-success">Approved</span> <?php break; ?>
                                    <?php case ('published'): ?> <span class="badge bg-primary">Published</span> <?php break; ?>
                                    <?php case ('revision_required'): ?> <span class="badge bg-warning text-dark">Revision Required</span> <?php break; ?>
                                    <?php case ('resubmitted'): ?> <span class="badge bg-secondary ">Resubmitted</span> <?php break; ?>
                                <?php endswitch; ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Recurrence</p>
                                <span class="text-dark"><?php echo e(ucfirst($event->recurrence)); ?></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Venue / Link</p>
                                <span><?php echo e($event->venue ?? 'Ã¢â‚¬â€'); ?></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Start Time</p>
                                <strong><?php echo e($event->formatted_start); ?></strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">End Time</p>
                                <strong><?php echo e($event->formatted_end); ?></strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Duration</p>
                                <?php
                                    $totalDuration = $event->programs->sum('duration');
                                    $hours = floor($totalDuration / 60);
                                    $minutes = $totalDuration % 60;
                                ?>
                                <strong><?php echo e($hours ? $hours.'h ' : ''); ?><?php echo e($minutes); ?>m total</strong>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1 text-muted small">Lead Minister</p>
                                    <strong><?php echo e($event->lead->name ?? 'Ã¢â‚¬â€'); ?></strong>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1 text-muted small">Assistant / Co-Leader</p>
                                    <strong><?php echo e($event->assistant->name ?? 'Ã¢â‚¬â€'); ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p class="mb-1 text-muted small">Description</p>
                            <p class="text-dark"><?php echo nl2br(e($event->description ?? 'No description provided.')); ?></p>
                        </div>

                        <?php if($attendanceEvent): ?>
                            <div class="mt-4 p-3 rounded bg-light border">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div>
                                        <p class="mb-1 text-muted small"><?php echo e(__('Zoom Meeting')); ?></p>
                                        <strong><?php echo e($attendanceEvent->meeting_id ? __('Configured') : __('Not yet created')); ?></strong>
                                        <?php if($attendanceEvent->meeting_id): ?>
                                            <div class="small text-muted mt-1">
                                                <?php echo e(__('Meeting ID')); ?>: <?php echo e($attendanceEvent->meeting_id); ?>

                                                <?php if($attendanceEvent->meeting_passcode): ?>
                                                    Ã¢â‚¬Â¢ <?php echo e(__('Passcode')); ?>: <?php echo e($attendanceEvent->meeting_passcode); ?>

                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <?php if($canJoinZoomMeeting): ?>
                                            <a href="<?php echo e(route('churchmeet.zoom.meetings.join', $attendanceEvent->id)); ?>" class="btn btn-sm btn-outline-primary">
                                                <?php echo e(__('Open Join Room')); ?>

                                            </a>
                                        <?php elseif($canCreateZoomMeeting): ?>
                                            <form method="POST" action="<?php echo e(route('churchmeet.zoom.meetings.create', $event->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-primary"><?php echo e(__('Create Zoom Meeting')); ?></button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Program Schedule -->
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="ti ti-clipboard-list"></i> Program Schedule</h6>
                                <span class="small text-muted">Total: <?php echo e($event->programs->count()); ?> items</span>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Program Item</th>
                                            <th>Duration</th>
                                            <th>Leader</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $event->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><strong><?php echo e($program->program_item); ?></strong></td>
                                                <td><?php echo e($program->duration); ?> min</td>
                                                <td><?php echo e($program->leader->name ?? 'Ã¢â‚¬â€'); ?></td>
                                                <td class="text-muted"><?php echo e($program->note ?? 'Ã¢â‚¬â€'); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-3">No program items added.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ã°Å¸Å¸Â© TAB 2: Attendance -->
            <div class="tab-pane fade" id="attendance" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="ti ti-users"></i> Attendance Summary</h6>
                            </div>
                            <div class="card-body">
                                <?php if($attendanceEvent): ?>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Registered: <strong><?php echo e($attendanceStats['total_registered']); ?></strong></li>
                                        <li class="list-group-item text-success">Present: <strong><?php echo e($attendanceStats['present']); ?></strong></li>
                                        <li class="list-group-item text-danger">Absent: <strong><?php echo e($attendanceStats['absent']); ?></strong></li>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No attendance record available for this event.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="ti ti-paperclip"></i> Attachments</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                    $attachments = is_array($event->attachments)
                                        ? $event->attachments
                                        : json_decode($event->attachments ?? '[]', true);
                                ?>
                                <?php if(!empty($attachments)): ?>
                                    <ul class="list-group list-group-flush">
                                        <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="ti ti-file"></i> <?php echo e(basename($file)); ?></span>
                                                <a href="<?php echo e(asset('storage/'.$file)); ?>" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No files attached.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ã°Å¸Å¸Â¨ TAB 3: Discussion / Review Comments -->
            <div class="tab-pane fade" id="discussion" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="ti ti-message-dots"></i> Reviewer Discussion</h6>
                    </div>
                    <div class="card-body">
                        <div class="chat-container bg-light rounded p-3" style="max-height: 400px; overflow-y: auto;">
                            <?php $__empty_1 = true; $__currentLoopData = $reviewComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="mb-3 d-flex <?php echo e($comment->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start'); ?>">
                                    <div class="p-3 rounded <?php echo e($comment->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border'); ?>"
                                         style="max-width: 80%;">
                                        <div class="small fw-bold mb-1">
                                            <?php echo e($comment->user?->name ?? 'System'); ?>

                                            <span class="text-muted small">
                                                Ã¢â‚¬Â¢ <?php echo e(\Carbon\Carbon::parse($comment->commented_at)->diffForHumans()); ?>

                                            </span>
                                        </div>
                                        <div><?php echo nl2br(e($comment->comment)); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted text-center small mb-0">No discussion yet for this event.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End Tab Content -->
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\events\show.blade.php ENDPATH**/ ?>