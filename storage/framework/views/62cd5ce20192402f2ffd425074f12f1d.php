<?php $__env->startSection('title', trans('installer_messages.updater.overview.title')); ?>
<?php $__env->startSection('container'); ?>
    <p class="update-copy">
        <?php echo e(trans_choice('installer_messages.updater.overview.message', $numberOfUpdatesPending, ['number' => $numberOfUpdatesPending])); ?>

    </p>
    <div class="update-stat">
        <span class="update-stat-value"><?php echo e($numberOfUpdatesPending); ?></span>
        <span class="update-stat-label"><?php echo e(__('Pending updates detected')); ?></span>
    </div>
    <div class="update-actions">
        <a href="<?php echo e(route('LaravelUpdater::database')); ?>" class="update-btn primary"><?php echo e(trans('installer_messages.updater.overview.install_updates')); ?></a>
        <a href="<?php echo e(route('LaravelUpdater::welcome')); ?>" class="update-btn secondary"><?php echo e(__('Back')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vendor.installer.layouts.master-update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\resources\views/vendor/installer/update/overview.blade.php ENDPATH**/ ?>