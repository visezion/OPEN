<?php $__env->startSection('title', trans('installer_messages.updater.welcome.title')); ?>
<?php $__env->startSection('container'); ?>
    <p class="update-copy">
        <?php echo e(trans('installer_messages.updater.welcome.message')); ?>

    </p>
    <div class="update-actions">
        <a href="<?php echo e(route('LaravelUpdater::overview')); ?>" class="update-btn primary"><?php echo e(trans('installer_messages.next')); ?></a>
        <a href="<?php echo e(url('/')); ?>" class="update-btn secondary"><?php echo e(__('Back to Home')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master-update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/vendor/installer/update/welcome.blade.php ENDPATH**/ ?>