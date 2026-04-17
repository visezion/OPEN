<?php $__env->startSection('page-title', __('Attendance Events')); ?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchmeet.attendance_events.create')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i> <?php echo e(__('New Attendance Event')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row attendance-events-page">
    
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0"><?php echo e(__('Attendance Events Management')); ?></h5>
                    <small class="text-muted"><?php echo e(__('Track and monitor attendance records for all church gatherings and programs.')); ?></small>
                </div>
                
            </div>

            
            <div class="card-body pb-0">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light-subtle text-center py-2">
                            <div class="card-body p-2">
                                <i class="ti ti-calendar text-primary fs-4 mb-1 d-block"></i>
                                <div class="fw-bold fs-6"><?php echo e($attendanceEvents->total()); ?></div>
                                <div class="text-muted small"><?php echo e(__('Total Events')); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light-subtle text-center py-2">
                            <div class="card-body p-2">
                                <i class="ti ti-wifi text-info fs-4 mb-1 d-block"></i>
                                <div class="fw-bold fs-6"><?php echo e($attendanceEvents->where('mode', 'online')->count()); ?></div>
                                <div class="text-muted small"><?php echo e(__('Online')); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light-subtle text-center py-2">
                            <div class="card-body p-2">
                                <i class="ti ti-building-church text-success fs-4 mb-1 d-block"></i>
                                <div class="fw-bold fs-6"><?php echo e($attendanceEvents->where('mode', 'onsite')->count()); ?></div>
                                <div class="text-muted small"><?php echo e(__('Onsite')); ?></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            

            
            <div class="card-body pt-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvents->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th><?php echo e(__('Event Name')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Mode')); ?></th>
                                    <th><?php echo e(__('Methods Enabled')); ?></th>
                                    <th class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attendanceEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendanceEvent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attendanceEvent->event): ?>
                                                <a href="<?php echo e(route('churchmeet.events.show', optional($attendanceEvent->event)->public_view_key ?? $attendanceEvent->event_id)); ?>" 
                                                class="fw-semibold text-primary text-decoration-none">
                                                    <?php echo e($attendanceEvent->event->title ?? __('N/A')); ?>

                                                </a>
                                                <br>
                                                <small class="text-muted">
                                                    <?php echo e($attendanceEvent->event->description 
                                                        ? Str::limit($attendanceEvent->event->description, 60) 
                                                        : __('No description provided')); ?>

                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo e(__('Event not found')); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>

                                        <td>
                                            <?php echo e($attendanceEvent->event && $attendanceEvent->event->date 
                                                ? \Carbon\Carbon::parse($attendanceEvent->event->date)->format('M d, Y') 
                                                : __('-')); ?>

                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($attendanceEvent->mode == 'online' ? 'info' : ($attendanceEvent->mode == 'hybrid' ? 'warning' : 'success')); ?>">
                                                <i class="ti <?php echo e($attendanceEvent->mode == 'online' ? 'ti-wifi' : ($attendanceEvent->mode == 'hybrid' ? 'ti-device-laptop' : 'ti-building-church')); ?>"></i>
                                                <?php echo e(ucfirst($attendanceEvent->mode)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($attendanceEvent->enabled_methods)): ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $attendanceEvent->enabled_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-secondary me-1">
                                                        <i class="ti ti-check"></i> <?php echo e(ucfirst($method)); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted"><?php echo e(__('No methods enabled')); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('churchmeet.attendance_events.show', $attendanceEvent->id)); ?>" 
                                                class="btn btn-sm btn-outline-primary" 
                                                title="<?php echo e(__('View Attendance Details')); ?>">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('churchmeet.attendance_events.edit', $attendanceEvent->id)); ?>" 
                                                class="btn btn-sm btn-outline-secondary" 
                                                title="<?php echo e(__('Edit Attendance Event')); ?>">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="<?php echo e(route('churchmeet.attendance_events.destroy', $attendanceEvent->id)); ?>" 
                                                    method="POST" 
                                                    onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this attendance event?')); ?>');" 
                                                    class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="<?php echo e(__('Delete Event')); ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($attendanceEvents->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="ti ti-user-check text-muted churchmeet-icon-48"></i>
                        <h6 class="mt-3 fw-semibold"><?php echo e(__('No Attendance Events Found')); ?></h6>
                        <p class="text-muted"><?php echo e(__('Start by creating a new attendance event to track members effectively.')); ?></p>
                        <a href="<?php echo e(route('churchmeet.attendance_events.create')); ?>" class="btn btn-primary mt-2">
                            <i class="ti ti-plus"></i> <?php echo e(__('Create First Attendance Event')); ?>

                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 mt-4 mt-lg-0">
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header text-white py-2">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> <?php echo e(__('Attendance Tips & Guidance')); ?></h6>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li>Use the <strong>mode</strong> (Online / Onsite / Hybrid) to manage event attendance effectively.</li>
                    <li>Enable suitable <strong>methods</strong> (QR code, manual entry, or ID scan) for tracking.</li>
                    <li>Click <strong>View</strong> to see who attended and their check-in times.</li>
                    <li>Attendance data is automatically synced with the member list.</li>
                    <li>Archived events can be accessed anytime for reports and analytics.</li>
                </ul>
            </div>
        </div>

        
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-bell"></i> <?php echo e(__('Recent Attendance Updates')); ?></h6>
                <a href="<?php echo e(route('churchmeet.attendance_events.index')); ?>" class="small text-muted"><?php echo e(__('View All')); ?></a>
            </div>
            <div class="card-body small">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="alert alert-<?php echo e($att->mode == 'online' ? 'info' : ($att->mode == 'hybrid' ? 'warning' : 'success')); ?> py-2 mb-2">
                        <i class="ti ti-calendar-event"></i> 
                        <strong><?php echo e($att->event->title ?? 'Unnamed Event'); ?></strong><br>
                        <span class="text-muted">
                            <?php echo e(__('Created on')); ?> <?php echo e($att->created_at->format('M d, Y h:i A')); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-3">
                        <i class="ti ti-bell-off fs-3"></i>
                        <p class="mt-2 mb-0"><?php echo e(__('No recent updates available.')); ?></p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\attendance\attendance_events\index.blade.php ENDPATH**/ ?>