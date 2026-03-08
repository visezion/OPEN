<?php if(Laratrust::hasPermission('bank transfer edit') || Laratrust::hasPermission('bank transfer delete')): ?>
    <span>
        <?php if (app('laratrust')->hasPermission('bank transfer edit')) : ?>
            <div class="action-btn  me-2">
                <a class="mx-3 btn bg-info btn-sm  align-items-center" data-url="<?php echo e(route('bank-transfer.edit', $transfer->id)); ?>"
                    data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                    data-title="<?php echo e(__('Edit Transfer')); ?>" data-bs-original-title="<?php echo e(__('Edit')); ?>">
                    <i class="ti ti-pencil text-white"></i>
                </a>
            </div>
        <?php endif; // app('laratrust')->permission ?>
        <?php if (app('laratrust')->hasPermission('bank transfer delete')) : ?>
            <div class="action-btn">
                <?php echo e(Form::open(['route' => ['bank-transfer.destroy', $transfer->id], 'class' => 'm-0'])); ?>

                <?php echo method_field('DELETE'); ?>
                <a class="mx-3 btn bg-danger btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip"
                    title="" data-bs-original-title="Delete" aria-label="Delete"
                    data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                    data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                    data-confirm-yes="delete-form-<?php echo e($transfer->id); ?>"><i class="ti ti-trash text-white text-white"></i></a>
                <?php echo e(Form::close()); ?>

            </div>
        <?php endif; // app('laratrust')->permission ?>
    </span>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\transfer\action.blade.php ENDPATH**/ ?>