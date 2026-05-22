<?php $__env->startSection('page-title', __('New donor')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('foodbank.donors.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Name')); ?></label>
                    <input type="text" name="name" value="<?php echo e(old('name', $defaults['name'])); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Phone')); ?></label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $defaults['phone'])); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Email')); ?></label>
                    <input type="email" name="email" value="<?php echo e(old('email', $defaults['email'])); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Address')); ?></label>
                    <textarea name="address" class="form-control"><?php echo e(old('address', $defaults['address'])); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Notes')); ?></label>
                    <textarea name="notes" class="form-control"><?php echo e(old('notes')); ?></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Preferred pickup')); ?></label>
                        <input type="text" name="preferred_pickup" class="form-control" value="<?php echo e(old('preferred_pickup')); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Preferred delivery')); ?></label>
                        <input type="text" name="preferred_delivery" class="form-control" value="<?php echo e(old('preferred_delivery')); ?>">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e(__('Save donor')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\donors\create.blade.php ENDPATH**/ ?>