

<?php $__env->startSection('page-title', __('Designations')); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5><?php echo e(__('Church Designations')); ?></h5>
        <a href="<?php echo e(route('churchdesignation.create')); ?>" class="btn btn-sm btn-primary"><?php echo e(__('Add Designation')); ?></a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><?php echo e(__('Name')); ?></th>
                    <th><?php echo e(__('Branch')); ?></th>
                    <th><?php echo e(__('Action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($designation->name); ?></td>
                        <td><?php echo e($designation->branch->name ?? '-'); ?></td>
                        <td>
                            <a href="<?php echo e(route('churchdesignation.edit', $designation)); ?>" class="btn btn-sm btn-warning"><?php echo e(__('Edit')); ?></a>
                            <form action="<?php echo e(route('churchdesignation.destroy', $designation)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger" onclick="return confirm('<?php echo e(__('Are you sure?')); ?>')"><?php echo e(__('Delete')); ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3"><?php echo e(__('No designations found.')); ?></td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\churchdesignation\index.blade.php ENDPATH**/ ?>