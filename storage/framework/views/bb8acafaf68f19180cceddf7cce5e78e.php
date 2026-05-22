<?php if (app('laratrust')->hasPermission('helpdesk ticket show')) : ?>
    <div class="action-btn me-2">
        <a href="<?php echo e(route('helpdesk.edit', $ticket->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center bg-info"
            data-bs-toggle="tooltip" title="<?php echo e(__('Edit & Reply')); ?>"> <span class="text-white"> <i
                    class="ti ti-corner-up-left"></i></span></a>
    </div>

    <div class="action-btn me-2">
        <a href="<?php echo e(route('helpdesk.view', [\Illuminate\Support\Facades\Crypt::encrypt($ticket->ticket_id)])); ?>"
            class="mx-3 btn btn-sm d-inline-flex align-items-center bg-warning" data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>">
            <span class="text-white"> <i class="ti ti-eye"></i></span></a>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('helpdesk ticket delete')) : ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::user()->id == $ticket->created_by || Auth::user()->type == 'super admin'): ?>
        <div class="action-btn">
            <form method="POST" action="<?php echo e(route('helpdesk.destroy', $ticket->id)); ?>" id="user-form-<?php echo e($ticket->id); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <input name="_method" type="hidden" value="DELETE">
                <button type="button" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm bg-danger"
                    data-bs-toggle="tooltip" title='<?php echo e(__('Delete')); ?>'>
                    <span class="text-white"> <i class="ti ti-trash"></i></span>
                </button>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; // app('laratrust')->permission ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\helpdesk_ticket\action.blade.php ENDPATH**/ ?>