

<?php $__env->startSection('page-title', __('Setup Attendance Event')); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchmeet.events.index')); ?>" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-calendar"></i> <?php echo e(__('View All Events')); ?>

    </a>
    <a href="<?php echo e(route('churchmeet.attendance_events.index')); ?>" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-list-details"></i> <?php echo e(__('View All Attendance Events')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row attendance-events-create">
    
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-clipboard-check text-primary"></i> <?php echo e(__('Create Attendance Event')); ?>

                </h5>
                <small class="text-muted">
                    <?php echo e(__('Link attendance tracking to an existing event and configure the attendance process.')); ?>

                </small>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="<?php echo e(route('churchmeet.attendance_events.store')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-calendar-event text-primary"></i> <?php echo e(__('Select Event')); ?>

                        </label>
                        <select name="event_id" class="form-select" required>
                            <option value="" disabled selected><?php echo e(__('-- Choose an Event --')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($event->id); ?>">
                                    <?php echo e($event->title); ?> (<?php echo e(\Carbon\Carbon::parse($event->date)->format('M d, Y')); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <?php echo e(__('The attendance event will be linked to this main event record.')); ?>

                        </small>
                    </div>

                    
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

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$value, $label, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="<?php echo e($value); ?>" id="method-<?php echo e($value); ?>" class="form-check-input">
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

                    
                    <div id="online-config" class="mb-4 churchmeet-hidden">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> <?php echo e(__('Online Configuration (Optional)')); ?>

                        </label>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="online_platform" placeholder="<?php echo e(__('Platform (e.g., Zoom, YouTube)')); ?>" class="form-control">
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

                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-4 text-secondary"></i> <?php echo e(__('Check-in Opens At')); ?>

                            </label>
                            <input type="datetime-local" name="checkin_start_at" class="form-control" value="<?php echo e(old('checkin_start_at')); ?>">
                            <small class="text-muted"><?php echo e(__('Optional time window start for check-in')); ?></small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-12 text-secondary"></i> <?php echo e(__('Check-in Closes At')); ?>

                            </label>
                            <input type="datetime-local" name="checkin_end_at" class="form-control" value="<?php echo e(old('checkin_end_at')); ?>">
                            <small class="text-muted"><?php echo e(__('Optional time window end for check-in')); ?></small>
                        </div>
                    </div>

                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="ti ti-device-floppy"></i> <?php echo e(__('Save Attendance Event')); ?>

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
                    <i class="ti ti-bulb"></i> <?php echo e(__('Setup Tips & Guidance')); ?>

                </h5>
            </div>
            <div class="card-body small text-muted">
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('How to Configure:')); ?></p>
                <ul class="ps-3 mb-3">
                    <li><strong><?php echo e(__('Select Event:')); ?></strong> Choose the parent event (e.g., Sunday Service).</li>
                    <li><strong><?php echo e(__('Mode:')); ?></strong> Choose onsite, online, or hybrid attendance type.</li>
                    <li><strong><?php echo e(__('Methods:')); ?></strong> Decide how members will check in (QR, Face AI, etc.).</li>
                    <li><strong><?php echo e(__('Online Config:')); ?></strong> Add Zoom/YouTube details for live streaming.</li>
                    <li><strong><?php echo e(__('Auto Logging:')); ?></strong> Use for automatic presence detection.</li>
                </ul>
                <hr>
                <p class="fw-semibold text-dark mb-2"><?php echo e(__('Best Practices:')); ?></p>
                <ul class="ps-3 mb-0">
                    <li>Keep method selection minimal for clarity.</li>
                    <li>Hybrid events offer maximum engagement.</li>
                    <li>Test AI/QR methods before the event starts.</li>
                    <li>Securely share meeting links only with verified members.</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeSelector = document.getElementById('mode-selector');
    const onlineConfig = document.getElementById('online-config');

    function toggleOnlineSection() {
        const val = modeSelector.value;
        onlineConfig.style.display = (val === 'online' || val === 'hybrid') ? 'block' : 'none';
    }

    modeSelector.addEventListener('change', toggleOnlineSection);
    toggleOnlineSection(); // initialize on load
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\attendance_events\create.blade.php ENDPATH**/ ?>