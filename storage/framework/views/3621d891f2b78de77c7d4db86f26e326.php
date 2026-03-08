<?php
    use Illuminate\Support\Str;
?>



<?php $__env->startSection('page-title', $schedule->asset_name); ?>
<?php $__env->startSection('page-breadcrumb', 'Maintenance,Detail'); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('maintenance.calendar')); ?>" class="btn btn-outline-primary"><?php echo e(__('View calendar')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row gy-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Schedule overview')); ?></h5>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1"><?php echo e(__('Asset code')); ?></p>
                            <strong><?php echo e($schedule->asset_code); ?></strong>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><?php echo e(__('Next due')); ?></p>
                            <strong><?php echo e(optional($schedule->next_due_date)->toDateString()); ?></strong>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><?php echo e(__('Status')); ?></p>
                            <span class="badge bg-<?php echo e($schedule->status === 'active' ? 'success' : 'secondary'); ?>">
                                <?php echo e($statusOptions[$schedule->status] ?? ucfirst($schedule->status)); ?>

                            </span>
                        </div>
                        <div class="col-md-4 mt-3">
                            <p class="mb-1"><?php echo e(__('Assigned to')); ?></p>
                            <strong><?php echo e($schedule->assignedTo->name ?? __('Unassigned')); ?></strong>
                        </div>
                        <div class="col-md-4 mt-3">
                            <p class="mb-1"><?php echo e(__('Frequency')); ?></p>
                            <strong><?php echo e($frequencyOptions[$schedule->frequency_type] ?? ucfirst($schedule->frequency_type)); ?></strong>
                        </div>
                        <div class="col-md-4 mt-3">
                            <p class="mb-1"><?php echo e(__('Priority')); ?></p>
                            <strong><?php echo e(ucfirst($schedule->priority)); ?></strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <p class="mb-1"><?php echo e(__('Location')); ?></p>
                            <strong><?php echo e($schedule->location ?? __('Not set')); ?></strong>
                        </div>
                        <div class="col-md-6 mt-3">
                            <p class="mb-1"><?php echo e(__('Branch / department')); ?></p>
                            <strong>
                                <?php echo e($schedule->branch->name ?? __('Headquarters')); ?>

                                /
                                <?php echo e($schedule->department->name ?? __('General')); ?>

                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Maintenance log history')); ?></h5>
                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e(optional($log->due_date)->toDateString()); ?></strong>
                                        <span class="text-muted">(<?php echo e(ucfirst($log->status)); ?>)</span>
                                        <div class="small text-muted">
                                            <?php echo e($log->notes ? Str::limit($log->notes, 80) : __('No notes provided')); ?>

                                        </div>
                                    </div>
                                    <a href="<?php echo e(route('maintenance.logs.show', $log)); ?>" class="btn btn-sm btn-outline-secondary">
                                        <?php echo e(__('View log')); ?>

                                    </a>
                                </div>
                                <div class="mt-2 text-muted">
                                    <?php echo e(__('Performed by')); ?>: <?php echo e($log->performedBy->name ?? __('Pending')); ?>

                                    | <?php echo e(__('Cost')); ?>: <?php echo e($log->cost_incurred ?? '—'); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="list-group-item text-center text-muted">
                                <?php echo e(__('No logs recorded yet.')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-3">
                        <?php echo e($logs->links()); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e(__('Add maintenance log')); ?></h5>
                    <form action="<?php echo e(route('maintenance.logs.store', $schedule)); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Due date')); ?></label>
                            <input type="date" name="due_date" class="form-control" value="<?php echo e(now()->toDateString()); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Status')); ?></label>
                            <select name="status" class="form-select">
                                <?php $__currentLoopData = ['pending','in_progress','completed','overdue','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $status))); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Performed by')); ?></label>
                            <select name="performed_by" class="form-select">
                                <option value=""><?php echo e(__('Select')); ?></option>
                                <?php $__currentLoopData = $assignableUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Notes')); ?></label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Cost incurred')); ?></label>
                            <input type="number" step="0.01" name="cost_incurred" class="form-control">
                        </div>
                        <button class="btn btn-primary w-100"><?php echo e(__('Save log')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\show.blade.php ENDPATH**/ ?>