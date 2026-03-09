

<?php $__env->startSection('page-title', __('Church Events')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('churchly.events.create')); ?>" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i> <?php echo e(__('Add New Event')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-lg-9">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="mb-0 fw-bold"><?php echo e(__('Upcoming & Past Events')); ?></h5>
                    <small class="text-muted"><?php echo e(__('View, manage, and organize all your church events in one place.')); ?></small>
                </div>
                
            </div>

            <div class="card-body">
                
                <form method="GET" class="row g-2 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="<?php echo e(__('Search by title or description...')); ?>" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="event_type" class="form-select form-select-sm">
                            <option value=""><?php echo e(__('All Types')); ?></option>
                            <option value="worship" <?php echo e(request('event_type') == 'worship' ? 'selected' : ''); ?>><?php echo e(__('Worship')); ?></option>
                            <option value="meeting" <?php echo e(request('event_type') == 'meeting' ? 'selected' : ''); ?>><?php echo e(__('Meeting')); ?></option>
                            <option value="training" <?php echo e(request('event_type') == 'training' ? 'selected' : ''); ?>><?php echo e(__('Training')); ?></option>
                            <option value="outreach" <?php echo e(request('event_type') == 'outreach' ? 'selected' : ''); ?>><?php echo e(__('Outreach')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control form-control-sm" value="<?php echo e(request('date')); ?>">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="ti ti-search"></i> <?php echo e(__('Filter')); ?>

                        </button>
                    </div>
                </form>

                
                <?php if($events->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Time')); ?></th>
                                    <th><?php echo e(__('Type')); ?></th>
                                     <th class="text-center"><?php echo e(__('Status')); ?></th>
                                    <th class="text-center"><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('churchly.events.show', $event->id)); ?>" class="fw-semibold text-primary">
                                            <?php echo e($event->title); ?>

                                        </a>
                                        <br>
                                        <small class="text-muted"><?php echo e(Str::limit($event->description, 60)); ?></small>
                                    </td>
                                    <td><?php echo e(\Carbon\Carbon::parse($event->date)->format('M d, Y')); ?></td>
                                    <td> <?php echo e($event->start_time ? date('h:i A', strtotime($event->start_time)) : '—'); ?> -  <?php echo e($event->end_time ? date('h:i A', strtotime($event->end_time)) : '—'); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($event->event_type == 'worship' ? 'info' : ($event->event_type == 'meeting' ? 'warning' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($event->event_type)); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?php echo e(\Carbon\Carbon::parse($event->date)->isFuture() ? 'bg-success' : 'bg-secondary'); ?>">
                                            <?php echo e(\Carbon\Carbon::parse($event->date)->isFuture() ? __('Upcoming') : __('Completed')); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('churchly.events.approve', $event->id)); ?>" class="btn btn-sm btn-outline-success" title="<?php echo e(__('View Approval')); ?>">
                                                <i class="ti ti-checks"></i>
                                            </a>     
                                            <a href="<?php echo e(route('churchly.events.review', $event->id)); ?>" class="btn btn-sm btn-outline-warning" title="<?php echo e(__('View Preview')); ?>">
                                                <i class="ti ti-check"></i>
                                            </a>    
                                            <a href="<?php echo e(route('churchly.events.show', $event->id)); ?>" class="btn btn-sm btn-outline-primary" title="<?php echo e(__('View Details')); ?>">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('churchly.events.edit', $event->id)); ?>" class="btn btn-sm btn-outline-secondary" title="<?php echo e(__('Edit Event')); ?>">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('churchly.events.destroy', $event->id)); ?>" 
                                                method="POST" 
                                                onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this event?')); ?>');" 
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <?php echo e($events->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="ti ti-calendar-event text-muted" style="font-size: 48px;"></i>
                        <h6 class="mt-3"><?php echo e(__('No events found')); ?></h6>
                        <p class="text-muted"><?php echo e(__('Start by creating your first event to manage your church activities effectively.')); ?></p>
                        <a href="<?php echo e(route('churchly.events.create')); ?>" class="btn btn-primary mt-2">
                            <i class="ti ti-plus"></i> <?php echo e(__('Create Your First Event')); ?>

                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-lg-3 mt-4 mt-lg-0">
        
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header  text-white py-2">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> <?php echo e(__('Instruction & Tips')); ?></h6>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li>Use the <strong>Filter</strong> bar to quickly find specific events by type or date.</li>
                    <li>Click <strong>“View”</strong> to open full event details including description and participants.</li>
                    <li>Use <strong>“Edit”</strong> to update the event’s date, time, or venue.</li>
                    <li>Only delete an event if it’s canceled — this action cannot be undone.</li>
                    <li>Completed or past events are automatically archived in the database.</li>
                </ul>
            </div>
        </div>

       
           

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/attendance/events/index.blade.php ENDPATH**/ ?>