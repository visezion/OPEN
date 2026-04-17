<?php $__env->startSection('title', trans('installer_messages.updater.final.title')); ?>
<?php $__env->startSection('container'); ?>
    <p class="update-copy">
        <?php echo e(isset(session('message')['message']) ? session('message')['message'] : __('Update process completed successfully.')); ?>

    </p>
    <div class="update-actions">
        <a href="<?php echo e(url('/')); ?>" class="update-btn primary"><?php echo e(trans('installer_messages.updater.final.exit')); ?></a>
        <a href="<?php echo e(route('LaravelUpdater::overview')); ?>" class="update-btn secondary"><?php echo e(__('Review Updates')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master-update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/vendor/installer/update/finished.blade.php ENDPATH**/ ?>