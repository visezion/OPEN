
<?php $__env->startSection('content'); ?>
<?php $palette = [ 'primary' => $theme->primary_color ?? '#4A6CF7', 'secondary' => $theme->secondary_color ?? '#F9B200' ]; ?>
<style>
:root{ --primary: <?php echo e($palette['primary']); ?>; --secondary: <?php echo e($palette['secondary']); ?>; }
body{ font-family: <?php echo e($theme->font_family ?? 'Inter, sans-serif'); ?>; }
.header{ padding:12px 20px; background:var(--primary); color:#fff; }
.footer{ padding:12px 20px; background:#f5f5f5; color:#666; }
.nav a{ color:#fff; margin-right:16px; text-decoration:none; }
.section{ padding:40px 20px; }
.card{ border:1px solid #d8e2ef !important; }
</style>
<div class="header d-flex align-items-center justify-content-between">
  <div class="d-flex align-items-center">
    <?php if($theme?->logo_path): ?> <img src="<?php echo e(asset(Storage::url($theme->logo_path))); ?>" height="36" class="me-2"> <?php endif; ?>
    <strong><?php echo e($page->title ?? 'Site'); ?></strong>
  </div>
  <div class="nav">
    <?php $__currentLoopData = ($menu->items ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(isset($it['slug']) ? url($workspace.'/site/'.ltrim($it['slug'],'/')) : ($it['url'] ?? '#')); ?>"><?php echo e($it['title'] ?? 'Link'); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>
<div class="content">
  <?php echo $__env->yieldContent('site'); ?>
</div>
<div class="footer text-center small">Powered by Churchly</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.empty', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\site\layout.blade.php ENDPATH**/ ?>