<form method="POST" action="<?php echo e(route('app-builder.saveBranding')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label"><?php echo e(__('App Name')); ?></label>
            <input type="text" class="form-control" name="app_name" value="<?php echo e(old('app_name', $profile->app_name ?? '')); ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label"><?php echo e(__('Theme Mode')); ?></label>
            <select class="form-control" name="theme_mode">
                <option value="system" <?php echo e(($profile->theme_mode ?? '') == 'system' ? 'selected' : ''); ?>>System</option>
                <option value="light" <?php echo e(($profile->theme_mode ?? '') == 'light' ? 'selected' : ''); ?>>Light</option>
                <option value="dark" <?php echo e(($profile->theme_mode ?? '') == 'dark' ? 'selected' : ''); ?>>Dark</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label"><?php echo e(__('Primary Color')); ?></label>
            <input type="color" name="primary_color" value="<?php echo e($profile->primary_color ?? '#4A6CF7'); ?>" class="form-control form-control-color">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label"><?php echo e(__('Accent Color')); ?></label>
            <input type="color" name="accent_color" value="<?php echo e($profile->accent_color ?? '#F9B200'); ?>" class="form-control form-control-color">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label"><?php echo e(__('Logo')); ?></label>
            <input type="file" name="logo_path" class="form-control">
            <?php if(!empty($profile->logo_path)): ?>
                <img src="<?php echo e(asset(Storage::url($profile->logo_path))); ?>" class="img-thumbnail mt-2" width="100">
            <?php endif; ?>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label"><?php echo e(__('Splash Screen')); ?></label>
            <input type="file" name="splash_path" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label"><?php echo e(__('App Icon')); ?></label>
            <input type="file" name="icon_path" class="form-control">
        </div>

        <div class="col-md-12 text-end mt-3">
            <button class="btn btn-primary" type="submit"><?php echo e(__('Save Branding')); ?></button>
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\app-builder\_branding.blade.php ENDPATH**/ ?>