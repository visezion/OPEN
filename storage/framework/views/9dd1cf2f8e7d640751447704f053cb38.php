<?php $__env->startSection('page-title', __('Request details')); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="btn-group">
        <a href="<?php echo e(route('foodbank.requests.edit', $requestEntry)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
        <a href="<?php echo e(route('foodbank.requests.approve', $requestEntry)); ?>" class="btn btn-sm btn-outline-success"><?php echo e(__('Approve')); ?></a>
        <a href="<?php echo e(route('foodbank.requests.reject', $requestEntry)); ?>" class="btn btn-sm btn-outline-danger"><?php echo e(__('Reject')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($requestEntry->requester_name); ?></h5>
                    <p class="text-muted mb-3"><?php echo e($requestEntry->phone); ?> &bull; <?php echo e($requestEntry->email ?? __('No email provided')); ?></p>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong><?php echo e(__('Status')); ?></strong>
                            <div><?php echo e($statusOptions[$requestEntry->status] ?? ucfirst($requestEntry->status)); ?></div>
                        </div>
                        <div class="col-md-4">
                            <strong><?php echo e(__('Delivery')); ?></strong>
                            <div><?php echo e($deliveryOptions[$requestEntry->delivery_preference] ?? '-'); ?></div>
                        </div>
                        <div class="col-md-4">
                            <strong><?php echo e(__('Family size')); ?></strong>
                            <div><?php echo e($requestEntry->family_size ?? '-'); ?></div>
                        </div>
                    </div>
                    <p><strong><?php echo e(__('Occupation')); ?>:</strong> <?php echo e($requestEntry->occupation ?? __('Not provided')); ?></p>
                    <p><strong><?php echo e(__('Children')); ?>:</strong> <?php echo e($requestEntry->children_count ?? '0'); ?></p>
                    <div class="mb-3">
                        <strong><?php echo e(__('Needs summary')); ?></strong>
                        <p><?php echo e($requestEntry->needs_description ?? __('No details yet.')); ?></p>
                    </div>
                    <?php if($requestEntry->delivery_preference === 'delivery'): ?>
                        <div class="mb-3">
                            <strong><?php echo e(__('Delivery address')); ?></strong>
                            <p><?php echo e($requestEntry->delivery_address ?? __('Not provided')); ?></p>
                            <?php if($requestEntry->delivery_map): ?>
                                <a href="<?php echo e($requestEntry->delivery_map); ?>" target="_blank" class="d-block small text-decoration-none">
                                    <?php echo e(__('Open map link')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <strong><?php echo e(__('Pickup location')); ?></strong>
                            <p><?php echo e($requestEntry->pickup_location ?? __('Not provided')); ?></p>
                        </div>
                    <?php endif; ?>
                    <div>
                        <strong><?php echo e(__('Notifications')); ?></strong>
                        <p class="small text-muted"><?php echo e(implode(', ', $requestEntry->notify_channels ?? []) ?: __('None')); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body">
                    <p class="small text-muted"><?php echo e(__('Last updated')); ?></p>
                    <h4><?php echo e($requestEntry->updated_at->format('d M Y, h:i A')); ?></h4>
                    <p class="text-muted mb-0"><?php echo e($requestEntry->updated_at->diffForHumans()); ?></p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <p class="mb-1 text-uppercase small text-muted"><?php echo e(__('Statuses')); ?></p>
                    <div class="d-flex flex-column gap-2">
                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between">
                                <span><?php echo e($label); ?></span>
                                <small class="text-muted"><?php echo e($requestEntry->status === $key ? __('Current') : ''); ?></small>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <hr>
                    <p class="text-muted small mb-0"><?php echo e(__('Approved by')); ?>: <?php echo e($requestEntry->approved_by ? $requestEntry->approved_by : __('Pending')); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Providers/../Resources/views/requests/show.blade.php ENDPATH**/ ?>