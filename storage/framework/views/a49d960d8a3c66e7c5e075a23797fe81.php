    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($custom_domain_request->status != 1): ?>
        <div class="action-btn me-2">
            <a class="mx-3 btn btn-sm align-items-center bg-primary" href="<?php echo e(route('custom_domain_request.request',[$custom_domain_request->id,1])); ?>"
                title="<?php echo e(__('Accept')); ?>" data-bs-toggle="tooltip">
            <span> <i class="ti ti-check text-white"></i></span>
            </a>
        </div>
        <div class="action-btn me-2">
            <a class="mx-3 btn btn-sm align-items-center bg-warning" href="<?php echo e(route('custom_domain_request.request',[$custom_domain_request->id,0])); ?>"
                title="<?php echo e(__('Reject')); ?>" data-bs-toggle="tooltip" class="bg-warning">
            <span> <i class="ti ti-x text-white"></i></span>
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="action-btn">
        <?php echo e(Form::open(['route' => ['custom_domain_request.destroy', $custom_domain_request->id], 'class' => 'm-0'])); ?>

        <?php echo method_field('DELETE'); ?>
        <a href="#"
            class="mx-3 btn btn-sm align-items-center show_confirm bg-danger"
            data-bs-toggle="tooltip" title=""
            data-bs-original-title="<?php echo e(__('Delete')); ?>" aria-label="<?php echo e(__('Delete')); ?>"
            data-confirm-yes="delete-form-<?php echo e($custom_domain_request->id); ?>"><i
                class="ti ti-trash text-white text-white"></i></a>
        <?php echo e(Form::close()); ?>

    </div>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\custom_domain_request\action.blade.php ENDPATH**/ ?>