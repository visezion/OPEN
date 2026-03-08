<?php
    if(Auth::user()->type=='super admin')
    {
        $plural_name = __('Customers');
        $singular_name = __('Customer');
    }
    else{

        $plural_name =__('Users');
        $singular_name =__('User');
    }
?>
<?php $__env->startSection('page-title'); ?>
<?php echo e($plural_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<?php echo e($plural_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
<div class="d-flex">
    <?php if (app('laratrust')->hasPermission('user logs history')) : ?>
        <a href="<?php echo e(route('users.userlog.history')); ?>" class="btn btn-sm btn-primary me-2"
                data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('User Logs History')); ?>"><i class="ti ti-user-check"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>

    <?php if (app('laratrust')->hasPermission('user import')) : ?>
        <a href="#" class="btn btn-sm btn-primary me-2" data-ajax-popup="true" data-title="<?php echo e(__('Import')); ?>"
            data-url="<?php echo e(route('users.file.import')); ?>" data-toggle="tooltip" title="<?php echo e(__('Import')); ?>"><i
                class="ti ti-file-import"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user manage')) : ?>
        <a href="<?php echo e(route('users.index')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Grid View')); ?>"
            class="btn btn-sm btn-primary btn-icon me-2">
            <i class="ti ti-layout-grid"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
    <?php if (app('laratrust')->hasPermission('user create')) : ?>
        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="<?php echo e(__('Create New '.($singular_name))); ?>"  data-url="<?php echo e(route('users.create')); ?>" data-bs-toggle="tooltip"  data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- [ Main Content ] start -->
        <div class="row">
            <?php if(\Auth::user()->type != 'super admin'): ?>
                <div class="" id="multiCollapseExample1">
                    <div class="card">
                        <div class="card-body">
                            <?php echo e(Form::open(['route' => ['users.index'], 'method' => 'GET', 'id' => 'user_submit'])); ?>

                            <div class="row d-flex align-items-center justify-content-end">
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('name', isset($_GET['name']) ? $_GET['name'] : null, ['class' => 'form-control','placeholder' => __('Enter Name')])); ?>


                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

                                        <?php echo e(Form::text('email', isset($_GET['email']) ? $_GET['email'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Email')])); ?>

                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box">
                                        <?php echo e(Form::label('role', __('Role'), ['class' => 'form-label'])); ?>

                                       </div>
                                </div>
                                <div class="col-auto float-end mt-4 d-flex">
                                    <a href="#!" class="btn btn-sm btn-primary me-2"
                                        id="applyfilter"
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"
                                        data-original-title="<?php echo e(__('apply')); ?>">
                                        <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                    </a>
                                    <a href="<?php echo e(route('users.list.view')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                        title="" data-bs-original-title=<?php echo e(__('Reset')); ?>>
                                        <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                    </a>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
    <!-- [ Main Content ] end -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo e($dataTable->scripts()); ?>

<script>
    $(document).on('change', '#password_switch', function() {
        if($(this).is(':checked'))
        {
            $('.ps_div').removeClass('d-none');
            $('#password').attr("required",true);

        } else {
            $('.ps_div').addClass('d-none');
            $('#password').val(null);
            $('#password').removeAttr("required");
        }
    });
    $(document).on('click', '.login_enable', function() {
        setTimeout(function() {
             $('.modal-body').append($('<input>', {type: 'hidden',val: 'true',name: 'login_enable' }));
        }, 1000);
    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\users\list.blade.php ENDPATH**/ ?>