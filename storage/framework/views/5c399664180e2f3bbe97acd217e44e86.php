<span>
    <div class="action-btn me-2">
        <a class="mx-3 btn btn-sm align-items-center bg-primary"
            data-url="<?php echo e(route('bank-transfer-request.edit', $bank_transfer_payment->id)); ?>" data-ajax-popup="true"
            data-size="md" data-bs-toggle="tooltip" title="" data-title="<?php echo e(__('Request Action')); ?>"
            data-bs-original-title="<?php echo e(__('Action')); ?>">
            <i class="ti ti-caret-right text-white"></i>
        </a>
    </div>
    <div class="action-btn">
        <?php echo e(Form::open(['route' => ['bank-transfer-request.destroy', $bank_transfer_payment->id], 'class' => 'm-0'])); ?>

        <?php echo method_field('DELETE'); ?>
        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip" title=""
            data-bs-original-title="<?php echo e(__('Delete')); ?>" aria-label="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
            data-confirm-yes="delete-form-<?php echo e($bank_transfer_payment->id); ?>"><i
                class="ti ti-trash text-white text-white"></i></a>
        <?php echo e(Form::close()); ?>

    </div>
</span>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\bank_transfer\action-button.blade.php ENDPATH**/ ?>