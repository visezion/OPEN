<?php $__env->startPush('scripts'); ?>
<?php if(isset($stripe_session)): ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
    var stripe = Stripe('<?php echo e(admin_setting('stripe_key')); ?>');
    stripe.redirectToCheckout({
        sessionId: '<?php echo e($stripe_session->id); ?>',
    }).then((result) => {
    });
    </script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\plan\request.blade.php ENDPATH**/ ?>