<?php $__env->startPush('title'); ?>
    <h4 class="m-b-10"><?php echo e(__('Guests')); ?></h4>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="index.html"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Guests')); ?></li>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('action-btn'); ?>
    <div class="float-end">

        <a href="#" data-size="md" data-url="<?php echo e(route('guests.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Guests')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>



    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('contant'); ?>

    <div class="col-xl-12">
        <div class="card">

            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable" id="datatable1">
                        <thead>
                            <tr>
                                <th>Guest Name</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Unity Pugh</td>
                                <td>9958</td>
                                <td>Curicó</td>
                                <td>2005/02/11</td>
                                <td>
                                    <div class="action-btn bg-light-warning ms-2">
                                        <a href=<?php echo e(route('guests.edit',1)); ?>  data-ajax-popup="fulla" data-pc-animate="slide-in-right" data-bs-toggle="tooltip" data-title="<?php echo e(__('Create New Rentals')); ?>" data-url="<?php echo e(route('guests.edit',1)); ?>" class="btn btn-sm btn-primary action-btn">
                                            <i class="ti ti-pencil"></i>
                                        </a>

                                    </div>
                                    <div class="action-btn bg-light-danger ms-2">
                                        <a href="#" type="button" data-bs-placement="top" data-bs-toggle="tooltip"
                                            class="btn btn-sm btn-danger action-btn bs-pass-para"
                                            data-confirm="<?php echo e(__('Are You Sure?')); ?>" title="<?php echo e(__('Cancel Job')); ?>"
                                            data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\guests\index.blade.php ENDPATH**/ ?>