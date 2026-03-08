<?php $__env->startSection('page-title', __('Edit donor')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('foodbank.donors.update', $donor)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Name')); ?></label>
                    <input type="text" name="name" value="<?php echo e(old('name', $donor->name)); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Phone')); ?></label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $donor->phone)); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Email')); ?></label>
                    <input type="email" name="email" value="<?php echo e(old('email', $donor->email)); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Address')); ?></label>
                    <textarea name="address" class="form-control"><?php echo e(old('address', $donor->address)); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?php echo e(__('Notes')); ?></label>
                    <textarea name="notes" class="form-control"><?php echo e(old('notes', $donor->notes)); ?></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Preferred pickup')); ?></label>
                        <input type="text" name="preferred_pickup" class="form-control" value="<?php echo e(old('preferred_pickup', $donor->preferred_pickup)); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Preferred delivery')); ?></label>
                        <input type="text" name="preferred_delivery" class="form-control" value="<?php echo e(old('preferred_delivery', $donor->preferred_delivery)); ?>">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e(__('Update donor')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\donors\edit.blade.php ENDPATH**/ ?>