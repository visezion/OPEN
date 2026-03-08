<?php $__env->startSection('page-title', __('Asset settings')); ?>
<?php $__env->startSection('page-breadcrumb', __('Assets')); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('assets.dashboard')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Dashboard')); ?></a>
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Inventory')); ?></a>
        <a href="<?php echo e(route('assets.reports')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Reports')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?php echo e(__('Notification preferences')); ?></h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('assets.settings.update')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Notification methods')); ?></label>
                        <div class="d-flex flex-wrap gap-2">
                            <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="notification_methods[]"
                                        value="<?php echo e($method); ?>" id="method-<?php echo e($method); ?>"
                                        <?php echo e(in_array($method, $settings->notification_methods ?? []) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="method-<?php echo e($method); ?>">
                                        <?php echo e(ucfirst($method)); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Notify time')); ?></label>
                        <input type="time" name="notification_time" class="form-control"
                            value="<?php echo e($settings->notification_time); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Low stock threshold')); ?></label>
                        <input type="number" name="low_stock_threshold" class="form-control"
                            value="<?php echo e($settings->low_stock_threshold ?? 5); ?>" min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><?php echo e(__('Inspection reminder days')); ?></label>
                        <input type="number" name="inspection_reminder_days" class="form-control"
                            value="<?php echo e($settings->inspection_reminder_days ?? 7); ?>" min="1">
                    </div>
                    <div class="col-12 text-end">
                        <button class="btn btn-primary"><?php echo e(__('Save settings')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\settings.blade.php ENDPATH**/ ?>