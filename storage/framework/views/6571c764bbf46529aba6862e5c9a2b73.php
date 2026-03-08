<?php $__env->startSection('page-title', __('Inventory')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('foodbank.inventory.create')); ?>" class="btn btn-primary"><?php echo e(__('Log inventory')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><?php echo e(__('Item')); ?></th>
                        <th><?php echo e(__('Category')); ?></th>
                        <th><?php echo e(__('Quantity')); ?></th>
                        <th><?php echo e(__('Pickup')); ?></th>
                        <th><?php echo e(__('Delivery')); ?></th>
                        <th class="text-end"><?php echo e(__('Received')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->item_name); ?></td>
                            <td><?php echo e($item->category); ?></td>
                            <td><?php echo e($item->quantity); ?> <?php echo e($item->unit); ?></td>
                            <td><?php echo e($item->pickup_location); ?></td>
                            <td><?php echo e($item->delivery_details); ?></td>
                            <td class="text-end"><?php echo e(optional($item->received_at)->format('Y-m-d')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($items->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\inventory\index.blade.php ENDPATH**/ ?>