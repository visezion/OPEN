

<?php $__env->startSection('page-title', __('Edit Attendance Event')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.attendance_events.create')); ?>" class="btn btn-sm btn-outline-success">
        <i class="ti ti-plus"></i> <?php echo e(__('Create New Attendance Event')); ?>

    </a>
    <a href="<?php echo e(route('churchly.attendance_events.index')); ?>" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-list-details"></i> <?php echo e(__('View All Attendance Events')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-edit text-primary"></i> <?php echo e(__('Edit Attendance Event')); ?>

                </h5>
                <small class="text-muted">
                    <?php echo e(__('Modify the event linkage, attendance mode, or online configurations. Changes apply immediately after saving.')); ?>

                </small>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('churchly.attendance_events.update', $attendanceEvent->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-calendar-event text-primary"></i> <?php echo e(__('Linked Event')); ?>

                        </label>
                        <select disabled name="event_id" class="form-select" required>
                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($event->id); ?>"
                                    <?php echo e($attendanceEvent->event_id == $event->id ? 'selected' : ''); ?>>
                                    <?php echo e($event->title); ?> (<?php echo e(\Carbon\Carbon::parse($event->date)->format('M d, Y')); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <?php echo e(__('The event to which attendance tracking is linked.')); ?>

                        </small>
                    </div>

                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-building-church text-success"></i> <?php echo e(__('Mode')); ?>

                            </label>
                            <select name="mode" class="form-select" id="mode-selector">
                                <option value="onsite" <?php echo e($attendanceEvent->mode == 'onsite' ? 'selected' : ''); ?>>Onsite</option>
                                <option value="online" <?php echo e($attendanceEvent->mode == 'online' ? 'selected' : ''); ?>>Online</option>
                                <option value="hybrid" <?php echo e($attendanceEvent->mode == 'hybrid' ? 'selected' : ''); ?>>Hybrid</option>
                            </select>
                            <small class="text-muted d-block mt-1">
                                <?php echo e(__('Switch between onsite, online, or hybrid formats.')); ?>

                            </small>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-world text-info"></i> <?php echo e(__('Online Platform (Optional)')); ?>

                            </label>
                            <input type="text" name="online_platform" value="<?php echo e(old('online_platform', $attendanceEvent->online_platform)); ?>"
                                   class="form-control" placeholder="<?php echo e(__('e.g., Zoom, YouTube, or Church App')); ?>">
                            <small class="text-muted"><?php echo e(__('Only relevant for online or hybrid modes.')); ?></small>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-checks text-info"></i> <?php echo e(__('Enabled Attendance Methods')); ?>

                        </label>
                        <?php
                            $enabled = is_array($attendanceEvent->enabled_methods)
                                ? $attendanceEvent->enabled_methods
                                : json_decode($attendanceEvent->enabled_methods, true);
                        ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?php $__currentLoopData = ['manual' => 'Manual', 'qr' => 'QR Code', 'kiosk' => 'Kiosk (Self Check-in)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="<?php echo e($value); ?>"
                                               id="method-<?php echo e($value); ?>" class="form-check-input"
                                               <?php echo e(in_array($value, $enabled ?? []) ? 'checked' : ''); ?>>
                                        <label for="method-<?php echo e($value); ?>" class="form-check-label"><?php echo e(__($label)); ?></label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="col-md-6">
                                <?php $__currentLoopData = ['face_ai' => 'Face AI Detection', 'zoom' => 'Zoom Integration', 'youtube' => 'YouTube Live Tracking']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="<?php echo e($value); ?>"
                                               id="method-<?php echo e($value); ?>" class="form-check-input"
                                               <?php echo e(in_array($value, $enabled ?? []) ? 'checked' : ''); ?>>
                                        <label for="method-<?php echo e($value); ?>" class="form-check-label"><?php echo e(__($label)); ?></label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <?php echo e(__('Select multiple methods if needed. Members can use any of the enabled methods to check in.')); ?>

                        </small>
                    </div>

                    
                    <div id="online-config" class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> <?php echo e(__('Online Configuration')); ?>

                        </label>
                        <input type="text" name="meeting_link" placeholder="<?php echo e(__('Meeting/Stream Link')); ?>"
                               class="form-control mb-2" value="<?php echo e(old('meeting_link', $attendanceEvent->meeting_link)); ?>">
                        <input type="text" name="meeting_id" placeholder="<?php echo e(__('Meeting ID (Zoom)')); ?>"
                               class="form-control mb-2" value="<?php echo e(old('meeting_id', $attendanceEvent->meeting_id)); ?>">
                        <input type="text" name="meeting_passcode" placeholder="<?php echo e(__('Passcode (Zoom)')); ?>"
                               class="form-control" value="<?php echo e(old('meeting_passcode', $attendanceEvent->meeting_passcode)); ?>">
                        <small class="text-muted d-block mt-1">
                            <?php echo e(__('Only required if you’re using Online or Hybrid mode.')); ?>

                        </small>
                    </div>

                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-4 text-secondary"></i> <?php echo e(__('Check-in Opens At')); ?>

                            </label>
                            <input type="datetime-local" name="checkin_start_at" class="form-control"
                                   value="<?php echo e(old('checkin_start_at', $attendanceEvent->checkin_start_at ? date('Y-m-d\TH:i', strtotime($attendanceEvent->checkin_start_at)) : '')); ?>">
                            <small class="text-muted"><?php echo e(__('Optional time window start for check-in')); ?></small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-12 text-secondary"></i> <?php echo e(__('Check-in Closes At')); ?>

                            </label>
                            <input type="datetime-local" name="checkin_end_at" class="form-control"
                                   value="<?php echo e(old('checkin_end_at', $attendanceEvent->checkin_end_at ? date('Y-m-d\TH:i', strtotime($attendanceEvent->checkin_end_at)) : '')); ?>">
                            <small class="text-muted"><?php echo e(__('Optional time window end for check-in')); ?></small>
                        </div>
                    </div>

                    
                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" class="form-check-input" name="auto_log_attendance" id="auto_log_attendance"
                               <?php echo e($attendanceEvent->auto_log_attendance ? 'checked' : ''); ?>>
                        <label for="auto_log_attendance" class="form-check-label fw-semibold">
                            <i class="ti ti-activity text-warning"></i> <?php echo e(__('Enable Auto Attendance Logging')); ?>

                        </label>
                        <small class="text-muted d-block mt-1">
                            <?php echo e(__('Automatically record check-ins for connected digital platforms (Zoom, YouTube, etc.).')); ?>

                        </small>
                    </div>

                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy"></i> <?php echo e(__('Update Attendance Event')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white py-2">
                <h5 class="mb-0">
                    <i class="ti ti-bulb"></i> <?php echo e(__('Edit Tips & Guidance')); ?>

                </h5>
            </div>
            <div class="card-body small text-muted">
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('What You Can Update:')); ?></p>
                <ul class="ps-3 mb-3">
                    <li><strong><?php echo e(__('Linked Event:')); ?></strong> Reassign to another event if needed.</li>
                    <li><strong><?php echo e(__('Mode:')); ?></strong> Change between onsite, online, or hybrid.</li>
                    <li><strong><?php echo e(__('Methods:')); ?></strong> Enable or disable different check-in methods.</li>
                    <li><strong><?php echo e(__('Auto Logging:')); ?></strong> Toggle automatic attendance tracking.</li>
                </ul>
                <hr>
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('Helpful Notes:')); ?></p>
                <ul class="ps-3 mb-0">
                    <li>Hybrid mode requires both onsite and online configurations.</li>
                    <li>Zoom/YouTube fields are ignored if mode is onsite only.</li>
                    <li>Keep meeting links private for security reasons.</li>
                    <li>Use auto logging only if event integrations are stable.</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeSelector = document.getElementById('mode-selector');
    const onlineSection = document.getElementById('online-config');

    function toggleOnlineSection() {
        const value = modeSelector.value;
        onlineSection.style.display = (value === 'online' || value === 'hybrid') ? 'block' : 'none';
    }

    modeSelector.addEventListener('change', toggleOnlineSection);
    toggleOnlineSection(); // Initialize on load
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\attendance\attendance_events\edit.blade.php ENDPATH**/ ?>