<?php $__env->startSection('page-title', __('Asset details')); ?>
<?php $__env->startSection('page-breadcrumb', __('Assets')); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Inventory')); ?></a>
        <a href="<?php echo e(route('assets.dashboard')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Dashboard')); ?></a>
        <a href="<?php echo e(route('assets.reports')); ?>" class="btn btn-outline-secondary"><?php echo e(__('Reports')); ?></a>
        <a href="<?php echo e(route('assets.edit', $asset)); ?>" class="btn btn-primary"><?php echo e(__('Edit asset')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between">
                <div>
                    <h4><?php echo e($asset->asset_name); ?></h4>
                    <p class="text-muted"><?php echo e($asset->asset_code); ?> · <?php echo e($asset->asset_tag); ?></p>
                </div>
                <div class="text-end">
                    <h5 class="mb-1"><?php echo e($asset->quantity); ?></h5>
                    <small class="text-muted"><?php echo e(__('on record')); ?></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <strong><?php echo e(__('Category')); ?></strong>
                    <p><?php echo e($asset->category ?? __('General')); ?></p>
                </div>
                <div class="col-md-3">
                    <strong><?php echo e(__('Branch')); ?></strong>
                    <p><?php echo e(optional($asset->branch)->name ?? __('Headquarters')); ?></p>
                </div>
                <div class="col-md-3">
                    <strong><?php echo e(__('Department')); ?></strong>
                    <p><?php echo e(optional($asset->department)->name ?? __('General')); ?></p>
                </div>
                <div class="col-md-3">
                    <strong><?php echo e(__('Status')); ?></strong>
                    <p>
                        <span class="badge bg-<?php echo e($asset->status == 'operational' ? 'success' : 'secondary'); ?>">
                            <?php echo e($statusOptions[$asset->status] ?? ucfirst($asset->status)); ?>

                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Movements')); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('assets.movements.store', $asset)); ?>" method="post" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Quantity')); ?></label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Reason')); ?></label>
                                <input type="text" name="reason" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Notes')); ?></label>
                                <input type="text" name="notes" class="form-control">
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-sm btn-primary"><?php echo e(__('Record movement')); ?></button>
                            </div>
                        </div>
                    </form>
                    <div class="list-group">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong><?php echo e($movement->quantity); ?> <?php echo e(__('items')); ?></strong>
                                    <small class="text-muted"><?php echo e($movement->moved_at->format('Y-m-d H:i')); ?></small>
                                </div>
                                <p class="mb-0 small text-muted">
                                    <?php echo e($movement->reason ?? __('Transfer update')); ?>

                                </p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="list-group-item text-muted">
                                <?php echo e(__('No movements recorded yet.')); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Inspections')); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('assets.inspections.store', $asset)); ?>" method="post" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Status')); ?></label>
                                <select name="status" class="form-select" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $inspectionStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Cost incurred')); ?></label>
                                <input type="number" step="0.01" name="cost_incurred" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Findings')); ?></label>
                                <textarea name="findings" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Inspected at')); ?></label>
                                <input type="datetime-local" name="inspected_at" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Next inspection')); ?></label>
                                <input type="date" name="next_inspection_date" class="form-control">
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-sm btn-primary"><?php echo e(__('Log inspection')); ?></button>
                            </div>
                        </div>
                    </form>
                    <div class="list-group">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $inspections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inspection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong><?php echo e($inspection->status); ?></strong>
                                    <small class="text-muted"><?php echo e($inspection->inspected_at->format('Y-m-d')); ?></small>
                                </div>
                                <p class="mb-0 small text-muted">
                                    <?php echo e($inspection->findings ?? __('No findings shared.')); ?>

                                </p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="list-group-item text-muted">
                                <?php echo e(__('No inspections recorded yet.')); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\assets\show.blade.php ENDPATH**/ ?>