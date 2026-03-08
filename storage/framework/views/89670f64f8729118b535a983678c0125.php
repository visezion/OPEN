<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: <?php echo config('stripe.name'); ?>

    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('stripe::layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\index.blade.php ENDPATH**/ ?>