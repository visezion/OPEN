<?php if (app('laratrust')->hasPermission('debitnote edit')) : ?>
    <div class="action-btn  me-2">
        <a data-url="<?php echo e(route('bill.debit-custom.edit', [$customdebitNote->bill, $customdebitNote->id])); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Edit Debit Note')); ?>" href="#" class="mx-3 btn btn-sm align-items-center bg-info"
            data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('debitnote delete')) : ?>
    <div class="action-btn  me-2">
        <?php echo Form::open([
            'method' => 'DELETE',
            'route' => ['bill.delete.custom-debit', $customdebitNote->bill, $customdebitNote->id],
            'id' => 'delete-form-' . $customdebitNote->id,
        ]); ?>


        <a href="#" class="bg-danger mx-3 btn btn-sm align-items-center show_confirm" data-bs-toggle="tooltip"
            title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?')); ?>"
            data-confirm-yes="document.getElementById('delete-form-<?php echo e($customdebitNote->id); ?>').submit();">
            <i class="ti ti-trash text-white"></i>
        </a>
        <?php echo Form::close(); ?>

    </div>
<?php endif; // app('laratrust')->permission ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customerDebitNote\action.blade.php ENDPATH**/ ?>