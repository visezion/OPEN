<?php $__env->startSection('page-title', __('Add inventory')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('foodbank.inventory.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Item name')); ?></label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Category')); ?></label>
                        <input type="text" name="category" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Quantity')); ?></label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Unit')); ?></label>
                        <input type="text" name="unit" class="form-control" value="pcs">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Received at')); ?></label>
                        <input type="date" name="received_at" class="form-control" value="<?php echo e(now()->toDateString()); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Pickup location')); ?></label>
                        <input type="text" name="pickup_location" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Delivery details')); ?></label>
                        <input type="text" name="delivery_details" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo e(__('Description')); ?></label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e(__('Log inventory')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\inventory\create.blade.php ENDPATH**/ ?>