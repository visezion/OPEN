<?php $__env->startSection('page-title', __('Website Assets')); ?>
<?php $__env->startSection('page-breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('cms.pages')); ?>"><?php echo e(__('Website CMS')); ?></a></li>
<li class="breadcrumb-item active"><?php echo e(__('Assets')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card"><div class="card-body">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('uploaded')): ?><div class="alert alert-info small"><?php echo e(__('Uploaded URL:')); ?> <code><?php echo e(session('uploaded')); ?></code></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  <form method="POST" action="<?php echo e(route('cms.assets.upload')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?>
    <div class="row align-items-end">
      <div class="col-md-6 mb-3"><label class="form-label"><?php echo e(__('Upload File')); ?></label><input type="file" name="file" class="form-control" required></div>
      <div class="col-md-3 mb-3"><button class="btn btn-primary"><?php echo e(__('Upload')); ?></button></div>
    </div>
  </form>
  <hr>
  <div class="row">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="col-md-3 mb-3">
        <div class="border rounded p-2 text-center">
          <img src="<?php echo e($f['url']); ?>" class="img-fluid" style="max-height:120px;object-fit:contain">
          <div class="small mt-2"><code><?php echo e($f['url']); ?></code></div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="col-12 text-muted small"><?php echo e(__('No assets yet')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\cms\assets.blade.php ENDPATH**/ ?>