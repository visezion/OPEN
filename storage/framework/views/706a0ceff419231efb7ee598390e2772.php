<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('paypal.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('paypal::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Paypal\src\Resources\views\index.blade.php ENDPATH**/ ?>