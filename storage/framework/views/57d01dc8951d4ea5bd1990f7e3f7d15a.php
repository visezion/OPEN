

<?php $__env->startSection('page-title', __('App Publish Settings')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('app-builder.index')); ?>"><?php echo e(__('App Builder')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Publish')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('app-builder.publish.save')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><?php echo e(__('Release Channel')); ?></label>
                    <select name="release_channel" class="form-control">
                        <option value="multi_tenant" <?php echo e(($publish->release_channel ?? '') == 'multi_tenant' ? 'selected' : ''); ?>>Use Multi-Church App</option>
                        <option value="white_label" <?php echo e(($publish->release_channel ?? '') == 'white_label' ? 'selected' : ''); ?>>Publish Own App</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label"><?php echo e(__('Current Version')); ?></label>
                    <input type="text" name="current_version" class="form-control" value="<?php echo e($publish->current_version ?? ''); ?>">
                </div>
            </div>

            <div class="text-end mt-3">
                <button class="btn btn-primary"><?php echo e(__('Save Publish Settings')); ?></button>
            </div>
        </form>

        <hr>
        <p class="mt-3 text-muted small">
            <?php echo e(__('In future updates, this screen will allow you to connect your Google Play and Apple Developer accounts and deploy your white-label app directly from Churchly.')); ?>

        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\app-builder\publish.blade.php ENDPATH**/ ?>