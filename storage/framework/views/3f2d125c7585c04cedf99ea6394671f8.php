<?php if (app('laratrust')->hasPermission('warehouse show')) : ?>
    <div class="action-btn me-2">
        <a href="<?php echo e(route('warehouses.show', $warehouse->id)); ?>"
            class="mx-3 btn btn-sm align-items-center bg-warning"
            data-bs-toggle="tooltip" title="<?php echo e(__('View')); ?>"><i class="ti ti-eye text-white"></i></a>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('warehouse edit')) : ?>
    <div class="action-btn me-2">
        <a class="mx-3 btn btn-sm  align-items-center bg-info" data-url="<?php echo e(route('warehouses.edit', $warehouse->id)); ?>"
            data-ajax-popup="true" data-size="lg " data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"
            data-title="<?php echo e(__('Edit Warehouse')); ?>">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php if (app('laratrust')->hasPermission('warehouse delete')) : ?>
    <div class="action-btn">
        <?php echo Form::open([
            'method' => 'DELETE',
            'route' => ['warehouses.destroy', $warehouse->id],
            'id' => 'delete-form-' . $warehouse->id,
        ]); ?>

        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip"
            title="<?php echo e(__('Delete')); ?>"><i class="ti ti-trash text-white"></i></a>
        <?php echo Form::close(); ?>

    </div>
<?php endif; // app('laratrust')->permission ?>
<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\warehouses\action.blade.php ENDPATH**/ ?>