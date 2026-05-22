<span>
    <div class="action-btn me-2">
        <a href="<?php echo e(route('coupons.show',$coupon->id)); ?>" class="mx-3 btn btn-sm align-items-center bg-warning" data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
    <?php if (app('laratrust')->hasPermission('coupon edit')) : ?>
        <div class="action-btn me-2">
                <a href="#" class="mx-3 btn btn-sm align-items-center bg-info" data-size="lg" data-url="<?php echo e(route('coupons.edit',$coupon->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Coupon')); ?>" data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
                <i class="ti ti-pencil text-white"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('coupon delete')) : ?>
        <div class="action-btn">
            <?php echo e(Form::open(['route' => ['coupons.destroy', $coupon->id], 'class' => 'm-0'])); ?>

            <?php echo method_field('DELETE'); ?>
            <a href="#"
                class="mx-3 btn btn-sm align-items-center show_confirm bg-danger"
                data-bs-toggle="tooltip" title=""
                data-bs-original-title="<?php echo e(__('Delete')); ?>" aria-label="<?php echo e(__('Delete')); ?>"
                data-confirm-yes="delete-form-<?php echo e($coupon->id); ?>"><i
                    class="ti ti-trash text-white text-white"></i></a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>
</span>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\coupon\action.blade.php ENDPATH**/ ?>