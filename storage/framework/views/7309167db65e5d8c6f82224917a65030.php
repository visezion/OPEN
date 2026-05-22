<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Proposal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Proposal')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(module_is_active('ProductService')): ?>
            <?php if (app('laratrust')->hasPermission('category create')) : ?>
                <a href="<?php echo e(route('category.index')); ?>"data-size="md" class="btn btn-sm btn-primary me-2"
                    data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i
                        class="ti ti-settings"></i></a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((module_is_active('ProductService') && module_is_active('Account')) || module_is_active('Taskly')): ?>
            <?php if (app('laratrust')->hasPermission('proposal manage')) : ?>
                <a href="<?php echo e(route('proposal.grid.view')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Grid View')); ?>"
                    class="btn btn-sm btn-primary btn-icon me-2">
                    <i class="ti ti-layout-grid"></i>
                </a>
                <a href="<?php echo e(route('proposal.stats.view')); ?>" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Quick Stats')); ?>" class="btn btn-sm btn-primary btn-icon me-2">
                    <i class="ti ti-filter"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
            <?php if (app('laratrust')->hasPermission('proposal create')) : ?>
                <a href="<?php echo e(route('proposal.create', 0)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                    data-bs-original-title="<?php echo e(__('Create')); ?>">
                    <i class="ti ti-plus"></i>
                </a>
            <?php endif; // app('laratrust')->permission ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="mt-2" id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['proposal.index'], 'method' => 'GET', 'id' => 'frm_submit'])); ?>

                    <div class="row d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                            <div class="btn-box">
                                <?php echo e(Form::label('issue_date', __('Date'), ['class' => 'text-type'])); ?>

                                <?php echo e(Form::text('issue_date', isset($_GET['issue_date']) ? $_GET['issue_date'] : null, ['class' => 'form-control flatpickr-to-input', 'placeholder' => 'Select Date'])); ?>

                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(\Auth::user()->type != 'client'): ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <?php echo e(Form::label('customer', __('Customer'), ['class' => 'text-type'])); ?>

                                    <?php echo e(Form::select('customer', $customer, isset($_GET['customer']) ? $_GET['customer'] : '', ['class' => 'form-control', 'placeholder' => 'Select Client'])); ?>

                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                            <div class="btn-box">
                                <?php echo e(Form::label('status', __('Status'), ['class' => 'text-type'])); ?>

                                <?php echo e(Form::select('status', ['' => 'Select Status'] + $status, isset($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control'])); ?>

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
                                        class="ti ti-trash-off text-white-off"></i></span>
                            </a>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        <div class="col-sm-12">
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
    <?php echo $__env->make('layouts.includes.datatable-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\proposal\index.blade.php ENDPATH**/ ?>