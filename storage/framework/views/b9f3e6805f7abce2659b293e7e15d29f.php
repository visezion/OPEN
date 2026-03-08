<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Revenues')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Revenues')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="d-flex">
        <?php echo $__env->yieldPushContent('addButtonHook'); ?>
        <?php if(module_is_active('ProductService')): ?>
            <a href="<?php echo e(route('category.index')); ?>"data-size="md" class="btn btn-sm btn-primary me-2"
                data-bs-toggle="tooltip"data-title="<?php echo e(__('Setup')); ?>" title="<?php echo e(__('Setup')); ?>"><i
                    class="ti ti-settings"></i></a>
        <?php endif; ?>
        <?php if (app('laratrust')->hasPermission('revenue create')) : ?>
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Create Revenue')); ?>"
                data-url="<?php echo e(route('revenue.create')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>">
                <i class="ti ti-plus"></i>
            </a>
        <?php endif; // app('laratrust')->permission ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="mt-2" id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-10">
                            <div class="row">
                                <div class="col-3">
                                    <?php echo e(Form::label('date', __('Date'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('date', isset($_GET['date']) ? $_GET['date'] : null, ['class' => 'month-btn form-control flatpickr-to-input', 'placeholder' => 'Select Date'])); ?>

                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 month">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('account', __('Account'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('account', $account, isset($_GET['account']) ? $_GET['account'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Account'])); ?>

                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 date">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('customer', __('Customer'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('customer', $customer, isset($_GET['customer']) ? $_GET['customer'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Customer'])); ?>

                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('category', __('Category'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::select('category', $category, isset($_GET['category']) ? $_GET['category'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Category'])); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto mt-4">
                            <div class="row">
                                <div class="col-auto">
                                    <a class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                        id="applyfilter" data-original-title="<?php echo e(__('apply')); ?>">
                                        <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                    </a>
                                    <a href="#!" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"
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

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Account\src\Resources\views\revenue\index.blade.php ENDPATH**/ ?>