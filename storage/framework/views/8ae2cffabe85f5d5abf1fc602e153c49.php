<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Email Templates')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-action'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <style>
        .email-template-index .email-template-card {
            border: 1px solid #d8e2ef;
            border-radius: 14px;
            box-shadow: none !important;
            background: #ffffff;
        }

        .email-template-index .email-template-card .card-body {
            padding: 0;
        }

        .email-template-index .table-responsive {
            border: 0 !important;
            border-radius: 14px;
        }

        .email-template-index table.dataTable thead th {
            background: #f8fbff;
            border-bottom: 1px solid #d8e2ef !important;
            color: #5f7696;
            font-size: 12px;
            letter-spacing: .04em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .email-template-index table.dataTable tbody td {
            border-bottom: 1px solid #e7edf6 !important;
            color: #1f3a62;
            vertical-align: middle;
        }

        .email-template-index table.dataTable tbody tr:last-child td {
            border-bottom: 0 !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row email-template-index">
        <div class="col-md-12">
            <div class="card email-template-card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <?php echo e($dataTable->table(['width' => '100%'])); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- [ basic-table ] end -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo e($dataTable->scripts()); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views\email_templates\index.blade.php ENDPATH**/ ?>