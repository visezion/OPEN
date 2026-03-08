<?php $__env->startSection('page-title', __('Asset reports')); ?>
<?php $__env->startSection('page-breadcrumb', __('Assets')); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('assets.dashboard')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Dashboard')); ?></a>
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Inventory')); ?></a>
        <a href="<?php echo e(route('assets.settings.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Settings')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo e(__('Category breakdown')); ?></h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Quantity')); ?></th>
                                <th><?php echo e(__('Available')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $categoryBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($row->category ?? __('Uncategorized')); ?></td>
                                    <td><?php echo e($row->total_quantity); ?></td>
                                    <td><?php echo e($row->available_quantity); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <?php echo e(__('No data yet.')); ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo e(__('Branch distribution')); ?></h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Quantity')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $branchBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(optional($row->branch)->name ?? __('Headquarter')); ?></td>
                                    <td><?php echo e($row->total_quantity); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        <?php echo e(__('No data yet.')); ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo e(__('Inspection status')); ?></h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $inspectionStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span><?php echo e(ucfirst($row->status)); ?></span>
                                <span><?php echo e($row->total); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="list-group-item text-muted">
                                <?php echo e(__('No inspections logged yet.')); ?>

                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo e(__('Active movements')); ?></h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $movementSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><?php echo e(optional($summary->asset)->asset_name ?? __('Unknown')); ?></span>
                                    <strong><?php echo e($summary->total); ?></strong>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="list-group-item text-muted">
                                <?php echo e(__('No movements recorded yet.')); ?>

                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\reports.blade.php ENDPATH**/ ?>