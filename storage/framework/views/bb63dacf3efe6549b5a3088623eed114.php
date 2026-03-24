<?php $__env->startSection('page-title', __('Website Theme')); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('cms.pages')); ?>"><?php echo e(__('Website CMS')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Theme')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card"><div class="card-body">
<form method="POST" action="<?php echo e(route('cms.theme.save')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?>
<div class="row">
  <div class="col-md-3 mb-3"><label class="form-label"><?php echo e(__('Primary Color')); ?></label><input type="color" name="primary_color" class="form-control form-control-color" value="<?php echo e($theme->primary_color ?? '#4A6CF7'); ?>"></div>
  <div class="col-md-3 mb-3"><label class="form-label"><?php echo e(__('Secondary Color')); ?></label><input type="color" name="secondary_color" class="form-control form-control-color" value="<?php echo e($theme->secondary_color ?? '#F9B200'); ?>"></div>
  <div class="col-md-6 mb-3"><label class="form-label"><?php echo e(__('Font Family')); ?></label><input type="text" name="font_family" class="form-control" value="<?php echo e($theme->font_family); ?>"></div>
  <div class="col-md-6 mb-3"><label class="form-label"><?php echo e(__('Logo')); ?></label><input type="file" name="logo_path" class="form-control"><?php if($theme->logo_path): ?><img src="<?php echo e(asset(Storage::url($theme->logo_path))); ?>" class="img-thumbnail mt-2" width="120"><?php endif; ?></div>
  <div class="col-md-6 mb-3"><label class="form-label"><?php echo e(__('Favicon')); ?></label><input type="file" name="favicon_path" class="form-control"></div>
  <div class="col-md-12 mb-3"><label class="form-label"><?php echo e(__('Custom CSS')); ?></label><textarea name="custom_css" class="form-control" rows="4"><?php echo e($theme->custom_css); ?></textarea></div>
  <div class="col-md-12 text-end"><button class="btn btn-primary"><?php echo e(__('Save Theme')); ?></button></div>
</div>
</form>
</div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\cms\theme.blade.php ENDPATH**/ ?>