<?php $__env->startSection('page-title', __('Food Bank Reports')); ?>
<?php $__env->startSection('content'); ?>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3">
                <p class="text-muted mb-1"><?php echo e(__('Inventory on hand')); ?></p>
                <h3><?php echo e($summary['total_inventory']); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <p class="text-muted mb-1"><?php echo e(__('Donors registered')); ?></p>
                <h3><?php echo e($summary['donors']); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <p class="text-muted mb-1"><?php echo e(__('Distributions')); ?></p>
                <h3><?php echo e($summary['distributions']); ?></h3>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\reports\index.blade.php ENDPATH**/ ?>