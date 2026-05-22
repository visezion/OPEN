<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Tickets')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Tickets')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-action'); ?>
    <div class="row">
        <div class="col-auto pe-0">
            <select class="form-select" id="projects" style="width: 121px;">
                <option value=""><?php echo e(__('All Tickets')); ?></option>
                <option value="in-progress"><?php echo e(__('In Progress')); ?></option>
                <option value="on-hold"><?php echo e(__('On Hold')); ?></option>
                <option value="closed"><?php echo e(__('Closed')); ?></option>
            </select>
        </div>
        <div class="col-auto ps-3 mt-1">
            <?php if (app('laratrust')->hasPermission('helpdesk ticket create')) : ?>
                <a href="<?php echo e(route('helpdesk.create')); ?>" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="<?php echo e(__('Create')); ?>"><i class="ti ti-plus text-white"></i></a>
            <?php endif; // app('laratrust')->permission ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('ticket_id') || session()->has('smtp_error')): ?>
                <div class="alert alert-info bg-pr">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('ticket_id')): ?>
                        <?php echo Session::get('ticket_id'); ?>

                        <?php echo e(Session::forget('ticket_id')); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('smtp_error')): ?>
                        <?php echo Session::get('smtp_error'); ?>

                        <?php echo e(Session::forget('smtp_error')); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
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

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\helpdesk_ticket\index.blade.php ENDPATH**/ ?>