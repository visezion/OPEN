<?php $__env->startSection('page-title', __('Maintenance Settings')); ?>
<?php $__env->startSection('page-breadcrumb', __('Maintenance')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-primary">
        <?php echo e(__('Back to schedules')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row gy-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><?php echo e(__('Notifications & Reminders')); ?></h5>
                    <span class="badge bg-info"><?php echo e(__('Workspace-level')); ?></span>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('maintenance.settings.update')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Notification methods')); ?></label>
                            <div class="form-check form-check-inline">
                                <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="notification_methods[]"
                                               value="<?php echo e($method); ?>" id="method_<?php echo e($method); ?>"
                                               <?php echo e(in_array($method, $settings->notification_methods ?: []) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="method_<?php echo e($method); ?>">
                                            <?php echo e(ucfirst($method)); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Notification time')); ?></label>
                            <input type="time" name="notification_time" class="form-control"
                                   value="<?php echo e($settings->notification_time); ?>">
                            <small class="text-muted"><?php echo e(__('Time when reminders are fired daily.')); ?></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Reminder lead time (days)')); ?></label>
                            <input type="number" name="reminder_before_days" class="form-control"
                                   value="<?php echo e($settings->reminder_before_days); ?>" min="0" max="30">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e(__('Default category')); ?></label>
                            <select name="default_category" class="form-select">
                                <option value=""><?php echo e(__('None')); ?></option>
                                <option value="General" <?php echo e($settings->default_category === 'General' ? 'selected' : ''); ?>>
                                    <?php echo e(__('General')); ?>

                                </option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->name); ?>"
                                            <?php echo e($settings->default_category === $category->name ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Save settings')); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Maintenance categories')); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('maintenance.settings.categories')); ?>" method="post" class="d-flex gap-2 mb-3">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="name" class="form-control" placeholder="<?php echo e(__('New category name')); ?>" required>
                        <button class="btn btn-success"><?php echo e(__('Add')); ?></button>
                    </form>
                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item d-flex align-items-center justify-content-between">
                                <span><?php echo e($category->name); ?></span>
                                <form action="<?php echo e(route('maintenance.settings.categories.destroy', $category)); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('delete'); ?>
                                    <button class="btn btn-outline-danger btn-sm"><?php echo e(__('Remove')); ?></button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted"><?php echo e(__('No custom categories yet.')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\maintenance\settings.blade.php ENDPATH**/ ?>