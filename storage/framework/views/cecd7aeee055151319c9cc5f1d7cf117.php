<?php echo $__env->yieldPushContent('purchase-signature'); ?>
<div class="action-btn me-2">
    <a href="#" class="btn btn-sm align-items-center cp_link bg-primary"
        data-link="<?php echo e(route('purchases.link.copy', \Crypt::encrypt($purchase->id))); ?>" data-bs-toggle="tooltip"
        title="<?php echo e(__('Copy')); ?>" data-original-title="<?php echo e(__('Click to copy purchasse link')); ?>">
        <i class="ti ti-file text-white"></i>
    </a>
</div>
<?php if (app('laratrust')->hasPermission('purchase show')) : ?>
    <div class="action-btn me-2">
        <a href="<?php echo e(route('purchases.show', \Crypt::encrypt($purchase->id))); ?>"
            class="mx-3 btn btn-sm align-items-center bg-warning" data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>"
            data-original-title="<?php echo e(__('Detail')); ?>">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($purchase->status != 4): ?>
    <?php if (app('laratrust')->hasPermission('purchase edit')) : ?>
        <div class="action-btn me-2">
            <a href="<?php echo e(route('purchases.edit', \Crypt::encrypt($purchase->id))); ?>"
                class="mx-3 btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" title="Edit"
                data-original-title="<?php echo e(__('Edit')); ?>">
                <i class="ti ti-pencil text-white"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('purchase delete')) : ?>
        <div class="action-btn">
            <?php echo Form::open([
                'method' => 'DELETE',
                'route' => ['purchases.destroy', $purchase->id],
                'class' => 'delete-form-btn',
                'id' => 'delete-form-' . $purchase->id,
            ]); ?>

            <a href="#" class="mx-3 btn btn-sm align-items-center show_confirm bg-danger" data-bs-toggle="tooltip"
                title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>"
                data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                data-confirm-yes="document.getElementById('delete-form-<?php echo e($purchase->id); ?>').submit();">
                <i class="ti ti-trash text-white"></i>
            </a>
            <?php echo Form::close(); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\action.blade.php ENDPATH**/ ?>