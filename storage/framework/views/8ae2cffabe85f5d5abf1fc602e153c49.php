<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="">
                        <?php echo e($dataTable->table(['width' => '100%'])); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- [ basic-table ] end -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\email_templates\index.blade.php ENDPATH**/ ?>