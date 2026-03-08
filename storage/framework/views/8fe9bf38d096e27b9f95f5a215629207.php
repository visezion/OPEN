<?php $__env->startSection('page-title', __('Asset dashboard')); ?>
<?php $__env->startSection('page-breadcrumb', __('Assets')); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Inventory')); ?></a>
        <a href="<?php echo e(route('assets.reports')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Reports')); ?></a>
        <a href="<?php echo e(route('assets.settings.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Settings')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Total items')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['total_items']); ?></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Quantity on record')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['total_quantity']); ?></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Available')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['available_quantity']); ?></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Low stock alerts')); ?></h6>
                <strong class="fs-4 text-danger"><?php echo e($stats['low_stock']); ?></strong>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5><?php echo e(__('Recent movements')); ?></h5>
                    <p class="text-muted"><?php echo e(__('Latest transfers tracked per asset.')); ?></p>
                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $recentMovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <strong><?php echo e($movement->asset->asset_name ?? __('Unknown asset')); ?></strong>
                                <div class="text-muted small">
                                    <?php echo e($movement->quantity); ?> <?php echo e(__('items')); ?> · <?php echo e($movement->moved_at->diffForHumans()); ?>

                                </div>
                                <div class="text-muted small">
                                    <?php echo e(__('From')); ?> <?php echo e(optional($movement->fromBranch)->name ?? __('N/A')); ?>

                                    <?php echo e(__('to')); ?> <?php echo e(optional($movement->toBranch)->name ?? __('N/A')); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="list-group-item text-muted">
                                <?php echo e(__('No recent movements.')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5><?php echo e(__('Recent inspections')); ?></h5>
                    <p class="text-muted"><?php echo e(__('Track latest audit statuses.')); ?></p>
                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $recentInspections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <strong><?php echo e($inspection->asset->asset_name ?? __('Unknown asset')); ?></strong>
                                <div class="text-muted small">
                                    <?php echo e(__('Status')); ?>: <?php echo e($inspection->status); ?>

                                    · <?php echo e($inspection->inspected_at->format('Y-m-d H:i')); ?>

                                </div>
                                <?php if($inspection->findings): ?>
                                    <div class="text-muted small">
                                        <?php echo e(\Illuminate\Support\Str::limit($inspection->findings, 80)); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="list-group-item text-muted">
                                <?php echo e(__('No inspections logged.')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5><?php echo e(__('Notification settings')); ?></h5>
                    <p class="text-muted"><?php echo e(__('Delivery preferences for low stock and inspection reminders.')); ?></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo e(__('Methods')); ?></span>
                            <span class="text-primary">
                                <?php echo e(implode(', ', $settings->notification_methods ?? []) ?: __('Not configured')); ?>

                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo e(__('Low stock threshold')); ?></span>
                            <span><?php echo e($settings->low_stock_threshold); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo e(__('Inspection reminder (days)')); ?></span>
                            <span><?php echo e($settings->inspection_reminder_days); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo e(__('Notification time')); ?></span>
                            <span><?php echo e($settings->notification_time ?? __('Anytime')); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\dashboard.blade.php ENDPATH**/ ?>