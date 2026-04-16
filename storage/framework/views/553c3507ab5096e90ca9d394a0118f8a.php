<?php $__env->startSection('page-title', __('New distribution')); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('foodbank.distributions.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Request')); ?></label>
                        <select name="request_id" class="form-select" required>
                            <option value=""><?php echo e(__('Select a request')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($req->id); ?>"><?php echo e($req->requester_name); ?> (<?php echo e($req->quantity_needed); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo e(__('Inventory item')); ?></label>
                        <select name="inventory_id" class="form-select">
                            <option value=""><?php echo e(__('None')); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $inventory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->item_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Quantity')); ?></label>
                        <input type="number" name="quantity_distributed" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Method')); ?></label>
                        <select name="method" class="form-select" required>
                            <option value="pickup"><?php echo e(__('Pickup')); ?></option>
                            <option value="delivery"><?php echo e(__('Delivery')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Scheduled at')); ?></label>
                        <input type="datetime-local" name="scheduled_at" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo e(__('Delivery address')); ?></label>
                        <input type="text" name="delivery_address" class="form-control">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button class="btn btn-primary"><?php echo e(__('Record distribution')); ?></button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\distributions\create.blade.php ENDPATH**/ ?>