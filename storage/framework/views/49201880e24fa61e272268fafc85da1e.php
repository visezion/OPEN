

<?php $__env->startSection('page-title', __('Edit Event')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchmeet.events.create')); ?>" class="btn btn-sm btn-outline-success">
        <i class="ti ti-plus"></i> <?php echo e(__('Create New Event')); ?>

    </a>
    <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-list-details"></i> <?php echo e(__('View All Events')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css')); ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $currentPlatform = old('online_platform', optional($attendanceEvent)->online_platform ?: ($zoomSetting->preferred_platform ?: 'jitsi'));
    $currentMeetingLink = old('meeting_link', optional($attendanceEvent)->meeting_link);
    $currentJitsiDomain = old('jitsi_domain');

    if (!$currentJitsiDomain && $currentPlatform === 'jitsi' && !empty($currentMeetingLink)) {
        $currentJitsiDomain = parse_url($currentMeetingLink, PHP_URL_HOST) ?: preg_replace('#^https?://#i', '', (string) $currentMeetingLink);
        $currentJitsiDomain = strtok((string) $currentJitsiDomain, '/');
    }

    if (!$currentJitsiDomain) {
        $currentJitsiDomain = $zoomSetting->jitsi_server_domain ?: 'meet.jit.si';
    }
?>
<div class="row">
    
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-edit text-primary"></i> <?php echo e(__('Edit Event Details')); ?>

                </h5>
                <small class="text-muted">
                    <?php echo e(__('Modify the event information, timing, or program schedule. Changes apply immediately after saving.')); ?>

                </small>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('churchmeet.events.update', $event->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-calendar-event text-primary"></i> <?php echo e(__('Event Title')); ?>

                        </label>
                        <input type="text" name="title" value="<?php echo e(old('title', $event->title)); ?>" class="form-control" required>
                    </div>

                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-category text-success"></i> <?php echo e(__('Event Type')); ?>

                            </label>
                            <input type="text" name="event_type" value="<?php echo e(old('event_type', $event->event_type)); ?>" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-switch-horizontal text-info"></i> <?php echo e(__('Mode')); ?>

                            </label>
                            <select name="mode" class="form-select" required>
                                <option value="onsite" <?php echo e(optional($attendanceEvent)->mode == 'onsite' ? 'selected' : ''); ?>>Onsite</option>
                                <option value="online" <?php echo e(optional($attendanceEvent)->mode == 'online' ? 'selected' : ''); ?>>Online</option>
                                <option value="hybrid" <?php echo e(optional($attendanceEvent)->mode == 'hybrid' ? 'selected' : ''); ?>>Hybrid</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-clock-hour-8 text-warning"></i> <?php echo e(__('Start Time')); ?></label>
                            <input type="datetime-local" name="start_time" value="<?php echo e(old('start_time', $event->start_time ? date('Y-m-d\TH:i', strtotime($event->start_time)) : '')); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-clock-hour-12 text-danger"></i> <?php echo e(__('End Time')); ?></label>
                            <input type="datetime-local" name="end_time" value="<?php echo e(old('end_time', $event->end_time ? date('Y-m-d\TH:i', strtotime($event->end_time)) : '')); ?>" class="form-control">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label fw-semibold"><i class="ti ti-map-pin text-secondary"></i> <?php echo e(__('Venue / Location')); ?></label>
                            <input type="text" name="venue" class="form-control" value="<?php echo e(old('venue', $event->venue)); ?>" placeholder="<?php echo e(__('Enter venue or meeting link')); ?>">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold"><?php echo e(__('Branch')); ?></label>
                            <select class="form-select" name="branch_id" id="branch_id">
                                <option value=""><?php echo e(__('Select Branch')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id', optional($attendanceEvent)->branch_id) == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold"><?php echo e(__('Department')); ?></label>
                            <select class="form-select" name="department_id" id="department_id">
                                <option value=""><?php echo e(__('Select Department')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($department->id); ?>"
                                            data-branch-id="<?php echo e($department->branch_id); ?>"
                                            <?php echo e(old('department_id', optional($attendanceEvent)->department_id) == $department->id ? 'selected' : ''); ?>>
                                        <?php echo e($department->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.0001" class="form-control" name="latitude" value="<?php echo e(old('latitude', $event->latitude)); ?>" placeholder="e.g., 6.5244">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.0001" class="form-control" name="longitude" value="<?php echo e(old('longitude', $event->longitude)); ?>" placeholder="e.g., 3.3792">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Radius (meters)</label>
                            <input type="number" min="1" class="form-control" name="radius_meters" value="<?php echo e(old('radius_meters', $event->radius_meters ?? 100)); ?>">
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="ti ti-repeat text-primary"></i> <?php echo e(__('Recurrence')); ?></label>
                        <select name="recurrence" class="form-select">
                            <option value="none" <?php echo e($event->recurrence == 'none' ? 'selected' : ''); ?>>None</option>
                            <option value="daily" <?php echo e($event->recurrence == 'daily' ? 'selected' : ''); ?>>Daily</option>
                            <option value="weekly" <?php echo e($event->recurrence == 'weekly' ? 'selected' : ''); ?>>Weekly</option>
                            <option value="monthly" <?php echo e($event->recurrence == 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                        </select>
                    </div>

                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-user-star text-info"></i> <?php echo e(__('Lead Minister')); ?></label>
                            <select name="lead_id" class="form-select member-select">
                                <option value="">-- Select Lead Minister --</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>" <?php echo e($event->lead_id == $member->id ? 'selected' : ''); ?>><?php echo e($member->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-user-plus text-success"></i> <?php echo e(__('Assistant / Co-Leader')); ?></label>
                            <select name="assistant_id" class="form-select member-select">
                                <option value="">-- Select Assistant --</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>" <?php echo e($event->assistant_id == $member->id ? 'selected' : ''); ?>><?php echo e($member->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="ti ti-align-left text-secondary"></i> <?php echo e(__('Description')); ?></label>
                        <textarea name="description" rows="4" class="form-control" placeholder="<?php echo e(__('Write a brief description of the event...')); ?>"><?php echo e(old('description', $event->description)); ?></textarea>
                    </div>

                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1"><?php echo e(__('Online Meeting')); ?></h6>
                                    <small class="text-muted"><?php echo e(__('Create or update Zoom, Jitsi, or LiveKit meeting details members will join from OPEN.')); ?></small>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentPlatform === 'livekit' ? !empty(optional($attendanceEvent)->meeting_id) : (optional($attendanceEvent)->meeting_id || optional($attendanceEvent)->meeting_link)): ?>
                                    <a href="<?php echo e(route('churchmeet.meetings.join', $attendanceEvent->public_join_key)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-video"></i> <?php echo e(__('Open Join Room')); ?>

                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Online Platform')); ?></label>
                                    <select name="online_platform" id="online_platform" class="form-select">
                                        <option value=""><?php echo e(__('Select Online Platform')); ?></option>
                                        <option value="zoom" <?php echo e(old('online_platform', optional($attendanceEvent)->online_platform) === 'zoom' ? 'selected' : ''); ?>><?php echo e(__('Zoom')); ?></option>
                                        <option value="jitsi" <?php echo e(old('online_platform', optional($attendanceEvent)->online_platform) === 'jitsi' ? 'selected' : ''); ?>><?php echo e(__('Jitsi Meet')); ?></option>
                                        <option value="livekit" <?php echo e(old('online_platform', optional($attendanceEvent)->online_platform) === 'livekit' ? 'selected' : ''); ?>><?php echo e(__('LiveKit')); ?></option>
                                        <option value="youtube" <?php echo e(old('online_platform', optional($attendanceEvent)->online_platform) === 'youtube' ? 'selected' : ''); ?>><?php echo e(__('YouTube')); ?></option>
                                        <option value="custom" <?php echo e(old('online_platform', optional($attendanceEvent)->online_platform) === 'custom' ? 'selected' : ''); ?>><?php echo e(__('Custom Link')); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Meeting Link')); ?></label>
                                    <input type="text" name="meeting_link" class="form-control" value="<?php echo e(old('meeting_link', optional($attendanceEvent)->meeting_link)); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Meeting ID / Jitsi Room')); ?></label>
                                    <input type="text" name="meeting_id" class="form-control" value="<?php echo e(old('meeting_id', optional($attendanceEvent)->meeting_id)); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo e(__('Passcode (Zoom only)')); ?></label>
                                    <input type="text" name="meeting_passcode" class="form-control" value="<?php echo e(old('meeting_passcode', optional($attendanceEvent)->meeting_passcode)); ?>">
                                </div>
                                <div class="col-md-6" id="jitsi-domain-wrap">
                                    <label class="form-label"><?php echo e(__('Jitsi Domain')); ?></label>
                                    <input type="text" id="jitsi_domain" name="jitsi_domain" class="form-control" value="<?php echo e($currentJitsiDomain); ?>" placeholder="meet.jit.si">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="auto_log_attendance" name="auto_log_attendance" value="1" <?php echo e(old('auto_log_attendance', optional($attendanceEvent)->auto_log_attendance) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="auto_log_attendance"><?php echo e(__('Auto attendance logging')); ?></label>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret) && empty(optional($attendanceEvent)->meeting_id)): ?>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="create_zoom_meeting" name="create_zoom_meeting" value="1">
                                        <label class="form-check-label" for="create_zoom_meeting"><?php echo e(__('Create Zoom meeting now')); ?></label>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($zoomSetting->livekit_enabled) && !empty($zoomSetting->livekit_server_url) && !empty($zoomSetting->livekit_api_key) && !empty($zoomSetting->livekit_api_secret) && empty(optional($attendanceEvent)->meeting_id)): ?>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="create_livekit_meeting" name="create_livekit_meeting" value="1">
                                        <label class="form-check-label" for="create_livekit_meeting"><?php echo e(__('Create LiveKit room now')); ?></label>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="create_jitsi_meeting" name="create_jitsi_meeting" value="1">
                                    <label class="form-check-label" for="create_jitsi_meeting"><?php echo e(__('Create / refresh Jitsi room')); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="ti ti-clipboard-list text-primary"></i> <?php echo e(__('Program Schedule')); ?></label>
                        <div id="program-wrapper">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $event->programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="row mb-3 program-item">
                                    <div class="col-md-4">
                                        <input type="text" name="program_item[]" class="form-control" value="<?php echo e($program->program_item); ?>" placeholder="<?php echo e(__('Program Item')); ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="duration[]" class="form-control" value="<?php echo e($program->duration); ?>" placeholder="<?php echo e(__('Min')); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="leader[]" class="form-select member-select">
                                            <option value="">-- Leader --</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($member->id); ?>" <?php echo e($program->leader_id == $member->id ? 'selected' : ''); ?>><?php echo e($member->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="note[]" class="form-control" value="<?php echo e($program->note); ?>" placeholder="<?php echo e(__('Notes (optional)')); ?>">
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-muted"><?php echo e(__('No program items yet. Add some below.')); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-program">
                            <i class="ti ti-plus"></i> <?php echo e(__('Add Program Item')); ?>

                        </button>
                    </div>

                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy"></i> <?php echo e(__('Update Event')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white py-2">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> <?php echo e(__('Edit Tips & Guidance')); ?></h5>
            </div>
            <div class="card-body small text-muted">
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('What You Can Update:')); ?></p>
                <ul class="ps-3 mb-3">
                    <li>Change the title, venue, and description.</li>
                    <li>Adjust timing and recurrence.</li>
                    <li>Assign or update leaders.</li>
                    <li>Modify program schedule details.</li>
                </ul>
                
                <hr>
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('Additional Guidance:')); ?></p>
                <ul class="ps-3 mb-0">
                    <li>Use the <strong>Ã¢â‚¬Å“Add Program ItemÃ¢â‚¬Â</strong> button to define each part of the service (e.g., Worship, Sermon, etc.).</li>
                    <li>Assign the right <strong>Leader / Person-in-Charge</strong> for each program segment.</li>
                    <li>You can upload <strong>service notes, slides, or images</strong> in the upload section below.</li>
                    <li>After reviewing all details, click <strong>Ã¢â‚¬Å“Submit Event for ReviewÃ¢â‚¬Â</strong> to move it to the next stage.</li>
                    <li>Saved events stay in <strong>Draft</strong> until approved or published by authorized personnel.</li>
                </ul>
                 <hr>
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('To edit or modify an Attendance Menthod:')); ?></p>
                <ul class="ps-3 mb-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent): ?>
                        <a href="<?php echo e(route('churchmeet.attendance_events.edit', $attendanceEvent->id)); ?>"
                           class="btn btn-sm btn-outline-warning"
                           title="<?php echo e(__('Edit Attendance Event')); ?>">
                            <i class="ti ti-pencil">Clink to edit or modify an Attendance Menthod</i>
                        </a>
                    <?php else: ?>
                        <span class="text-muted"><?php echo e(__('Attendance settings will appear after the event is saved.')); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
                <hr>
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('Review Comments / Descussions')); ?></p><br>
                <ul class="ps-0 mb-0"> 
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->reviewerComments->count() > 0): ?>
                <div class="chat-container bg-light rounded shadow-sm p-3 churchmeet-chat-scroll">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $event->reviewerComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="mb-3 d-flex <?php echo e($comment->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start'); ?>">
                            <div class="p-3 rounded churchmeet-chat-bubble <?php echo e($comment->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border'); ?>">
                                <div class="small fw-bold mb-1">
                                    <?php echo e($comment->user?->name ?? 'System'); ?>

                                    <span class="text-muted small">
                                        Ã¢â‚¬Â¢ <?php echo e($comment->commented_at ? \Carbon\Carbon::parse($comment->commented_at)->diffForHumans() : ''); ?>

                                    </span>
                                </div>
                                <div><?php echo nl2br(e($comment->comment)); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted small text-center">No reviewer comments yet. Be the first to add feedback below.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
           
                     <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>   
         </ul>
           </div>
    </div>
      
    </div>
    
</div>


<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('program-wrapper');
    const addBtn = document.getElementById('add-program');
    const branchSelect = document.getElementById('branch_id');
    const departmentSelect = document.getElementById('department_id');
    const createZoomMeeting = document.getElementById('create_zoom_meeting');
    const createJitsiMeeting = document.getElementById('create_jitsi_meeting');
    const createLivekitMeeting = document.getElementById('create_livekit_meeting');
    const onlinePlatform = document.getElementById('online_platform');
    const modeSelect = document.querySelector('select[name="mode"]');
    const jitsiDomainWrap = document.getElementById('jitsi-domain-wrap');
    const jitsiDomainInput = document.getElementById('jitsi_domain');

    function initializeMemberSelect(scope = document) {
        if (!(window.$ && $.fn && $.fn.select2)) {
            return;
        }

        $(scope).find('.member-select').each(function () {
            const $select = $(this);
            if ($select.hasClass('select2-hidden-accessible')) {
                return;
            }

            $select.select2({
                placeholder: 'Search member...',
                allowClear: true,
                width: '100%'
            });
        });
    }

    addBtn.addEventListener('click', () => {
        const row = document.createElement('div');
        row.classList.add('row', 'mb-3', 'program-item');
        row.innerHTML = `
            <div class="col-md-4"><input type="text" name="program_item[]" class="form-control" placeholder="Program Item"></div>
            <div class="col-md-2"><input type="number" name="duration[]" class="form-control" placeholder="Min"></div>
            <div class="col-md-3">
                <select name="leader[]" class="form-select member-select">
                    <option value="">-- Leader --</option>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3"><input type="text" name="note[]" class="form-control" placeholder="Notes (optional)"></div>
        `;
        wrapper.appendChild(row);
        initializeMemberSelect(row);
    });

    function filterDepartments() {
        if (!branchSelect || !departmentSelect) {
            return;
        }

        const branchId = branchSelect.value;

        Array.from(departmentSelect.options).forEach((option, index) => {
            if (index === 0) {
                option.hidden = false;
                return;
            }

            option.hidden = branchId !== '' && option.dataset.branchId !== branchId;
        });

        if (departmentSelect.selectedOptions[0]?.hidden) {
            departmentSelect.value = '';
        }
    }

    function syncZoomDefaults() {
        if (createZoomMeeting?.checked) {
            onlinePlatform.value = 'zoom';
            if (createJitsiMeeting) {
                createJitsiMeeting.checked = false;
            }
            if (createLivekitMeeting) {
                createLivekitMeeting.checked = false;
            }
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    function syncJitsiDefaults() {
        if (createJitsiMeeting?.checked) {
            onlinePlatform.value = 'jitsi';
            if (createZoomMeeting) {
                createZoomMeeting.checked = false;
            }
            if (createLivekitMeeting) {
                createLivekitMeeting.checked = false;
            }
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    function syncLivekitDefaults() {
        if (createLivekitMeeting?.checked) {
            onlinePlatform.value = 'livekit';
            if (createZoomMeeting) {
                createZoomMeeting.checked = false;
            }
            if (createJitsiMeeting) {
                createJitsiMeeting.checked = false;
            }
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    function toggleJitsiDomain() {
        if (jitsiDomainWrap) {
            jitsiDomainWrap.style.display = onlinePlatform.value === 'jitsi' ? '' : 'none';
        }
    }

    function syncPlatformToggles() {
        if (!onlinePlatform) {
            return;
        }

        if (onlinePlatform.value === 'zoom') {
            createZoomMeeting && (createZoomMeeting.checked = createZoomMeeting.checked || false);
            createJitsiMeeting && (createJitsiMeeting.checked = false);
            createLivekitMeeting && (createLivekitMeeting.checked = false);
        }

        if (onlinePlatform.value === 'jitsi') {
            createJitsiMeeting && (createJitsiMeeting.checked = true);
            createZoomMeeting && (createZoomMeeting.checked = false);
            createLivekitMeeting && (createLivekitMeeting.checked = false);
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
            if (jitsiDomainInput && !jitsiDomainInput.value.trim()) {
                jitsiDomainInput.value = 'meet.jit.si';
            }
        }

        if (onlinePlatform.value === 'livekit') {
            createLivekitMeeting && (createLivekitMeeting.checked = true);
            createZoomMeeting && (createZoomMeeting.checked = false);
            createJitsiMeeting && (createJitsiMeeting.checked = false);
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    branchSelect?.addEventListener('change', filterDepartments);
    createZoomMeeting?.addEventListener('change', syncZoomDefaults);
    createJitsiMeeting?.addEventListener('change', syncJitsiDefaults);
    createLivekitMeeting?.addEventListener('change', syncLivekitDefaults);
    onlinePlatform?.addEventListener('change', function () {
        syncPlatformToggles();
        toggleJitsiDomain();
    });
    filterDepartments();
    syncZoomDefaults();
    syncJitsiDefaults();
    syncLivekitDefaults();
    syncPlatformToggles();
    toggleJitsiDomain();
    initializeMemberSelect();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\events\edit.blade.php ENDPATH**/ ?>