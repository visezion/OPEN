
<div class="payment-method">
    <div class="payment-title d-flex align-items-center justify-content-between">
        <h4><?php echo e(__('Stripe')); ?></h4>
        <div class="payment-image d-flex align-items-center">
            <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="">
        </div>
    </div>
    <p><?php echo e(__('Safe money transfer using your bank account. We support Mastercard, Visa, Maestro and Skrill.')); ?></p>
    <form action="<?php echo e(route('course.pay.with.stripe', $store->slug)); ?>" role="form" method="post"
        class="payment-method-form" id="payment-form">
        <?php echo csrf_field(); ?>
        <div class="form-group text-right">
            <button type="submit" class="btn"><?php echo e(__('Pay Now')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\course_payment.blade.php ENDPATH**/ ?>