<?php $__env->startSection('page-title', __('Distributions')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('foodbank.distributions.create')); ?>" class="btn btn-primary"><?php echo e(__('Log distribution')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th><?php echo e(__('Request')); ?></th>
                        <th><?php echo e(__('Item')); ?></th>
                        <th><?php echo e(__('Method')); ?></th>
                        <th><?php echo e(__('Quantity')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th class="text-end"><?php echo e(__('Scheduled')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($record->request->requester_name); ?></td>
                            <td><?php echo e(optional($record->inventory)->item_name); ?></td>
                            <td><?php echo e(ucfirst($record->method)); ?></td>
                            <td><?php echo e($record->quantity_distributed); ?></td>
                            <td><?php echo e(ucfirst($record->status)); ?></td>
                            <td class="text-end"><?php echo e(optional($record->scheduled_at)->format('Y-m-d')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($records->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\distributions\index.blade.php ENDPATH**/ ?>