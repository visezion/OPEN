

<?php $__env->startSection('page-title'); ?>
    Create New Event / Service
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Create New Event / Service ')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .church-events-create .card {
        border: 1px solid var(--bs-border-color, #dee2e6) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.events.index')); ?>" class="btn btn-secondary btn-sm">
        <i class="ti ti-arrow-left"></i> Back to List
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row church-events-create">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">Event Workflow</h6>
                    <span class="small text-secondary">Status: <strong class="text-primary">Draft</strong></span>
                </div>

                <div class="progress-container" style="position: relative;">
                    <div class="progress" style="height: 10px; background: #f1f1f1; border-radius: 10px;">
                        <div id="progressBar" class="progress-bar bg-primary" style="width: 25%; border-radius: 10px;"></div>
                    </div>

                    <ul class="d-flex justify-content-between list-unstyled position-absolute w-100 top-0" style="margin-top: -10px;">
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-primary text-white mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">1</div>
                            <small>Draft</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-light text-muted border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">2</div>
                            <small>Review</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-light text-muted border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">3</div>
                            <small>Approver</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-light text-muted border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">4</div>
                            <small>Publish</small>
                        </li>
                    </ul><br>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Event / Service Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('churchly.events.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <!-- Basic Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Event Type</label>
                            <select class="form-select" name="event_type">
                                <option value="service">Service</option>
                                <option value="meeting">Meeting</option>
                                <option value="training">Training</option>
                                <option value="rehearsal">Rehearsal</option>
                                <option value="outreach">Outreach</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft">Draft</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <!-- Scheduling -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Start Date & Time</label>
                            <input type="datetime-local" class="form-control" name="start_time">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">End Date & Time</label>
                            <input type="datetime-local" class="form-control" name="end_time">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Recurrence</label>
                            <select class="form-select" name="recurrence">
                                <option value="none">None</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>

                        <!-- 🔍 Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Lead Minister / Person-in-Charge</label>
                            <select class="form-select member-select" name="lead_id">
                                <option value="">Select Lead</option>
                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- 🔍 Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Assistant / Co-Leader</label>
                            <select class="form-select member-select" name="assistant_id">
                                <option value="">Select Assistant</option>
                                <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Venue / Link</label>
                            <input type="text" class="form-control" name="venue" placeholder="e.g., Main Hall or Zoom Link">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Branch</label>
                            <select class="form-select" name="branch_id" id="branch_id">
                                <option value="">Select Branch</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department_id" id="department_id">
                                <option value="">Select Department</option>
                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($department->id); ?>" data-branch-id="<?php echo e($department->branch_id); ?>"><?php echo e($department->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.0001" class="form-control" name="latitude" value="<?php echo e(old('latitude')); ?>" placeholder="e.g., 6.5244">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.0001" class="form-control" name="longitude" value="<?php echo e(old('longitude')); ?>" placeholder="e.g., 3.3792">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Radius (meters)</label>
                            <input type="number" min="1" class="form-control" name="radius_meters" value="<?php echo e(old('radius_meters', 100)); ?>">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description / Notes</label>
                            <textarea class="form-control" rows="3" name="description" placeholder="Describe this event..."></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- 🧩 Program Builder -->
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
                                    <td><input type="number" class="form-control" name="duration[]" value="10"></td>
                                    <td>
                                        <!-- 🔍 Searchable Dropdown Added -->
                                        <select class="form-select member-select" name="leader[]">
                                            <option value="">Select Member</option>
                                            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($member->id); ?>"><?php echo e($member->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="note[]" placeholder="Optional note"></td>
                                    <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-x"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-building-church text-success"></i> <?php echo e(__('Mode of Attendance')); ?>

                            </label>
                            <select name="mode" id="mode-selector" class="form-select" required>
                                <option value="onsite"><?php echo e(__('Onsite')); ?></option>
                                <option value="online"><?php echo e(__('Online')); ?></option>
                                <option value="hybrid"><?php echo e(__('Hybrid')); ?></option>
                            </select>
                            <small class="text-muted d-block mt-1">
                                <?php echo e(__('Define how participants will attend this event.')); ?>

                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">
                                <i class="ti ti-activity text-warning"></i> <?php echo e(__('Auto Attendance Logging')); ?>

                            </label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="auto_log_attendance" name="auto_log_attendance">
                                <label for="auto_log_attendance" class="form-check-label"><?php echo e(__('Enable Auto Logging')); ?></label>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <?php echo e(__('Automatically record attendance for Zoom/YouTube integrations.')); ?>

                            </small>
                        </div>
                    </div>

                    <?php if(!empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret)): ?>
                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo e(__('Zoom is connected.')); ?></strong>
                                <?php echo e(__('You can create the Zoom meeting automatically when this event is saved.')); ?>

                            </div>
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" class="form-check-input" id="create_zoom_meeting" name="create_zoom_meeting" value="1">
                                <label for="create_zoom_meeting" class="form-check-label"><?php echo e(__('Auto-create Zoom meeting')); ?></label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <?php echo e(__('Zoom meeting creation is unavailable until Churchly Zoom settings are configured.')); ?>

                            <a href="<?php echo e(route('churchly.zoom.index')); ?>" class="alert-link"><?php echo e(__('Open Zoom settings')); ?></a>
                        </div>
                    <?php endif; ?>

                    
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
                                    ['youtube', 'YouTube Live Tracking', 'ti-brand-youtube']
                                ];
                            ?>

                            <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$value, $label, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="<?php echo e($value); ?>" id="method-<?php echo e($value); ?>" class="form-check-input">
                                        <label for="method-<?php echo e($value); ?>" class="form-check-label d-flex align-items-center">
                                            <i class="ti <?php echo e($icon); ?> text-primary me-2"></i> <?php echo e(__($label)); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <?php echo e(__('Multiple methods can be enabled simultaneously for flexibility.')); ?>

                        </small>
                    </div>

                    
                    <div id="online-config" class="mb-4" style="display:none;">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> <?php echo e(__('Online Configuration (Optional)')); ?>

                        </label>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="online_platform" id="online_platform" placeholder="<?php echo e(__('Platform (e.g., Zoom, YouTube)')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_link" placeholder="<?php echo e(__('Meeting/Stream Link')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_id" placeholder="<?php echo e(__('Meeting ID (Zoom)')); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_passcode" placeholder="<?php echo e(__('Passcode (Zoom)')); ?>" class="form-control">
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1">
                            <?php echo e(__('Only required for Online or Hybrid modes.')); ?>

                        </small>
                    </div>

                    <hr>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload Files (Optional)</label>
                        <input type="file" class="form-control" name="files[]" multiple>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-send"></i> Submit Event for Review</button>
                        <button type="reset" class="btn btn-light">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 mt-4 mt-lg-0">
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header  text-primary py-3">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> <?php echo e(__('Instructions & Tips')); ?></h5>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li><strong>Fill in all required fields</strong> such as title, date, and lead before submitting.</li>
                    <li>Use <strong>“Add Item”</strong> in the Program Schedule to define each part of the service (e.g., Worship, Sermon).</li>
                    <li>Assign the right <strong>Leader / Person-in-Charge</strong> for each program segment.</li>
                    <li>You can upload <strong>service notes, slides, or images</strong> in the upload section below.</li>
                    <li>Choose appropriate <strong>attendance methods</strong> (QR, Kiosk, App, Face AI) based on the setup.</li>
                    <li>After reviewing all details, click <strong>“Submit Event for Review”</strong> to move it to the next stage.</li>
                    <li>Saved events stay in <strong>Draft</strong> until approved or published by authorized personnel.</li>
                </ul>
                <hr class="my-3">
                <div class="alert alert-info mb-0">
                    <i class="ti ti-shield-check"></i>
                    <strong>Note:</strong> Event creation and editing are collaborative, but <u>final review and approval rights belong solely to the Lead Minister or Assistant/Co-Leader</u>. They may modify program items, timing, or details before publication.
                </div>
            </div>
        </div>


       
            <?php
                $recentEvents = \Workdo\Churchly\Entities\Event::orderBy('created_at', 'desc')->take(3)->get();
            ?>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">
                        <i class="ti ti-bell"></i> <?php echo e(__('Recent Notifications')); ?>

                    </h6>
                    <a href="<?php echo e(route('churchly.events.index')); ?>" class="text-muted small"><?php echo e(__('View All')); ?></a>
                </div>

                <div class="card-body small">
                    <?php $__empty_1 = true; $__currentLoopData = $recentEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="alert alert-<?php echo e($event->event_type == 'worship' ? 'info' : 
                            ($event->event_type == 'meeting' ? 'warning' : 
                            ($event->event_type == 'outreach' ? 'success' : 'secondary'))); ?> mb-2 py-2">
                            <i class="ti ti-calendar-event"></i>
                            <strong><?php echo e($event->title); ?></strong>
                            <br>
                            <span class="text-muted">
                                <?php echo e(__('Scheduled for')); ?> <?php echo e(\Carbon\Carbon::parse($event->date)->format('M d, Y')); ?>

                                <?php if($event->time): ?>
                                    <?php echo e(__('at')); ?> <?php echo e(\Carbon\Carbon::parse($event->time)->format('h:i A')); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center text-muted py-3">
                            <i class="ti ti-bell-off" style="font-size: 28px;"></i>
                            <p class="mt-2 mb-0"><?php echo e(__('No recent event notifications yet.')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

    </div>
</div>

<!-- ✅ Include Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Activate searchable dropdowns
    $('.member-select').select2({
        placeholder: "Search member...",
        allowClear: true,
        width: '100%'
    });

    // Add program row dynamically
    document.getElementById('addProgramRow').addEventListener('click', function() {
        const table = document.querySelector('#programTable tbody');
        const newRow = document.createElement('tr');
        const count = table.rows.length + 1;
        let memberOptions = `<?php echo $members->map(fn($m)=>"<option value='{$m->id}'>{$m->name}</option>")->implode(''); ?>`;
        newRow.innerHTML = `
            <td>${count}</td>
            <td><input type="text" class="form-control" name="program_item[]" placeholder="Program name"></td>
            <td><input type="number" class="form-control" name="duration[]" value="10"></td>
            <td>
                <select class="form-select member-select" name="leader[]">
                    <option value="">Select Member</option>
                    ${memberOptions}
                </select>
            </td>
            <td><input type="text" class="form-control" name="note[]" placeholder="Notes"></td>
            <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-x"></i></button></td>
        `;
        table.appendChild(newRow);
        $('.member-select').select2({ placeholder: "Search member...", width: '100%' });
    });

    document.addEventListener('click', function(e) {
        if(e.target.closest('.removeRow')) e.target.closest('tr').remove();
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const modeSelector = document.getElementById('mode-selector');
    const onlineConfig = document.getElementById('online-config');
    const createZoomMeeting = document.getElementById('create_zoom_meeting');
    const onlinePlatform = document.getElementById('online_platform');
    const branchSelect = document.getElementById('branch_id');
    const departmentSelect = document.getElementById('department_id');

    function toggleOnlineSection() {
        const val = modeSelector.value;
        onlineConfig.style.display = (val === 'online' || val === 'hybrid') ? 'block' : 'none';
    }

    function syncZoomPlatform() {
        if (createZoomMeeting && createZoomMeeting.checked) {
            onlinePlatform.value = 'zoom';
            if (modeSelector.value === 'onsite') {
                modeSelector.value = 'online';
            }
            toggleOnlineSection();
        }
    }

    function filterDepartments() {
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

    modeSelector.addEventListener('change', toggleOnlineSection);
    branchSelect.addEventListener('change', filterDepartments);
    if (createZoomMeeting) {
        createZoomMeeting.addEventListener('change', syncZoomPlatform);
    }

    filterDepartments();
    toggleOnlineSection(); // initialize on load
    syncZoomPlatform();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/attendance/events/create.blade.php ENDPATH**/ ?>