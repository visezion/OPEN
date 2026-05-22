<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Bills')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Bill')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <a href="<?php echo e(route('bill.grid')); ?>" class="btn btn-sm btn-primary me-2"
            data-bs-toggle="tooltip"title="<?php echo e(__('Grid View')); ?>">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService')): ?>
            <?php if (app('laratrust')->hasPermission('bill create')) : ?>
                <a href="<?php echo e(route('category.index')); ?>"data-size="md" class="btn btn-sm btn-primary me-2"
                    data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i
                        class="ti ti-settings"></i></a>

                <a href="<?php echo e(route('bills.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Create')); ?>">
                    <i class="ti ti-plus"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('Signature')): ?>
        <link rel="stylesheet" href="<?php echo e(asset('packages/workdo/Signature/src/Resources/assets/css/custom.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        .bill_status {
            min-width: 94px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class=" multi-collapse mt-2" id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <?php echo e(Form::label('bill_date', __('Date'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::date('bill_date', isset($_GET['bill_date']) ? $_GET['bill_date'] : null, ['class' => 'form-control form-control flatpickr-to-input', 'placeholder' => 'Select Date'])); ?>

                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'vendor'): ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('vendor', __('Vendor'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('vendor', $vendor, isset($_GET['vendor']) ? $_GET['vendor'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Vendor'])); ?>

                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::select('status', $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Status'])); ?>

                                </div>
                            </div>
                            <div class="col-auto float-end mt-4">
                                <a class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                    id="applyfilter" data-original-title="<?php echo e(__('apply')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="#!" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                    title="<?php echo e(__('Reset')); ?>" id="clearfilter"
                                    data-original-title="<?php echo e(__('Reset')); ?>">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).on("click", ".cp_link", function() {
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\bill\index.blade.php ENDPATH**/ ?>