<div class="payment-method">
    <div class="payment-title d-flex align-items-center justify-content-between">
        <h2 class="h5"><?php echo e(__('Stripe')); ?></h2>
        <div class="payment-image">
            <img src="<?php echo e(get_module_img('Stripe')); ?>" alt="">
        </div>
    </div>
    <p><?php echo e(__('Safe money transfer using your bank account. We support Mastercard, Visa, Maestro and Skrill.')); ?></p>
    <form action="<?php echo e(route('content.pay.with.stripe', $store->slug)); ?>" role="form" method="post"
        class="payment-method-form" id="payment-form">
        <?php echo csrf_field(); ?>
        <div class="pay-btn text-right">
            <button class="btn" type="submit"><?php echo e(__('Pay Now')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\Stripe\src\Resources\views\payment\content_payment.blade.php ENDPATH**/ ?>