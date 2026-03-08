<?php $__env->startSection('page-title', __('Asset inventory')); ?>
<?php $__env->startSection('page-breadcrumb', 'Assets,Inventory'); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('assets.dashboard')); ?>" class="btn btn-outline-secondary">
            <?php echo e(__('Dashboard')); ?>

        </a>
        <a href="<?php echo e(route('assets.reports')); ?>" class="btn btn-outline-secondary">
            <?php echo e(__('Reports')); ?>

        </a>
        <a href="<?php echo e(route('assets.export', ['format' => 'excel'])); ?>" class="btn btn-outline-secondary">
            <?php echo e(__('Export Excel')); ?>

        </a>
        <a href="<?php echo e(route('assets.export', ['format' => 'pdf'])); ?>" class="btn btn-outline-secondary">
            <?php echo e(__('Export PDF')); ?>

        </a>
        <a href="<?php echo e(route('assets.print')); ?>" class="btn btn-outline-secondary" target="_blank">
            <?php echo e(__('Print')); ?>

        </a>
        <a href="<?php echo e(route('assets.settings.index')); ?>" class="btn btn-outline-secondary">
            <?php echo e(__('Settings')); ?>

        </a>
        <a href="<?php echo e(route('assets.create')); ?>" class="btn btn-primary">
            <?php echo e(__('Add asset')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Total items')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['total_items']); ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Total quantity')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['total_quantity']); ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Low stock alerts')); ?></h6>
                <strong class="fs-4 text-danger"><?php echo e($stats['low_stock']); ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Movements')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['movements']); ?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-uppercase text-muted mb-1"><?php echo e(__('Inspections')); ?></h6>
                <strong class="fs-4"><?php echo e($stats['inspections']); ?></strong>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label"><?php echo e(__('Branch')); ?></label>
                    <select name="branch_id" class="form-select">
                        <option value=""><?php echo e(__('Any branch')); ?></option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e($filters['branch_id'] == $id ? 'selected' : ''); ?>>
                                <?php echo e($name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><?php echo e(__('Department')); ?></label>
                    <select name="department_id" class="form-select">
                        <option value=""><?php echo e(__('Any department')); ?></option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e($filters['department_id'] == $id ? 'selected' : ''); ?>>
                                <?php echo e($name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><?php echo e(__('Category')); ?></label>
                    <select name="category" class="form-select">
                        <option value=""><?php echo e(__('All categories')); ?></option>
                        <?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php echo e($filters['category'] == $category ? 'selected' : ''); ?>>
                                <?php echo e($category); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                    <select name="status" class="form-select">
                        <option value=""><?php echo e(__('Any status')); ?></option>
                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e($filters['status'] == $value ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-12 text-end">
                    <button class="btn btn-light border"><?php echo e(__('Apply filters')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th><?php echo e(__('Asset')); ?></th>
                        <th><?php echo e(__('Category')); ?></th>
                        <th><?php echo e(__('Location')); ?></th>
                        <th><?php echo e(__('Quantity')); ?></th>
                        <th><?php echo e(__('Available')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th class="text-end"><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($asset->asset_name); ?></strong><br>
                                <small class="text-muted"><?php echo e($asset->asset_code); ?></small>
                            </td>
                            <td><?php echo e($asset->category ?? __('General')); ?></td>
                            <td><?php echo e($asset->location ?? __('Not set')); ?></td>
                            <td><?php echo e($asset->quantity); ?></td>
                            <td><?php echo e($asset->available_quantity); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($asset->status == 'operational' ? 'success' : 'secondary'); ?>">
                                    <?php echo e($statusOptions[$asset->status] ?? ucfirst($asset->status)); ?>

                                </span>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('assets.edit', $asset)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('asset inventory delete')): ?>
                                    <form action="<?php echo e(route('assets.destroy', $asset)); ?>" method="post" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('<?php echo e(__('Are you sure?')); ?>');">
                                            <?php echo e(__('Delete')); ?>

                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <?php echo e(__('No assets recorded yet.')); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($assets->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/assets/index.blade.php ENDPATH**/ ?>