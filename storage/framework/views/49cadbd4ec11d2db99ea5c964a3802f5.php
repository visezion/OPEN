<?php if (app('laratrust')->hasPermission('creditnote edit')) : ?>
<div class="action-btn me-2">
    <a data-url="<?php echo e(route('invoice.edit.custom-credit',[$customcreditNote->invoice,$customcreditNote->id])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Credit Note')); ?>" href="#" class="mx-3 btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-original-title="<?php echo e(__('Edit')); ?>">
        <i class="ti ti-pencil text-white"></i>
    </a>
</div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('creditnote delete')) : ?>
<div class="action-btn">
    <?php echo e(Form::open(array('route'=>array('invoice.custom-note.delete', $customcreditNote->invoice,$customcreditNote->id),'class' => 'm-0'))); ?>

    <?php echo method_field('DELETE'); ?>
    <a href="#"
       class="mx-3 btn bg-danger btn-sm  align-items-center bs-pass-para show_confirm"
       data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
       aria-label="Delete" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"  data-confirm-yes="delete-form-<?php echo e($customcreditNote->id); ?>"><i
            class="ti ti-trash text-white text-white"></i></a>
    <?php echo e(Form::close()); ?>

</div>
<?php endif; // app('laratrust')->permission ?>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customerCreditNote\action.blade.php ENDPATH**/ ?>