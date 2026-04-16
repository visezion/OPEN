<?php $__env->startSection('page-title', __('Food Bank Dashboard')); ?>
<?php $__env->startSection('page-breadcrumb', __('Food Bank')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('foodbank.donors.index')); ?>" class="btn btn-primary"><?php echo e(__('Manage Donors')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3">
        <div class="col-xxl-4 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1"><?php echo e(__('Donors registered')); ?></p>
                    <h3 class="mb-0"><?php echo e($totals['donors']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1"><?php echo e(__('Inventory items available')); ?></p>
                    <h3 class="mb-0"><?php echo e($totals['inventory_items']); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-1"><?php echo e(__('Distributions completed')); ?></p>
                    <h3 class="mb-0"><?php echo e($totals['distributed']); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-xxl-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Recent donors')); ?></h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?php echo e($donor->name); ?></strong><br>
                                        <small class="text-muted"><?php echo e($donor->phone ?? $donor->email ?? __('Contact not available')); ?></small>
                                    </div>
                                    <span class="badge rounded-pill bg-soft-info text-info"><?php echo e($donor->preferred_pickup ?? __('Pickup')); ?></span>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="list-group-item text-muted"><?php echo e(__('No donors yet')); ?></li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Tips for helpers')); ?></h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled lh-lg">
                        <li><?php echo e(__('Log donations immediately so allocation is accurate.')); ?></li>
                        <li><?php echo e(__('Keep pickup and delivery details handy so donors know where to drop off.')); ?></li>
                        <li><?php echo e(__('Ask about dietary restrictions and number of children before packing the box.')); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\dashboard\index.blade.php ENDPATH**/ ?>