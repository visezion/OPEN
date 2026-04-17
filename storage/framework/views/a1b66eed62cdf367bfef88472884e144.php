<?php $__env->startSection('page-title', __('Submit Weekly Report')); ?>
<?php $__env->startSection('page-breadcrumb', __('Reports')); ?>

<?php $__env->startSection('page-action'); ?>
    <a href="<?php echo e(route('feedback.dashboard')); ?>" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="<?php echo e(__('Reports Dashboard')); ?>">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="<?php echo e(route('feedback.index')); ?>" class="btn btn-sm btn-danger btn-icon me-1" data-bs-toggle="tooltip" title="<?php echo e(__('Go Back')); ?>">
        <i class="ti ti-arrow-back-up"></i>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('churchly::feedback._wizard', [
        'formRoute' => ['feedback.store'],
        'formMethod' => 'post',
        'feedback' => null,
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\feedback\create.blade.php ENDPATH**/ ?>