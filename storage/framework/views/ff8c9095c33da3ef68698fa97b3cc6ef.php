

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Import / Export Members')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('Members')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-action'); ?>
    <div class="col-auto">
        <a href="<?php echo e(asset('templates/members_template.csv')); ?>" class="btn btn-sm btn-info">
            <i class="ti ti-download"></i> <?php echo e(__('Download CSV Template')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h5><?php echo e(__('Import Members from CSV')); ?></h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('members.file')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="csv_file" class="form-label"><?php echo e(__('Upload CSV File')); ?></label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                        <small class="form-text text-muted">
                            <?php echo e(__('Only .csv files allowed (max 2MB). Make sure headers match the template.')); ?>

                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Upload & Preview')); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\members\import_export.blade.php ENDPATH**/ ?>