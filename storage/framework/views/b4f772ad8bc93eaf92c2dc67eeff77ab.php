<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Customer')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Customer')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>


    <script>
        $(document).on('click', '#billing_data', function () {
            $("[name='shipping_name']").val($("[name='billing_name']").val());
            $("[name='shipping_country']").val($("[name='billing_country']").val());
            $("[name='shipping_state']").val($("[name='billing_state']").val());
            $("[name='shipping_city']").val($("[name='billing_city']").val());
            $("[name='shipping_phone']").val($("[name='billing_phone']").val());
            $("[name='shipping_zip']").val($("[name='billing_zip']").val());
            $("[name='shipping_address']").val($("[name='billing_address']").val());
        })
    </script>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
<div class="d-flex">
    <?php echo $__env->yieldPushContent('addButtonHook'); ?>
    <?php if (app('laratrust')->hasPermission('customer import')) : ?>
        <a href="#"  class="btn btn-sm btn-primary me-2" data-size="md" data-ajax-popup="true" data-title="<?php echo e(__('Customer Import')); ?>" data-url="<?php echo e(route('customer.file.import')); ?>"  data-toggle="tooltip" title="<?php echo e(__('Import')); ?>"><i class="ti ti-file-import"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
    <a href="<?php echo e(route('customer.grid')); ?>" class="btn btn-sm btn-primary me-2"
            data-bs-toggle="tooltip"title="<?php echo e(__('Grid View')); ?>">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    <?php if (app('laratrust')->hasPermission('customer create')) : ?>
        <a  class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create Customer')); ?>" data-url="<?php echo e(route('customer.create')); ?>" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <?php echo e($dataTable->table(['width' => '100%'])); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customer\index.blade.php ENDPATH**/ ?>