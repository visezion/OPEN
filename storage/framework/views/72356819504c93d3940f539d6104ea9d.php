<?php $__env->startSection('payment_redirect'); ?>
<form method="post" action="<?php echo e($txn_url); ?>" name="f1" style="visibility: hidden;">
<table border="1">
<tbody>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<input type="hidden" name="<?php echo e($key); ?>"  value="<?php echo e($value); ?>" />
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<input type="hidden" name="CHECKSUMHASH" value="<?php echo e($checkSum); ?>">
</tbody>
</table>
<script type="text/javascript">
document.f1.submit();
</script>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($view, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\vendor\anandsiddharth\laravel-paytm-wallet\src\resources\views\form.blade.php ENDPATH**/ ?>