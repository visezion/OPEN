<?php echo $__env->yieldPushContent('bill-signature'); ?>
<?php if(Laratrust::hasPermission('bill edit') ||
        Laratrust::hasPermission('bill delete') ||
        Laratrust::hasPermission('bill show') ||
        Laratrust::hasPermission('bill duplicate')): ?>
    <span>
        <div class="action-btn  me-2">
            <a href="#" class="bg-primary btn btn-sm  align-items-center cp_link"
                data-link="<?php echo e(route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id))); ?>"
                data-bs-toggle="tooltip" title="<?php echo e(__('Copy')); ?>"
                data-original-title="<?php echo e(__('Click to copy Bill link')); ?>">
                <i class="ti ti-file text-white"></i>
            </a>
        </div>
        <?php if (app('laratrust')->hasPermission('bill duplicate')) : ?>
            <div class="action-btn  me-2">
                <?php echo Form::open([
                    'method' => 'get',
                    'route' => ['bill.duplicate', $bill->id],
                    'id' => 'duplicate-form-' . $bill->id,
                ]); ?>

                <a class="mx-3 btn bg-secondary btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip"
                    title="" data-bs-original-title="<?php echo e(__('Duplicate')); ?>" aria-label="Delete"
                    data-text="<?php echo e(__('You want to confirm duplicate this bill. Press Yes to continue or No to go back')); ?>"
                    data-confirm-yes="duplicate-form-<?php echo e($bill->id); ?>">
                    <i class="ti ti-copy text-white text-white"></i>
                </a>
                <?php echo e(Form::close()); ?>

            </div>
        <?php endif; // app('laratrust')->permission ?>
        <?php if (app('laratrust')->hasPermission('bill show')) : ?>
            <div class="action-btn  me-2">
                <a href="<?php echo e(route('bill.show', \Crypt::encrypt($bill->id))); ?>" class="mx-3 btn btn-sm align-items-center bg-warning"
                    data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>" data-original-title="<?php echo e(__('Detail')); ?>">
                    <i class="ti ti-eye text-white"></i>
                </a>
            </div>
        <?php endif; // app('laratrust')->permission ?>
        <?php if($bill->status != 4): ?>
            <?php if(module_is_active('ProductService') && $bill->bill_module == 'taskly'
                    ? module_is_active('Taskly')
                    : module_is_active('Account')): ?>
                <?php if (app('laratrust')->hasPermission('bill edit')) : ?>
                    <div class="action-btn  me-2">
                        <a href="<?php echo e(route('bill.edit', \Crypt::encrypt($bill->id))); ?>"
                            class="mx-3 btn bg-info btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit"
                            data-original-title="<?php echo e(__('Edit')); ?>">
                            <i class="ti ti-pencil text-white"></i>
                        </a>
                    </div>
                <?php endif; // app('laratrust')->permission ?>
            <?php endif; ?>
            <?php if (app('laratrust')->hasPermission('bill delete')) : ?>
                <div class="action-btn">
                    <?php echo e(Form::open(['route' => ['bill.destroy', $bill->id], 'class' => 'm-0'])); ?>

                    <?php echo method_field('DELETE'); ?>
                    <a class="mx-3 btn bg-danger btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip"
                        title="" data-bs-original-title="Delete" aria-label="Delete"
                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                        data-confirm-yes="delete-form-<?php echo e($bill->id); ?>"><i
                            class="ti ti-trash text-white text-white"></i></a>
                    <?php echo e(Form::close()); ?>

                </div>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?>
    </span>

<?php endif; ?>



<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\action.blade.php ENDPATH**/ ?>