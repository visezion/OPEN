

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Event')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('ChurchMeet')); ?>,<?php echo e(__('Create Event')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .church-events-create .card {
        border: 1px solid #d8e2ef !important;
        box-shadow: none !important;
    }

    .church-events-create .create-hero {
        border-top: 3px solid #245f86 !important;
        background: linear-gradient(180deg, rgba(36, 95, 134, 0.06), rgba(36, 95, 134, 0)), #fff;
    }

    .church-events-create .section-copy,
    .church-events-create .text-muted {
        color: #6b7d90 !important;
    }

    .church-events-create .quick-card {
        background: #f7fafc;
        border-radius: 12px;
        border: 1px solid #d8e2ef;
        padding: 1rem;
    }

    .church-events-create .quick-card strong {
        color: #19324a;
    }

    .church-events-create .aside-sticky {
        position: sticky;
        top: 92px;
    }

    .church-events-create .smart-panel {
        border: 1px solid #d8e2ef;
        border-radius: 12px;
        background: #f7fafc;
        padding: 1rem;
    }

    .church-events-create .smart-kpi {
        border: 1px solid #d8e2ef;
        border-radius: 10px;
        background: #fff;
        padding: 0.75rem 0.85rem;
        height: 100%;
    }

    .church-events-create .smart-kpi-label {
        display: block;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #6b7d90;
        font-weight: 700;
    }

    .church-events-create .smart-kpi-value {
        display: block;
        margin-top: 0.3rem;
        color: #19324a;
        font-weight: 700;
    }

    .church-events-create .smart-timeline-table td,
    .church-events-create .smart-timeline-table th {
        font-size: 0.84rem;
    }

    @media (max-width: 991.98px) {
        .church-events-create .aside-sticky {
            position: static;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to Events')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $zoomReady = !empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret);
    $livekitReady = !empty($zoomSetting->livekit_enabled) && !empty($zoomSetting->livekit_server_url) && !empty($zoomSetting->livekit_api_key) && !empty($zoomSetting->livekit_api_secret);
    $defaultPlatform = $zoomSetting->preferred_platform ?: ($livekitReady ? 'livekit' : ($zoomReady ? 'zoom' : 'jitsi'));
    $advancedToolsOpen = old('online_platform') || old('meeting_link') || old('meeting_id') || old('meeting_passcode') || old('enabled_methods') || old('create_zoom_meeting') || old('create_jitsi_meeting') || old('create_livekit_meeting');
?>
<div class="row church-events-create">
    <div class="col-md-12 mb-4">
        <div class="card create-hero">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start">
                    <div>
                        <h4 class="mb-2"><?php echo e(__('Create a New Event')); ?></h4>
                        <p class="section-copy mb-0"><?php echo e(__('Start with the basics first. Meeting settings and advanced options are kept lower down so the page stays easier to use.')); ?></p>
                    </div>
                    <span class="badge bg-light text-primary border"><?php echo e(__('Draft Stage')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-white p-4">
                <h5 class="mb-1"><?php echo e(__('Basic Details')); ?></h5>
                <p class="section-copy mb-0"><?php echo e(__('Fill the core event information first. Most events can be created with just this section and the attendance mode.')); ?></p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('churchmeet.events.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div id="smartWarnings"></div>
                    <div class="row">

                        <!-- Basic Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('Event Title')); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="<?php echo e(old('title')); ?>" placeholder="<?php echo e(__('Sunday Worship Service')); ?>" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Event Type')); ?></label>
                            <select class="form-select" name="event_type" id="event_type">
                                <option value="service" <?php echo e(old('event_type', 'service') === 'service' ? 'selected' : ''); ?>>Service</option>
                                <option value="meeting" <?php echo e(old('event_type') === 'meeting' ? 'selected' : ''); ?>>Meeting</option>
                                <option value="training" <?php echo e(old('event_type') === 'training' ? 'selected' : ''); ?>>Training</option>
                                <option value="rehearsal" <?php echo e(old('event_type') === 'rehearsal' ? 'selected' : ''); ?>>Rehearsal</option>
                                <option value="outreach" <?php echo e(old('event_type') === 'outreach' ? 'selected' : ''); ?>>Outreach</option>
                                <option value="other" <?php echo e(old('event_type') === 'other' ? 'selected' : ''); ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Attendance Mode')); ?></label>
                            <select name="mode" id="mode-selector" class="form-select" required>
                                <option value="onsite" <?php echo e(old('mode', 'onsite') === 'onsite' ? 'selected' : ''); ?>><?php echo e(__('Onsite')); ?></option>
                                <option value="online" <?php echo e(old('mode') === 'online' ? 'selected' : ''); ?>><?php echo e(__('Online')); ?></option>
                                <option value="hybrid" <?php echo e(old('mode') === 'hybrid' ? 'selected' : ''); ?>><?php echo e(__('Hybrid')); ?></option>
                            </select>
                        </div>

                        <!-- Scheduling -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Start Date & Time')); ?></label>
                            <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?php echo e(old('start_time')); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('End Date & Time')); ?></label>
                            <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?php echo e(old('end_time')); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Recurrence')); ?></label>
                            <select class="form-select" name="recurrence">
                                <option value="none" <?php echo e(old('recurrence', 'none') === 'none' ? 'selected' : ''); ?>>None</option>
                                <option value="daily" <?php echo e(old('recurrence') === 'daily' ? 'selected' : ''); ?>>Daily</option>
                                <option value="weekly" <?php echo e(old('recurrence') === 'weekly' ? 'selected' : ''); ?>>Weekly</option>
                                <option value="monthly" <?php echo e(old('recurrence') === 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                            </select>
                        </div>

                        <!-- Ã°Å¸â€Â Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Lead Minister / Person-in-Charge')); ?></label>
                            <select class="form-select member-select" id="lead_id" name="lead_id">
                                <option value=""><?php echo e(__('Select Lead')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>" <?php echo e(old('lead_id') == $member->id ? 'selected' : ''); ?>><?php echo e($member->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>

                        <!-- Ã°Å¸â€Â Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Assistant / Co-Leader')); ?></label>
                            <select class="form-select member-select" id="assistant_id" name="assistant_id">
                                <option value=""><?php echo e(__('Select Assistant')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>" <?php echo e(old('assistant_id') == $member->id ? 'selected' : ''); ?>><?php echo e($member->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('Venue / Link')); ?></label>
                            <input type="text" class="form-control" name="venue" value="<?php echo e(old('venue')); ?>" placeholder="<?php echo e(__('Main Hall or meeting address')); ?>">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Branch')); ?></label>
                            <select class="form-select" name="branch_id" id="branch_id">
                                <option value=""><?php echo e(__('Select Branch')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(__('Department')); ?></label>
                            <select class="form-select" name="department_id" id="department_id">
                                <option value=""><?php echo e(__('Select Department')); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($department->id); ?>" data-branch-id="<?php echo e($department->branch_id); ?>" <?php echo e(old('department_id') == $department->id ? 'selected' : ''); ?>><?php echo e($department->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label"><?php echo e(__('Description / Notes')); ?></label>
                            <textarea class="form-control" rows="3" name="description" placeholder="<?php echo e(__('Briefly describe this event...')); ?>"><?php echo e(old('description')); ?></textarea>
                        </div>

                        <div class="col-12">
                            <div class="smart-panel mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-1"><?php echo e(__('Smart Schedule Assistant')); ?></h6>
                                        <small class="text-muted"><?php echo e(__('Auto-calculate duration, suggest end time, and preview timeline.')); ?></small>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="applySuggestedEnd"><?php echo e(__('Use Suggested End Time')); ?></button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="smart-kpi">
                                            <span class="smart-kpi-label"><?php echo e(__('Program Duration')); ?></span>
                                            <span class="smart-kpi-value" id="smartTotalDuration">0 <?php echo e(__('min')); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smart-kpi">
                                            <span class="smart-kpi-label"><?php echo e(__('Suggested End')); ?></span>
                                            <span class="smart-kpi-value" id="smartSuggestedEnd">-</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="smart-kpi">
                                            <span class="smart-kpi-label"><?php echo e(__('Duration Gap')); ?></span>
                                            <span class="smart-kpi-value" id="smartDurationGap">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Ã°Å¸Â§Â© Program Builder -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Program Schedule</h6>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addProgramRow">+ Add Item</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="programTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Program Item</th>
                                    <th>Duration (min)</th>
                                    <th>Leader / Person-in-Charge</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" class="form-control" name="program_item[]" placeholder="e.g., Opening Prayer"></td>
                                    <td><input type="number" class="form-control" name="duration[]" value="10" min="1"></td>
                                    <td>
                                        <!-- Ã°Å¸â€Â Searchable Dropdown Added -->
                                        <select class="form-select member-select" name="leader[]">
                                            <option value="">Select Member</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="note[]" placeholder="Optional note"></td>
                                    <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-x"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="smart-panel mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0"><?php echo e(__('Timeline Preview')); ?></h6>
                            <small class="text-muted"><?php echo e(__('Generated from start time plus each item duration.')); ?></small>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0 smart-timeline-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th><?php echo e(__('Program')); ?></th>
                                        <th style="width: 140px;"><?php echo e(__('Duration')); ?></th>
                                        <th style="width: 240px;"><?php echo e(__('Time Slot')); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="smartTimelineBody">
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-2"><?php echo e(__('Add start time and program items to preview timeline.')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="smart-panel mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-1"><?php echo e(__('Automatic Attendance & Meeting Setup')); ?></h6>
                                <small class="text-muted"><?php echo e(__('For normal events, ChurchMeet can choose the online platform and attendance defaults automatically.')); ?></small>
                            </div>
                            <span class="badge bg-light text-primary border"><?php echo e(__('Automatic')); ?></span>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="smart-kpi">
                                    <span class="smart-kpi-label"><?php echo e(__('Platform')); ?></span>
                                    <span class="smart-kpi-value" id="automationPlatform"><?php echo e(strtoupper($defaultPlatform)); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="smart-kpi">
                                    <span class="smart-kpi-label"><?php echo e(__('Attendance')); ?></span>
                                    <span class="smart-kpi-value" id="automationMethods"><?php echo e(__('Manual + QR')); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="smart-kpi">
                                    <span class="smart-kpi-label"><?php echo e(__('Room Action')); ?></span>
                                    <span class="smart-kpi-value" id="automationRoom"><?php echo e(__('Only when needed')); ?></span>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2" id="automationHelp"><?php echo e(__('If you do not open the customize panel below, ChurchMeet will use the workspace defaults for the selected event mode.')); ?></small>
                    </div>

                    <details class="mb-4" id="customize-tools" <?php echo e($advancedToolsOpen ? 'open' : ''); ?>>
                        <summary class="fw-semibold"><?php echo e(__('Customize attendance and meeting settings')); ?></summary>
                        <div class="mt-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h6 class="mb-1"><?php echo e(__('Attendance & Meeting Tools')); ?></h6>
                                    <small class="text-muted"><?php echo e(__('Open this only when you need to override the automatic defaults.')); ?></small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input type="checkbox" class="form-check-input" id="auto_log_attendance" name="auto_log_attendance" value="1" <?php echo e(old('auto_log_attendance') ? 'checked' : ''); ?>>
                                    <label for="auto_log_attendance" class="form-check-label"><?php echo e(__('Auto Log')); ?></label>
                                </div>
                            </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret)): ?>
                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo e(__('Zoom is connected.')); ?></strong>
                                <?php echo e(__('Leave this off if you want ChurchMeet to decide automatically.')); ?>

                            </div>
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" class="form-check-input" id="create_zoom_meeting" name="create_zoom_meeting" value="1" <?php echo e(old('create_zoom_meeting') ? 'checked' : ''); ?>>
                                <label for="create_zoom_meeting" class="form-check-label"><?php echo e(__('Auto-create Zoom meeting')); ?></label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <?php echo e(__('Zoom auto-creation is unavailable until ChurchMeet integration settings are configured.')); ?>

                            <a href="<?php echo e(route('churchmeet.integrations.index')); ?>" class="alert-link"><?php echo e(__('Open Integration settings')); ?></a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="alert alert-light border d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo e(__('Jitsi is available.')); ?></strong>
                            <?php echo e(__('Leave this off if you want ChurchMeet to use the preferred platform automatically.')); ?>

                            </div>
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" class="form-check-input" id="create_jitsi_meeting" name="create_jitsi_meeting" value="1" <?php echo e(old('create_jitsi_meeting') ? 'checked' : ''); ?>>
                            <label for="create_jitsi_meeting" class="form-check-label"><?php echo e(__('Auto-create Jitsi room')); ?></label>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($zoomSetting->livekit_enabled) && !empty($zoomSetting->livekit_server_url) && !empty($zoomSetting->livekit_api_key) && !empty($zoomSetting->livekit_api_secret)): ?>
                        <div class="alert alert-success d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo e(__('LiveKit is connected.')); ?></strong>
                                <?php echo e(__('Leave this off if you want ChurchMeet to choose automatically.')); ?>

                            </div>
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" class="form-check-input" id="create_livekit_meeting" name="create_livekit_meeting" value="1" <?php echo e(old('create_livekit_meeting') ? 'checked' : ''); ?>>
                                <label for="create_livekit_meeting" class="form-check-label"><?php echo e(__('Auto-create LiveKit room')); ?></label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-secondary">
                            <?php echo e(__('LiveKit room creation is unavailable until ChurchMeet integration settings are configured.')); ?>

                            <a href="<?php echo e(route('churchmeet.integrations.index')); ?>" class="alert-link"><?php echo e(__('Open Integration settings')); ?></a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-checks text-info"></i> <?php echo e(__('Enabled Attendance Methods')); ?>

                        </label>
                       
                        <div class="row g-3">
                            <?php
                                $methods = [
                                    ['manual', 'Manual Check-in', 'ti-user-check'],
                                    ['qr', 'QR Code Scanning', 'ti-qrcode'],
                                    ['kiosk', 'Kiosk Self Check-in', 'ti-device-ipad'],
                                    ['face_ai', 'Face AI Detection', 'ti-camera'],
                                    ['zoom', 'Zoom Attendance Sync', 'ti-video'],
                                    ['jitsi', 'Jitsi Meeting Room', 'ti-brand-tabler'],
                                    ['livekit', 'LiveKit Room', 'ti-brand-webrtc'],
                                    ['youtube', 'YouTube Live Tracking', 'ti-brand-youtube']
                                ];
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$value, $label, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="<?php echo e($value); ?>" id="method-<?php echo e($value); ?>" class="form-check-input" <?php echo e(in_array($value, old('enabled_methods', [])) ? 'checked' : ''); ?>>
                                        <label for="method-<?php echo e($value); ?>" class="form-check-label d-flex align-items-center">
                                            <i class="ti <?php echo e($icon); ?> text-primary me-2"></i> <?php echo e(__($label)); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <?php echo e(__('Multiple methods can be enabled simultaneously for flexibility.')); ?>

                        </small>
                    </div>

                    
                    <div id="online-config" class="mb-4" style="display:none;">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> <?php echo e(__('Online Meeting Details')); ?>

                        </label>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <select name="online_platform" id="online_platform" class="form-select">
                                    <option value=""><?php echo e(__('Select Online Platform')); ?></option>
                                    <option value="zoom" <?php echo e(old('online_platform', $defaultPlatform) === 'zoom' ? 'selected' : ''); ?>><?php echo e(__('Zoom')); ?></option>
                                    <option value="jitsi" <?php echo e(old('online_platform', $defaultPlatform) === 'jitsi' ? 'selected' : ''); ?>><?php echo e(__('Jitsi Meet')); ?></option>
                                    <option value="livekit" <?php echo e(old('online_platform', $defaultPlatform) === 'livekit' ? 'selected' : ''); ?>><?php echo e(__('LiveKit')); ?></option>
                                    <option value="youtube" <?php echo e(old('online_platform') === 'youtube' ? 'selected' : ''); ?>><?php echo e(__('YouTube')); ?></option>
                                    <option value="custom" <?php echo e(old('online_platform') === 'custom' ? 'selected' : ''); ?>><?php echo e(__('Custom Link')); ?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_link" value="<?php echo e(old('meeting_link')); ?>" placeholder="<?php echo e(__('Meeting/Stream Link')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_id" value="<?php echo e(old('meeting_id')); ?>" placeholder="<?php echo e(__('Meeting ID or Jitsi Room Name')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_passcode" value="<?php echo e(old('meeting_passcode')); ?>" placeholder="<?php echo e(__('Passcode (Zoom only)')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="jitsi_domain" id="jitsi_domain" value="<?php echo e(old('jitsi_domain', $zoomSetting->jitsi_server_domain ?: 'meet.jit.si')); ?>" placeholder="<?php echo e(__('Jitsi Domain (optional, defaults to meet.jit.si)')); ?>" class="form-control">
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1">
                            <?php echo e(__('Only required for Online or Hybrid modes. For Jitsi, the room name becomes the meeting ID.')); ?>

                        </small>
                    </div>
                        </div>
                    </details>

                    <hr>

                    <details class="mb-3">
                        <summary><?php echo e(__('Advanced Options')); ?></summary>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                                <input type="number" step="0.0001" class="form-control" name="latitude" value="<?php echo e(old('latitude')); ?>" placeholder="6.5244">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                                <input type="number" step="0.0001" class="form-control" name="longitude" value="<?php echo e(old('longitude')); ?>" placeholder="3.3792">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label"><?php echo e(__('Radius (meters)')); ?></label>
                                <input type="number" min="1" class="form-control" name="radius_meters" value="<?php echo e(old('radius_meters', 100)); ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Upload Files (Optional)')); ?></label>
                                <input type="file" class="form-control" name="files[]" multiple>
                            </div>
                        </div>
                    </details>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-send"></i> <?php echo e(__('Submit Event for Review')); ?></button>
                        <button type="reset" class="btn btn-light"><?php echo e(__('Clear')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 mt-4 mt-lg-0">
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header  text-primary py-3">
                <h5 class="mb-1"><i class="ti ti-bulb me-1"></i> <?php echo e(__('Quick Guide')); ?></h5>
                <p class="section-copy mb-0"><?php echo e(__('Use the shortest path possible for normal events.')); ?></p>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li><strong>For most events, only fill title, date, lead, and mode.</strong> ChurchMeet will handle the rest automatically.</li>
                    <li>Use <strong>"Add Item"</strong> in the Program Schedule to define each part of the service (e.g., Worship, Sermon).</li>
                    <li>Assign the right <strong>Leader / Person-in-Charge</strong> for each program segment.</li>
                    <li>You can upload <strong>service notes, slides, or images</strong> in the upload section below.</li>
                    <li>Open <strong>Customize attendance and meeting settings</strong> only when you need special overrides.</li>
                    <li>After reviewing all details, click <strong>"Submit Event for Review"</strong> to move it to the next stage.</li>
                    <li>Saved events stay in <strong>Draft</strong> until approved or published by authorized personnel.</li>
                </ul>
                <hr class="my-3">
                <div class="alert alert-info mb-0">
                    <i class="ti ti-shield-check"></i>
                    <strong>Note:</strong> Event creation and editing are collaborative, but <u>final review and approval rights belong solely to the Lead Minister or Assistant/Co-Leader</u>. They may modify program items, timing, or details before publication.
                </div>
            </div>
        </div>


       
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><?php echo e(__('Current Defaults')); ?></h6>
                </div>

                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><?php echo e(__('Workflow')); ?></span>
                        <strong><?php echo e(__('Draft -> Review')); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><?php echo e(__('Default Method')); ?></span>
                        <strong><?php echo e(__('Automatic')); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><?php echo e(__('Meeting Setup')); ?></span>
                        <strong><?php echo e(__('Automatic')); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><?php echo e(__('Zoom')); ?></span>
                        <strong><?php echo e(!empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret) ? __('Ready') : __('Needs setup')); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><?php echo e(__('Jitsi')); ?></span>
                        <strong><?php echo e(__('Ready')); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted"><?php echo e(__('LiveKit')); ?></span>
                        <strong><?php echo e(!empty($zoomSetting->livekit_enabled) && !empty($zoomSetting->livekit_server_url) && !empty($zoomSetting->livekit_api_key) && !empty($zoomSetting->livekit_api_secret) ? __('Ready') : __('Needs setup')); ?></strong>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted"><?php echo e(__('Readiness')); ?></span>
                        <strong id="smartReadinessValue">0%</strong>
                    </div>
                    <div class="text-muted" id="smartReadinessHint"><?php echo e(__('Start filling fields to build a ready event draft.')); ?></div>
                </div>
            </div>

    </div>
</div>

<!-- Ã¢Å“â€¦ Include Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.church-events-create form');
    const modeSelector = document.getElementById('mode-selector');
    const onlineConfig = document.getElementById('online-config');
    const createZoomMeeting = document.getElementById('create_zoom_meeting');
    const createJitsiMeeting = document.getElementById('create_jitsi_meeting');
    const createLivekitMeeting = document.getElementById('create_livekit_meeting');
    const onlinePlatform = document.getElementById('online_platform');
    const jitsiDomain = document.getElementById('jitsi_domain');
    const branchSelect = document.getElementById('branch_id');
    const departmentSelect = document.getElementById('department_id');
    const programTableBody = document.querySelector('#programTable tbody');
    const addProgramRowButton = document.getElementById('addProgramRow');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const timelineBody = document.getElementById('smartTimelineBody');
    const smartTotalDuration = document.getElementById('smartTotalDuration');
    const smartSuggestedEnd = document.getElementById('smartSuggestedEnd');
    const smartDurationGap = document.getElementById('smartDurationGap');
    const smartWarnings = document.getElementById('smartWarnings');
    const applySuggestedEndButton = document.getElementById('applySuggestedEnd');
    const leadSelect = document.getElementById('lead_id');
    const assistantSelect = document.getElementById('assistant_id');
    const readinessValue = document.getElementById('smartReadinessValue');
    const readinessHint = document.getElementById('smartReadinessHint');
    const titleInput = document.querySelector('input[name="title"]');
    const meetingLinkInput = document.querySelector('input[name="meeting_link"]');
    const meetingIdInput = document.querySelector('input[name="meeting_id"]');
    const attendanceMethodInputs = Array.from(document.querySelectorAll('input[name="enabled_methods[]"]'));
    const automationPlatform = document.getElementById('automationPlatform');
    const automationMethods = document.getElementById('automationMethods');
    const automationRoom = document.getElementById('automationRoom');
    const automationHelp = document.getElementById('automationHelp');
    const preferredPlatformDefault = <?php echo json_encode($defaultPlatform, 15, 512) ?>;
    const providerReady = {
        zoom: <?php echo json_encode($zoomReady, 15, 512) ?>,
        jitsi: true,
        livekit: <?php echo json_encode($livekitReady, 15, 512) ?>,
    };

    if (!form || !programTableBody) {
        return;
    }

    let userCustomizedMethods = attendanceMethodInputs.some((input) => input.checked);
    let currentSuggestedEnd = null;
    let userChangedAutoLog = <?php echo e(old('auto_log_attendance') !== null ? 'true' : 'false'); ?>;

    if (window.$ && $.fn && $.fn.select2) {
        $('.member-select').select2({
            placeholder: "Search member...",
            allowClear: true,
            width: '100%'
        });
    }

    function parseDateTimeLocal(value) {
        if (!value) {
            return null;
        }
        const date = new Date(value);
        return Number.isNaN(date.getTime()) ? null : date;
    }

    function formatDateTimeLocal(date) {
        if (!(date instanceof Date) || Number.isNaN(date.getTime())) {
            return '';
        }
        const pad = (value) => value.toString().padStart(2, '0');
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    function formatDateTimeDisplay(date) {
        if (!(date instanceof Date) || Number.isNaN(date.getTime())) {
            return '-';
        }
        return date.toLocaleString(undefined, {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function escapeHtml(text) {
        return String(text || '').replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[character];
        });
    }

    function getProgramRows() {
        return Array.from(programTableBody.querySelectorAll('tr'));
    }

    function reindexProgramRows() {
        getProgramRows().forEach((row, index) => {
            const firstCell = row.querySelector('td');
            if (firstCell) {
                firstCell.textContent = String(index + 1);
            }
        });
    }

    function totalProgramDuration() {
        return getProgramRows().reduce((total, row) => {
            const durationInput = row.querySelector('input[name="duration[]"]');
            const value = durationInput ? parseInt(durationInput.value, 10) : 0;
            return total + (Number.isFinite(value) && value > 0 ? value : 0);
        }, 0);
    }

    function updateWarnings() {
        const leadId = leadSelect ? leadSelect.value : '';
        const assistantId = assistantSelect ? assistantSelect.value : '';
        const warnings = [];

        if (leadId !== '' && assistantId !== '' && leadId === assistantId) {
            warnings.push('Lead and Assistant are the same person. Use different members for role separation.');
        }

        if (warnings.length === 0) {
            smartWarnings.innerHTML = '';
            return;
        }

        smartWarnings.innerHTML = warnings.map((message) => `<div class="alert alert-warning py-2 mb-3">${escapeHtml(message)}</div>`).join('');
    }

    function renderTimeline() {
        const startDate = parseDateTimeLocal(startTimeInput ? startTimeInput.value : '');
        const rows = getProgramRows();
        const entries = [];
        let cursor = startDate ? new Date(startDate.getTime()) : null;

        rows.forEach((row, index) => {
            const itemInput = row.querySelector('input[name="program_item[]"]');
            const durationInput = row.querySelector('input[name="duration[]"]');
            const itemTitle = itemInput && itemInput.value.trim() !== '' ? itemInput.value.trim() : `Item ${index + 1}`;
            const duration = durationInput ? parseInt(durationInput.value, 10) : 0;

            if (!Number.isFinite(duration) || duration <= 0) {
                return;
            }

            let slotLabel = '-';
            if (cursor) {
                const slotStart = new Date(cursor.getTime());
                const slotEnd = new Date(cursor.getTime() + (duration * 60000));
                slotLabel = `${formatDateTimeDisplay(slotStart)} - ${slotEnd.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' })}`;
                cursor = slotEnd;
            }

            entries.push({
                number: index + 1,
                title: itemTitle,
                duration,
                slotLabel
            });
        });

        if (!startDate || entries.length === 0) {
            timelineBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-2">Add start time and program items to preview timeline.</td></tr>';
            return;
        }

        timelineBody.innerHTML = entries.map((entry) => `
            <tr>
                <td>${entry.number}</td>
                <td>${escapeHtml(entry.title)}</td>
                <td>${entry.duration} min</td>
                <td>${escapeHtml(entry.slotLabel)}</td>
            </tr>
        `).join('');
    }

    function updateReadiness(totalMinutes) {
        const startDate = parseDateTimeLocal(startTimeInput ? startTimeInput.value : '');
        const endDate = parseDateTimeLocal(endTimeInput ? endTimeInput.value : '');
        const mode = modeSelector ? modeSelector.value : 'onsite';
        const platform = onlinePlatform ? onlinePlatform.value : '';
        const hasAttendanceMethod = attendanceMethodInputs.some((input) => input.checked);
        const hasMeetingAccess = !!((meetingLinkInput && meetingLinkInput.value.trim() !== '') || (meetingIdInput && meetingIdInput.value.trim() !== ''));

        let score = 0;
        if (titleInput && titleInput.value.trim() !== '') score += 20;
        if (startDate) score += 15;
        if (endDate && startDate && endDate > startDate) score += 10;
        if (leadSelect && leadSelect.value !== '') score += 10;
        if (totalMinutes > 0) score += 15;
        if (hasAttendanceMethod) score += 15;
        if (mode === 'onsite') score += 15;
        if ((mode === 'online' || mode === 'hybrid') && platform !== '') score += 10;
        if ((mode === 'online' || mode === 'hybrid') && hasMeetingAccess) score += 5;

        score = Math.min(100, score);
        if (readinessValue) {
            readinessValue.textContent = `${score}%`;
        }

        if (!readinessHint) {
            return;
        }

        if (score >= 85) {
            readinessHint.textContent = 'Ready for review. Core schedule and attendance settings are complete.';
        } else if (score >= 60) {
            readinessHint.textContent = 'Almost ready. Add remaining meeting details to reduce follow-up edits.';
        } else {
            readinessHint.textContent = 'Add title, timing, lead, and attendance details to complete this draft.';
        }
    }

    function updateSmartAssistant() {
        const totalMinutes = totalProgramDuration();
        const startDate = parseDateTimeLocal(startTimeInput ? startTimeInput.value : '');
        const endDate = parseDateTimeLocal(endTimeInput ? endTimeInput.value : '');

        if (smartTotalDuration) {
            smartTotalDuration.textContent = `${totalMinutes} min`;
        }

        if (startDate && totalMinutes > 0) {
            currentSuggestedEnd = new Date(startDate.getTime() + (totalMinutes * 60000));
            if (smartSuggestedEnd) {
                smartSuggestedEnd.textContent = formatDateTimeDisplay(currentSuggestedEnd);
            }
        } else {
            currentSuggestedEnd = null;
            if (smartSuggestedEnd) {
                smartSuggestedEnd.textContent = '-';
            }
        }

        if (smartDurationGap) {
            if (endDate && currentSuggestedEnd) {
                const diffMinutes = Math.round((endDate.getTime() - currentSuggestedEnd.getTime()) / 60000);
                if (diffMinutes === 0) {
                    smartDurationGap.textContent = 'On target';
                } else if (diffMinutes > 0) {
                    smartDurationGap.textContent = `${diffMinutes} min free`;
                } else {
                    smartDurationGap.textContent = `${Math.abs(diffMinutes)} min short`;
                }
            } else {
                smartDurationGap.textContent = '-';
            }
        }

        renderTimeline();
        updateWarnings();
        updateReadiness(totalMinutes);
    }

    function toggleOnlineSection() {
        if (!modeSelector || !onlineConfig) {
            return;
        }
        const value = modeSelector.value;
        onlineConfig.style.display = (value === 'online' || value === 'hybrid') ? 'block' : 'none';
    }

    function toggleJitsiDomain() {
        if (!jitsiDomain || !onlinePlatform) {
            return;
        }
        const wrapper = jitsiDomain.closest('.col-md-6');
        if (wrapper) {
            wrapper.style.display = onlinePlatform.value === 'jitsi' ? '' : 'none';
        }
    }

    function resolvePlatformChoice() {
        const selected = (onlinePlatform?.value || '').trim().toLowerCase();

        if (selected) {
            return selected;
        }

        let fallback = (preferredPlatformDefault || 'jitsi').toLowerCase();

        if (fallback === 'zoom' && !providerReady.zoom) {
            fallback = providerReady.livekit ? 'livekit' : 'jitsi';
        }

        if (fallback === 'livekit' && !providerReady.livekit) {
            fallback = 'jitsi';
        }

        return fallback || 'jitsi';
    }

    function syncAutomaticDefaults() {
        const mode = modeSelector ? modeSelector.value : 'onsite';
        const platform = resolvePlatformChoice();

        if (!userChangedAutoLog && document.getElementById('auto_log_attendance')) {
            document.getElementById('auto_log_attendance').checked = mode !== 'onsite';
        }

        if (!automationPlatform || !automationMethods || !automationRoom || !automationHelp) {
            return;
        }

        if (mode === 'onsite') {
            automationPlatform.textContent = 'N/A';
            automationMethods.textContent = 'Manual + QR + Kiosk';
            automationRoom.textContent = 'No room';
            automationHelp.textContent = 'Onsite events use in-person attendance defaults automatically. Open customize only if you need special attendance tools.';
            return;
        }

        automationPlatform.textContent = platform.toUpperCase();
        automationMethods.textContent = mode === 'hybrid' ? `Manual + QR + ${platform.toUpperCase()}` : `Manual + ${platform.toUpperCase()}`;

        if (platform === 'zoom') {
            automationRoom.textContent = providerReady.zoom ? 'Create Zoom room' : 'Needs Zoom setup';
        } else if (platform === 'livekit') {
            automationRoom.textContent = providerReady.livekit ? 'Create LiveKit room' : 'Needs LiveKit setup';
        } else if (platform === 'jitsi') {
            automationRoom.textContent = 'Create Jitsi room';
        } else {
            automationRoom.textContent = 'No auto room';
        }

        automationHelp.textContent = `ChurchMeet will use ${platform.toUpperCase()} automatically for ${mode} events unless you override it below.`;
    }

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

        if (departmentSelect.selectedOptions[0] && departmentSelect.selectedOptions[0].hidden) {
            departmentSelect.value = '';
        }
    }

    function setAttendanceMethod(method, enabled) {
        const input = document.getElementById(`method-${method}`);
        if (input) {
            input.checked = !!enabled;
        }
    }

    function applyAttendanceMethodDefaults() {
        if (userCustomizedMethods) {
            return;
        }

        const mode = modeSelector ? modeSelector.value : 'onsite';
        const platform = onlinePlatform ? onlinePlatform.value : '';
        setAttendanceMethod('manual', true);
        setAttendanceMethod('qr', mode !== 'online');
        setAttendanceMethod('kiosk', mode === 'onsite');
        setAttendanceMethod('face_ai', false);
        setAttendanceMethod('zoom', platform === 'zoom');
        setAttendanceMethod('jitsi', platform === 'jitsi');
        setAttendanceMethod('livekit', platform === 'livekit');
        setAttendanceMethod('youtube', platform === 'youtube');
        syncAutomaticDefaults();
    }

    function syncZoomPlatform() {
        if (!createZoomMeeting || !createZoomMeeting.checked || !onlinePlatform) {
            return;
        }
        onlinePlatform.value = 'zoom';
        if (createJitsiMeeting) {
            createJitsiMeeting.checked = false;
        }
        if (createLivekitMeeting) {
            createLivekitMeeting.checked = false;
        }
        if (modeSelector && modeSelector.value === 'onsite') {
            modeSelector.value = 'online';
        }
        toggleOnlineSection();
        toggleJitsiDomain();
        applyAttendanceMethodDefaults();
        updateSmartAssistant();
    }

    function syncJitsiPlatform() {
        if (!createJitsiMeeting || !createJitsiMeeting.checked || !onlinePlatform) {
            return;
        }
        onlinePlatform.value = 'jitsi';
        if (createZoomMeeting) {
            createZoomMeeting.checked = false;
        }
        if (createLivekitMeeting) {
            createLivekitMeeting.checked = false;
        }
        if (modeSelector && modeSelector.value === 'onsite') {
            modeSelector.value = 'online';
        }
        toggleOnlineSection();
        toggleJitsiDomain();
        applyAttendanceMethodDefaults();
        updateSmartAssistant();
    }

    function syncLivekitPlatform() {
        if (!createLivekitMeeting || !createLivekitMeeting.checked || !onlinePlatform) {
            return;
        }
        onlinePlatform.value = 'livekit';
        if (createZoomMeeting) {
            createZoomMeeting.checked = false;
        }
        if (createJitsiMeeting) {
            createJitsiMeeting.checked = false;
        }
        if (modeSelector && modeSelector.value === 'onsite') {
            modeSelector.value = 'online';
        }
        toggleOnlineSection();
        toggleJitsiDomain();
        applyAttendanceMethodDefaults();
        updateSmartAssistant();
    }

    if (addProgramRowButton) {
        addProgramRowButton.addEventListener('click', function () {
            const existingLeaderSelect = programTableBody.querySelector('select[name="leader[]"]');
            const leaderOptionsHtml = existingLeaderSelect
                ? existingLeaderSelect.innerHTML
                : '<option value="">Select Member</option>';
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>0</td>
                <td><input type="text" class="form-control" name="program_item[]" placeholder="Program name"></td>
                <td><input type="number" class="form-control" name="duration[]" value="10" min="1"></td>
                <td>
                    <select class="form-select member-select" name="leader[]">
                        ${leaderOptionsHtml}
                    </select>
                </td>
                <td><input type="text" class="form-control" name="note[]" placeholder="Notes"></td>
                <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-x"></i></button></td>
            `;
            programTableBody.appendChild(row);

            const newSelect = row.querySelector('.member-select');
            if (newSelect && window.$ && $.fn && $.fn.select2) {
                $(newSelect).select2({
                    placeholder: "Search member...",
                    allowClear: true,
                    width: '100%'
                });
            }
            reindexProgramRows();
            updateSmartAssistant();
        });
    }

    document.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.removeRow');
        if (!removeButton) {
            return;
        }
        const row = removeButton.closest('tr');
        if (!row) {
            return;
        }

        if (getProgramRows().length === 1) {
            const itemInput = row.querySelector('input[name="program_item[]"]');
            const durationInput = row.querySelector('input[name="duration[]"]');
            const noteInput = row.querySelector('input[name="note[]"]');
            const leaderInput = row.querySelector('select[name="leader[]"]');
            if (itemInput) itemInput.value = '';
            if (durationInput) durationInput.value = '10';
            if (noteInput) noteInput.value = '';
            if (leaderInput) {
                leaderInput.value = '';
                if (window.$) {
                    $(leaderInput).trigger('change');
                }
            }
        } else {
            row.remove();
            reindexProgramRows();
        }
        updateSmartAssistant();
    });

    form.addEventListener('input', function (event) {
        if (event.target.matches('input[name="duration[]"], input[name="program_item[]"], input[name="title"], input[name="meeting_link"], input[name="meeting_id"], #start_time, #end_time')) {
            updateSmartAssistant();
        }
    });

    form.addEventListener('change', function (event) {
        if (event.target.matches('#lead_id, #assistant_id, select[name="leader[]"]')) {
            updateSmartAssistant();
        }
        if (event.target.matches('input[name="enabled_methods[]"]')) {
            userCustomizedMethods = true;
            updateSmartAssistant();
        }
        if (event.target.matches('#auto_log_attendance')) {
            userChangedAutoLog = true;
        }
    });

    if (applySuggestedEndButton) {
        applySuggestedEndButton.addEventListener('click', function () {
            if (!currentSuggestedEnd || !endTimeInput) {
                return;
            }
            endTimeInput.value = formatDateTimeLocal(currentSuggestedEnd);
            updateSmartAssistant();
        });
    }

    if (branchSelect) {
        branchSelect.addEventListener('change', filterDepartments);
    }
    if (modeSelector) {
        modeSelector.addEventListener('change', function () {
            toggleOnlineSection();
            applyAttendanceMethodDefaults();
            updateSmartAssistant();
        });
    }
    if (createZoomMeeting) {
        createZoomMeeting.addEventListener('change', syncZoomPlatform);
    }
    if (createJitsiMeeting) {
        createJitsiMeeting.addEventListener('change', syncJitsiPlatform);
    }
    if (createLivekitMeeting) {
        createLivekitMeeting.addEventListener('change', syncLivekitPlatform);
    }
    if (onlinePlatform) {
        onlinePlatform.addEventListener('change', function () {
            if (createZoomMeeting) {
                createZoomMeeting.checked = onlinePlatform.value === 'zoom';
            }
            if (createJitsiMeeting) {
                createJitsiMeeting.checked = onlinePlatform.value === 'jitsi';
            }
            if (createLivekitMeeting) {
                createLivekitMeeting.checked = onlinePlatform.value === 'livekit';
            }
            toggleJitsiDomain();
            applyAttendanceMethodDefaults();
            updateSmartAssistant();
        });
    }

    filterDepartments();
    reindexProgramRows();
    toggleOnlineSection();
    toggleJitsiDomain();
    applyAttendanceMethodDefaults();
    if (createZoomMeeting && createZoomMeeting.checked) {
        syncZoomPlatform();
    } else if (createJitsiMeeting && createJitsiMeeting.checked) {
        syncJitsiPlatform();
    } else if (createLivekitMeeting && createLivekitMeeting.checked) {
        syncLivekitPlatform();
    }
    syncAutomaticDefaults();
    updateSmartAssistant();
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\events\create.blade.php ENDPATH**/ ?>