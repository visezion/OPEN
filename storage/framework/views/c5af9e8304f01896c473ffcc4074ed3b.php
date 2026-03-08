<span>
    <div class="action-btn me-2">
        <a href="#" class="btn btn-sm align-items-center cp_link bg-primary"
            data-link="<?php echo e(route('pay.invoice', \Illuminate\Support\Facades\Crypt::encrypt($invoice->id))); ?>"
            data-bs-toggle="tooltip" title="<?php echo e(__('Copy')); ?>"
            data-original-title="<?php echo e(__('Click to copy invoice link')); ?>">
            <i class="ti ti-file text-white"></i>
        </a>
    </div>
    <?php if(module_is_active('EInvoice')): ?>
        <?php if (app('laratrust')->hasPermission('download invoice')) : ?>
            <?php echo $__env->make('einvoice::download.generate_invoice', ['invoice_id' => $invoice->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; // app('laratrust')->permission ?>
    <?php endif; ?>
    <div class="action-btn me-2">
        <a href="#" class="btn btn-sm  align-items-center bg-info"
            data-url="<?php echo e(route('delivery-form.pdf', \Crypt::encrypt($invoice->id))); ?>" data-ajax-popup="true"
            data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Invoice Delivery Form')); ?>"
            data-title="<?php echo e(__('Invoice Delivery Form')); ?>">
            <i class="ti ti-clipboard-list text-white"></i>
        </a>
    </div>

    <?php if (app('laratrust')->hasPermission('invoice duplicate')) : ?>
        <div class="action-btn me-2">
            <?php echo Form::open([
                'method' => 'get',
                'route' => ['invoice.duplicate', $invoice->id],
                'id' => 'duplicate-form-' . $invoice->id,
            ]); ?>

            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-secondary" data-bs-toggle="tooltip"
                title="" data-bs-original-title="<?php echo e(__('Duplicate')); ?>" aria-label="Delete"
                data-text="<?php echo e(__('You want to confirm duplicate this invoice. Press Yes to continue or No to go back')); ?>"
                data-confirm-yes="duplicate-form-<?php echo e($invoice->id); ?>">
                <i class="ti ti-copy  text-white"></i>
            </a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
        <div class="action-btn me-2">
            <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($invoice->id))); ?>" class="mx-3 btn btn-sm align-items-center bg-warning"
                data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>">
                <i class="ti ti-eye  text-white"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>

    <?php if($invoice->status != 4): ?>
        <?php if (app('laratrust')->hasPermission('invoice edit')) : ?>
            <div class="action-btn me-2">
                <a href="<?php echo e(route('invoice.edit', \Crypt::encrypt($invoice->id))); ?>"
                    class="mx-3 btn btn-sm  align-items-center bg-info" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Edit')); ?>">
                    <i class="ti ti-pencil text-white"></i>
                </a>
            </div>
        <?php endif; // app('laratrust')->permission ?>

        <?php if (app('laratrust')->hasPermission('invoice delete')) : ?>
            <div class="action-btn">
                <?php echo e(Form::open(['route' => ['invoice.destroy', $invoice->id], 'class' => 'm-0'])); ?>

                <?php echo method_field('DELETE'); ?>
                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                    data-bs-toggle="tooltip" title="" data-bs-original-title="<?php echo e(__('Delete')); ?>" aria-label="<?php echo e(__('Delete')); ?>"
                    data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                    data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                    data-confirm-yes="delete-form-<?php echo e($invoice->id); ?>">
                    <i class="ti ti-trash text-white text-white"></i>
                </a>
                <?php echo e(Form::close()); ?>

            </div>
        <?php endif; // app('laratrust')->permission ?>
    <?php endif; ?>

</span>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\invoice\action.blade.php ENDPATH**/ ?>