

<?php
    $company_settings = getCompanyAllSetting();
    $department_name = $company_settings['churchly_department_name'] ?? __('Department');
    $branch_name = $company_settings['churchly_branch_name'] ?? __('Branch');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e($department_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Church Department')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <?php if (app('laratrust')->hasPermission('church_department create')) : ?>
        <a href="javascript:void(0)"
           class="btn btn-sm btn-primary"
           data-ajax-popup="true"
           data-size="md"
           data-title="<?php echo e(__('Create ' . $department_name)); ?>"
           data-url="<?php echo e(route('churchly.departments.create')); ?>"
           data-toggle="tooltip"
           title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; // app('laratrust')->permission ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-3">
        <?php echo $__env->make('churchly::layouts.churchly_setup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <div class="col-sm-9">
        <div class="card mb-3">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="mb-0"><?php echo e($department_name); ?></h4>
                </div>
            </div>
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th><?php echo e($department_name); ?></th>
                                <th><?php echo e($branch_name); ?></th>
                                <th width="120px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($department->name ?? '-'); ?></td>
                                    <td><?php echo e($department->branch->name ?? '-'); ?></td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (app('laratrust')->hasPermission('church_department edit')) : ?>
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-url="<?php echo e(route('churchly.departments.edit', $department->id)); ?>"
                                                   data-ajax-popup="true"
                                                   data-size="md"
                                                   data-title="<?php echo e(__('Edit ' . $department_name)); ?>"
                                                   data-bs-toggle="tooltip"
                                                   title="<?php echo e(__('Edit')); ?>">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            <?php endif; // app('laratrust')->permission ?>

                                            <?php if (app('laratrust')->hasPermission('church_department delete')) : ?>
                                                <?php echo Form::open([
                                                    'route' => ['churchly.departments.destroy', $department->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $department->id
                                                ]); ?>

                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="<?php echo e(__('Delete')); ?>"
                                                       data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                       data-text="<?php echo e(__('This action cannot be undone. Do you want to continue?')); ?>"
                                                       data-confirm-yes="delete-form-<?php echo e($department->id); ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                <?php echo Form::close(); ?>

                                            <?php endif; // app('laratrust')->permission ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php echo $__env->make('layouts.nodatafound', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\departments\index.blade.php ENDPATH**/ ?>