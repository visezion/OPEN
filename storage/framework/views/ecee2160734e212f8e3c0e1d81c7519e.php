<?php
    $company_settings = getCompanyAllSetting();
    $branch_name = $company_settings['churchly_branch_name'] ?? __('Branch');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e($branch_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Church Branch')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('church_branch create')) : ?>
        <a href="javascript:void(0)" 
           class="btn btn-sm btn-primary"
           data-ajax-popup="true"
           data-size="md"
           data-title="<?php echo e(__('Create Branch')); ?>"
           data-url="<?php echo e(route('churchbranch.create')); ?>"
           data-toggle="tooltip"
           title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-3">
        <?php echo $__env->make('churchly::layouts.churchly_setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="col-sm-9">
          <?php if (app('laratrust')->hasPermission('church_branch edit')) : ?>
            <div class="card mb-3">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="mb-0"><?php echo e($branch_name); ?></h4>
                    <a href="javascript:void(0)"
                       class="btn btn-sm bg-info text-white"
                       data-url="<?php echo e(route('branchname.edit')); ?>"
                       data-ajax-popup="true"
                       data-size="md"
                       data-title="<?php echo e(__('Edit ' . $branch_name)); ?>"
                       data-bs-toggle="tooltip"
                       title="<?php echo e(__('Edit Name')); ?>">
                        <i class="ti ti-pencil"></i>
                    </a>
                </div>
            </div>
        <?php endif; // app('laratrust')->permission ?>
          

        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e($branch_name); ?></th>
                                <th width="100px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($branch->name ?? '-'); ?></td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (app('laratrust')->hasPermission('church_branch edit')) : ?>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-url="<?php echo e(route('churchbranch.edit', $branch->id)); ?>"
                                                   data-ajax-popup="true"
                                                   data-size="md"
                                                   data-title="<?php echo e(__('Edit Branch')); ?>"
                                                   data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>

                                            <?php if (app('laratrust')->hasPermission('church_branch delete')) : ?>
                                                <?php echo Form::open([
                                                    'route' => ['churchbranch.destroy', $branch->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $branch->id
                                                ]); ?>

                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="<?php echo e(__('Delete')); ?>"
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                       data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                       data-confirm-yes="delete-form-<?php echo e($branch->id); ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                <?php echo Form::close(); ?>

                                             <?php endif; // app('laratrust')->permission ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php echo $__env->make('layouts.nodatafound', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Providers/../Resources/views/branch/index.blade.php ENDPATH**/ ?>