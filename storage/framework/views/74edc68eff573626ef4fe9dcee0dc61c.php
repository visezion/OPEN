<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

    <script>
        $('.copy_link').click(function(e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('Success', 'Url copied to clipboard', 'success');
        });
    </script>
    <script>
        $(document).on("click",".cp_link",function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/Signature/src/Resources/assets/css/custom.css')); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('packages/workdo/Pos/src/Resources/assets/css/custom.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <a href="<?php echo e(route('purchases.grid')); ?>" class="btn btn-sm btn-primary me-2"
            data-bs-toggle="tooltip"title="<?php echo e(__('Grid View')); ?>">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService')): ?>
            <a href="<?php echo e(route('category.index')); ?>"data-size="md" class="btn btn-sm btn-primary me-2"
                data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i
                    class="ti ti-settings"></i></a>
            <?php if (app('laratrust')->hasPermission('purchase create')) : ?>
                <a href="<?php echo e(route('purchases.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                    title="<?php echo e(__('Create')); ?>">
                    <i class="ti ti-plus"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
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


<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\purchases\index.blade.php ENDPATH**/ ?>