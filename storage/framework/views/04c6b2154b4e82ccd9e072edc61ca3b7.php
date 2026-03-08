<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Debit Notes')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Debit Note')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="float-end">
        <?php if (app('laratrust')->hasPermission('debitnote create')) : ?>
            <a href="#" data-url="<?php echo e(route('bill.custom.debit.note')); ?>" data-ajax-popup="true"
                data-title="<?php echo e(__('Create Debit Note')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class=" multi-collapse mt-2" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-3">
                                <div class="btn-box">
                                    <?php echo e(Form::label('debit_type', __('Type'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('debit_type', $debit_type, isset($_GET['debit_type']) ? $_GET['debit_type'] : '0', ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                            <div class="col-auto float-end mt-4 d-flex">
                                <a class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip"
                                    title="<?php echo e(__('Apply')); ?>" id="applyfilter"
                                    data-original-title="<?php echo e(__('apply')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="#!" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                    title="<?php echo e(__('Reset')); ?>" id="clearfilter"
                                    data-original-title="<?php echo e(__('Reset')); ?>">
                                    <span class="btn-inner--icon"><i
                                            class="ti ti-trash-off text-white-off "></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        var type = $('input[name="type"]:checked').val();

        $.ajax({
            url: "<?php echo e(route('debit-bill.itemprice')); ?>",
            method:'POST',
            data: {
                "item_id": item_id,
                "type"   : type,
                "_token" : "<?php echo e(csrf_token()); ?>",
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\customerDebitNote\index.blade.php ENDPATH**/ ?>