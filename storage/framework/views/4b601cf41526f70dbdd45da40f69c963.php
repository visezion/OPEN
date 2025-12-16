<?php $__env->startSection('page-title', __('Food Bank Requests')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('foodbank.requests.create')); ?>" class="btn btn-primary"><?php echo e(__('New request')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1"><?php echo e(__('Pending')); ?></p>
                    <h3 class="mb-0"><?php echo e($stats['pending']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1"><?php echo e(__('Approved')); ?></p>
                    <h3 class="mb-0"><?php echo e($stats['approved']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1"><?php echo e(__('Rejected')); ?></p>
                    <h3 class="mb-0"><?php echo e($stats['rejected']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1"><?php echo e(__('Total requests')); ?></p>
                    <h3 class="mb-0"><?php echo e($stats['total']); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form class="row gy-2 gx-3 align-items-end" method="get">
                <div class="col-md-3">
                    <label class="form-label small"><?php echo e(__('Status')); ?></label>
                    <select name="status" class="form-select">
                        <option value=""><?php echo e(__('Any status')); ?></option>
                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(($filters['status'] ?? '') === $value ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small"><?php echo e(__('Delivery')); ?></label>
                    <select name="delivery_preference" class="form-select">
                        <option value=""><?php echo e(__('Any option')); ?></option>
                        <?php $__currentLoopData = $deliveryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(($filters['delivery_preference'] ?? '') === $value ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small"><?php echo e(__('Search')); ?></label>
                    <input type="text" name="search" class="form-control" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="<?php echo e(__('Name, phone, email')); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100"><?php echo e(__('Filter')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo e(__('Name')); ?></th>
                            <th><?php echo e(__('Delivery')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Updated')); ?></th>
                            <th class="text-end"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($entry->requester_name); ?></strong><br>
                                    <small class="text-muted"><?php echo e($entry->phone); ?> &bull; <?php echo e($entry->email ?? __('Not provided')); ?></small>
                                </td>
                                <td><?php echo e($deliveryOptions[$entry->delivery_preference] ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($entry->status === 'approved' ? 'success' : ($entry->status === 'rejected' ? 'danger' : 'secondary')); ?>">
                                        <?php echo e($statusOptions[$entry->status] ?? ucfirst($entry->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($entry->updated_at->diffForHumans()); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('foodbank.requests.show', $entry)); ?>" class="btn btn-sm btn-light"><?php echo e(__('View')); ?></a>
                                    <a href="<?php echo e(route('foodbank.requests.edit', $entry)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
                                    <form action="<?php echo e(route('foodbank.requests.destroy', $entry)); ?>" method="post" class="d-inline-block" onsubmit="return confirm('<?php echo e(__('Delete request?')); ?>')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-outline-danger"><?php echo e(__('Delete')); ?></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted"><?php echo e(__('No requests found yet.')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($requests->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Providers/../Resources/views/requests/index.blade.php ENDPATH**/ ?>