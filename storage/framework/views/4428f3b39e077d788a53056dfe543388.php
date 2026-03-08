
<?php $__env->startSection('site'); ?>
  <?php if($page): ?>
    <?php $__currentLoopData = ($page->sections ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="section">
        <h3><?php echo e($s->title); ?></h3>
        <pre class="bg-light p-2 rounded"><?php echo e(json_encode($s->content)); ?></pre>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php else: ?>
    <div class="section text-center text-muted">No home page yet.</div>
  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('churchly::site.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Churchly\src\Resources\views\site\home.blade.php ENDPATH**/ ?>