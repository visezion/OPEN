
<?php if($customer->is_disable == 1): ?>
<span>
    <?php if(!empty($customer['customer_id'])): ?>
        <?php if (app('laratrust')->hasPermission('customer show')) : ?>
        <div class="action-btn  me-2">
            <a href="<?php echo e(route('customer.show',\Crypt::encrypt($customer['id']))); ?>" class="mx-3 btn btn-sm align-items-center bg-warning"
            data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>">
                <i class="ti ti-eye text-white text-white"></i>
            </a>
        </div>
        <?php endif; // app('laratrust')->permission ?>
    <?php endif; ?>
    <?php if (app('laratrust')->hasPermission('customer edit')) : ?>
        <div class="action-btn  me-2">
            <a  class="mx-3 btn bg-info btn-sm  align-items-center"
                data-url="<?php echo e(route('customer.edit',$customer['id'])); ?>" data-ajax-popup="true"  data-size="lg"
                data-bs-toggle="tooltip" title=""
                data-title="<?php echo e(__('Edit Customer')); ?>"
                data-bs-original-title="<?php echo e(__('Edit')); ?>">
                <i class="ti ti-pencil text-white"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if(!empty($customer['customer_id'])): ?>
        <?php if (app('laratrust')->hasPermission('customer delete')) : ?>
            <div class="action-btn">
                <?php echo e(Form::open(array('route'=>array('customer.destroy', $customer['id']),'class' => 'm-0'))); ?>

                <?php echo method_field('DELETE'); ?>
                    <a
                        class="mx-3 bg-danger btn btn-sm  align-items-center bs-pass-para show_confirm"
                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                        aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($customer['id']); ?>"><i
                            class="ti ti-trash text-white text-white"></i></a>
                <?php echo e(Form::close()); ?>

            </div>
        <?php endif; // app('laratrust')->permission ?>
    <?php endif; ?>
</span>
<?php else: ?>
<div class="action-btn">
    <a href="#" class="btn btn-sm d-inline-flex align-items-center bg-dark" data-title="<?php echo e(__('Lock')); ?>"
        data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Customer Is Disable')); ?>"><span class="text-white"><i
                class="ti ti-lock"></i></span>
    </a>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customer\action.blade.php ENDPATH**/ ?>