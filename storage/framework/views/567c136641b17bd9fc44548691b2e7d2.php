
    <div class="action-btn me-2">
        <a href="#" class="btn btn-sm align-items-center cp_link bg-primary" data-link="<?php echo e(route('pay.proposalpay',\Illuminate\Support\Facades\Crypt::encrypt($proposal->id))); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Copy')); ?>" data-original-title="<?php echo e(__('Click to copy proposal link')); ?>">
            <i class="ti ti-file text-white"></i>
        </a>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->status != 0 && $proposal->status != 3 ): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($proposal->is_convert == 0 && $proposal->is_convert_retainer ==0): ?>
            <?php if (app('laratrust')->hasPermission('proposal convert invoice')) : ?>
                <div class="action-btn me-2">
                    <?php echo Form::open([
                        'method' => 'get',
                        'route' => ['proposal.convert', $proposal->id],
                        'id' => 'proposal-form-' . $proposal->id,
                    ]); ?>

                    <a href="#"
                        class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-success"
                        data-bs-toggle="tooltip" title=""
                        data-bs-original-title="<?php echo e(__('Convert to Invoice')); ?>"
                        aria-label="<?php echo e(__('Delete')); ?>"
                        data-text="<?php echo e(__('You want to confirm convert to Invoice. Press Yes to continue or No to go back')); ?>"
                        data-confirm-yes="proposal-form-<?php echo e($proposal->id); ?>">
                        <i class="ti ti-exchange text-white"></i>
                    </a>
                    <?php echo e(Form::close()); ?>

                </div>
            <?php endif; // app('laratrust')->permission ?>
        <?php elseif($proposal->is_convert ==1): ?>
            <?php if (app('laratrust')->hasPermission('invoice show')) : ?>
                <div class="action-btn me-2">
                    <a href="<?php echo e(route('invoice.show', \Crypt::encrypt($proposal->converted_invoice_id))); ?>"
                        class="mx-3 btn btn-sm  align-items-center bg-success"
                        data-bs-toggle="tooltip"
                        title="<?php echo e(__('Already convert to Invoice')); ?>">
                        <i class="ti ti-eye text-white"></i>
                    </a>
                </div>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Retainer')): ?>
        <?php echo $__env->make('retainer::setting.convert_retainer', ['proposal' => $proposal ,'type' =>'list'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <?php if (app('laratrust')->hasPermission('proposal duplicate')) : ?>
        <div class="action-btn me-2">
            <?php echo Form::open([
                'method' => 'get',
                'route' => ['proposal.duplicate', $proposal->id],
                'id' => 'duplicate-form-' . $proposal->id,
            ]); ?>

            <a href="#"
                class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-secondary"
                data-bs-toggle="tooltip" title=""
                data-bs-original-title="<?php echo e(__('Duplicate')); ?>"
                aria-label="Delete"
                data-text="<?php echo e(__('You want to confirm duplicate this proposal. Press Yes to continue or No to go back')); ?>"
                data-confirm-yes="duplicate-form-<?php echo e($proposal->id); ?>">
                <i class="ti ti-copy text-white text-white"></i>
            </a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>

    <?php if (app('laratrust')->hasPermission('proposal show')) : ?>
        <div class="action-btn me-2">
            <a href="<?php echo e(route('proposal.show', \Crypt::encrypt($proposal->id))); ?>"
                class="mx-3 btn btn-sm align-items-center bg-warning"
                data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>"
                data-original-title="<?php echo e(__('Detail')); ?>">
                <i class="ti ti-eye text-white text-white"></i>
            </a>
        </div>
    <?php endif; // app('laratrust')->permission ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService') && ($proposal->proposal_module == 'taskly' ? module_is_active('Taskly') : module_is_active('Account')) && ($proposal->proposal_module == 'cmms' ? module_is_active('CMMS') : module_is_active('Account'))): ?>
        <?php if (app('laratrust')->hasPermission('proposal edit')) : ?>
            <div class="action-btn me-2">
                <a href="<?php echo e(route('proposal.edit', \Crypt::encrypt($proposal->id))); ?>"
                    class="mx-3 btn btn-sm  align-items-center bg-info"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Edit')); ?>">
                    <i class="ti ti-pencil text-white"></i>
                </a>
            </div>
        <?php endif; // app('laratrust')->permission ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if (app('laratrust')->hasPermission('proposal delete')) : ?>
        <div class="action-btn me-2">
            <?php echo e(Form::open(['route' => ['proposal.destroy', $proposal->id], 'class' => 'm-0'])); ?>

            <?php echo method_field('DELETE'); ?>
            <a href="#"
                class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
                data-bs-toggle="tooltip" title=""
                data-bs-original-title="<?php echo e(__('Delete')); ?>" aria-label="<?php echo e(__('Delete')); ?>"
                data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                data-confirm-yes="delete-form-<?php echo e($proposal->id); ?>"><i
                    class="ti ti-trash text-white text-white"></i></a>
            <?php echo e(Form::close()); ?>

        </div>
    <?php endif; // app('laratrust')->permission ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\proposal\action.blade.php ENDPATH**/ ?>