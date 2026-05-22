<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Credit Notes')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Credit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Credit Note')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
<?php if (app('laratrust')->hasPermission('creditnote create')) : ?>
    <div class="float-end">
        <a data-url="<?php echo e(route('create.custom.credit.note')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip"
            title="<?php echo e(__('Create')); ?>" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Credit Note')); ?>"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
<?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <?php echo e($dataTable->table(['width' => '100%'])); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).on('click' , '#item' , function(){
        var item_id = $(this).val();
        $.ajax({
            url: "<?php echo e(route('credit-invoice.itemprice')); ?>",
            method:'POST',
            data: {
                "item_id": item_id, 
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function (data) {
                if (data !== undefined) {
                    $('#amount').val(data);
                    $('input[name="amount"]').attr('min', 0);
                }
            }
        });        
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customerCreditNote\index.blade.php ENDPATH**/ ?>