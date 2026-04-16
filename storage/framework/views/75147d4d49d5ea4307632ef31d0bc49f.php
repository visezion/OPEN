<?php if (app('laratrust')->hasPermission('bank account show')) : ?>
    <div class="action-btn me-2">
        <a class="btn btn-sm align-items-center bg-warning"
            data-url="<?php echo e(route('bank-account.show', $account->id)); ?>"
            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title=""
            data-title="<?php echo e(__('Bank Account Detail')); ?>" data-bs-original-title="<?php echo e(__('View')); ?>">
            <i class="ti ti-eye text-white"></i>
        </a>
    </div>
<?php endif; // app('laratrust')->permission ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($account->holder_name!='Cash'): ?>
    <?php if (app('laratrust')->hasPermission('bank account edit')) : ?>
        <div class="action-btn  me-2">
            <a  class="mx-3 btn bg-info btn-sm align-items-center" data-url="<?php echo e(route('bank-account.edit',$account->id)); ?>" data-ajax-popup="true" title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Bank Account')); ?>"data-bs-toggle="tooltip"  data-size="md"  data-original-title="<?php echo e(__('Edit')); ?>">
                <i class="ti ti-pencil text-white"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('bank account delete')) : ?>
        <div class="action-btn">
            <?php echo e(Form::open(array('route'=>array('bank-account.destroy', $account->id),'class' => 'm-0'))); ?>

            <?php echo method_field('DELETE'); ?>
                <a
                    class="mx-3 bg-danger btn btn-sm  align-items-center bs-pass-para show_confirm"
                    data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                    aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($account->id); ?>"><i
                        class="ti ti-trash text-white text-white"></i></a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>
<?php else: ?>
    -
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bankAccount\action.blade.php ENDPATH**/ ?>