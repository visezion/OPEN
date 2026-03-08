<?php $__env->startSection('page-title', __('Donors')); ?>
<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('foodbank.donors.create')); ?>" class="btn btn-primary"><?php echo e(__('Add donor')); ?></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th><?php echo e(__('Name')); ?></th>
                        <th><?php echo e(__('Contact')); ?></th>
                        <th><?php echo e(__('Preferred')); ?></th>
                        <th class="text-end"><?php echo e(__('Actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $donors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($donor->name); ?></td>
                            <td><?php echo e($donor->phone); ?><br><?php echo e($donor->email); ?></td>
                            <td>
                                <?php echo e($donor->preferred_pickup); ?> / <?php echo e($donor->preferred_delivery); ?>

                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('foodbank.donors.edit', $donor)); ?>" class="btn btn-sm btn-outline-secondary"><?php echo e(__('Edit')); ?></a>
                                <form action="<?php echo e(route('foodbank.donors.destroy', $donor)); ?>" method="post" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('<?php echo e(__('Delete donor?')); ?>');">
                                        <?php echo e(__('Delete')); ?>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($donors->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\FoodBank\src\Resources\views\donors\index.blade.php ENDPATH**/ ?>