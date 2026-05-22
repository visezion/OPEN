<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('paypal.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('paypal::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\index.blade.php ENDPATH**/ ?>