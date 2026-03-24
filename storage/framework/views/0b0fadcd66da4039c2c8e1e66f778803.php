<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Warehouse Transfer')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Warehouse Transfer')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div>
        <?php if (app('laratrust')->hasPermission('warehouse create')) : ?>
            <a data-size="lg" data-url="<?php echo e(route('warehouses-transfer.create')); ?>" data-ajax-popup="true"
               data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create Warehouse Transfer')); ?>"  class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
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

<?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo e($dataTable->scripts()); ?>



    <script>
        $(document).ready(function () {
            var w_id = $('#warehouse_id').val();
            getProduct(w_id);
        });
        $(document).on('change', 'select[name=from_warehouse]', function ()
        {
            var warehouse_id = $(this).val();
            getProduct(warehouse_id);
        });

        function getProduct(wid)
        {
            $.ajax({
                url: '<?php echo e(route('warehouses-transfer.getproduct')); ?>',
                type: 'POST',
                data: {
                    "warehouse_id": wid,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#product_id').empty();

                    $("#product_div").html('');
                    $('#product_div').append('<label for="product" class="form-label"><?php echo e(__('Product')); ?></label>');
                    $('#product_div').append('<select class="form-control" id="product_id" name="product_id"></select>');
                    $('#product_id').append('<option value=""><?php echo e(__('Select Product')); ?></option>');

                    $.each(data.ware_products, function (key, value) {
                        $('#product_id').append('<option value="' + key + '">' + value + '</option>');
                    });

                    $('select[name=to_warehouse]').empty();
                    $.each(data.to_warehouses, function(key, value) {
                        var option = '<option value="' + key + '">' + value + '</option>';
                        $('select[name=to_warehouse]').append(option);
                    });
                }

            });
        }

        $(document).on('change', '#product_id', function () {
            var product_id = $(this).val();
            getQuantity(product_id);
        });

        function getQuantity(pid) {
            $.ajax({
                url: '<?php echo e(route('warehouses-transfer.getquantity')); ?>',
                type: 'POST',
                data: {
                    "product_id": pid,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    if (Array.isArray(data)) {
                        $('#quantity').val(data[0]);
                    } else {
                        $('#quantity').val(data);
                    }
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\warehouses-transfer\index.blade.php ENDPATH**/ ?>